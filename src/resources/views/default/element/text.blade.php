<div class="form__element form__element_type_text @if($error) form__element--error @endif {{$class}}">
    <label class="form__label">{{ $label }}</label>
    <div class="form__element-container">
        <input @foreach($attributes as $attributeName => $attributeValue) {{ $attributeName }}="{{ $attributeValue }}" @endforeach type="text" value="{{ $value }}" name="{{ $elementName }}" placeholder="{{ $placeholder }}">
        @if ($postfix)
        <span class="form__element-group-addon">{{$postfix}}</span>
        @endif
    </div>
    <div class="form__feedback">{{ $error }}</div>
</div>