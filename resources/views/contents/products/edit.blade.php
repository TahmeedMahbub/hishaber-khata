@extends('contents.body')

@section('title', 'Edit Product')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">পণ্য সম্পাদনা</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.products.partials.errors')

                    <form method="POST" action="{{ route('products.update', $product) }}">
                        @csrf
                        @method('PUT')
                        @include('contents.products.partials.form', ['product' => $product])

                        <div class="d-flex gap-2 mt-3 align-items-center">
                            <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">বাতিল</a>
                            @include('contents.partials.status-switch', ['model' => $product])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
