<?php

namespace App\Domains\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the main dashboard.
     */
    public function index(): View
    {
        return view('contents.dashboard');
    }
}
