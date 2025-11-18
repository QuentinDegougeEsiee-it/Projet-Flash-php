<?php
// common.php

// Démarrage de la session PHP (obligatoire pour userConnexion et security)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement des dépendances dans l'ordre
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/validators.php';
require_once __DIR__ . '/userConnexion.php';

// Optionnel : Définition de constantes globales
define('SITE_NAME', 'Mon Super Site');