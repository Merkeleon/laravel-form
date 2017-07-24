<div class="form__element form__element_type_checkbox @if($error) form__element_error @endif {{$class}}">
    <input type="hidden" value="0" name="{{ $elementName }}">
    <label class="form__label">
        <input @foreach($attributes as $attributeName => $attributeValue) {{ $attributeName }}="{{ $attributeValue }}" @endforeach type="checkbox" value="1" @if($checked) checked="checked" @endif name="{{ $elementName }}"> <span>{{ $label  }}</span>
    </label>
    <div class="form__feedback">{{ $error }}</div>
</div>