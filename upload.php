<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
include "config.php";

# AJOUT D’UN CODE
if (isset($_POST['add_code'])) {
    $destinataire = $_POST['destinataire_option'] === 'Autre' ? $_POST['destinataire_autre'] : $_POST['destinataire_option'];

    $fileName = null;
    if (!empty($_FILES['file_code']['name'])) {
        $file = $_FILES['file_code'];
        $fileName = time() . "_" . $file['name'];
        move_uploaded_file($file['tmp_name'], "uploads/" . $fileName);
    }

    $githubLink = $_POST['github_link'] ?? null;

    $sql = $pdo->prepare("INSERT INTO codes (titre, type, description, date_creation, destinataire, file, github_link)
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->execute([
        $_POST['titre'],
        $_POST['type'],
        $_POST['description'],
        $_POST['date_creation'],
        $destinataire,
        $fileName,
        $githubLink
    ]);

    header("Location: admin.php?ok");
    exit;
}


# AJOUT D’UNE CREATION GRAPH
if (isset($_POST['add_graph'])) {
    $destinataire = $_POST['destinataire_option'] === 'Autre' ? $_POST['destinataire_autre'] : $_POST['destinataire_option'];

    $file = $_FILES['image'];
    $fileName = time() . "_" . $file['name'];
    move_uploaded_file($file['tmp_name'], "uploads/" . $fileName);

    $sql = $pdo->prepare("INSERT INTO graph (titre, type, image, date_creation, destinataire, description)
                          VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([
        $_POST['titre'],
        $_POST['type'],
        $fileName,
        $_POST['date_creation'],
        $destinataire,
        $_POST['description']
    ]);

    header("Location: admin.php?ok");
    exit;
}

?>