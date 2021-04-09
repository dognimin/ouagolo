<?php
if(ACTIVE_URL == URL) {
    define('TITLE', 'Ouagolo');
}elseif (ACTIVE_URL == URL.'connexion') {
    define('TITLE', ' Connexion Ouagolo');
}elseif (ACTIVE_URL == URL.'mot-de-passe') {
    define('TITLE', 'MAJ du mot de passe');
}elseif (ACTIVE_URL == URL.'parametres/') {
    define('TITLE', 'Paramètres');
}elseif (ACTIVE_URL == URL.'parametres/tables-de-valeurs') {
    define('TITLE', 'Tables de valeurs');
}