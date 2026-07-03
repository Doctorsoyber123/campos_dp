<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('reginde.panel');
        }

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $ok = Auth::attempt([
            'name' => $credentials['username'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'));

        if (!$ok) {
            return back()->withErrors(['username' => 'Usuario o contraseña incorrectos.'])->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('reginde.panel'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
