<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;

class AccountStatsComposer
{
    public function compose(View $view)
    {
        $user = auth()->user();

        $sales = $user->sales;
        $files = $user->files()->finished()->get();

        $view->with([
            'fileCount' => $files->count(),
            'saleCount' => $sales->count(),
            'thisMonthEarned' => $user->saleValueThisMonth(),
            'thisMonthEarnedNoCommission' => $user->saleValueThisMonth(false),
            'lifetimeEarned' => $user->saleValueOverLifetime(),
            'lifetimeEarnedNoCommission' => $user->saleValueOverLifetime(false)
        ]);
    }
}
