<div class="form__element form__element_type_textarea @if($error) form__element_error @endif {{$class}}">
    <label class="form__label">{{ $label }}</label>
    <div class="form__element-container">
        <textarea rows="5" @foreach($attributes as $attributeName => $attributeValue) {{ $attributeName }}="{{ $attributeValue }}" @endforeach name="{{ $elementName }}" placeholder="{{ $placeholder }}">{{ $value }}</textarea>
        <div class="form__feedback">{{ $error }}</div>
    </div>
</div>