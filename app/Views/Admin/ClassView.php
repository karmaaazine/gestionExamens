<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h4>Liste des Classes</h4>
            <a href="<?= site_url('admin/classes/add') ?>" class="btn btn-primary">Ajouter une Classe</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de la Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>
                        <tr>
                            <td><?= esc($class['id']) ?></td>
                            <td><?= esc($class['name']) ?></td>
                            
                            <td>
                                <a href="<?= site_url('admin/classes/edit/' . $class['id']) ?>" class="btn btn-warning btn-sm">Modifier</a>

                                <form action="<?= site_url('admin/classes/delete/' . $class['id']) ?>" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Aucune Classe trouvée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
