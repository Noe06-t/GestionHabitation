<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HabitantAuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion habitant
     */
    public function showLoginForm()
    {
        return view('habitant.login');
    }

    /**
     * Traiter la connexion habitant
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('habitant')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('habitant.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
        ]);
    }

    /**
     * Déconnexion habitant
     */
    public function logout(Request $request)
    {
        Auth::guard('habitant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('habitant.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
