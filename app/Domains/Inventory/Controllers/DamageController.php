<?php

namespace App\Domains\Inventory\Controllers;

use App\Domains\Inventory\Models\Damage;
use App\Domains\Inventory\Requests\DamageRequest;
use App\Domains\Inventory\Services\DamageService;
use App\Domains\Product\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DamageController extends Controller
{
    public function __construct(protected DamageService $service)
    {
    }

    public function index(Request $request): View
    {
        return view('contents.damages.index', [
            'damages' => $this->service->paginate($request->query('search')),
            'search'  => $request->query('search'),
        ]);
    }

    public function create(): View
    {
        return view('contents.damages.create', [
            'products' => Product::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function store(DamageRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('damages.index')
            ->with('success', t('msg.damage_created'));
    }

    public function destroy(Damage $damage): RedirectResponse
    {
        $this->service->delete($damage);

        return redirect()->route('damages.index')
            ->with('success', t('msg.damage_deleted'));
    }
}
