<?php

use App\Events\MessageBroadcasted;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send', function () {
    event(new MessageBroadcasted(Request::query('message') ?? 'Hello from Laravel 13 🚀'));

    return 'Message sent!';
});
