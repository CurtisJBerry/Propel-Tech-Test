<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return redirect()->route('users.index');
});

Route::get('/create', function () {

    return view('create-contact');
})->name('create');

Route::resource('/users', UserController::class);

Route::controller(UserController::class)->group(function () {
    Route::get('/users/{id}', 'show')->name('show');

    Route::get('/users/update/{id}', function ($id){
        if(file_exists(storage_path('\app\public\contacts.json'))){
            // Read File
            $jsonString = file_get_contents(storage_path('\app\public\contacts.json'));

            $collection = collect(json_decode($jsonString, true));

            $data = $collection->get($id);

            return view('update-contact', compact('data', 'id'));

        }else{
            return back()->with('error', 'Record could not be found.');
        }
    })->name('update-page');

    Route::post('/users/update/{id}','update')->name('update');

    Route::post('/users/store/{id}','store')->name('store');

    Route::get('/users/delete/{id}','destroy')->name('destroy');

    Route::post('/users/search','search')->name('search');
});
