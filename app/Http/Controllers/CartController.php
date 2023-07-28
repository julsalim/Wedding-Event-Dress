<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Dress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //

    public function index () {

        $cart = Cart::where('user_id', Auth::user()->id)->get();

        $dresses = [];
        $totalPrice = 0;
        foreach ($cart as $index=>$item) {
            $dresses[] = Dress::where('id', $item->dress_id)->first();
            $totalPrice += $dresses[$index]->price;
        }


        


        return view('Cart.cart', compact('cart', 'dresses', 'totalPrice'));
    }

    public function addToCart(Request $request) {
        $dress = Dress::where('id', $request->input('dressId'))->first();
        $user = User::where('id', $request->input('userId'))->first();

        $cart = new Cart;
        $cart->dress_id = $dress->id;
        $cart->user_id = $user->id;
        $cart->save();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function checkout (Request $request) {
        
        // remove all cart items from database that id matches the user id
        Cart::where('user_id', Auth::user()->id)->delete();

        
    }

    public function deleteCart ($id) {
        Cart::where('dress_id', $id)->where('user_id', Auth::user()->id)->delete();

        return redirect()->back();
    }
}
