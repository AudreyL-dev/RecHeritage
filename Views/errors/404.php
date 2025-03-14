<?php
$pageTitle = "Page non trouvée - 404";
include __DIR__ . '/../includes/head.php';
?>
<body class="flex flex-col items-center justify-center h-screen error-background">
    <div class="overlay">
        <a class="egg-link" href="<?php echo BASE_URL . '/index.php'; ?>" aria-label="Retour à l’accueil"></a>
    </div>
    <div class="error-explication">Oups!Cette page a disparu du menu mais tu peux cliquer sur l'œuf pour retourner à
        l'accueil.</div>
</body>
</html>