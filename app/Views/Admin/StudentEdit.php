<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modifier un Étudiant</title>
        <link rel="stylesheet" href="/path/to/your/css/file.css">
    </head>
    <body>
        <?php include('navbar.php'); ?>

        <div class="container mt-5">
            <a href="<?= base_url('/admin/student_view') ?>" class="btn btn-dark">Retourner</a>
            <div class="container">
                <h1>Modifier un Étudiant</h1>

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('message')): ?>
                    <div class="alert alert-success">
                        <?= esc(session('message')) ?>
                    </div>
                <?php elseif (session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session('error')) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/admin/student/edit/'. $student['id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="name">Nom & Prénom</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="grade">Classe</label>
                        <input type="text" name="grade" id="grade" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tel">Téléphone</label>
                        <input type="text" name="tel" id="tel" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Modifier</button>
                    <a href="<?= base_url('/admin/student_view') ?>" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </body>
</html>
