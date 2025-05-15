<div class="form-group">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    @if ($type === 'text' || $type === 'email' || $type === 'number' || $type === 'datetime-local')
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
            value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" class="form-control">
    @elseif($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $id }}" placeholder="{{ $placeholder }}" class="form-control">{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select name="{{ $name }}" id="{{ $id }}" class="form-control single-select">
            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ old($name, $selected) == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @elseif($type === 'file')
        <input type="file" name="{{ $name }}" id="{{ $id }}" class="form-control">
    @endif

    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
