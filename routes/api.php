<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/contacts', function (){
    return User::all();
});

Route::post('/contacts', function (){
    return User::create([
        'first_name' => request('first_name'),
        'last_name' => request('last_name'),
        'phone' => request('phone'),
        'email' => request('email'),
    ]);
});


