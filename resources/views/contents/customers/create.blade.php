@extends('contents.body')

@section('title', 'New Customer')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">নতুন কাস্টমার</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.customers.partials.errors')

                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf
                        @include('contents.customers.partials.form', ['customer' => null])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">বাতিল</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
