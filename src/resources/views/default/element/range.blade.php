<div class="form__element form__element_type_range @if($error) form__element_error @endif {{$class}}">
    <label class="form__label">{{ $label }}</label>
    <div class="form__element-container form__element-container_range">
        @spaceless
            <input @foreach($attributes as $attributeName => $attributeValue) {{ $attributeName }}="{{ $attributeValue }}" @endforeach type="text" value="{{ array_get($value, 'from') }}" name="{{ $elementName }}[from]" placeholder="{{trans('frontend.form.range.from')}}">
            <input @foreach($attributes as $attributeName => $attributeValue) {{ $attributeName }}="{{ $attributeValue }}" @endforeach type="text" value="{{ array_get($value, 'to') }}" name="{{ $elementName }}[to]" placeholder="{{trans('frontend.form.range.to')}}">
        @endspaceless
        <div class="form__help">{{ $help }}</div>
        <div class="form__feedback">{{ $error }}</div>
    </div>
</div>