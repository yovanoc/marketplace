<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;
use App\{File, Sale};

class AdminStatsComposer
{
    public function compose(View $view)
    {
        $view->with([
            'fileCount' => File::finished()->approved()->count(),
            'saleCount' => Sale::count(),
            'commissionThisMonth' => Sale::commissionThisMonth(),
            'lifetimeCommission' => Sale::lifetimeCommission()
        ]);
    }
}
