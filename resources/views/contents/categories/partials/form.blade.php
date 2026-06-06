<div class="mb-3">
    <label for="name" class="form-label">ক্যাটাগরির নাম</label>
    <input type="text" id="name" name="name" class="form-control"
        value="{{ old('name', $category->name ?? '') }}" placeholder="যেমন: চাল, তেল" autofocus required>
</div>

<div class="mb-3">
    <label for="status" class="form-label">স্ট্যাটাস</label>
    <select id="status" name="status" class="form-select" required>
        @php $current = old('status', $category->status ?? 'active'); @endphp
        <option value="active" {{ $current === 'active' ? 'selected' : '' }}>সক্রিয়</option>
        <option value="inactive" {{ $current === 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
    </select>
</div>
