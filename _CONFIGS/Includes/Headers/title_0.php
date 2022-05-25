<?php
if($Links['ACTIVE_URL'] === $Links['URL']) {
    define('TITLE', "Ouagolo");
}elseif($Links['ACTIVE_URL'] === $Links['URL'].'page-introuvable') {
    define('TITLE', "!404 Page introuvable");
}elseif($Links['ACTIVE_URL'] === $Links['URL'].'connexion') {
    define('TITLE', "Connexion");
}else {
    header("Location: ".$Links['URL'].'page-introuvable');
}