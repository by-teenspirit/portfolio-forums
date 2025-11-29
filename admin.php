<?php 
include "config.php";
include "includes/header.php"; 
?>

<h1>Admin — Ajouter du contenu</h1>

<div class="wrap-2-columns">

<div class="column">
<h2>Ajouter un Code</h2>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="add_code" value="1">
    
    <input type="text" name="titre" placeholder="Titre" required>
    
    <label>Type :</label>
    <select name="type" required>
        <option value="">-- Choisir le type --</option>
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
    
    <label>Pour qui :</label>
    <select name="destinataire_option" id="destinataire_option" onchange="toggleDestinataire()" required>
        <option value="">-- Choisir --</option>
        <option value="LDD">LDD</option>
        <option value="Moi-même">Moi-même</option>
        <option value="Autre">Autre</option>
    </select>
    <input type="text" name="destinataire_autre" id="destinataire_autre" placeholder="Précisez" style="display:none;">
    
    <input type="number" name="date_creation" min="2000" max="2030" value="<?= date('Y') ?>" required>
    
    <textarea name="description" placeholder="Description (optionnelle)"></textarea>
    
    <label>Fichier code (optionnel) :</label>
    <input type="file" name="file_code">
    
    <label>Lien GitHub (optionnel, uniquement si projet LDD) :</label>
    <input type="url" name="github_link" placeholder="https://github.com/...">
    
    <button>Ajouter</button>
</form>

<script>
function toggleDestinataire() {
    const sel = document.getElementById('destinataire_option');
    const autre = document.getElementById('destinataire_autre');
    autre.style.display = sel.value === 'Autre' ? 'inline-block' : 'none';
    autre.required = sel.value === 'Autre';
}
</script>
</div>

<div class="column">
<h2>Ajouter une Création Graphique</h2>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="add_graph" value="1">
    
    <input type="text" name="titre" placeholder="Titre" required>
    
    <label>Type :</label>
    <select name="type" required>
        <option value="">-- Choisir le type --</option>
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
    
    <label>Pour qui :</label>
    <select name="destinataire_option" id="destinataire_option_graph" onchange="toggleDestinataireGraph()" required>
        <option value="">-- Choisir --</option>
        <option value="LDD">LDD</option>
        <option value="Moi-même">Moi-même</option>
        <option value="Autre">Autre</option>
    </select>
    <input type="text" name="destinataire_autre" id="destinataire_autre_graph" placeholder="Précisez" style="display:none;">
    
    <input type="number" name="date_creation" min="2000" max="2030" value="<?= date('Y') ?>" required>
    
    <textarea name="description" placeholder="Description (optionnelle)"></textarea>
    
    <label>Image :</label>
    <input type="file" name="image" required>
    
    <button>Ajouter</button>
</form>

<script>
function toggleDestinataireGraph() {
    const sel = document.getElementById('destinataire_option_graph');
    const autre = document.getElementById('destinataire_autre_graph');
    autre.style.display = sel.value === 'Autre' ? 'inline-block' : 'none';
    autre.required = sel.value === 'Autre';
}
</script>
</div></div>

<?php include "includes/footer.php"; ?>
