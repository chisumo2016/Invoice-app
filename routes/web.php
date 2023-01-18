<?php

use App\Http\Controllers\API\V1\CustomerController;
use App\Http\Controllers\API\V1\InvoiceController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});
Route::resource('customers', CustomerController::class);
Route::resource('invoices', InvoiceController::class);

Route::get('/setup', function (){
    $credentials =[
        'email' => 'admin@test.com',
        'password' => 'password'
    ];

    if (!Auth::attempt($credentials)){
        $user = new \App\Models\User();

        $user -> name = 'Admin';
        $user -> email = $credentials['email'];
        $user -> password = \Illuminate\Support\Facades\Hash::make($credentials['password']);

        $user->save();

        if (Auth::attempt($credentials)){
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token',['create', 'update','delete']);
            $updateToken = $user->createToken('update-token',['create', 'update']);
            $basicToken  = $user->createToken('basic-token');

            return [
                'admin'  => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' =>  $basicToken->plainTextToken,
            ];
        }
    }
});
