<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('complete-login/{user}', function (User $user) {
    if (! $user->email_verified_at) {
        $user->email_verified_at = now();
        $user->save();
    }

    Auth::login($user, remember: true);

    return redirect('/home');
})->middleware(['guest', 'signed'])->name('complete-login');
