<?php

use Illuminate\Support\Facades\Route;
use KishorRajbanshi\LaravelAuth\Http\Middleware\User\Guest;
use KishorRajbanshi\LaravelAuth\Http\Controllers\User\RegisterController;

Route::middleware(Guest::class)->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::name('register')->prefix('/register')
            ->group(function () {
                Route::get('/', 'create');
                Route::post('/', 'store');
            });
    });
});

// Route model binding
// use App\Models\User;
//
// Route::get('/users/{user}', function (User $user) {
//     return $user->email;
// });
//
// Controller method definition...
// public function show(User $user)
// {
//     return view('user.profile', ['user' => $user]);
// }

Route::fallback(function () {
    return view('laravel-auth::pages.errors.404');
});
