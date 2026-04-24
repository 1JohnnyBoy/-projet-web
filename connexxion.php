<?php
session_start();
$connexion = new PDO('mysql:host=127.0.0.1;dbname=email_base', 'root', '');

/*$connexion = new PDO('mysql:host=127.0.0.1;dbname=email_base','root','');*/
/*
if($connexion) {
    echo "Connexion réussie";
}
sia test pour connecter php à la base de données(mysql)
*/

/*
if(isset($_POST['valider'])){ pour vérifier si le bouton "se connecter"a été cliqué
    echo 'Valider';
}
*/

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_POST['email']) || empty($_POST['password'])){ /*askip méthode plus fiable car elle ne dépendra pas du bouton(name="valider")*/
        $message = "Veuillez remplir tous les champs";
    }
    else{
        $email = htmlspecialchars($_POST['email']);/*récup l'email saisi dans le formulaire*/
        $password = sha1($_POST['password']);/*sha1 du mdp (comme à l'inscription)*/
        $req = $connexion->prepare("SELECT * FROM adresse_email WHERE Mail =?");/*cherche l'utilisateur par email uniquement*/
        $req->execute(array($email));/*ajout de la variable($email) saisi dans le formulaire, que la requete précédente a affiché*/
        $user = $req->fetch();/*récupère la ligne de l'utilisateur dans la table(db)*/

        if($user && password_verify($password, $user['MDP'])){/*vérifie le mdp avec password_verify*/
            $message = "Vous êtes connecté";
            header("Location: index.php");
            exit();
        }
        else{
            $message = "Mauvais email ou mauvais mot de passe";
        }
    }
}

/*
if(isset($_POST['valider'])){
    if(!empty($_POST['email']) AND !empty($_POST['password'])){ !empty pour voir si les variables email et password ne sont pas vides

    }else{
        $message = "Veuillez remplir tous les champs"; message d'erreur à afficher au cas où l'email et le password sont vides (ou email rempli,password vide et inversement)
    }
}
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="connexxion.css"/>

</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <p>Entrez vos identifiants</p>
        <form action="connexxion.php" method="post">
            <input type="email" name="email" placeholder="E-mail">
            <input type="password" name="password" placeholder="Mot de passe">
            <button type="submit" name="valider" value="1">Se connecter</button>
            <p class="texte">
                <i style="color:red">
                    <?php
                    if(isset($message)){
                        echo $message. "<br />";
                    }
                    ?>
                </i>
                Pas de compte ? <a href="inscription.php">Inscrivez-vous</a>
            </p>

        </form>
    </div>
</body>
</html>