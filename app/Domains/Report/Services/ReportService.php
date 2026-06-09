<?php

namespace App\Domains\Report\Services;

use App\Domains\Customer\Models\Customer;
use App\Domains\Expense\Models\Expense;
use App\Domains\Payment\Models\DuePayment;
use App\Domains\Product\Models\Product;
use App\Domains\Purchase\Models\Purchase;
use App\Domains\Sales\Models\Sale;
use App\Domains\Sales\Models\SaleItem;
use App\Domains\Supplier\Models\Supplier;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * Daily sales report for a single date.
     *
     * @return array<string, mixed>
     */
    public function dailySales(string $date): array
    {
        $sales = Sale::with('customer')
            ->withCount('items')
            ->whereDate('sale_date', $date)
            ->orderBy('id')
            ->get();

        $saleIds = $sales->pluck('id');
        $profit = (float) SaleItem::whereIn('sale_id', $saleIds)
            ->selectRaw('COALESCE(SUM((unit_price - cost_price) * qty), 0) as p')
            ->value('p');

        return [
            'date'     => $date,
            'sales'    => $sales,
            'total'    => (float) $sales->sum('total'),
            'discount' => (float) $sales->sum('discount'),
            'paid'     => (float) $sales->sum('paid'),
            'due'      => (float) $sales->sum('due'),
            'profit'   => round($profit, 2),
            'count'    => $sales->count(),
        ];
    }

    /**
     * Monthly sales report grouped by day for a given month (YYYY-MM).
     *
     * @return array<string, mixed>
     */
    public function monthlySales(string $month): array
    {
        $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end = (clone $start)->endOfMonth();

        $rows = Sale::selectRaw('sale_date, COUNT(*) as orders, COALESCE(SUM(total),0) as total, COALESCE(SUM(paid),0) as paid, COALESCE(SUM(due),0) as due')
            ->whereBetween('sale_date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        $saleIds = Sale::whereBetween('sale_date', [$start->toDateString(), $end->toDateString()])->pluck('id');
        $profit = (float) SaleItem::whereIn('sale_id', $saleIds)
            ->selectRaw('COALESCE(SUM((unit_price - cost_price) * qty), 0) as p')
            ->value('p');

        return [
            'month'  => $month,
            'label'  => $start->format('F Y'),
            'rows'   => $rows,
            'total'  => (float) $rows->sum('total'),
            'paid'   => (float) $rows->sum('paid'),
            'due'    => (float) $rows->sum('due'),
            'orders' => (int) $rows->sum('orders'),
            'profit' => round($profit, 2),
        ];
    }

    /**
     * Purchase report for a date range.
     *
     * @return array<string, mixed>
     */
    public function purchases(string $from, string $to): array
    {
        $purchases = Purchase::with('supplier')
            ->withCount('items')
            ->whereBetween('purchase_date', [$from, $to])
            ->orderBy('purchase_date')
            ->orderBy('id')
            ->get();

        return [
            'from'      => $from,
            'to'        => $to,
            'purchases' => $purchases,
            'total'     => (float) $purchases->sum('total'),
            'paid'      => (float) $purchases->sum('paid'),
            'due'       => (float) $purchases->sum('due'),
            'count'     => $purchases->count(),
        ];
    }

    /**
     * Current stock report (all active products).
     *
     * @return array<string, mixed>
     */
    public function stock(): array
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        return [
            'products'       => $products,
            'total_cost'     => (float) $products->sum(fn ($p) => (float) $p->stock_qty * (float) $p->purchase_price),
            'total_sale'     => (float) $products->sum(fn ($p) => (float) $p->stock_qty * (float) $p->sale_price),
            'total_qty'      => (float) $products->sum('stock_qty'),
            'count'          => $products->count(),
        ];
    }

    /**
     * Low stock report (stock at or below alert threshold).
     *
     * @return array<string, mixed>
     */
    public function lowStock(): array
    {
        $products = Product::with('category')
            ->where('low_stock_alert', '>', 0)
            ->whereColumn('stock_qty', '<=', 'low_stock_alert')
            ->orderBy('stock_qty')
            ->get();

        return [
            'products' => $products,
            'count'    => $products->count(),
        ];
    }

    /**
     * Customer due report.
     *
     * @return array<string, mixed>
     */
    public function customerDue(): array
    {
        $customers = Customer::where('due_balance', '>', 0)
            ->orderByDesc('due_balance')
            ->get();

        return [
            'customers' => $customers,
            'total'     => (float) $customers->sum('due_balance'),
            'count'     => $customers->count(),
        ];
    }

    /**
     * Supplier due report.
     *
     * @return array<string, mixed>
     */
    public function supplierDue(): array
    {
        $suppliers = Supplier::where('due_balance', '>', 0)
            ->orderByDesc('due_balance')
            ->get();

        return [
            'suppliers' => $suppliers,
            'total'     => (float) $suppliers->sum('due_balance'),
            'count'     => $suppliers->count(),
        ];
    }

    /**
     * Expense report for a date range.
     *
     * @return array<string, mixed>
     */
    public function expenses(string $from, string $to): array
    {
        $expenses = Expense::whereBetween('expense_date', [$from, $to])
            ->orderBy('expense_date')
            ->orderBy('id')
            ->get();

        return [
            'from'     => $from,
            'to'       => $to,
            'expenses' => $expenses,
            'total'    => (float) $expenses->sum('amount'),
            'count'    => $expenses->count(),
        ];
    }

    /**
     * Cash book report: money in and out for a date range.
     *
     * @return array<string, mixed>
     */
    public function cashBook(string $from, string $to): array
    {
        $entries = new Collection();

        // Money IN — sales paid
        foreach (Sale::where('paid', '>', 0)->whereBetween('sale_date', [$from, $to])->with('customer')->get() as $s) {
            $entries->push([
                'date'   => $s->sale_date,
                'type'   => 'in',
                'head'   => 'বিক্রয়',
                'detail' => $s->invoice_no . ($s->customer ? ' — ' . $s->customer->name : ''),
                'amount' => (float) $s->paid,
            ]);
        }

        // Money IN — customer due collections
        foreach (DuePayment::where('party_type', 'customer')->whereBetween('payment_date', [$from, $to])->with('customer')->get() as $p) {
            $entries->push([
                'date'   => $p->payment_date,
                'type'   => 'in',
                'head'   => 'কাস্টমার বাকি আদায়',
                'detail' => $p->customer->name ?? '—',
                'amount' => (float) $p->amount,
            ]);
        }

        // Money OUT — purchases paid
        foreach (Purchase::where('paid', '>', 0)->whereBetween('purchase_date', [$from, $to])->with('supplier')->get() as $pu) {
            $entries->push([
                'date'   => $pu->purchase_date,
                'type'   => 'out',
                'head'   => 'ক্রয়',
                'detail' => $pu->invoice_no . ($pu->supplier ? ' — ' . $pu->supplier->name : ''),
                'amount' => (float) $pu->paid,
            ]);
        }

        // Money OUT — supplier due payments
        foreach (DuePayment::where('party_type', 'supplier')->whereBetween('payment_date', [$from, $to])->with('supplier')->get() as $p) {
            $entries->push([
                'date'   => $p->payment_date,
                'type'   => 'out',
                'head'   => 'সরবরাহকারী বাকি পরিশোধ',
                'detail' => $p->supplier->name ?? '—',
                'amount' => (float) $p->amount,
            ]);
        }

        // Money OUT — expenses
        foreach (Expense::whereBetween('expense_date', [$from, $to])->get() as $e) {
            $entries->push([
                'date'   => $e->expense_date,
                'type'   => 'out',
                'head'   => 'খরচ',
                'detail' => $e->title,
                'amount' => (float) $e->amount,
            ]);
        }

        $sorted = $entries->sortBy(fn ($e) => optional($e['date'])->timestamp ?? 0)->values();

        $totalIn = (float) $sorted->where('type', 'in')->sum('amount');
        $totalOut = (float) $sorted->where('type', 'out')->sum('amount');

        return [
            'from'    => $from,
            'to'      => $to,
            'entries' => $sorted,
            'in'      => $totalIn,
            'out'     => $totalOut,
            'net'     => $totalIn - $totalOut,
        ];
    }

    /**
     * Profit & loss report for a date range.
     *
     * @return array<string, mixed>
     */
    public function profitLoss(string $from, string $to): array
    {
        $saleIds = Sale::whereBetween('sale_date', [$from, $to])->pluck('id');

        $revenue = (float) Sale::whereBetween('sale_date', [$from, $to])->sum('total');
        $discount = (float) Sale::whereBetween('sale_date', [$from, $to])->sum('discount');

        $cogs = (float) SaleItem::whereIn('sale_id', $saleIds)
            ->selectRaw('COALESCE(SUM(cost_price * qty), 0) as c')
            ->value('c');

        $grossProfit = $revenue - $cogs;
        $expenses = (float) Expense::whereBetween('expense_date', [$from, $to])->sum('amount');
        $netProfit = $grossProfit - $expenses;

        return [
            'from'         => $from,
            'to'           => $to,
            'revenue'      => round($revenue, 2),
            'discount'     => round($discount, 2),
            'cogs'         => round($cogs, 2),
            'gross_profit' => round($grossProfit, 2),
            'expenses'     => round($expenses, 2),
            'net_profit'   => round($netProfit, 2),
        ];
    }
}
