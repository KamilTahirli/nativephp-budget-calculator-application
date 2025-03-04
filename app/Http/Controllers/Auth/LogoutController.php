<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * @param Request $request
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function logout(Request $request): \Illuminate\Foundation\Application|Redirector|Application|RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
