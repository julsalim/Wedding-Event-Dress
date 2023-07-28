<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Dress;
use App\Models\Location;

class HomeController extends Controller
{
    //
    public function index() {

        $user = User::where('id', Auth::user()->id)->first();
        $genders = $user->gender;

        $partnerGender = $genders == "1" ? "2" : "1";


        if (!Cache::has('user-is-online-' . $user->dating_code . '-' . $partnerGender)) {
            return redirect('/waiting-room');
        }

        $partner = User::where('dating_code', Auth::user()->dating_code)->where('gender', $partnerGender)->first();

        $dresses = Dress::all();

        // shuffle the dress
        $dresses = $dresses->shuffle();
        $location = Location::all();
        
        return view('Landing.landing', compact('user', 'partner', 'dresses', 'location'));
    }

    public function filter (Request $request) {
        // echo $request->input('locationId');

        $filtered = Dress::all();

        $filtered = $filtered->shuffle();

        if ($request->input('locationId') != 0) {
            $filtered = $filtered->where('location_id', $request->input('locationId'));
        }

        foreach ($filtered as $index=>$dress) {
            $gender = $dress->gender == '1' ? 'Male' : 'Female';
            $location = ($dress->location_id == '1') ? 'Tangerang' : ($dress->location_id == '2' ? 'Singapore' : 'Jakarta');
            $price = number_format($dress->price, 0, ',', '.');
            $onclick = "addToCart($dress->id)";
            echo 
            "<div class='col-md-6 col-lg-4 col-xl-3'>
                <div id='product-$index' class='single-product'>
                    <div class='part-1'>
                        <span class='new'>$gender</span>
                        <span class='discount'>$location</span>
                            <ul>
                                    <li><a onclick='$onclick'><i class='fas fa-shopping-cart'></i></a></li>
                            </ul>
                    </div>
                    <div class='part-2'>
                            <h3 class='product-title'>$dress->name</h3>
                            <h4 class='product-price'>Rp $price</h4>
                            
                    </div>
                </div>
            </div>
            
            <style>
                .section-products #product-$index .part-1::before {
                    background: url('$dress->image') no-repeat center;
                    background-size: cover;
                }
            </style>
            "
            
            ;
        }

        

                    
    }
}
