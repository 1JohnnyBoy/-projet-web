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
    }
    elseif(empty($_POST['brand']) || empty($_POST['model']) || empty($_POST['price']) || empty($_POST['image']) || empty($_POST['storage'])){ /*askip méthode plus fiable car elle ne dépendra pas du bouton(name="valider")*/
        $message = "Veuillez remplir tous les champs";
    }
    else{
        $brand   = trim((string) ($_POST['brand'] ?? ''));/*récup la marque saisi dans le formulaire*/
        $color = trim((string) ($_POST['color'] ?? ''));;/*récup la couleur saisi dans le formulaire*/ 
        $image = enregistrer_image();/*récup l'image déposée dans le formulaire*/ 
        $model = trim((string) ($_POST['model'] ?? ''));/*récup le modèle présent dans le formulaire*/
        $storage = trim((string) ($_POST['storage'] ?? ''));/*récup le stockage saisi dans le formulaire*/
        $price = trim((string) ($_POST['price'] ?? ''));/*écup le prix saisi dans le formulaire*/
        

        
        $testmodel = $connexion->prepare("SELECT * FROM le_c WHERE modele =?");/*$testmodel : variable associée à la requete(qui cherche la marque par modèle uniquement) SELECT contenue dans prepare*/
        $testmodel->execute(array($model));/*ajout de la variable($model) saisi dans le formulaire, que la requete précédente va afficher*/

        $controlmodel= $testmodel->rowCount();/*compte le nombre de ligne retourné par la requete précédente*/

        if($controlmodel==0){/*la condition est vérifiée, les identifiants ne sont pas présents dans la table(db)*/
            $insertion = $connexion->prepare("INSERT INTO le_c(Marque,modele,couleur,photo,prix,stockage) VALUES(?,?,?,?,?,?)");/*requete qui va ajouter les identifiants dans la db*/
            $ok = $insertion->execute(array($brand,$model,$color,$image,$price,$storage));
            if($ok){
                $message = "Smartphone ajouté";
            } else {
                $message = "Erreur lors de l'ajout de données";
            }
        } else{
            $message = "modèle déjà associé à une marque";
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
    <title>Ajout de smartphones</title>
    <link rel="stylesheet" href="ajout.css"/>

</head>
<body>
    <div class="container">
        <h1>Smartphone</h1>
        <p>Caractéristiques</p>
        <form action="ajout.php" method="post" enctype="multipart/form-data">
            <?= csrf_champ() ?>
            <input type="text" name="brand" placeholder="Marque">
            <input type="text" name="model" placeholder="Modele">
            <input type="text" name="color" placeholder="Couleur">
            <input type="file" name="image" placeholder="Photo" enctype="multipart/form-data">
            <input type="number" name="price" placeholder="Prix">
            <input type="number" name="storage" placeholder="Stockage">
            <button type="submit" name="valider" value="1">Ajouter</button>
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