<form action="{{ route('checkout.free', $file) }}" method="post">
    {{ csrf_field() }}
    
    <span class="field has-addons">
        <p class="control">
            <input type="email" name="email" class="input" id="email" required placeholder="you@somewhere.com" value="{{ old('email') }}">
        </p>
        <p class="control">
            <button class="button is-primary">Download for free</button>
        </p>
    </span>
    @if($errors->has('email'))
        <p class="help is-danger">{{ $errors->first('email') }}</p>
    @endif
</form>
