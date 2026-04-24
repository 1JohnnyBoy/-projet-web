<?php require_once 'connexxion.php';
session_start();
/*$connexion = new PDO('mysql:host=127.0.0.1;dbname=smartphones', 'root', '');*/

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['brand'])) {
        $message = "Veuillez entrer une marque.";
    } else {
        $brand = htmlspecialchars($_POST['brand']);/*récup la marque saisie dans le formulaire*/
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
                <input type="text" name="brand" placeholder="Marque">
                <button type="submit">Rechercher</button>
            </form>
        </div>
    </div>

    <?php if (isset($message)) : ?>
        <p style="color:red; text-align:center; margin-top:1rem;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <?php if (!empty($resultats)) : ?>
        <div id="cadre">
            <?php foreach ($resultats as $telephone) : ?>
                <div id="tel">
                    <img src="uploads/<?php echo htmlspecialchars($telephone['photo']); ?>" alt="<?php echo htmlspecialchars($telephone['modèle']); ?>"><br />
                    <?php echo htmlspecialchars($telephone['Marque']); ?><br />
                    <?php echo htmlspecialchars($telephone['modèle']); ?><br />
                    <?php echo htmlspecialchars($telephone['prix']); ?> €<br />
                    <?php echo htmlspecialchars($telephone['couleur']); ?><br />
                    <?php echo htmlspecialchars($telephone['stockage']); ?> Go
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
