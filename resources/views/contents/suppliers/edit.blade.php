@extends('contents.body')

@section('title', 'Edit Supplier')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">সরবরাহকারী সম্পাদনা</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.suppliers.partials.errors')

                    <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
                        @csrf
                        @method('PUT')
                        @include('contents.suppliers.partials.form', ['supplier' => $supplier])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">বাতিল</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
