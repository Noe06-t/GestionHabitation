<h1>Liste des Certificats</h1>

<a href="{{ route('certificats.create') }}">Ajouter un certificat</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <th>Date</th>
        <th>Habitant</th>
        <th>Actions</th>
    </tr>

    @foreach($certificats as $certificat)
    <tr>
        <td>{{ $certificat->date_certificat }}</td>
        <td>{{ $certificat->habitant->nom }} {{ $certificat->habitant->prenom }}</td>
        <td>
            <a href="{{ route('certificats.edit', $certificat->id) }}">Modifier</a>

            <form action="{{ route('certificats.destroy', $certificat->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
