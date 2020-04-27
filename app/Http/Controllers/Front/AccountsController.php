<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountsController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('front.accounts');
    }
}
