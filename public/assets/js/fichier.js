/*-----------------------------------------------------------------------------------*/
/*---------------------contact.php-------------------------------------------- */
//X qui efface les champs un par un

document.addEventListener("DOMContentLoaded", () => {
  const clearButtons = document.querySelectorAll(".clear-btn");

  clearButtons.forEach((button) => {
    button.addEventListener("click", () => {
      // Trouve l'input ou le textarea associé
      const input = button.parentNode.querySelector("input, textarea");

      // Efface le contenu

      input.value = "";
    });
  });
});

/*-----------------------------------------------------------------------------------*/
/*---------------------signUp.php-------------------------------------------- */

document.querySelectorAll(".toggle-password").forEach((button) => {
  button.addEventListener("click", function () {
    // Récupérer le champ cible
    const targetSelector = this.getAttribute("data-target");
    const passwordField = document.querySelector(targetSelector);

    if (!passwordField) {
      console.error(
        "Champ mot de passe introuvable pour le sélecteur :",
        targetSelector
      );
      return;
    }

    // Alterner le type de champ entre 'password' et 'text'
    if (passwordField.type === "password") {
      passwordField.type = "text"; // Montrer le mot de passe
    } else {
      passwordField.type = "password"; // Cacher le mot de passe
    }

    // Alterner les icônes
    const eyeOpen = this.querySelector(".eye-open");
    const eyeClosed = this.querySelector(".eye-closed");

    if (passwordField.type === "text") {
      eyeOpen.classList.remove("hidden");
      eyeClosed.classList.add("hidden");
    } else {
      eyeOpen.classList.add("hidden");
      eyeClosed.classList.remove("hidden");
    }
  });
});
