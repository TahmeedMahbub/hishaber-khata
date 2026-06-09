@extends('contents.body')

@section('title', 'Feedback')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12 col-lg-8">
            <h4 class="fw-bold mb-3">মতামত / ফিডব্যাক</h4>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <p class="text-muted">আপনার মতামত আমাদের কাছে গুরুত্বপূর্ণ। সমস্যা, পরামর্শ বা প্রশংসা — যা কিছু থাকুক, জানান।</p>

                    <form method="POST" action="{{ route('feedback.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="type" class="form-label">ধরন</label>
                                <select id="type" name="type" class="form-select" required>
                                    @foreach ($types as $key => $label)
                                        <option value="{{ $key }}" {{ old('type') === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block">রেটিং (ঐচ্ছিক)</label>
                                <div class="hk-rating d-inline-flex flex-row-reverse gap-1" role="radiogroup" aria-label="রেটিং">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" class="btn-check" name="rating" id="rate{{ $i }}"
                                            value="{{ $i }}" {{ (string) old('rating') === (string) $i ? 'checked' : '' }}>
                                        <label class="hk-star mb-0" for="rate{{ $i }}" title="{{ $i }}">
                                            <i class="mdi mdi-star-outline"></i>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">আপনার মতামত</label>
                                <textarea id="message" name="message" class="form-control" rows="4"
                                    placeholder="এখানে লিখুন..." required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-send me-1"></i> পাঠান
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hk-rating .hk-star { font-size: 1.6rem; color: #d8d8e0; cursor: pointer; line-height: 1; }
        .hk-rating .hk-star:hover,
        .hk-rating .hk-star:hover ~ .hk-star,
        .hk-rating .btn-check:checked ~ .hk-star { color: #f5a623; }
        .hk-rating .btn-check:checked + .hk-star .mdi::before,
        .hk-rating .hk-star:hover .mdi::before { content: "\F04CE"; } /* mdi-star (filled) */
    </style>
@endsection
