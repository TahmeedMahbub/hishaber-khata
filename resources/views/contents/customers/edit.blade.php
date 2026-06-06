@extends('contents.body')

@section('title', 'Edit Customer')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">কাস্টমার সম্পাদনা</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.customers.partials.errors')

                    <form method="POST" action="{{ route('customers.update', $customer) }}">
                        @csrf
                        @method('PUT')
                        @include('contents.customers.partials.form', ['customer' => $customer])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">বাতিল</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
