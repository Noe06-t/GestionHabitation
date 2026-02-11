@extends('layouts.main')

@section('title', 'Liste des Habitants')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-people"></i> Liste des Habitants</h2>
        <div>
            <a href="{{ route('certificats.index') }}" class="btn btn-light me-2">
                <i class="bi bi-file-earmark-text"></i> Certificats
            </a>
            <a href="{{ route('habitants.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Ajouter un habitant
            </a>
        </div>
    </div>
    <div class="card-body p-4">
        @if($habitants->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun habitant enregistré</p>
                <a href="{{ route('habitants.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter le premier habitant
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person"></i> Nom</th>
                            <th><i class="bi bi-person"></i> Prénom</th>
                            <th><i class="bi bi-envelope"></i> Email</th>
                            <th><i class="bi bi-geo-alt"></i> Quartier</th>
                            <th><i class="bi bi-telephone"></i> Téléphone</th>
                            <th><i class="bi bi-calendar"></i> Date de naissance</th>
                            <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($habitants as $habitant)
                        <tr>
                            <td class="fw-semibold">{{ $habitant->nom }}</td>
                            <td>{{ $habitant->prenom }}</td>
                            <td>{{ $habitant->email }}</td>
                            <td>{{ $habitant->quartier }}</td>
                            <td>{{ $habitant->telephone }}</td>
                            <td>{{ \Carbon\Carbon::parse($habitant->date_naissance)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('habitants.edit', $habitant->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <form action="{{ route('habitants.destroy', $habitant->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet habitant ?')">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
