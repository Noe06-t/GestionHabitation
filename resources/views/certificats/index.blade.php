@extends('layouts.main')

@section('title', 'Liste des Certificats')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2><i class="bi bi-file-earmark-text"></i> Liste des Certificats</h2>
        <div>
            <a href="{{ route('habitants.index') }}" class="btn btn-light me-2">
                <i class="bi bi-people"></i> Habitants
            </a>
            <a href="{{ route('certificats.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i> Ajouter un certificat
            </a>
        </div>
    </div>
    <div class="card-body p-4">
        @if($certificats->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun certificat enregistré</p>
                <a href="{{ route('certificats.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter le premier certificat
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="bi bi-calendar"></i> Date du certificat</th>
                            <th><i class="bi bi-person"></i> Habitant</th>
                            <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificats as $certificat)
                        <tr>
                            <td class="fw-semibold">{{ \Carbon\Carbon::parse($certificat->date_certificat)->format('d/m/Y') }}</td>
                            <td>{{ $certificat->habitant->nom }} {{ $certificat->habitant->prenom }}</td>
                            <td class="text-center">
                                <a href="{{ route('certificats.edit', $certificat->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <form action="{{ route('certificats.destroy', $certificat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce certificat ?')">
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
