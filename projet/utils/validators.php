<?php
// validators.php

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isStrongPassword($password) {
    // Exemple: min 8 caractères
    return strlen($password) >= 8;
}

function isNotEmpty($fields = []) {
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            return false;
        }
    }
    return true;
}