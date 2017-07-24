<div class="form__element form__element_type_submit">
    <div class="form__element-container">
        <button @foreach($attributes as $attributeName => $attributeValue) {{ $attributeName }}="{{ $attributeValue }}" @endforeach @if (!array_has($attributes, 'class')) class="btn" @endif type="submit" name="{{$elementName}}" value="1">{{ $label }}</button>
    </div>
</div>