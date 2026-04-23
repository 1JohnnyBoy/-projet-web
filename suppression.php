<?php require_once 'connexxion.php';
session_start();
/*$connexion = new PDO('mysql:host=127.0.0.1;dbname=smartphones','root','');*/
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
    if(empty($_POST['brand']) || empty($_POST['model'])){ /*askip méthode plus fiable car elle ne dépendra pas du bouton(name="valider")*/
        $message = "Veuillez remplir tous les champs";
    }
    else{
        $model = htmlspecialchars($_POST['model']);/*récup le modèle saisi dans le formulaire*/
        $brand = htmlspecialchars($_POST['brand']);/*récup la marque saisi dans le formulaire*/

        $testmodel = $connexion->prepare("SELECT * FROM le_c WHERE modèle =?");/*$testmodel : variable associée à la requete(qui cherche la marque par modèle uniquement) SELECT contenue dans prepare*/
        $testmodel->execute(array($model));

        $controlmodel= $testmodel->rowCount();/*compte le nombre de ligne retourné par la requete précédente*/


        if($controlmodel>0){/*la condition est vérifiée,il y'a une ligne associée à ce modèle dans la table(db)*/
            $delete= $connexion->prepare("DELETE FROM le_c WHERE modèle = ?");/*requete qui va supp la ligne du modèle en question dans la table*/
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
            <input type="text" name="brand" placeholder="Marque">
            <input type="text" name="model" placeholder="Modèle">
            <input type="text" name="color" placeholder="Couleur" readonly>
            <input type="file" name="image" placeholder="Photo" enctype="multipart/form-data" readonly>
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

