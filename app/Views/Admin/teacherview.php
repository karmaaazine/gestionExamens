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
        <!-- Titre et bouton d'ajout -->
        <div class="d-flex justify-content-between mb-3">
            <h4>Liste des Professeurs</h4>
            <a href="<?= site_url('admin/teachers/create') ?>" class="btn btn-primary">Ajouter un Professeur</a>
        </div>

        <!-- Barre de recherche -->
        <form method="GET" action="" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Rechercher un professeur (prénom, nom, matière)" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <!-- Tableau des professeurs -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Matière</th>
                    <th>Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';

                if (!empty($search)) {

                    $filteredTeachers = array_filter($teachers, function ($teacher) use ($search) {
                        return stripos($teacher['first_name'], $search) !== false ||
                               stripos($teacher['last_name'], $search) !== false ||
                               stripos($teacher['subject'], $search) !== false;
                    });
                } else {
                    $filteredTeachers = $teachers;
                }

                // Affichage des professeurs
                if (!empty($filteredTeachers)):
                    foreach ($filteredTeachers as $teacher): ?>
                        <tr>
                            <td><?= $teacher['id'] ?></td>
                            <td><?= $teacher['first_name'] ?></td>
                            <td><?= $teacher['last_name'] ?></td>
                            <td><?= $teacher['subject'] ?></td>
                            <td><?= $teacher['class'] ?></td>
                            <td>
                                <a href="<?= site_url('admin/teachers/edit/' . $teacher['id']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <form action="<?= site_url('admin/teachers/delete/' . $teacher['id']) ?>" method="POST" style="display:inline-block;">
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
