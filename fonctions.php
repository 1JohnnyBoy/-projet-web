<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
 

/*
 * fonctions.php — les outils réutilisés par toutes les pages.
 * Inclus automatiquement par config.php.
 */

// ---------------------------------------------------------------
// Affichage : échapper au moment de l'affichage, jamais avant
// ---------------------------------------------------------------

/**
 * Raccourci pour htmlspecialchars.
 * Règle d'or : on stocke les données BRUTES en base, on les échappe
 * uniquement au moment de les afficher. Sinon une apostrophe finit
 * stockée en "&#039;" dans la base.
 */
function e(mixed $valeur): string
{
    return htmlspecialchars((string) $valeur, ENT_QUOTES, 'UTF-8');
}

/**
 * Longueur d'une chaîne en CARACTÈRES (et non en octets).
 *
 * On n'appelle pas mb_strlen() directement : l'extension mbstring n'est pas
 * activée sur tous les hébergements mutualisés, et son absence provoquerait
 * une erreur fatale. On prévoit donc un repli.
 */
function longueur(string $chaine): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($chaine, 'UTF-8');
    }
    return (int) preg_match_all('/./us', $chaine);
}

// ---------------------------------------------------------------
// Authentification
// ---------------------------------------------------------------

function utilisateur_connecte(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * À appeler en haut de chaque page réservée aux membres.
 * Sans ça, n'importe qui connaissant l'URL /suppression.php vide la base.
 */
function est_admin(): bool
{
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1;
}
/*admin uniquement*/
function exiger_connexion(): void
{
    if (!utilisateur_connecte()) {
        header('Location: connexxion.php');
        exit();
    }
}

function connecter_utilisateur(array $user): void
{
    // Nouvel identifiant de session : protège contre la fixation de session.
    session_regenerate_id(true);
    $_SESSION['user_id']  = (int) $user['Id'];
    $_SESSION['username'] = $user['Username'];
    unset($_SESSION['csrf']); // on repart sur un jeton neuf
}

// ---------------------------------------------------------------
// Protection CSRF
// ---------------------------------------------------------------

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/** À insérer dans chaque formulaire POST. */
function csrf_champ(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

/** À vérifier avant tout traitement POST. */
function csrf_valide(): bool
{
    return isset($_POST['csrf'])
        && is_string($_POST['csrf'])
        && hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']);
}

// ---------------------------------------------------------------
// Upload d'image
// ---------------------------------------------------------------

/**
 * Enregistre une image envoyée via $_FILES.
 *
 * @return array{0: ?string, 1: ?string} [nom_du_fichier, message_erreur]
 *
 * Trois protections indispensables :
 *  - on lit le vrai type MIME du contenu (finfo), pas l'extension annoncée ;
 *  - on régénère le nom du fichier (sinon on peut uploader "shell.php") ;
 *  - on limite la taille.
 */
function enregistrer_image(?array $fichier): array
{
    if ($fichier === null || !isset($fichier['error']) || $fichier['error'] === UPLOAD_ERR_NO_FILE) {
        return [null, 'Choisis une image.'];
    }

    if ($fichier['error'] === UPLOAD_ERR_INI_SIZE || $fichier['error'] === UPLOAD_ERR_FORM_SIZE) {
        return [null, 'Image trop lourde. Maximum 2 Mo.'];
    }

    if ($fichier['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($fichier['tmp_name'])) {
        return [null, "L'envoi de l'image a échoué. Réessaie."];
    }

    if ($fichier['size'] > 2 * 1024 * 1024) {
        return [null, 'Image trop lourde. Maximum 2 Mo.'];
    }

    $extensionsAutorisees = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($fichier['tmp_name']);

    if (!is_string($mime) || !isset($extensionsAutorisees[$mime])) {
        return [null, 'Format non accepté. Utilise un JPG, PNG, WEBP ou GIF.'];
    }

    if (!is_dir(UPLOAD_DIR) && !mkdir(UPLOAD_DIR, 0755, true) && !is_dir(UPLOAD_DIR)) {
        return [null, "Le dossier d'images est inaccessible."];
    }

    // Nom aléatoire : on ne fait jamais confiance au nom d'origine.
    $nomFichier = bin2hex(random_bytes(16)) . '.' . $extensionsAutorisees[$mime];

    if (!move_uploaded_file($fichier['tmp_name'], UPLOAD_DIR . '/' . $nomFichier)) {
        return [null, "L'image n'a pas pu être enregistrée."];
    }

    return [$nomFichier, null];
}

/** Supprime une image du disque (utilisé après une suppression en base). */
function supprimer_image(?string $nomFichier): void
{
    if (empty($nomFichier)) {
        return;
    }
    // basename() empêche un "../../config.php" de remonter dans l'arborescence.
    $chemin = UPLOAD_DIR . '/' . basename($nomFichier);
    if (is_file($chemin)) {
        @unlink($chemin);
    }
}

/** Construit l'URL d'affichage d'une image (gère les espaces dans les noms). */
function url_image(?string $nomFichier): string
{
    if (empty($nomFichier)) {
        return '';
    }
    return UPLOAD_URL . '/' . rawurlencode(basename($nomFichier));
}