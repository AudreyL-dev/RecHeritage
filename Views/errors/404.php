<?php
$pageTitle = "Page non trouvée - 404";
$bodyClass = "bg-error-404 bg-cover bg-center bg-no-repeat w-screen h-screen flex flex-col items-center justify-center text-gray-700"; // exemple de fond spécifique ou sans image
include __DIR__ . '/../includes/head.php';
?>

<div class="overlay">
    <a class="p-[12vh] rounded-full" href="<?php echo BASE_URL . '/index.php'; ?>" aria-label="Retour à l’accueil"></a>
</div>
<div
    class="fixed bottom-0 left-0 w-screen p-[1vh] text-center font-lora text-white text-lg sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl">
    Oups! Cette page a disparu
    du menu mais tu peux cliquer sur l'œuf pour retourner à l'accueil.</div>
</body>
</html>