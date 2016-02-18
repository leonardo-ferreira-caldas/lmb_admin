<input
    {{ $attributes->get("required") ? "required" : '' }}
    {{ $attributes->get("disabled") ? "disabled" : '' }}
    {{ $attributes->get("readonly") ? "readonly" : '' }}
    type="text"
    value="{{ $attributes->get('value') }}"
    name="{{ $attributes->get('name') }}"
    class="form-control">