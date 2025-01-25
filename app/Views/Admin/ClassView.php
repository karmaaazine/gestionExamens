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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                Ajouter une Classe
            </button>
        </div>

        <!-- Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de la Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class): ?>
                    <tr id="row-<?= esc($class['id']) ?>">
                        <td><?= esc($class['id']) ?></td>
                        <td id="name-<?= esc($class['id']) ?>"><?= esc($class['name']) ?></td>
                        <td id="actions-<?= esc($class['id']) ?>">
                            <!-- Default Actions -->
                            <button onclick="editClass(<?= esc($class['id']) ?>)" class="btn btn-warning btn-sm">Modifier</button>
                            <button onclick="deleteClass(<?= esc($class['id']) ?>)" class="btn btn-danger btn-sm">Supprimer</button>

                            <!-- Edit Mode Actions -->
                            <div id="edit-actions-<?= esc($class['id']) ?>" style="display: none;">
                                <form method="post" action="/admin/classes/edit/<?= esc($class['id']) ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= esc($class['id']) ?>">
                                    <input type="hidden" id="input-name-<?= esc($class['id']) ?>" name="name">
                                    <button type="submit" class="btn btn-danger btn-sm">Sauvegarder</button>
                                </form>
                                <button onclick="cancelEdit(<?= esc($class['id']) ?>, '<?= esc($class['name']) ?>')" class="btn btn-secondary btn-sm">Annuler</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Class Modal -->
    <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClassModalLabel">Ajouter une Classe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addClassForm" method="post" action="/admin/classes/add">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="mb-3">
                            <label for="className" class="form-label">Nom de la Classe</label>
                            <input type="text" class="form-control" id="className" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-trigger edit mode if returning from validation error
        <?php if (isset($classToEdit)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                editClass(<?= $classToEdit['id'] ?>);
            });
        <?php endif; ?>

        function editClass(id) {
            const nameCell = document.getElementById(`name-${id}`);
            const currentName = nameCell.innerText;
            nameCell.innerHTML = `<input type="text" id="edit-name-${id}" class="form-control" value="${currentName}">`;

            const actionsCell = document.getElementById(`actions-${id}`);
            actionsCell.querySelector('button.btn-warning').style.display = 'none';
            actionsCell.querySelector('button.btn-danger').style.display = 'none';

            const editActions = document.getElementById(`edit-actions-${id}`);
            editActions.style.display = 'inline';

            const hiddenInput = document.getElementById(`input-name-${id}`);
            hiddenInput.value = currentName;
        }

        function cancelEdit(id, originalName) {
            const nameCell = document.getElementById(`name-${id}`);
            nameCell.innerText = originalName;

            const actionsCell = document.getElementById(`actions-${id}`);
            actionsCell.querySelector('button.btn-warning').style.display = 'inline';
            actionsCell.querySelector('button.btn-danger').style.display = 'inline';

            const editActions = document.getElementById(`edit-actions-${id}`);
            editActions.style.display = 'none';

            const hiddenInput = document.getElementById(`input-name-${id}`);
            hiddenInput.value = originalName;
        }

        // AJAX for Add Class
        document.getElementById('addClassForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            const csrfToken = document.querySelector('input[name="<?= csrf_token() ?>"]').value;

            fetch('/admin/classes/add', {
                method: 'POST',
                body: formData,
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken

                 }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Classe ajoutée avec succès!');
                    bootstrap.Modal.getInstance(document.getElementById('addClassModal')).hide();
                    window.location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur s\'est produite lors de l\'ajout de la classe.');
            });
        });

        // Delete Class Confirmation
        function deleteClass(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')) {
                window.location.href = `/admin/classes/delete/${id}`;
            }
        }
    </script>
</body>
</html>