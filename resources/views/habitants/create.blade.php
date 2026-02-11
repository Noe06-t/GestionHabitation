<h1>Ajouter un Habitant</h1>

<form action="{{ route('habitants.store') }}" method="POST">
    @csrf

    <input type="text" name="nom" placeholder="Nom"><br>
    <input type="text" name="prenom" placeholder="Prénom"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="text" name="telephone" placeholder="Téléphone"><br>
    <input type="date" name="date_naissance"><br>
    <input type="text" name="quartier" placeholder="Quartier"><br>

    <button type="submit">Enregistrer</button>
</form>
