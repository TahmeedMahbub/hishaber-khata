@extends('contents.body')

@section('title', t('supplier.new'))

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">{{ t('supplier.new') }}</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.suppliers.partials.errors')

                    <form method="POST" action="{{ route('suppliers.store') }}">
                        @csrf
                        @include('contents.suppliers.partials.form', ['supplier' => null])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">{{ t('common.save') }}</button>
                            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">{{ t('common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
