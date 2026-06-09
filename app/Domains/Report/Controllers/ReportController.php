<?php

namespace App\Domains\Report\Controllers;

use App\Domains\Report\Services\ReportService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reports)
    {
    }

    public function index(): View
    {
        return view('contents.reports.index');
    }

    public function dailySales(Request $request): View
    {
        $date = $request->date('date')?->toDateString() ?? Carbon::today()->toDateString();

        return view('contents.reports.daily-sales', [
            'report' => $this->reports->dailySales($date),
        ]);
    }

    public function monthlySales(Request $request): View
    {
        $month = $request->query('month') ?: Carbon::today()->format('Y-m');

        // Guard against malformed input.
        if (! preg_match('/^\d{4}-\d{2}$/', (string) $month)) {
            $month = Carbon::today()->format('Y-m');
        }

        return view('contents.reports.monthly-sales', [
            'report' => $this->reports->monthlySales($month),
        ]);
    }

    public function purchases(Request $request): View
    {
        [$from, $to] = $this->range($request);

        return view('contents.reports.purchase', [
            'report' => $this->reports->purchases($from, $to),
        ]);
    }

    public function stock(): View
    {
        return view('contents.reports.stock', [
            'report' => $this->reports->stock(),
        ]);
    }

    public function lowStock(): View
    {
        return view('contents.reports.low-stock', [
            'report' => $this->reports->lowStock(),
        ]);
    }

    public function customerDue(): View
    {
        return view('contents.reports.customer-due', [
            'report' => $this->reports->customerDue(),
        ]);
    }

    public function supplierDue(): View
    {
        return view('contents.reports.supplier-due', [
            'report' => $this->reports->supplierDue(),
        ]);
    }

    public function expenses(Request $request): View
    {
        [$from, $to] = $this->range($request);

        return view('contents.reports.expense', [
            'report' => $this->reports->expenses($from, $to),
        ]);
    }

    public function cashBook(Request $request): View
    {
        [$from, $to] = $this->range($request);

        return view('contents.reports.cash-book', [
            'report' => $this->reports->cashBook($from, $to),
        ]);
    }

    public function profitLoss(Request $request): View
    {
        [$from, $to] = $this->range($request);

        return view('contents.reports.profit-loss', [
            'report' => $this->reports->profitLoss($from, $to),
        ]);
    }

    /**
     * Resolve a [from, to] date range from the request, defaulting to the current month.
     *
     * @return array{0:string,1:string}
     */
    protected function range(Request $request): array
    {
        $from = $request->date('from')?->toDateString() ?? Carbon::today()->startOfMonth()->toDateString();
        $to = $request->date('to')?->toDateString() ?? Carbon::today()->toDateString();

        if ($from > $to) {
            [$from, $to] = [$to, $from];
        }

        return [$from, $to];
    }
}
