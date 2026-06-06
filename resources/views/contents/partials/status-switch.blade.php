@php $isActive = old('status', $model->status) === 'active'; @endphp
<div class="form-check form-switch mb-0 ms-auto align-self-center">
    <input type="hidden" name="status" value="inactive">
    <input type="checkbox" class="form-check-input" id="status" name="status"
        value="active" {{ $isActive ? 'checked' : '' }}
        onchange="this.closest('.form-switch').querySelector('label').textContent = this.checked ? 'সক্রিয়' : 'নিষ্ক্রিয়'">
    <label class="form-check-label" for="status">{{ $isActive ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</label>
</div>
