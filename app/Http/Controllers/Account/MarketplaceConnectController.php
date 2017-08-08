<?php

namespace App\Http\Controllers\Account;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarketplaceConnectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'has.marketplace']);
    }

    public function index()
    {
        session(['stripe_token' => str_random(60)]);

        return view('account.marketplace.index');
    }

    public function store(Request $request, Guzzle $guzzle)
    {
        if (!$request->code) {
            return redirect()->route('account.connect');
        }

        if ($request->state !== session('stripe_token')) {
            return redirect()->route('account.connect');
        }

        $stripeRequest = $guzzle->request('POST', 'https://connect.stripe.com/oauth/token', [
            'form_params' => [
                'client_secret' => config('services.stripe.secret'),
                'code' => $request->code,
                'grant_type' => 'authorization_code'
            ]
        ]);

        $stripeResponse = json_decode($stripeRequest->getBody());

        $request->user()->update([
            'stripe_id' => $stripeResponse->stripe_user_id,
            'stripe_key' => $stripeResponse->stripe_publishable_key
        ]);

        return redirect()->route('account.index')
                ->withSuccess('You have connected your Stripe account.');
    }
}
