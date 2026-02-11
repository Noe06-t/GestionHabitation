<h1>Modifier Habitant</h1>

<form action="{{ route('habitants.update', $habitant->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nom" value="{{ $habitant->nom }}"><br>
    <input type="text" name="prenom" value="{{ $habitant->prenom }}"><br>
    <input type="email" name="email" value="{{ $habitant->email }}"><br>
    <input type="text" name="telephone" value="{{ $habitant->telephone }}"><br>
    <input type="date" name="date_naissance" value="{{ $habitant->date_naissance }}"><br>
    <input type="text" name="quartier" value="{{ $habitant->quartier }}"><br>

    <button type="submit">Modifier</button>
</form>
