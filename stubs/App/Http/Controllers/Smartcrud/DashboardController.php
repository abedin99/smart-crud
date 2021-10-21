<?php

namespace App\Http\Controllers\Smartcrud;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the Dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('smartcrud.auth.dashboard');
    }

}
