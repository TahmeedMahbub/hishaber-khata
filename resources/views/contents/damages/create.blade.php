@extends('contents.body')

@section('title', 'New Damage/Lost')

@section('content')
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <h4 class="fw-bold mb-3">ড্যামেজ / হারানো পণ্য</h4>

            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('damages.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="product_id" class="form-label">পণ্য</label>
                                <select id="product_id" name="product_id" class="form-select" required>
                                    <option value="">— পণ্য নির্বাচন করুন —</option>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}" {{ (string) old('product_id') === (string) $p->id ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="type" class="form-label">ধরন</label>
                                <select id="type" name="type" class="form-select">
                                    <option value="damage" {{ old('type') === 'damage' ? 'selected' : '' }}>ড্যামেজ</option>
                                    <option value="lost" {{ old('type') === 'lost' ? 'selected' : '' }}>হারানো</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="qty" class="form-label">পরিমাণ</label>
                                <input type="number" step="0.01" min="0.01" id="qty" name="qty"
                                    class="form-control" value="{{ old('qty', '1') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="damage_date" class="form-label">তারিখ</label>
                                <input type="date" id="damage_date" name="damage_date" class="form-control"
                                    value="{{ old('damage_date', now()->toDateString()) }}">
                            </div>

                            <div class="col-md-8">
                                <label for="reason" class="form-label">কারণ <span class="text-muted">(ঐচ্ছিক)</span></label>
                                <input type="text" id="reason" name="reason" class="form-control"
                                    value="{{ old('reason') }}" placeholder="যেমন: মেয়াদ শেষ, ভেঙে গেছে">
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0 py-2 small">
                            <i class="mdi mdi-information-outline me-1"></i> এই পরিমাণ স্টক থেকে কমে যাবে।
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                            <a href="{{ route('damages.index') }}" class="btn btn-outline-secondary">বাতিল</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
