@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container is-fluid">
            <div class="columns">
                <div class="column is-half is-offset-one-quarter">
                    <h1 class="title">Let's get you ready for selling</h1>
                    <form action="#" method="post" class="form">
                        {{ csrf_field() }}

                        <div class="field">
                            <label for="email" class="label">Email</label>
                            <p class="control">
                                <input required type="email" name="email" id="email" placeholder="e.g. mabel@codecourse.com" class="input{{ $errors->has('email') ? ' is-danger' : '' }}" value="{{ old('email') }}">
                            </p>
                            @if ($errors->has('email'))
                                <p class="help is-danger">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="name" class="label">Name</label>
                            <p class="control">
                                <input required type="text" name="name" id="name" placeholder="e.g. Mabel" class="input{{ $errors->has('name') ? ' is-danger' : '' }}" value="{{ old('name') }}">
                            </p>
                            @if ($errors->has('name'))
                                <p class="help is-danger">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="password" class="label">Choose a password</label>
                            <p class="control">
                                <input required type="password" name="password" id="password" class="input{{ $errors->has('name') ? ' is-danger' : '' }}">
                            </p>
                            @if ($errors->has('password'))
                                <p class="help is-danger">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>

                        <div class="field">
                            <label for="password-confirm" class="label">Repeat your password</label>
                            <p class="control">
                                <input required type="password" name="password_confirmation" id="password-confirm" class="input{{ $errors->has('name') ? ' is-danger' : '' }}">
                            </p>
                            @if ($errors->has('password-confirm'))
                                <p class="help is-danger">
                                    {{ $errors->first('password-confirm') }}
                                </p>
                            @endif
                        </div>

                        <div class="field">
                            <p class="control">
                                <button class="button is-primary">Sign up</button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
