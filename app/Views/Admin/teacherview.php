<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Professeurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h4>Liste des Professeurs</h4>
            <a href="<?= site_url('admin/teachers/add') ?>" class="btn btn-primary">Ajouter un Professeur</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Ville</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($teachers)): ?>
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td><?= esc($teacher['id']) ?></td>
                            <td><?= esc($teacher['name']) ?></td>
                            <td><?= esc($teacher['email']) ?></td>
                            <td><?= esc($teacher['city']) ?></td>
                            <td><?= esc($teacher['tel']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/gestion_prof/edit/' . $teacher['id']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                                
                                <form action="<?= site_url('/admin/teachers/delete/' . $teacher['id']) ?>" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucun professeur trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
