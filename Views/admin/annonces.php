<h1>Gestion des annonces</h1>

<table class="table table-striped">
    <thead>
        <th>ID</th>
        <th>Titre</th>
        <th>Contenu</th>
        <th>ID du propriétaire</th>
        <th>Actif</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach($annonces as $annonce):  ?>
        <tr>
            <td><?= $annonce->id ?></td>
            <td><?= $annonce->titre ?></td>
            <td><?= $annonce->description ?></td>
            <td><?= $annonce->users_id ?></td>
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch"
                        id="flexSwitchCheckDefault<?= $annonce->id ?>" <?= $annonce->actif ? 'checked' : ""?>
                        data-id="<?= $annonce->id ?>">
                    <label class="form-check-label" for="flexSwitchCheckDefault<?= $annonce->id ?>"></label>
                </div>
            </td>
            <td>
                <a href="/annonces/modifier/<?= $annonce->id ?>" class="btn btn-warning">Modifier</a>
                <a href="/admin/supprimeAnnonce/<?= $annonce->id ?>" class="btn btn-danger">Supprimer</a>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>