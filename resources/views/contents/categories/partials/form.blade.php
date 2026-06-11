<div class="mb-3">
    <label for="name" class="form-label">{{ t('category.name_label') }}</label>
    <input type="text" id="name" name="name" class="form-control"
        value="{{ old('name', $category->name ?? '') }}" placeholder="{{ t('category.name_ph') }}" autofocus required>
</div>

