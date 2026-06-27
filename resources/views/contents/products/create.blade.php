@extends('contents.body')

@section('title', t('product.new'))

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">{{ t('product.new') }}</h4>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary px-2">
                    <i class="mdi mdi-format-list-bulleted me-1"></i> {{ t('product.list') }}
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    @include('contents.products.partials.errors')

                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf
                        @include('contents.products.partials.form', ['product' => null])

                        <input type="hidden" name="_add_another" id="_add_another" value="0">

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary px-3">{{ t('common.save') }}</button>
                            <button type="submit" class="btn btn-outline-primary px-3"
                                onclick="document.getElementById('_add_another').value='1'">
                                <i class="mdi mdi-plus me-1"></i>{{ t('common.save_and_add_another') }}
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-3">{{ t('common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
