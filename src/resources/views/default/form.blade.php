<form class="form {{$class}}" role="form"
      @if ($isAjax) data-toggle="ajax-form" @endif
      @if ($enctype) enctype="{{$enctype}}" @endif
      @if ($name) id="form-name-{{ $name }}" data-name="{{$name}}" @endif
      method="{{$method}}" action="{{ $action }}">
    <div class="form__container">
        @foreach($elements as $element)
            {{ $element->render() }}
        @endforeach
        @if(!str_is('get', $method))
            {{ csrf_field() }}
        @endif
    </div>
</form>