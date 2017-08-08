@extends('account.layouts.default')

@section('account.content')
    <a href="https://connect.stripe.com/oauth/authorize?response_type=code&state={{ session('stripe_token') }}&scope=read_write&client_id={{ config('services.stripe_connect.key') }}">Connect your Stripe account</a>
@endsection
