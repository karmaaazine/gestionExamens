<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
    <script type="text/javascript">
        window.tailwind.config = {
            darkMode: ['class'],
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(var(--border))',
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))'
                        },
                        secondary: {
                            DEFAULT: 'hsl(var(--secondary))',
                            foreground: 'hsl(var(--secondary-foreground))'
                        },
                        destructive: {
                            DEFAULT: 'hsl(var(--destructive))',
                            foreground: 'hsl(var(--destructive-foreground))'
                        },
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))'
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))'
                        },
                        popover: {
                            DEFAULT: 'hsl(var(--popover))',
                            foreground: 'hsl(var(--popover-foreground))'
                        },
                        card: {
                            DEFAULT: 'hsl(var(--card))',
                            foreground: 'hsl(var(--card-foreground))'
                        },
                    },
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            :root {
                --background: 0 0% 100%;
                --foreground: 240 10% 3.9%;
                --card: 0 0% 100%;
                --card-foreground: 240 10% 3.9%;
                --popover: 0 0% 100%;
                --popover-foreground: 240 10% 3.9%;
                --primary: 240 5.9% 10%;
                --primary-foreground: 0 0% 98%;
                --secondary: 240 4.8% 95.9%;
                --secondary-foreground: 240 5.9% 10%;
                --muted: 240 4.8% 95.9%;
                --muted-foreground: 240 3.8% 46.1%;
                --accent: 240 4.8% 95.9%;
                --accent-foreground: 240 5.9% 10%;
                --destructive: 0 84.2% 60.2%;
                --destructive-foreground: 0 0% 98%;
                --border: 240 5.9% 90%;
                --input: 240 5.9% 90%;
                --ring: 240 5.9% 10%;
                --radius: 0.5rem;
            }
            .dark {
                --background: 240 10% 3.9%;
                --foreground: 0 0% 98%;
                --card: 240 10% 3.9%;
                --card-foreground: 0 0% 98%;
                --popover: 240 10% 3.9%;
                --popover-foreground: 0 0% 98%;
                --primary: 0 0% 98%;
                --primary-foreground: 240 5.9% 10%;
                --secondary: 240 3.7% 15.9%;
                --secondary-foreground: 0 0% 98%;
                --muted: 240 3.7% 15.9%;
                --muted-foreground: 240 5% 64.9%;
                --accent: 240 3.7% 15.9%;
                --accent-foreground: 0 0% 98%;
                --destructive: 0 62.8% 30.6%;
                --destructive-foreground: 0 0% 98%;
                --border: 240 3.7% 15.9%;
                --input: 240 3.7% 15.9%;
                --ring: 240 4.9% 83.9%;
            }
        }
    </style>
    <!-- Link to FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="bg-background min-h-screen">
        <header class="bg-zinc-800 text-white p-4 flex justify-between items-center">
            <?php include 'navbar.php'; ?>
        </header>

        <main class="p-6 grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            <div class="bg-zinc-700 text-white p-6 rounded-lg flex flex-col items-center hover:bg-zinc-600">
                <!-- FontAwesome icon for Professeurs -->
                <i class="fas fa-chalkboard-teacher text-3xl"></i>
                <span class="mt-2 text-lg"><a href = '/admin/prof_view'>Professeurs</a></span>
            </div>
            <div class="bg-zinc-700 text-white p-6 rounded-lg flex flex-col items-center hover:bg-zinc-600">
                <!-- FontAwesome icon for Étudiants -->
                <i class="fas fa-user-graduate text-3xl"></i>
                <span class="mt-2 text-lg"><a href = '/admin/student_view'>Étudiants</a></span>
            </div>
            <div class="bg-zinc-700 text-white p-6 rounded-lg flex flex-col items-center hover:bg-zinc-600">
                <!-- FontAwesome icon for Classes -->
                <i class="fas fa-school text-3xl"></i>
                <span class="mt-2 text-lg"><a href = '/admin/classes_view'>Classes</a></span>
            </div>
            <div class="bg-zinc-700 text-white p-6 rounded-lg flex flex-col items-center hover:bg-zinc-600">
                <!-- FontAwesome icon for Sections -->
                <i class="fas fa-layer-group text-3xl"></i>
                <span class="mt-2 text-lg">Modules</span>
            </div>
            <div class="bg-blue-600 text-white p-6 rounded-lg flex flex-col items-center hover:bg-blue-500">
                <!-- FontAwesome icon for Paramètres -->
                <i class="fas fa-cogs text-3xl"></i>
                <span class="mt-2 text-lg">Paramètres</span>
            </div>
            <div class="bg-yellow-500 text-black p-6 rounded-lg flex flex-col items-center hover:bg-yellow-400">
                <!-- FontAwesome icon for Déconnexion -->
                <i class="fas fa-sign-out-alt text-3xl"></i>
                <a href="/logout_admin" class="mt-2 text-lg bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Déconnexion
                </a>

                <!-- <span class="mt-2 text-lg">Déconnexion</span> -->
            </div>
        </main>
    </div>
</body>
</html>
