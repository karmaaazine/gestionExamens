<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the navbar */
        .navbar {
            background-color: #007bff; /* Bleu Bootstrap */
        }

        .navbar-brand img {
            width: 40px;
            height: 40px;
        }

        .navbar-nav .nav-link {
            font-size: 1rem;
            font-weight: 500;
            color: #ffffff !important; /* Texte blanc */
        }

        .navbar-toggler {
            border-color: #ffffff;
        }

        .logout-btn {
            color: #fff;
            background-color: #0056b3; /* Bleu foncé */
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background-color: #003f7f; /* Bleu encore plus foncé */
        }
    </style>
</head>
<body>
    <!-- Responsive Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('assets/images/logo.png'); ?>" alt="Logo">
                Admin Dashboard
            </a>
            <!-- Toggler button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="professeurs.php">Professeurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="StudentView.php">Étudiants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="classes.php">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sections.php">Sections</a>
                    </li>
                </ul>
                <!-- Logout Button -->
                <form action="logout.php" method="POST" class="d-flex">
                    <button type="submit" class="btn logout-btn">Déconnecter</button>
                </form>
            </div>
        </div>
    </nav>

   

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
