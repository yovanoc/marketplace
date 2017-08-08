<?php

namespace App;

use App\Traits\Roles\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    /**
     * Route notifications for the Nexmo channel.
     *
     * @return string
     */
    public function routeNotificationForNexmo()
    {
        return "33783263010";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'stripe_id', 'stripe_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function saleValueOverLifetime($withCommission = true)
    {
        if ($withCommission) {
            return $this->sales->sum('sale_price');
        } else {
            return $this->sales->sum(function ($sale) {
                return $sale->sale_price - $sale->sale_commission;
            });
        }
    }

    public function saleValueThisMonth($withCommission = true)
    {
        $now = Carbon::now();

        $sales = $this->sales()->whereBetween('created_at', [
            $now->startOfMonth(),
            $now->copy()->endOfMonth()
        ])->get();

        if ($withCommission) {
            return $sales->sum('sale_price');
        } else {
            return $sales->sum(function ($sale) {
                return $sale->sale_price - $sale->sale_commission;
            });
        }
    }

    public function isTheSameAs(User $user)
    {
        return $user->id === $this->id;
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
