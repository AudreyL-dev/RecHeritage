<?php

// Nettoie un titre de recette (retire balises HTML, espaces inutiles)
function sanitizeRecipeTitle(string $title): string
{
    return trim(strip_tags($title));
}

// Nettoie le contenu d'une recette (retire balises HTML, espaces inutiles)
function sanitizeRecipeContent(string $content): string
{
    return trim(strip_tags($content));
}

// Coupe un texte pour aperçu (limite la longueur)
function truncateRecipe(string $text, int $maxLength = 100): string
{
    if (mb_strlen($text) > $maxLength) {
        return mb_substr($text, 0, $maxLength) . '...';
    }
    return $text;
}

// Formate la date de création d'une recette (par exemple : "24 avril 2025")
function formatRecipeDate(string $dateString): string
{
    $date = new DateTime($dateString);
    return $date->format('d F Y'); // tu peux adapter le format si besoin
}
