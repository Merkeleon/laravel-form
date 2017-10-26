<div class="form__element form__element_type_checkbox-group @if($error) form__element_error @endif {{$class}}">
    <label class="form__label">{{ $label }}</label>
    <div class="form__element-container">
        @foreach ($options as $key => $label)
            <label>
                <input @foreach($attributes as $attributeName => $attributeValue) {{ $attributeName }}="{{ $attributeValue }}" @endforeach type="checkbox"
                       value="{{ $key }}" @if(is_array($checked) && in_array($key, $checked)) checked="checked"
                       @endif name="{{ $elementName }}[]"> <span>{{ $label }}</span>
            </label>
        @endforeach
    </div>
    <div class="form__feedback">{{ $error }}</div>
</div>