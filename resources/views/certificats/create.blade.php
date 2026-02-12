@extends('layouts.main')

@section('title', 'Ajouter un Certificat')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="bi bi-file-earmark-plus"></i> Ajouter un Certificat</h2>
    </div>
    <div class="card-body p-4">
        <!-- Alerte d'information -->
        <div class="alert alert-info mb-4" style="background: #DBEAFE; color: #1E40AF; border-color: #93C5FD;">
            <i class="bi bi-info-circle-fill"></i> 
            <strong>Information :</strong> Le certificat sera créé avec le statut "En attente". L'habitant devra se connecter pour effectuer le paiement de <strong>5 000 FCFA</strong>.
        </div>

        <form action="{{ route('certificats.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date_certificat" class="form-label"><i class="bi bi-calendar"></i> Date du certificat *</label>
                    <input type="date" class="form-control" id="date_certificat" name="date_certificat" value="{{ date('Y-m-d') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="habitant_id" class="form-label"><i class="bi bi-person"></i> Habitant *</label>
                    <select name="habitant_id" id="habitant_id" class="form-select" required>
                        <option value="">Choisir un habitant</option>
                        @foreach($habitants as $habitant)
                            <option value="{{ $habitant->id }}">
                                {{ $habitant->nom }} {{ $habitant->prenom }} - {{ $habitant->quartier }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('certificats.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Créer le Certificat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
