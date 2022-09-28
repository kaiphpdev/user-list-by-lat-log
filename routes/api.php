<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//API route for register new user
Route::post('/register', [App\Http\Controllers\Auth\LoginController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);


//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });


    Route::get('/users-list', function(Request $request) {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $distance = $request->distance;

        $aa = User::distance($latitude, $longitude, $distance);
        $aa1 = [];
        foreach ($aa as $key => $value) {
            $aa1[] = $value;
        }

        return response()->json(["data"=>$aa1]);

        // dd($aa);
    });



    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
