<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WaitingController extends Controller
{
    //

    public function index() {
        $user = User::where('id', Auth::user()->id)->first();
        $genders = $user->gender;

        $partnerGender = $genders == "1" ? "2" : "1";

        if (Cache::has('user-is-online-' . $user->dating_code . '-' . $partnerGender)) {
            return redirect('/home');
        }
        
        return view('Landing.waiting', compact('user',));
    }
}
