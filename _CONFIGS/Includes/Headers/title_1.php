<?php
if($Links['ACTIVE_URL'] === $Links['URL'].'parametres/') {
    define('TITLE', "Paramètres");
}else {
    header("Location: ".$Links['URL'].'page-introuvable');
}