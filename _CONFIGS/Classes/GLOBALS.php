<?php

namespace App;

class GLOBALS extends BDD
{
    public function metas() {
        return array(
            'LANGUAGE' => "fr",
            'AUTHORS' => "TecHouse SARL",
            'DESCRIPTION' => "",
            'VERSION' => "1.0.0"
        );
    }

    public function headers($level) {
        if($level === 0) {
            $json = array(
                'success' => true,
                'title' => "_CONFIGS/Includes/Headers/title_0.php",
                'header' => "_CONFIGS/Includes/Headers/header_0.php",
                'footer' => "_CONFIGS/Includes/Headers/footer_0.php",
                'loader' => "_CONFIGS/Includes/Headers/loader.php",
                'menu' => "_CONFIGS/Includes/Headers/Menu.php"
            );
        }
        elseif($level === 1) {
            $json = array(
                'success' => true,
                'title' => "../_CONFIGS/Includes/Headers/title_1.php",
                'header' => "../_CONFIGS/Includes/Headers/header_1.php",
                'footer' => "../_CONFIGS/Includes/Headers/footer_1.php",
                'loader' => "../_CONFIGS/Includes/Headers/loader.php",
                'menu' => "../_CONFIGS/Includes/Headers/Menu.php"
            );
        }
        elseif($level === 2) {
            $json = array(
                'success' => true,
                'title' => "../../_CONFIGS/Includes/Headers/title_2.php",
                'header' => "../../_CONFIGS/Includes/Headers/header_2.php",
                'footer' => "../../_CONFIGS/Includes/Headers/footer_2.php",
                'loader' => "../../_CONFIGS/Includes/Headers/loader.php",
                'menu' => "../../_CONFIGS/Includes/Headers/Menu.php"
            );
        }
        else {
            $json = array(
                'success' => false
            );
        }
        return $json;
    }

    public function links() {
        session_start();
        define("URL", "https://projets.techouse.io/ouagolo/");
        return array(
            'URL' => URL,
            'CONFIGS' => URL."_CONFIGS/",
            'PUBLICS' => URL."_PUBLICS/",
            'CSS' => URL."_PUBLICS/css/",
            'JS' => URL."_PUBLICS/js/",
            'IMAGES' => URL."_PUBLICS/images/",
            'NODE_MODULES' => URL."_PUBLICS/node_modules/",
            'ACTIVE_URL' => "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}",
            'DIR' => $_SERVER['DOCUMENT_ROOT'].'ouagolo/',
            'SERVEUR_ADRESSE_IP' => $_SERVER['SERVER_ADDR'],
            'CLIENT_ADRESSE_IP' => $_SERVER['REMOTE_ADDR']
        );
    }

    public function smtp() {
        return array(
            'HOST' => "mail.techouse.io",
            'PORT' => 465,
            'USERNAME' => "smtp@techouse.io",
            'PASSWORD' => "jjcA+@LxzMF#"
        );
    }
}