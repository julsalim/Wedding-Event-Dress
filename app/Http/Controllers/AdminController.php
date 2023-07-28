<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //

    public function index () {
        $users = User::where('isAdmin', 0)->get();

        return view('Landing.admin', compact('users'));
    }

    public function ban ($id) {
        $user = User::where('id', $id)->first();
        $user->isBanned = 1;
        $user->save();

        return redirect()->back();
    }

    public function unban ($id) {
        $user = User::where('id', $id)->first();
        $user->isBanned = 0;
        $user->save();

        return redirect()->back();
    }

    public function editUser ($id) {
        $user = User::where('id', $id)->first();

        return view('Edit.edit', compact('user'));
    }

    public function updateUser (Request $request, $id) {
        $user = User::where('id', $id)->first();
        
        $user->name = $request->name;
        $user->date_of_birth = $request->birthDate;
        $user->gender = $request->gender;
        $user->phone_number = $request->phoneNumber;

        if($request->file('image') != null){
            $user->profile_picture = $request->file('image')->store('profile-images');
        }
        
        $user->save();

        return redirect('/admin');
    }
}
