<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff; /* Fond blanc */
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff; /* Fond blanc pour la carte */
        }
        .card-header {
            background-color: #007bff; /* Bleu pour l'en-tête */
            color: white;
            text-align: center;
            padding: 30px 0;
        }
        .card-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 10px;
            height: 45px;
            border: 1px solid #007bff; /* Bordure bleue des champs */
        }
        .btn-primary {
            background-color: #007bff; /* Bleu pour le bouton */
            border: none;
            border-radius: 10px;
            padding: 10px;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Bleu plus foncé au survol */
        }
        .card-footer {
            text-align: center;
            background-color: #f8f9fa; /* Gris très clair pour le bas */
            padding: 15px;
        }
        .card-footer a {
            color: #007bff; /* Bleu pour le lien */
        }
        .card-footer a:hover {
            text-decoration: underline;
        }
        .logo {
            display: block;
            margin: 0 auto;
            max-width: 120px;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <img src="<?= base_url('assets/images/logo.jpeg') ?>" alt="Logo" class="logo">
                    <h3>Admin</h3>
                    <p class="mb-0">Veuillez entrer vos identifiants</p>
                </div>
                <div class="card-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error_message) ?>
                        </div>
                    <?php endif; ?>
                    <!-- Formulaire de connexion -->
                    <form action="/login_process" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                        </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
