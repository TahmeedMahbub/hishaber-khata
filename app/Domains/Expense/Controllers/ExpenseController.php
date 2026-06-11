<?php

namespace App\Domains\Expense\Controllers;

use App\Domains\Expense\Models\Expense;
use App\Domains\Expense\Requests\ExpenseRequest;
use App\Domains\Expense\Services\ExpenseService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function __construct(protected ExpenseService $service)
    {
    }

    public function index(Request $request): View
    {
        return view('contents.expenses.index', [
            'expenses' => $this->service->paginate($request->query('search')),
            'search'   => $request->query('search'),
        ]);
    }

    public function create(): View
    {
        return view('contents.expenses.create');
    }

    public function store(ExpenseRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->route('expenses.index')
            ->with('success', t('msg.expense_created'));
    }

    public function edit(Expense $expense): View
    {
        return view('contents.expenses.edit', ['expense' => $expense]);
    }

    public function update(ExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $this->service->update($expense, $request->validated());

        return redirect()->route('expenses.index')
            ->with('success', t('msg.expense_updated'));
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $this->service->delete($expense);

        return redirect()->route('expenses.index')
            ->with('success', t('msg.expense_deleted'));
    }
}
