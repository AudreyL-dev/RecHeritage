<!-- Appel des inclusions PHP-->

<?php require_once(__DIR__ . '/init.php'); ?>

<!-- head.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="dist/output.css">
    <script>
        const users = <?php echo json_encode($users); ?>;
    </script>
    <script async type="text/javascript" src="fichier.js"></script>


</head>