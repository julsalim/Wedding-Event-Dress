<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Models\OnlineUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('Login.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // $onlineUser = new OnlineUser;
        // $onlineUser->user_id = Auth::user()->id;
        // $onlineUser->dating_id = Auth::user()->dating_id;
        // $onlineUser->dating_code = Auth::user()->dating_code;
        // $onlineUser->gender = Auth::user()->gender;
        // $onlineUser->save();
        
        if (Auth::user()->isAdmin == 1) {
            return redirect('/admin');
        }
        if (Auth::user()->isBanned == 1) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            Cache::flush();

            return redirect('/login')->with('banned', 'Your account has been banned');
        }
        if(Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(3);
            Cache::put('user-is-online-' . Auth::user()->dating_code . '-' . Auth::user()->gender , true, $expiresAt);
        }
        return redirect()->intended('/waiting-room');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Cache::flush();

        return redirect('/');
    }
}
