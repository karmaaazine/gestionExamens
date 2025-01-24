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
            <h4>Liste des Etudiants</h4>
            <a href="<?= site_url('admin/student/add') ?>" class="btn btn-primary">Ajouter un Etudiant</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom&Prenom</th>
                    <th>Email</th>
                    <th>Ville</th>
                    <th>Téléphone</th>
                    <th>Class</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= esc($student['id']) ?></td>
                            <td><?= esc($student['name']) ?></td>

                            <td><?= esc($student['email']) ?></td>
                            <td><?= esc($student['city']) ?></td>
                            <td><?= esc($student['tel']) ?></td>
                            <td><?= esc($student['class']['name']) ?></td>
                            <td><?= esc($student['year']['year']) ?></td>
                            <td>
                                <a href="<?= site_url('admin/students/edit/' . $student['id']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                                
                                <form action="<?= site_url('/admin/student_view/delete/' . $student['id']) ?>" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucun Etudiant trouvé</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
