<?php
include __DIR__ . "/includes/header.php";
include __DIR__ . "/config.php";

$type = $_GET['type'] ?? "";

if ($type) {
    $sql = $pdo->prepare("SELECT * FROM codes WHERE type = ?");
    $sql->execute([$type]);
    $codes = $sql->fetchAll();
} else {
    $codes = $pdo->query("SELECT * FROM codes")->fetchAll();
}
?>

<h1>Mes Codes</h1>

<form method="GET">
    <label>Type :</label>
    <select name="type">
        <option value="">Tous</option>
        <option value="Maquette non codée">Maquette non codée</option>
        <optgroup label="Structure du forum">
            <option value="Page d'accueil">Page d'accueil</option>
            <option value="Catégories">Catégories</option>
            <option value="QEEL">QEEL</option>
            <option value="Affichage des sujets">Affichage des sujets</option>
            <option value="Affichage d'un sujet">Affichage d'un sujet</option>
            <option value="Affichage du profil">Affichage du profil</option>
            <option value="Barre de navigation">Barre de navigation</option>
            <option value="Liste des membres">Liste des membres</option>
            <option value="Autre">Autre</option>
        </optgroup>

        <optgroup label="Fiches">
            <option value="Fiche RP">Fiche RP</option>
            <option value="Fiche personnage/répertoire">Fiche personnage/répertoire</option>
            <option value="Fiche de liens">Fiche de liens</option>
            <option value="Autres">Autres</option>
        </optgroup>
    </select>
    <button type="submit">Filtrer</button>
</form>

<div class="card-container">
<?php foreach ($codes as $code): ?>
    <div class="card">
        <?php if($code['file']): ?>
            <img src="uploads/<?= htmlspecialchars($code['file']) ?>" alt="<?= htmlspecialchars($code['titre']) ?>">
        <?php else: ?>
            <img src="placeholder-code.png" alt="Code <?= htmlspecialchars($code['titre']) ?>">
        <?php endif; ?>
        <div class="card-info">
            <h3><?= htmlspecialchars($code['titre']) ?></h3>
        </div>
        <div class="card-hover">
            <p>Type: <?= htmlspecialchars($code['type']) ?></p>
            <p>Année: <?= htmlspecialchars($code['date_creation']) ?></p>
            <p>Pour qui: <?= htmlspecialchars($code['destinataire']) ?></p>
            <form action="edit.php" method="GET">
                <input type="hidden" name="type" value="code">
                <input type="hidden" name="id" value="<?= $code['id'] ?>">
                <button type="submit">✏️ Modifier</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>
</div>

</div>

<?php include __DIR__ . "/includes/footer.php"; ?>
