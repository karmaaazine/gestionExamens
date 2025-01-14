<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter un Professeur</title>
        <link rel="stylesheet" href="/path/to/your/css/file.css">
    </head>
    <body>
    <?php include('navbar.php'); ?>

        <div class="container mt-5">
            <a href="<?= base_url('/admin/prof_view') ?>" class="btn btn-dark">Retourner</a>
            <div class="container">
                <h1>Ajouter un Professeur</h1>

                <!-- Display Validation Errors -->
                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Display Success or Error Messages -->
                <?php if (session()->has('message')): ?>
                    <div class="alert alert-success">
                        <?= esc(session('message')) ?>
                    </div>
                <?php elseif (session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session('error')) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/admin/gestion_prof/add') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="city">Ville</label>
                        <input type="text" name="city" id="city" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tel">Telephone</label>
                        <input type="text" name="tel" id="tel" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de Passe</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <a href="<?= base_url('/admin/prof_view') ?>" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>

    </body>
</html>