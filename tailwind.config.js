/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php", // Fichiers PHP à la racine
    "./*.html", // Fichiers HTML à la racine
    "./*.js", // Fichiers JavaScript à la racine
    "./config/**/*.php", // Fichiers PHP dans le dossier "config"
    "./dist/**/*.css", // Fichiers CSS générés dans "dist"
    "./img/**/*.{png,jpg,jpeg,svg,webp}", // Images utilisées dans le dossier "img"
    "./node_modules/**/*.{js,css}", // Modules Node.js pertinents
  ],
  safelist: ["hs-password-active:hidden", "hs-password-active:block"],
  theme: {
    extend: {
      colors: {
        primary: "#384D48",
        secondary: "#6E7271",
        accent: "#ACAD94",
        neutral: "#D8D4D5",
        light: "#E2E2E2",
        danger: "#B91C1C",
        dangerHover: "#EF4444",
      },
    },
  },
  plugins: [
    require("preline/plugin"), // Utiliser le plugin Preline
  ],
};
