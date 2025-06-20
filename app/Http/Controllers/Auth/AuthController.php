<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return to_route('login.show');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return to_route('orders.index');
        }

        return back()->withErrors([
            'email' => __('The provided credentials do not match our records.'),
        ])->withInput();
    }

    public function register(UserRequest $request): RedirectResponse
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole("user");

        Auth::login($user);

        return to_route('orders.index');
    }
}
