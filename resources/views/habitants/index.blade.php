<h1>Liste des Habitants</h1>

<a href="{{ route('habitants.create') }}">Ajouter un habitant</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1">
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Quartier</th>
        <th>Téléphone</th>
        <th>Date de naissance</th>
    </tr>

    @foreach($habitants as $habitant)
    <tr>
        <td>{{ $habitant->nom }}</td>
        <td>{{ $habitant->prenom }}</td>
        <td>{{ $habitant->email }}</td>
        <td>{{ $habitant->quartier }}</td>
        <td>{{ $habitant->telephone }}</td>
        <td>{{ $habitant->date_naissance }}</td>
        <td>
            <a href="{{ route('habitants.edit', $habitant->id) }}">Modifier</a>

            <form action="{{ route('habitants.destroy', $habitant->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
