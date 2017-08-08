<?php

namespace App\Http\Controllers\Checkout;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\FreeCheckoutRequest;
use App\File;
use App\Jobs\Checkout\CreateSale;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function free(FreeCheckoutRequest $request, File $file)
    {
        if (!$file->isFree()) {
            return back();
        }

        dispatch(new CreateSale($file, $request->email));

        return back()->withSuccess("We've emailed your download link to you.");
    }

    public function payment(Request $request, File $file)
    {
        try {
            $charge = Charge::create([
                'amount' => $file->price * 100,
                'currency' => 'eur',
                'source' => $request->stripeToken,
                'application_fee' => ceil($file->calculateCommission() * 100)
            ], [
                'stripe_account' => $file->user->stripe_id
            ]);

        } catch (Exception $e) {
            return back()->withError('Something went wrong while processing your payment.');
        }

        dispatch(new CreateSale($file, $request->stripeEmail));

        return back()->withSuccess("Payment complete. We've emailed your download link to you.");
    }
}
