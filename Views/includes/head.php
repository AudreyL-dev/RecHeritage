<!-- Appel des inclusions PHP-->

<?php require_once(__DIR__ . '/../../config/autoload.php'); ?>

<!-- head.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/dist/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/404.css">
    <script>
        const users = <?php echo json_encode($users); ?>;
    </script>
    <script async type=" text/javascript" src="<?= BASE_URL ?>/assets/js/script.js">
    </script>

</head>