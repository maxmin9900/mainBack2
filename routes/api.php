<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\Home\SearchController;
use App\Http\Controllers\Home\ServicesController;
use App\Http\Controllers\Api\Providers\ServicesController as ServiceProvidersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1'
], function () {
    Route::post('auth/login', [LoginController::class, 'index']);
    Route::post('auth/register', [RegisterController::class, 'index']);


    Route::group([
        'middleware' => ['auth:sanctum']
    ], function () {
        # Auth
        Route::post('auth/logout', [LoginController::class, 'logout']);
        # Profile
        Route::post('profile', [ProfileController::class, 'update']);
        Route::post('profile/avatar', [ProfileController::class, 'avatar']);
        Route::get('profile', [ProfileController::class, 'index']);

        #Dashboard
        Route::post('dashboard/services', [ServiceProvidersController::class, 'store']);
        Route::patch('dashboard/services', [ServiceProvidersController::class, 'update']);
        Route::get('dashboard/services', [ServiceProvidersController::class, 'index']);

    });


    #Service
    Route::get('services/{id}', [ServicesController::class, 'show']);
    Route::get('services', [ServicesController::class, 'index']);

    #Search
    Route::get('search/providers', [SearchController::class, 'providers']);
    Route::get('search', [SearchController::class, 'index']);
    Route::get('search', [SearchController::class, 'index']);
    Route::get('profile/{id}', [ProfileController::class, 'getProfile']);

});
//these are two methods for creating fake data from blockchain
Route::get('getAllProviderScore', function () {
    return json_encode(
        [
            "scores" => [
                ["provider" => '0xd17a21F2d613fB2c71b81f75Ca1c7Dd9815bd668', "scCount" => 1, "scTotal" => 34],
                ["provider" => '0xd17a21F2d613fB2c71b81f75Ca1c7Dd9815bd663', "scCount" => 4, "scTotal" => 10],
                ["provider" => '0xd17a21F2d613fB2c71b81f75Ca1c7Dd9815bd665', "scCount" => 5, "scTotal" => 100]
            ]
        ]
    );
});
Route::get('getAllProviderPopularity', function () {
    return json_encode(
        ["popularity" => [
            ["provider" => '0xd17a21F2d613fB2c71b81f75Ca1c7Dd9815bd668', "inCount" => 2],
            ["provider" => '0xd17a21F2d613fB2c71b81f75Ca1c7Dd9815bd663', "inCount" => 4],
            ["provider" => '0xd17a21F2d613fB2c71b81f75Ca1c7Dd9815bd665', "inCount" => 8]]]
    );
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
