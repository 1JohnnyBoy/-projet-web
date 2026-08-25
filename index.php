<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valide()) {
        $message = 'Session expirée. Recharge la page et réessaie.';
    }
    elseif (empty($_POST['brand'])) {
        $message = "Veuillez entrer une marque.";
    } else {
        $brand = trim((string) ($_POST['brand'] ?? ''));/*récup la marque saisie dans le formulaire*/
        $req = $connexion->prepare("SELECT * FROM le_c WHERE Marque = ?");/*cherche dans la table les lignes ayant cette marque*/
        $req->execute(array($brand));
        $resultats = $req->fetchAll();/*récupère les lignes de la table qui ont la marque présente dans le formulaire*/

        if (count($resultats) === 0) {
            $message = "Aucun smartphone trouvé pour la marque \"" . $brand . "\".";
        }
    }
}
if(isset($_POST['Acheter'])){
    header("Location: connexxion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="index.css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div id="entete">
        <img src="photo_telephones.webp" alt="picture of phones" width="100%" height="350">
        <p>Smartphones Sale</p>
        <div id="phoneform">
            <form action="index.php" method="post">
                <?= csrf_champ() ?>
                <input type="text" name="brand" placeholder="Marque">
                <button type="submit">Rechercher</button>
            </form>
        </div>
    <div id="menu">
        <?php if (utilisateur_connecte()): ?>
            Bonjour <?= e($_SESSION['username']) ?> —
            <a href="deconnexxion.php">Se déconnecter</a>
        
        <?php if (est_admin()): ?>
            <a href="ajout.php">Ajouter</a> 
            <a href="modification.php">Modifier</a> 
            <a href="suppression.php">Supprimer</a>
        <?php endif; ?>
        
        <?php else: ?>
            <a href="connexxion.php">Se connecter</a> 
            <a href="inscription.php">Créer un compte</a>
        <?php endif; ?>
    </div>        
            
            
    </div>

    <?php if (isset($message)) : ?>
        <p style="color:red; text-align:center; margin-top:1rem;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (!empty($resultats)) : ?>
        <div id="cadre">
            <?php foreach ($resultats as $telephone) : ?>
                <div id="tel">
                    <img src="uploads/<?= e($telephone['photo']); ?>" alt="<?= e($telephone['modèle']); ?>"><br />
                    <?= e($telephone['Marque']); ?><br />
                    <?= e($telephone['modèle']); ?><br />
                    <?= e($telephone['prix']); ?> €<br />
                    <?= e($telephone['couleur']); ?><br />
                    <?= e($telephone['stockage']); ?> Go
                    <form action="connexxion.php" method="post">
                        <button type="submit">Acheter</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <script>
        function rechercher() {
            const modele = document.getElementById("brand").value;
            $.ajax({
                url: "index.php",
                method: "POST",
                data: { modele: modele },
                success: function(data) {
                    $("#cadre").html(data);
                }
            });
        }
    </script>
</body>
</html>
