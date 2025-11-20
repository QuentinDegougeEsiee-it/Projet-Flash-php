<?php
/**
 * Affiche une notification HTML/CSS
 * * @param string $message     Le contenu du message
 * @param string $messageType Le type : 'success' ou 'error'
 */
function displayNotification($message, $messageType = 'success') {
    // Configuration par défaut (Success)
    $title = "Succès !";
    $modifierClass = "success";
    
    // Configuration si Erreur
    if ($messageType === 'error') {
        $title = "Erreur !";
        $modifierClass = "error";
    }

    // Note: Dans un vrai projet, retirez la classe 'active' pour gérer l'affichage via JS.
    // Ici, je la laisse pour que vous voyiez le résultat immédiatement.
    $html = '
    <div class="notification active ' . $modifierClass . '">
        <div class="icon-circle">
            <div class="icon-' . ($messageType === 'error' ? 'cross' : 'check') . '"></div>
        </div>
        <div class="notif-content">
            <h3>' . $title . '</h3>
            <p>' . htmlspecialchars($message) . '</p>
        </div>
    </div>';

    echo $html;
}
?>