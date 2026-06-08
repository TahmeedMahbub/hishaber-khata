<?php

namespace App\Domains\Dashboard\Controllers;

use App\Domains\Dashboard\Services\DashboardService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service)
    {
    }

    /**
     * Render the dashboard shell only. No statistics are queried here;
     * widgets are hydrated client-side via the AJAX endpoints below.
     */
    public function index(): View
    {
        return view('contents.dashboard');
    }

    public function stats(): JsonResponse
    {
        return response()->json($this->service->stats());
    }

    public function alerts(): JsonResponse
    {
        return response()->json($this->service->alerts());
    }

    public function recentSales(): JsonResponse
    {
        return response()->json($this->service->recentSales());
    }

    public function topProducts(): JsonResponse
    {
        return response()->json($this->service->topProducts());
    }
}
