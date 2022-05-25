<?php
if($Links['ACTIVE_URL'] === $Links['URL'].'parametres/securite/') {
    define('TITLE', "Sécurité");
}elseif($Links['ACTIVE_URL'] === $Links['URL'].'parametres/securite/compte') {
    define('TITLE', "Sécurité du compte");
}elseif($Links['ACTIVE_URL'] === $Links['URL'].'parametres/securite/mot-de-passe') {
    define('TITLE', "Sécurité du mot de passe");
}else {
    header("Location: ".$Links['URL'].'page-introuvable');
}