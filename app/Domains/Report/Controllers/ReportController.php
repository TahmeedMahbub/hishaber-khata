<?php

namespace App\Domains\Report\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('contents.reports.index');
    }
}
