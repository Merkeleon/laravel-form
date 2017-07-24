<div class="form__element form__element_type_password @if($error) form__element_error @endif {{$class}}">
    <label class="form__label">{{ $label }}</label>
    <div class="form__element-container">
        <input @foreach($attributes as $attributeName => $attributeValue) {{ $attributeName }}="{{ $attributeValue }}" @endforeach type="password" name="{{ $elementName }}" placeholder="{{ $placeholder }}">
    </div>
    <div class="form__feedback">{{ $error }}</div>
</div>