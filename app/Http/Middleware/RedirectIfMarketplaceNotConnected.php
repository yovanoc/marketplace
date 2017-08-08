<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfMarketplaceNotConnected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->stripe_id) {
            return redirect()->route('account.connect')
                    ->withError('Please connect a Stripe account.');
        }

        return $next($request);
    }
}
