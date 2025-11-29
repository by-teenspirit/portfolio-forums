<?php 
include "includes/header.php"; 
include "config.php";

$type = $_GET['type'] ?? "";

$sql = $type
    ? $pdo->prepare("SELECT * FROM graph WHERE type = ?")
    : $pdo->query("SELECT * FROM graph");

$items = $type ? ($sql->execute([$type]) ? $sql->fetchAll() : []) : $sql->fetchAll();
?>

<h1>Mes Réalisations Graphiques</h1>

<form method="GET">
    <select name="type">
        <option value="">Toutes</option>
        <optgroup label="Avatars">
            <option value="Avatar - Célébrité">Célébrité</option>
            <option value="Avatar - Autre">Autre</option>
        </optgroup>

        <optgroup label="Signatures">
            <option value="Signature - LGDC">LGDC</option>
            <option value="Signature - Autre">Autre</option>
        </optgroup>

        <optgroup label="Bannière">
            <option value="Bannière - LGDC">LGDC</option>
            <option value="Bannière - RPG Humain">RPG Humain</option>
            <option value="Bannière - Autre">Autre</option>
        </optgroup>
    </select>
    <button>Filtrer</button>
</form>

<div class="gallery">
<?php foreach ($items as $g): ?>
    <div class="gallery-item">
        <img src="uploads/<?= htmlspecialchars($g['image']) ?>" alt="<?= htmlspecialchars($g['titre']) ?>">
        <div class="overlay">
            <h3><?= htmlspecialchars($g['titre']) ?></h3>
            <p>Type : <?= htmlspecialchars($g['type']) ?></p>
            <p>Année : <?= htmlspecialchars($g['date_creation']) ?></p>
            <p>Pour qui : <?= htmlspecialchars($g['destinataire']) ?></p>
            <form action="edit.php" method="GET">
                <input type="hidden" name="type" value="graph">
                <input type="hidden" name="id" value="<?= $g['id'] ?>">
                <button type="submit">✏️ Modifier</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php include "includes/footer.php"; ?>
