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
    "./Views/**/*.php",
  ],
  safelist: ["hs-password-active:hidden", "hs-password-active:block"],
  theme: {
    extend: {
      fontFamily: {
        lora: ['"Lora"', "serif"],
        rouge_script: ['"Rouge Script"', "serif"],
        bellota: ['"Bellota"', "sans-serif"],
      },
      colors: {
        primary: "#384D48",
        secondary: "#6E7271",
        accent: "#ACAD94",
        neutral: "#D8D4D5",
        light: "#E2E2E2",
        danger: "#B91C1C",
        dangerHover: "#EF4444",
      },
      backgroundImage: {
        "custom-radial":
          "radial-gradient(circle at top left, #8a8978, #8f8e77 30%, #8e8c78 60%, #8b8975 100%)",
        "all-site": "url('/public/assets/img/bg-rec-heritage.webp')",
        "error-404": "url('/public/assets/img/bg-404-rec-heritage.webp')",
      },
    },
  },
  plugins: [
    require("preline/plugin"), // Utiliser le plugin Preline
  ],
};
