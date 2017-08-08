<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Charts;
use App\Sale;

class AccountController extends Controller
{
    public function index()
    {
        return view('account.index');
    }
}
