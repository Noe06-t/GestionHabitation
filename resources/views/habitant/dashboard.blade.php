@extends('layouts.habitant')

@section('title', 'Mes Certificats')

@section('content')
<div class="mb-4">
    <h1><i class="bi bi-person-badge"></i> Mes Certificats d'Habitation</h1>
    <p class="text-muted">Bonjour {{ $habitant->prenom }} {{ $habitant->nom }}</p>
</div>

<!-- Mode Simulation -->
@if(env('PAYDUNYA_SIMULATE'))
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill"></i> 
        <strong>Mode Simulation Activé</strong> - Les paiements sont simulés et ne passent pas par PayDunya.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Messages de succès ou erreur -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show">
        <i class="bi bi-info-circle-fill"></i> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Liste de vos certificats</h5>
    </div>
    <div class="card-body">
        @if($certificats->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date du certificat</th>
                            <th>Statut</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificats as $certificat)
                            <tr>
                                <td>#{{ $certificat->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($certificat->date_certificat)->format('d/m/Y') }}</td>
                                <td>
                                    @if($certificat->statut === 'paye')
                                        <span class="badge" style="background: #059669; color: white; padding: 0.5rem 1rem;">
                                            <i class="bi bi-check-circle"></i> Payé
                                        </span>
                                    @else
                                        <span class="badge" style="background: #F59E0B; color: white; padding: 0.5rem 1rem;">
                                            <i class="bi bi-clock"></i> En attente
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $certificat->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($certificat->statut === 'paye')
                                        <a href="{{ route('habitant.certificat.show', $certificat->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Voir le certificat
                                        </a>
                                    @else
                                        <form action="{{ route('habitant.certificat.payer', $certificat->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-credit-card"></i> Payer (5 000 FCFA)
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Vous n'avez aucun certificat pour le moment.
            </div>
        @endif
    </div>
</div>

<!-- Informations supplémentaires -->
<div class="card mt-4" style="border: 1px solid #2563EB; background: #EFF6FF;">
    <div class="card-body">
        <h5 style="color: #2563EB;"><i class="bi bi-info-circle"></i> Informations importantes</h5>
        <ul class="mb-0">
            <li>Les certificats sont créés par l'administration et apparaissent ici avec le statut "En attente"</li>
            <li>Vous devez effectuer un paiement de <strong>5 000 FCFA</strong> pour accéder à votre certificat</li>
            <li>Une fois le paiement effectué, le statut passe à "Payé" et vous pouvez télécharger votre certificat</li>
            <li>Paiement sécurisé via PayDunya (Mobile Money, Carte bancaire)</li>
        </ul>
    </div>
</div>

@section('styles')
<style>
    .badge {
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .table th {
        background: var(--primary-color);
        color: white;
        font-weight: 600;
    }
    
    .table-hover tbody tr:hover {
        background: #F3F4F6;
    }
</style>
@endsection
@endsection
