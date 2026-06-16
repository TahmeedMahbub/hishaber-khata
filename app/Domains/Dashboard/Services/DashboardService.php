<?php

namespace App\Domains\Dashboard\Services;

use App\Domains\Customer\Models\Customer;
use App\Domains\Expense\Models\Expense;
use App\Domains\Payment\Models\DuePayment;
use App\Domains\Product\Models\Product;
use App\Domains\Purchase\Models\Purchase;
use App\Domains\Sales\Models\Sale;
use App\Domains\Sales\Models\SaleItem;
use App\Domains\Supplier\Models\Supplier;
use Illuminate\Support\Carbon;

class DashboardService
{
    /**
     * Headline statistics for the dashboard cards.
     *
     * @return array<string, float|int>
     */
    public function stats(): array
    {
        $today = Carbon::today()->toDateString();

        $todaySales = (float) Sale::whereDate('sale_date', $today)->sum('total');

        $todaySaleIds = Sale::whereDate('sale_date', $today)->pluck('id');
        $todayProfit = (float) SaleItem::whereIn('sale_id', $todaySaleIds)
            ->selectRaw('COALESCE(SUM((unit_price - cost_price) * qty), 0) as profit')
            ->value('profit');

        $customerDue = (float) Customer::sum('due_balance');
        $supplierDue = (float) Supplier::sum('due_balance');

        $stockValue = (float) Product::selectRaw('COALESCE(SUM(stock_qty * purchase_price), 0) as v')
            ->value('v');

        $cashBalance = $this->cashBalance();

        return [
            'today_sales'  => round($todaySales, 2),
            'today_profit' => round($todayProfit, 2),
            'cash_balance' => round($cashBalance, 2),
            'customer_due' => round($customerDue, 2),
            'supplier_due' => round($supplierDue, 2),
            'stock_value'  => round($stockValue, 2),
        ];
    }

    /**
     * Cash position: money in from sales & customer payments minus
     * purchases, supplier payments and expenses.
     */
    protected function cashBalance(): float
    {
        $salesPaid    = (float) Sale::sum('paid');
        $purchasePaid = (float) Purchase::sum('paid');
        $expenses     = (float) Expense::sum('amount');

        $customerPaymentsIn = (float) DuePayment::where('party_type', 'customer')->sum('amount');
        $supplierPaymentsOut = (float) DuePayment::where('party_type', 'supplier')->sum('amount');

        return $salesPaid + $customerPaymentsIn - $purchasePaid - $supplierPaymentsOut - $expenses;
    }

    /**
     * Alert badges loaded asynchronously.
     *
     * @return array<string, int|float>
     */
    public function alerts(): array
    {
        $lowStockCount = Product::where('status', 'active')
            ->where('low_stock_alert', '>', 0)
            ->whereColumn('stock_qty', '<=', 'low_stock_alert')
            ->count();

        $customersWithDue = Customer::where('due_balance', '>', 0)->count();
        $suppliersWithDue = Supplier::where('due_balance', '>', 0)->count();

        return [
            'low_stock_count'    => $lowStockCount,
            'customer_due_count' => $customersWithDue,
            'supplier_due_count' => $suppliersWithDue,
        ];
    }

    /**
     * Last 5 sales.
     *
     * @return array<int, array<string, mixed>>
     */
    public function recentSales(): array
    {
        return Sale::with('customer')
            ->latest('sale_date')
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(fn (Sale $sale) => [
                'id'         => $sale->public_id,
                'invoice_no' => $sale->invoice_no,
                'customer'   => $sale->customer->name ?? t('sale.walkin_short'),
                'total'      => round((float) $sale->total, 2),
                'due'        => round((float) $sale->due, 2),
                'date'       => optional($sale->sale_date)->format('d M Y'),
                'url'        => route('sales.show', $sale),
            ])
            ->all();
    }

    /**
     * Top 5 selling products by quantity sold.
     *
     * @return array<int, array<string, mixed>>
     */
    public function topProducts(): array
    {
        $saleIds = Sale::pluck('id');

        return SaleItem::query()
            ->whereIn('sale_id', $saleIds)
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->selectRaw('products.name as name, COALESCE(SUM(sale_items.qty), 0) as qty_sold, COALESCE(SUM(sale_items.total), 0) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('qty_sold')
            ->limit(5)
            ->get()
            ->map(fn ($row) => [
                'name'    => $row->name,
                'qty'     => round((float) $row->qty_sold, 2),
                'revenue' => round((float) $row->revenue, 2),
            ])
            ->all();
    }
}
