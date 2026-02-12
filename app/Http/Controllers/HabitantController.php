<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitant;

class HabitantController extends Controller
{
    public function __construct()
    {
        //Appliquer le middleware d'authentification et d'administration à toutes les méthodes de ce contrôleur
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    
        // cette partie affiche la liste de tous les habitants
        $habitants = Habitant::all();
        return view('habitants.index', compact('habitants'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //cette partie affiche le formulaire de creation
        return view('habitants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Valider et enregistrer les données dans la base de données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:habitants,email',
            'telephone' => 'required|string|unique:habitants,telephone',
            'date_naissance' => 'required|date',
            'quartier' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Habitant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'date_naissance' => $request->date_naissance,
            'quartier' => $request->quartier,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('habitants.index')
                         ->with('success', 'Habitant créé avec succès. Il peut maintenant se connecter avec son email et le mot de passe fourni.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habitant $habitant)
    {
        //Affiche le formulaire de modification
        return view('habitants.edit', compact('habitant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitant $habitant)
    {
        //mis à jour des données dans la base de données
        $habitant->update($request->all());
        return redirect()->route('habitants.index')
                         ->with('success', 'Habitant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitant $habitant)
    {
        $habitant->delete();
        return redirect()->route('habitants.index')
                         ->with('success', 'Habitant supprimé avec succès.');
    }
}
