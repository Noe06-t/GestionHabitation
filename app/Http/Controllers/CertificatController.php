<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificat;
use App\Models\Habitant;
class CertificatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Lister tous les certificats
        $certificats = Certificat::with('habitant')->get();
        return view('certificats.index', compact('certificats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Formulaire de création d'un certificat
        $habitants = Habitant::all();
        return view('certificats.create', compact('habitants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Eneregistrer un nouveau certificat
        Certificat::create($request->all());
        return redirect()->route('certificats.index')
                         ->with('success', 'Certificat créé avec succès.'); 
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
    public function edit(Certificat $certificat)
    {
        $habitants = Habitant::all();
        return view('certificats.edit', compact('certificat', 'habitants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificat $certificat)
    {
        $certificat->update($request->all());
        return redirect()->route('certificats.index')
                         ->with('success', 'Certificat mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificat $certificat)
    {
        $certificat->delete();
        return redirect()->route('certificats.index')
                         ->with('success', 'Certificat supprimé avec succès.');
    }
}
