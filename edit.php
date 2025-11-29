<?php
include "config.php";
include "includes/header.php"; 

$type = $_GET['type'] ?? null; // 'code' ou 'graph'
$id = $_GET['id'] ?? null;

if (!$type || !$id) {
    die("Paramètres manquants.");
}

// Récupérer l'élément à modifier
if ($type === 'code') {
    $stmt = $pdo->prepare("SELECT * FROM codes WHERE id = ?");
} else {
    $stmt = $pdo->prepare("SELECT * FROM graph WHERE id = ?");
}
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    die("Élément non trouvé.");
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinataire = $_POST['destinataire_option'] === 'Autre' ? $_POST['destinataire_autre'] : $_POST['destinataire_option'];

    if ($type === 'code') {
        $fileName = $item['file']; // garder le fichier existant
        if (!empty($_FILES['file_code']['name'])) {
            $file = $_FILES['file_code'];
            $fileName = time() . "_" . $file['name'];
            move_uploaded_file($file['tmp_name'], "uploads/" . $fileName);
        }
        $githubLink = $_POST['github_link'] ?? null;

        $sql = $pdo->prepare("UPDATE codes SET titre=?, type=?, description=?, date_creation=?, destinataire=?, file=?, github_link=? WHERE id=?");
        $sql->execute([
            $_POST['titre'],
            $_POST['type'],
            $_POST['description'],
            $_POST['date_creation'],
            $destinataire,
            $fileName,
            $githubLink,
            $id
        ]);

    } else {
        $fileName = $item['image'];
        if (!empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            $fileName = time() . "_" . $file['name'];
            move_uploaded_file($file['tmp_name'], "uploads/" . $fileName);
        }

        $sql = $pdo->prepare("UPDATE graph SET titre=?, type=?, image=?, date_creation=?, destinataire=?, description=? WHERE id=?");
        $sql->execute([
            $_POST['titre'],
            $_POST['type'],
            $fileName,
            $_POST['date_creation'],
            $destinataire,
            $_POST['description'],
            $id
        ]);
    }

    header("Location: admin.php?ok");
    exit;
}
?>


<h1>Modifier <?= htmlspecialchars($type) ?></h1>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="titre" value="<?= htmlspecialchars($item['titre']) ?>" required>

    <label>Type :</label>
    <input type="text" name="type" value="<?= htmlspecialchars($item['type']) ?>" required>

    <label>Pour qui :</label>
    <select name="destinataire_option" onchange="toggleDestinataire()" required>
        <option value="LDD" <?= $item['destinataire']=='LDD' ? 'selected' : '' ?>>LDD</option>
        <option value="Moi-même" <?= $item['destinataire']=='Moi-même' ? 'selected' : '' ?>>Moi-même</option>
        <option value="Autre" <?= !in_array($item['destinataire'], ['LDD','Moi-même']) ? 'selected' : '' ?>>Autre</option>
    </select>
    <input type="text" name="destinataire_autre" id="destinataire_autre" placeholder="Précisez" style="display:none;" value="<?= !in_array($item['destinataire'], ['LDD','Moi-même']) ? htmlspecialchars($item['destinataire']) : '' ?>">

    <input type="number" name="date_creation" value="<?= $item['date_creation'] ?>" required>

    <textarea name="description"><?= $item['description'] ?? '' ?></textarea>

    <?php if ($type === 'code'): ?>
        <label>Fichier code :</label>
        <input type="file" name="file_code">
        <?php if($item['file']): ?><p>Fichier existant : <?= htmlspecialchars($item['file']) ?></p><?php endif; ?>
        <label>GitHub :</label>
        <input type="url" name="github_link" value="<?= $item['github_link'] ?? '' ?>">
    <?php else: ?>
        <label>Image :</label>
        <input type="file" name="image">
        <?php if($item['image']): ?><p>Image existante : <?= htmlspecialchars($item['image']) ?></p><?php endif; ?>
    <?php endif; ?>

    <button>Modifier</button>
</form>

<script>
function toggleDestinataire() {
    const sel = document.querySelector('select[name="destinataire_option"]');
    const autre = document.getElementById('destinataire_autre');
    autre.style.display = sel.value === 'Autre' ? 'inline-block' : 'none';
    autre.required = sel.value === 'Autre';
}
toggleDestinataire();
</script>
