<?php
// Génère un champ <input type="hidden"> avec le token CSRF
function csrfInput(): string
{
    return '<input type="hidden" name="csrf_token" value="' . generateCsrfToken() . '">';
}