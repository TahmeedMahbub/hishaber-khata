@extends('contents.body')

@section('title', t('expense.edit_title'))

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">{{ t('expense.edit_title') }}</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.expenses.partials.errors')

                    <form method="POST" action="{{ route('expenses.update', $expense) }}">
                        @csrf
                        @method('PUT')
                        @include('contents.expenses.partials.form', ['expense' => $expense])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">{{ t('common.update') }}</button>
                            <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">{{ t('common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
