<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    
<?php session_start(); ?>
<nav class="navbar">
    <div class="nav-left">
    <a href="index.php">Accueil</a>
    <a href="codes.php">Codes</a>
    <a href="graph.php">Graphismes</a>
</div>
    <div class="nav-right">
        <?php if (isset($_SESSION['admin'])): ?>
            <!-- Bouton Ajouter une création -->
            <a href="admin.php" class="btn-add">➕ Ajouter</a>

            <!-- Bouton Déconnexion -->
            <a href="logout.php" class="btn-logout">🔒 Déconnexion</a>
        <?php else: ?>
            <!-- Bouton Connexion -->
            <a href="login.php" class="btn">🔑 Connexion</a>
        <?php endif; ?>
    </div>
</nav>

<div class="content">