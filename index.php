<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2 class="logo">Dashboard</h2>
            <nav class="menu">
                <a href="index.html">Inicio</a>
            </nav>
            <nav class="menu">
                <a href="crear.php">Crear cita</a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                </div>
                <div class="user-info">
                    <span class="user-name">Morgan Oakley (@morgan)</span>
                    <img src="user-avatar.png" alt="User Avatar" class="user-avatar">
                </div>
            </header>
            <section class="projects">
                <h2>Your Projects</h2>
                <div class="project-cards">
                    <div class="project-card"> <!-- Repeat for each project -->
                        <h3>Super Cool Project</h3>
                        <p>Sed tempus ut lacus ut scelerisque. Suspendisse sollicitudin nibh erat, id facilisis felis accumsan nec.</p>
                        <div class="project-actions">
                            <span>☆</span> <span>👀</span> <span>🔗</span>
                        </div>
                    </div>
                    <!-- Add more project cards as needed -->
                </div>
            </section>
        </main>
    </div>
</body>
</html>