<?php 
session_start();
/*$connexion = new PDO('mysql:host=127.0.0.1;dbname=smartphones','root','');*/
$env = "railway";

if($env === "local"){
    $connexion = new PDO('mysql:host=127.0.0.1;dbname=smartphones', 'root', '');
} else {
    $connexion = new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_NAME') . ';charset=utf8',
        getenv('DB_USER'),
        getenv('DB_PASSWORD')
    );
}
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    if(empty($_POST['brand']) || empty($_POST['model']) || empty($_POST['price']) || empty($_POST['image']) || empty($_POST['storage'])){ /*askip méthode plus fiable car elle ne dépendra pas du bouton(name="valider")*/
        $message = "Veuillez remplir tous les champs";
    }
    else{
        $brand = htmlspecialchars($_POST['brand']);/*récup la marque saisi dans le formulaire*/
        $model = htmlspecialchars($_POST['model']);/*récup le modèle saisi dans le formulaire*/ 
        $color = htmlspecialchars($_POST['color']);/*récup la couleur saisi dans le formulaire*/ 
        $image = htmlspecialchars($_POST['image']);/*récup l'image saisi dans le formulaire*/ 
        $price = htmlspecialchars($_POST['price']);/*récup le prix saisi dans le formulaire*/ 
        $storage = htmlspecialchars($_POST['storage']);/*récup le stockage saisi dans le formulaire*/
        

        
        $testmodel = $connexion->prepare("SELECT * FROM le_c WHERE modèle =?");/*$testmodel : variable associée à la requete(qui cherche la marque par modèle uniquement) SELECT contenue dans prepare*/
        $testmodel->execute(array($model));/*ajout de la variable($model) saisi dans le formulaire, que la requete précédente va afficher*/

        $controlmodel= $testmodel->rowCount();/*compte le nombre de ligne retourné par la requete précédente*/

        if($controlmodel==0){/*la condition est vérifiée, les identifiants ne sont pas présents dans la table(db)*/
            $insertion = $connexion->prepare("INSERT INTO le_c(Marque,modèle,couleur,photo,prix,stockage) VALUES(?,?,?,?,?,?)");/*requete qui va ajouter les identifiants dans la db*/
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
        <form action="ajout.php" method="post">
            <input type="text" name="brand" placeholder="Marque">
            <input type="text" name="model" placeholder="Modèle">
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
