<?php

namespace App\Domains\Common\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Public legal pages (no auth). Their URLs are used in Google OAuth branding.
 */
class LegalController extends Controller
{
    public function privacy(): View
    {
        return view('legal.privacy');
    }

    public function terms(): View
    {
        return view('legal.terms');
    }
}
