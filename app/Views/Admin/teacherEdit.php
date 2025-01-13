<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le professeur</title>
    <link rel="stylesheet" href="/path/to/your/css/file.css">
</head>
<body>
<?php include('navbar.php'); ?>
<div class="container mt-5">
        <a href="<?= base_url('/admin/prof_view')?>"
           class="btn btn-dark">Retourner</a>
    <div class="container">
        <h1>Modifier le professeur</h1>

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

        <form action="<?= base_url('/admin/gestion_prof/edit/' . $teacher['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Nom</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control" 
                    value="<?= esc($teacher['name']) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    value="<?= esc($teacher['email']) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="city">Ville</label>
                <input 
                    type="text" 
                    name="city" 
                    id="city" 
                    class="form-control" 
                    value="<?= esc($teacher['city']) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="tel">Telephone</label>
                <input 
                    type="text" 
                    name="tel" 
                    id="tel" 
                    class="form-control" 
                    value="<?= esc($teacher['tel']) ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control" 
                    placeholder="Leave blank to keep the current password"
                >
            </div>

            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="<?= base_url('/admin/prof_view') ?>" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
