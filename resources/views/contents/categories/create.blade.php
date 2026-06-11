@extends('contents.body')

@section('title', t('category.new'))

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">{{ t('category.new') }}</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.categories.partials.errors')

                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        @include('contents.categories.partials.form', ['category' => null])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">{{ t('common.save') }}</button>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">{{ t('common.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
