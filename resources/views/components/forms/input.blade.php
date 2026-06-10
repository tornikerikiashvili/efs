<div class="form-group{{ $errors->has($name) ? ' has-danger' : '' }}">
    <label class="form-control-label" for="input-name">{{ __($headline) }}</label>
    <input type="{{$type}}" name={{$name}} id="input-name" {{$disabled ? 'disabled' : ''}}
        class="form-control form-control-alternative{{ $errors->has($name) ? ' is-invalid' : '' }}"
        placeholder="{{ __($headline) }}" value="{{ $value }}"
         autofocus>

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
