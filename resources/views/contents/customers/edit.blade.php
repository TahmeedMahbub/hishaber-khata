@extends('contents.body')

@section('title', t('customer.edit_title'))

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">{{ t('customer.edit_title') }}</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.customers.partials.errors')

                    <form method="POST" action="{{ route('customers.update', $customer) }}">
                        @csrf
                        @method('PUT')
                        @include('contents.customers.partials.form', ['customer' => $customer])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">{{ t('common.update') }}</button>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">{{ t('common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
