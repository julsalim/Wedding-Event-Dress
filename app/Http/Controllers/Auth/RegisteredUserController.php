<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('Register.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $userRegistration = $request->validate([
            'name' => ['required', 'string', 'min:3','max:255'],
            'datingCode' => ['required', 'max:3', 'min:3'],
            'birthDate' => ['required', 'before:today'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'email:dns'],
            'phoneNumber' => ['required', 'min:10', 'max:15', 'regex:/^8\w*/'],
            'image' => ['required', 'image', 'max:5000', 'file'],
            'password' => ['required', 'min:8', ],
        ]);
        
        // dd($userRegistration->errors());
        
        $userRegistration['dating_id'] = 'SKY'.$request->datingCode."0".$request->gender;
        $userRegistration['image'] = $request->file('image')->store('profile-images');
        $userRegistration['phoneNumber'] = '+65'.$request->phoneNumber;

        $user = User::all();

        foreach ($user as $u) {
            if($u->gender == $request->gender && $u->dating_code == $request->datingCode){
                return redirect('/register')->with('failed', 'Dating code have been used');
            }
        }

        $user = User::create([
            'dating_id' => $userRegistration['dating_id'],
            'name' => $userRegistration['name'],
            'email' => $userRegistration['email'],
            'password' => Hash::make($userRegistration['password']),
            'dating_code' => $userRegistration['datingCode'],
            'date_of_birth' => $userRegistration['birthDate'],
            'gender' => $userRegistration['gender'],
            'phone_number' => $userRegistration['phoneNumber'],
            'profile_picture' => $userRegistration['image'],
            'password' => $userRegistration['password'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME)->with('success', 'Selamat akun anda berhasil dibuat, anda dapat login menggunakan'. $request->email .' atau '. $request->dating_id);
        return redirect('/waiting-room')->with('success', 'Selamat akun anda berhasil dibuat, anda dapat login menggunakan '. $request->email .' atau '. $userRegistration['dating_id']);
    }
}
