@extends('contents.body')

@section('title', 'New Category')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-md-8 col-lg-6">
            <h4 class="fw-bold mb-3">নতুন ক্যাটাগরি</h4>

            <div class="card">
                <div class="card-body">
                    @include('contents.categories.partials.errors')

                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        @include('contents.categories.partials.form', ['category' => null])

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">বাতিল</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
