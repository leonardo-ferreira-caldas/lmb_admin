<select
    {{ $attributes->get("required") ? "required" : '' }}
    {{ $attributes->get("disabled") ? "disabled" : '' }}
    {{ $attributes->get("readonly") ? "readonly" : '' }}
    name="{{ $attributes->get('name') }}"
    class="form-control input-sm">
    <option value="">{{ $defaultText }}</option>

    @foreach($options as $option)
        <option value="{{ $option['value'] }}" {{ $option['selected'] ? 'selected' : '' }} >{{ $option['text'] }}</option>
    @endforeach
</select>