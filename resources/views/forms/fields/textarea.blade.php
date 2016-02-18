<textarea
    {{ $attributes->get("required") ? "required" : '' }}
    {{ $attributes->get("disabled") ? "disabled" : '' }}
    {{ $attributes->get("readonly") ? "readonly" : '' }}
    name="{{ $attributes->get('name') }}"
    class="form-control"
    @foreach($custom_attributes->all() as $attributeName => $attributeValue)
        {{ $attributeName . "=" . $attributeValue }}
    @endforeach
        >{{ $attributes->get('value') }}</textarea>