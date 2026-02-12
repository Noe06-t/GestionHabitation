@extends('layouts.main')

@section('title', 'Ajouter un Habitant')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="bi bi-person-plus"></i> Ajouter un Habitant</h2>
    </div>
    <div class="card-body p-4">
        <div class="alert alert-info mb-4" style="background: #DBEAFE; color: #1E40AF; border-color: #93C5FD;">
            <i class="bi bi-info-circle-fill"></i> 
            <strong>Information :</strong> Lors de la création d'un habitant, un compte de connexion sera automatiquement créé. L'habitant pourra se connecter avec son email et le mot de passe que vous définissez.
        </div>

        <form action="{{ route('habitants.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label"><i class="bi bi-person"></i> Nom *</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez le nom" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label"><i class="bi bi-person"></i> Prénom *</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez le prénom" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email *</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="exemple@email.com" required>
                    <small class="text-muted">Servira d'identifiant de connexion</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label"><i class="bi bi-telephone"></i> Téléphone *</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="77 123 45 67" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date_naissance" class="form-label"><i class="bi bi-calendar"></i> Date de naissance *</label>
                    <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="quartier" class="form-label"><i class="bi bi-geo-alt"></i> Quartier *</label>
                    <input type="text" class="form-control" id="quartier" name="quartier" placeholder="Entrez le quartier" required>
                </div>
            </div>

            <div class="card mb-3" style="border: 2px solid #2563EB; background: #EFF6FF;">
                <div class="card-body">
                    <h5 style="color: #2563EB;"><i class="bi bi-key"></i> Identifiants de connexion</h5>
                    <div class="row mt-3">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label"><i class="bi bi-lock"></i> Mot de passe *</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Minimum 8 caractères" required minlength="8">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label"><i class="bi bi-lock-fill"></i> Confirmer le mot de passe *</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Répéter le mot de passe" required minlength="8">
                        </div>
                    </div>
                    <small class="text-muted"><i class="bi bi-info-circle"></i> Communiquez ces identifiants à l'habitant pour qu'il puisse se connecter.</small>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('habitants.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
