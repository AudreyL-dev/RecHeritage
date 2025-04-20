<!-- Appel des inclusions PHP-->

<?php require_once(__DIR__ . '/../../config/autoload.php'); ?>

<!-- head.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "Recettes en Héritage - " . $pageTitle; ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/dist/output.css">


   <!-- Favicon par défaut (pour compatibilité maximale) -->
<link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/assets/img/favicon-light.svg">

<!-- Favicon Light Mode (Mode Clair) -->
<link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/assets/img/favicon-light.svg" media="(prefers-color-scheme: light)">

<!-- Favicon Dark Mode (Mode Sombre) -->
<link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/assets/img/favicon-dark.svg" media="(prefers-color-scheme: dark)">

    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rouge+Script&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bellota:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/favicon.ico">
    <script>
        const users = <?php echo json_encode($users); ?>;
    </script>
    <script async type=" text/javascript" src="<?= BASE_URL ?>/assets/js/script.js">
    </script>

</head>
<body
    class="<?= isset($bodyClass) ? $bodyClass : 'bg-all-site bg-cover bg-center bg-no-repeat bg-fixed flex flex-col min-h-screen text-gray-700' ?>">
</body>