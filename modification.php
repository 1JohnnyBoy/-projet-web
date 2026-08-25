<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

exiger_connexion();

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
    }else{
        if(empty($_POST['price']) || empty($_POST['storage'])){ /*askip méthode plus fiable car elle ne dépendra pas du bouton(name="valider")*/
            $message = "Veuillez remplir tous les champs";
        }
        else{
            $model = trim((string) ($_POST['model'] ?? ''));/*récup le modèle présent dans le formulaire*/
            $storage = trim((string) ($_POST['storage'] ?? ''));/*récup le stockage saisi dans le formulaire*/
            $price = trim((string) ($_POST['price'] ?? ''));/*écup le prix saisi dans le formulaire*/ 
        
            $testmodel = $connexion->prepare("SELECT * FROM le_c WHERE modele =?");/*$testmodel : variable associée à la requete(qui cherche la marque par modèle uniquement) SELECT contenue dans prepare*/
            $testmodel->execute(array($model));

            $controlmodel= $testmodel->rowCount();/*compte le nombre de ligne retourné par la requete précédente*/


            if($controlmodel>0){/*la condition est vérifiée,il y'a une ligne associée à ce modèledans la table(db)*/
                $update= $connexion->prepare("UPDATE le_c SET prix= ?, stockage= ? WHERE modele = ?");/*requete qui va modifier le prix du modèle dans la table*/
                $ok = $update->execute(array($price,$_POST['model']));
                if($ok){
                    $message = "Prix et stockage mis à jour avec succès";
                } else {
                    $message = "Erreur lors de l'update";
                }
            }   else{
                $message = "Modèle absent dans la db";
            }
        
        
        

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
    <title>Mise à jour</title>
    <link rel="stylesheet" href="modification.css"/>

</head>
<body>
    <div class="container">
        <h1>Smartphone</h1>
        <p>Caractéristiques</p>
        <form action="modification.php" method="post">
            <?= csrf_champ() ?>

            <input type="text" name="brand" placeholder="Marque" readonly>
            <input type="text" name="model" placeholder="Modele">
            <input type="text" name="color" placeholder="Couleur" readonly>
            <input type="file" name="image" placeholder="Photo" enctype="multipart/form-data" disabled>
            <input type="number" name="price" placeholder="Prix">
            <input type="number" name="storage" placeholder="Stockage">
            <button type="submit" name="valider" value="1">Mettre à jour</button>
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

