<?php
declare(strict_types=1);
 

/*
 * config.php — connexion à la base + réglages communs.
 * Ce fichier est inclus en haut de TOUTES les pages.
 *
 * Aucun mot de passe n'est écrit en dur ici : les valeurs viennent de
 * variables d'environnement, avec des valeurs de repli pour ton WAMP/XAMPP local.
 * Sur l'hébergeur, tu définis DB_HOST / DB_NAME / DB_USER / DB_PASS / APP_ENV
 * dans le panneau d'administration (ou dans un .env non versionné).
 */

// ---------------------------------------------------------------
// 1. Environnement : "local" ou "prod"
// ---------------------------------------------------------------
$appEnv = getenv('APP_ENV') ?: 'local';
define('APP_ENV', $appEnv);

if (APP_ENV === 'local') {
    // En local on veut voir les erreurs pour déboguer.
    ini_set('display_errors', '1');
} else {
    // En ligne, jamais : un message d'erreur PDO affiche l'hôte et le nom de la base.
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}
error_reporting(E_ALL);

// ---------------------------------------------------------------
// 2. Session (cookie durci)
// ---------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,  // le cookie n'est pas lisible en JavaScript
        'samesite' => 'Lax', // limite les envois depuis un site tiers
        'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    ]);
    session_start();
}

// ---------------------------------------------------------------
// 3. Connexion à la base
// ---------------------------------------------------------------
$dbHost = getenv('DB_HOST') ?: 'mysql-sleazyjohan.alwaysdata.net';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'sleazyjohan_smartphones';
$dbUser = getenv('DB_USER') ?: 'sleazyjohan';
$dbPass = getenv('DB_PASS') ?: 'richforever237';

try {
    $connexion = new PDO(
        "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, // vraies requêtes préparées côté serveur
        ]
    );
} catch (PDOException $e) {
    error_log('Connexion BDD impossible : ' . $e->getMessage());
    http_response_code(500);
    exit(APP_ENV === 'local'
        ? 'Connexion BDD impossible : ' . $e->getMessage()
        : 'Le site est momentanément indisponible. Réessaie dans quelques minutes.');
}

// ---------------------------------------------------------------
// 4. Dossier des images de smartphones
// ---------------------------------------------------------------
define('UPLOAD_DIR', __DIR__ . '/uploads');   // chemin disque
define('UPLOAD_URL', 'uploads');              // chemin dans les URL

require_once __DIR__ . '/fonctions.php';