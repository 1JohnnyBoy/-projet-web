<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
 
if(!isset($_SESSION¨['user_id'])){
    header("Location : connexxion.php");
    exit;
}

/*
if($connexion) {
    echo "Connexion réussie";
}
sia test pour connecter php à la base de données(mysql)
*/

/*
if(isset($_POST['valider'])){
    echo 'Valider';
}
*/
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (!csrf_valide()) {
        $message = 'Session expirée. Recharge la page et réessaie.';
    }
    elseif(empty($_POST['brand']) || empty($_POST['model'])){ /*askip méthode plus fiable car elle ne dépendra pas du bouton(name="valider")*/
        $message = "Veuillez remplir tous les champs";
    }
    else{
        $brand   = trim((string) ($_POST['brand'] ?? ''));/*récup la marque saisi dans le formulaire*/
        $model   = trim((string) ($_POST['model'] ?? ''));/*récup le modèle saisi dans le formulaire*/
        $image   = supprimer_image();

        $testmodel = $connexion->prepare("SELECT * FROM le_c WHERE modele =?");/*$testmodel : variable associée à la requete(qui cherche la marque par modèle uniquement) SELECT contenue dans prepare*/
        $testmodel->execute(array($brand,$model));

        $controlmodel= $testmodel->rowCount();/*compte le nombre de ligne retourné par la requete précédente*/


        if($controlmodel>0){/*la condition est vérifiée,il y'a une ligne associée à ce modèle dans la table(db)*/
            $delete= $connexion->prepare("DELETE FROM le_c WHERE modele = ?");/*requete qui va supp la ligne du modèle en question dans la table*/
            $ok = $delete->execute(array($brand,$_POST['model']));
            if($ok){
                $message = "Suppression réussie";
            } else {
                $message = "Erreur lors de la suppression";
            }
        } else{
            $message = "Modèle absent dans la db";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression</title>
    <link rel="stylesheet" href="suppression.css"/>

</head>
<body>
    <div class="container">
        <h1>Smartphone</h1>
        <p>Caractéristiques</p>
        <form action="suppression.php" method="post">
            <?= csrf_champ() ?>
            <input type="text" name="brand" placeholder="Marque">
            <input type="text" name="model" placeholder="Modele">
            <input type="text" name="color" placeholder="Couleur" readonly>
            <input type="file" name="image" placeholder="Photo" enctype="multipart/form-data" disabled>
            <input type="number" name="price" placeholder="Prix" readonly>
            <button type="submit" name="valider" value="1">Supprimer</button>
            <p class="texte">
                <i style="color:red">
                    <?php
                    if(isset($message)){
                    echo $message. "<br />";
                    }
                    ?>
                </i>
            </p>
        </form>
    </div>
</body>
</html>

