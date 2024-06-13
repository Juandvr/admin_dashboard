<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <base href="/admin_dashboard/">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2 class="logo">Dashboard</h2>
            <nav class="menu">
                <a href="index.php">Usuarios</a>
            </nav>
            <nav class="menu">
                <a href="empleados/index_empleados.php">Empleados</a>
            </nav>
            <nav class="menu">
                <a href="servicios/index_servicios.php">Servicios</a>
            </nav>
            <nav class="menu">
                <a href="citas/index_citas.php">Citas</a>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <div class="user-info">
                    <span class="user-name">Administrador</span>
                    <i class="material-icons">account_box</i>
                </div>
            </header>
            <section class="projects">