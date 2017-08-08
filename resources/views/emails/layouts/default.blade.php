@if(isset($user))
    <p>Hi {{ $user->name }}</p>
@else
    <p>Hi there</p>
@endif

@yield('content')

<p>Thanks,<br>{{ config('app.name') }}</p>