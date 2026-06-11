@extends('contents.body')

@section('title', t('product.edit_title'))

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">{{ t('product.edit_title') }}</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.products.partials.errors')

                    <form method="POST" action="{{ route('products.update', $product) }}">
                        @csrf
                        @method('PUT')
                        @include('contents.products.partials.form', ['product' => $product])

                        <div class="d-flex gap-2 mt-3 align-items-center">
                            <button type="submit" class="btn btn-primary">{{ t('common.update') }}</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">{{ t('common.cancel') }}</a>
                            @include('contents.partials.status-switch', ['model' => $product])
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
