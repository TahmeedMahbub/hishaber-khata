<div class="mb-3">
    <label for="name" class="form-label">ক্যাটাগরির নাম</label>
    <input type="text" id="name" name="name" class="form-control"
        value="{{ old('name', $category->name ?? '') }}" placeholder="যেমন: চাল, তেল" autofocus required>
</div>

