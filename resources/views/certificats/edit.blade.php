<h1>Modifier Certificat</h1>

<form action="{{ route('certificats.update', $certificat->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="date" name="date_certificat" value="{{ $certificat->date_certificat }}"><br><br>

    <select name="habitant_id">
        @foreach($habitants as $habitant)
            <option value="{{ $habitant->id }}"
                {{ $certificat->habitant_id == $habitant->id ? 'selected' : '' }}>
                {{ $habitant->nom }} {{ $habitant->prenom }}
            </option>
        @endforeach
    </select><br><br>

    <button type="submit">Modifier</button>
</form>
