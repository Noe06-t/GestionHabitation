<h1>Ajouter un Certificat</h1>

<form action="{{ route('certificats.store') }}" method="POST">
    @csrf

    <input type="date" name="date_certificat"><br><br>

    <select name="habitant_id">
        <option value="">Choisir un habitant</option>
        @foreach($habitants as $habitant)
            <option value="{{ $habitant->id }}">
                {{ $habitant->nom }} {{ $habitant->prenom }}
            </option>
        @endforeach
    </select><br><br>

    <button type="submit">Enregistrer</button>
</form>
