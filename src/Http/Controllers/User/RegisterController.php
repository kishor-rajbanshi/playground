<?php

namespace KishorRajbanshi\LaravelAuth\Http\Controllers\User;

use Illuminate\Http\Request;

class RegisterController
{
    public function create()
    {
        return view('laravel-auth::pages.user.register');
    }

    public function store(Request $request)
    {
        //
    }
}
