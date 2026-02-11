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
        //Enregistrer les données dans la base de données
        Habitant::create($request->all());
        return redirect()->route('habitants.index')
                         ->with('success', 'Habitant créé avec succès.');
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
