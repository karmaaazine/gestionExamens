Pour intégrer la fonctionnalité d'édition et de suppression dynamique dans le code que vous avez fourni, nous allons combiner les deux exemples. Nous allons permettre la modification des noms de classe directement dans le tableau et supprimer les lignes correspondantes lorsque l'utilisateur clique sur le bouton "Supprimer".

Voici le code complet pour `ClasseView.php`, qui inclut les fonctionnalités d'édition et de suppression :

### Code Complet pour `ClasseView.php`

```php
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .edit-mode {
            display: none;
        }
    </style>
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
                        <tr data-id="<?= esc($class['id']) ?>">
                            <td><?= esc($class['id']) ?></td>
                            <td>
                                <span class="class-name"><?= esc($class['name']) ?></span>
                                <input type="text" class="edit-name form-control edit-mode" value="<?= esc($class['name']) ?>">
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn">Modifier</button>
                                <button class="btn btn-success btn-sm save-btn edit-mode">Sauvegarder</button>
                                <button class="btn btn-danger btn-sm delete-btn">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">Aucune Classe trouvée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                row.querySelector('.class-name').style.display = 'none'; // Cacher le nom
                row.querySelector('.edit-name').style.display = 'inline'; // Afficher le champ d'édition
                this.style.display = 'none'; // Cacher le bouton Modifier
                row.querySelector('.save-btn').style.display = 'inline'; // Afficher le bouton Sauvegarder
            });
        });

        document.querySelectorAll('.save-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const newName = row.querySelector('.edit-name').value;
                const classId = row.getAttribute('data-id'); // Récupérer l'ID de la classe

                // Mettre à jour le texte affiché
                row.querySelector('.class-name').textContent = newName;

                // Afficher le nom et cacher le champ d'édition
                row.querySelector('.class-name').style.display = 'inline';
                row.querySelector('.edit-name').style.display = 'none';
                this.style.display = 'none';
                row.querySelector('.edit-btn').style.display = 'inline';

                // Requête AJAX pour mettre à jour la base de données
                fetch('<?= site_url('admin/classes/update') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: classId, name: newName }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Classe mise à jour avec succès');
                    } else {
                        console.error('Erreur lors de la mise à jour de la classe');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const classId = row.getAttribute('data-id'); // Récupérer l'ID de la classe

                // Requête AJAX pour supprimer la classe
                fetch('<?= site_url('admin/classes/delete') ?>', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: classId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Classe supprimée avec succès');
                        row.remove(); // Supprimer la ligne du tableau
                    } else {
                        console.error('Erreur lors de la suppression de la classe');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            });
        });
    </script>
</body>
</html>