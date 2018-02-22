<div class="form__element form__element_type_submit">
    <div class="form__element-container">
        <button @foreach($attributes as $attributeName => $attributeValue) @if ($attributeName != 'class') {{ $attributeName }}="{{ $attributeValue }}" @endif @endforeach class="{{ $buttonClass }} {{ $class }}"type="submit" name="{{$elementName}}" value="1">{{ $label }}</button>
    </div>
</div>