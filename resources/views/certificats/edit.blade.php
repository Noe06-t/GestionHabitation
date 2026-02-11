@extends('layouts.main')

@section('title', 'Modifier Certificat')

@section('content')
<div class="card">
    <div class="card-header">
        <h2><i class="bi bi-pencil-square"></i> Modifier Certificat</h2>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('certificats.update', $certificat->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date_certificat" class="form-label"><i class="bi bi-calendar"></i> Date du certificat *</label>
                    <input type="date" class="form-control" id="date_certificat" name="date_certificat" value="{{ $certificat->date_certificat }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="habitant_id" class="form-label"><i class="bi bi-person"></i> Habitant *</label>
                    <select name="habitant_id" id="habitant_id" class="form-select" required>
                        @foreach($habitants as $habitant)
                            <option value="{{ $habitant->id }}" {{ $certificat->habitant_id == $habitant->id ? 'selected' : '' }}>
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
                    <i class="bi bi-check-circle"></i> Modifier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
