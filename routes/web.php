<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Game;
use App\Http\Controllers\WaitingController;
use App\Http\Middleware\OnlineCheck;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

use App\Http\Middleware\BannedCheck;
use App\Http\Middleware\AdminCheck;

use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/waiting-room');
    }

    return redirect()->route('login');
})->middleware(['auth', 'verified'])->middleware(BannedCheck::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/waiting-room', [WaitingController::class, 'index'])->middleware(OnlineCheck::class)->middleware(BannedCheck::class);

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class)->name('landing')->middleware(BannedCheck::class);

Route::get('/game-room', function () {
    if(Game::where('player_2', null)->whereNot('player_1', Auth::user()->id)->exists()){
        $game = Game::where('player_2', null)->whereNot('player_1', Auth::user()->id)->first();
        $game->player_2 = Auth::user()->id;
        $game->save();
        $roomId = $game->roomId;

        return view('TicTacToe.tic', compact('roomId'));
    } else {

        $game = new Game();
        $game->player_1 = Auth::user()->id;
        $roomId = uniqid();
        $game->roomid = $roomId;
        $game->save();
        return view('TicTacToe.tic', compact('roomId'));
    }
    // return view('TicTacToe.tic');
});

Route::get('/reconnect', function(){
    if(Game::where('player_1', Auth::user()->id)->exists()){
        if(Game::where('player_1', Auth::user()->id)->where('player_2', null)->exists()){
            Game::where('player_1', Auth::user()->id)->where('player_2', null)->delete();
        }

        $game = Game::where('player_1', Auth::user()->id)->first();
        $game->player_1 = $game->player_2;
        $game->player_2 = null;
        $game->save();
    } else if(Game::where('player_2', Auth::user()->id)->exists()){
        DB::table('games')->where('player_2', Auth::user()->id)->update(['player_2', null]);
    }
});

Route::get('/restarts-game', function () {
    $user = Auth::user();
    

    if(Game::where('player1_id', Auth::user()->id)->exists()){
        if(Game::where('player1_id', Auth::user()->id)->where('player2_id', null)->exists()){
            Game::where('player1_id', Auth::user()->id)->delete();
        }
        $game = Game::where('player1_id', $user->id)->first();
        $game->player1_id = $game->player2_id;
        $game->player2_id = null;
        $game->save();
    } else if(Game::where('player2_id', Auth::user()->id)->exists()){
        DB::table('games')->where('player2_id', Auth::user()->id)->update(['player2_id' => null]);
    }
});

Route::post('/location-filter', [HomeController::class, 'filter'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class);
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class);

Route::get('/cart', [CartController::class, 'index'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class)->name('cart');
Route::post('/checkout', [CartController::class, 'checkout'])->middleware(OnlineCheck::class);
Route::get('/delete-cart/{id}', [CartController::class, 'deleteCart'])->middleware(OnlineCheck::class);

Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class)->middleware(AdminCheck::class);
Route::get('/ban/{id}', [AdminController::class, 'ban'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class)->middleware(AdminCheck::class);
Route::get('/unban/{id}', [AdminController::class, 'unban'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class)->middleware(AdminCheck::class);
Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class)->middleware(AdminCheck::class);
Route::post('/update-user/{id}', [AdminController::class, 'updateUser'])->middleware(['auth', 'verified'])->middleware(OnlineCheck::class)->middleware(AdminCheck::class);

require __DIR__.'/auth.php';
