@extends('contents.body')

@section('title', 'New Expense')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">নতুন খরচ</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.expenses.partials.errors')

                    <form method="POST" action="{{ route('expenses.store') }}">
                        @csrf
                        @include('contents.expenses.partials.form', ['expense' => null])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                            <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">বাতিল</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
