<?php require_once 'connexxion.php';
session_start();
/*$connexion = new PDO('mysql:host=127.0.0.1;dbname=email_base','root','');*/
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
    if(empty($_POST['email']) || empty($_POST['password'])){ /*askip méthode plus fiable car elle ne dépendra pas du bouton(name="valider")*/
        $message = "Veuillez remplir tous les champs";
    }
    else{
        $nom = htmlspecialchars($_POST['nom']);/*récup le nom saisi dans le formulaire*/
        $email = htmlspecialchars($_POST['email']);/*récup l'email saisi dans le formulaire*/ 
        $password = sha1($_POST['password']);/*récup le mdp saisi dans le formulaire*/ 
        $password_hache = password_hash($password, PASSWORD_DEFAULT); /*pour crypter le mdp*/

        if(strlen($_POST['password'])<4){
            $message = "Mot de passe trop court";
        }elseif(strlen($nom)>30){
            $message = "Nom trop long";
        }else{
            $testmail = $connexion->prepare("SELECT * FROM adresse_email WHERE Mail =?");/*$testmail : variable associée à la requete SELECT(qui cherche l'utilisateur par email uniquement) contenue dans prepare*/
            $testmail->execute(array($email));/*ajout de la variable($email) saisi dans le formulaire, que la requete précédente a affiché*/

            $controlmail= $testmail->rowCount();/*compte le nombre de ligne retourné par la requete précédente*/

            if($controlmail==0){/*la condition est vérifiée, les identifiants ne sont pas présents dans la table(db)*/
                $insertion = $connexion->prepare("INSERT INTO adresse_email(Username,Mail,MDP) VALUES(?,?,?)");/*requete qui va ajouter les identifiants dans la db*/
                $ok = $insertion->execute(array($nom,$email,$password_hache));
                if($ok){
                    $message = "Votre compte a bien été créé";
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Erreur lors de la création du compte";
                }
            } else{
                $message = "Cette adresse est déjà associée à un compte";
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
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css"/>

</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <p>Entrez vos coordonées</p>
        <form action="inscription.php" method="post">
            <input type="text" name="nom" placeholder="Nom">
            <input type="email" name="email" placeholder="E-mail">
            <input type="password" name="password" placeholder="Mot de passe">
            <button type="submit" name="valider" value="1">S'enregistrer</button>
            <p class="texte">
                <i style="color:red">
                    <?php
                    if(isset($message)){
                    echo $message. "<br />";
                    }
                    ?>
                </i>
                Avez-vous déjà un compte ? <a href="connexxion.php">Connexion</a>
            </p>
        </form>
    </div>
</body>
</html>