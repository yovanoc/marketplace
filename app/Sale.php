<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sale extends Model
{
    protected $fillable = [
        'identifier', 'buyer_email', 'sale_price', 'sale_commission'
    ];

    public function getRouteKeyName()
    {
        return 'identifier';
    }

    public static function lifetimeCommission()
    {
        return static::get()->sum('sale_commission');
    }

    public static function commissionThisMonth()
    {
        $now = Carbon::now();

        return static::whereBetween('created_at', [
            $now->startOfMonth(),
            $now->copy()->endOfMonth()
        ])->get()->sum('sale_commission');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
