<?php

use App\UTILISATEURS;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function verifier_utilisateur_acces($path_deep, $url, $code_session): array{
    require $path_deep . 'vendor/autoload.php';
    if($code_session) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($code_session);
        if($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if($user) {
                $user_p = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                if($user_p) {
                    if((int)$user_p['statut'] === 1) {
                        $user_s = $UTILISATEURS->trouver_statut($user['id_user']);
                        if($user_s) {
                            $json = array(
                                'success' => true,
                                'code_session' => $session['code_session'],
                                'id_user' => $user['id_user'],
                                'email' => $user['email'],
                                'code_profil' => $user['code_profil'],
                                'num_secu' => $user['num_secu'],
                                'code_civilite' => $user['code_civilite'],
                                'prenoms' => $user['prenoms'],
                                'nom' => $user['nom'],
                                'nom_patronymique' => $user['nom_patronymique'],
                                'photo' => $user['photo'],
                                'code_sexe' => $user['code_sexe'],
                                'code_situation_familiale' => $user['code_situation_familiale'],
                                'message' => null
                            );
                        } else {
                            $json = array(
                                'success' => false,
                                'id_user' => $user['id_user'],
                                'user_disabled' => true,
                                'message' => "Cet utilisateur est désactivé."
                            );
                        }
                    } else {
                        $json = array(
                            'success' => false,
                            'id_user' => $user['id_user'],
                            'password_reset' => true,
                            'message' => "Le mot de passe de l'utilisateur doit être renouvelé."
                        );
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'id_user' => $user['id_user'],
                        'message' => "Le mot de passe de l'utilisateur est introuvable."
                    );
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "L'utilisateur est inconnu par ce système."
                );
            }
        } else {
            $json = array(
                'success' => false,
                'message' => "L'identifiant de cette session est erronée."
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session n'a été définie."
        );
    }
    $audit = $UTILISATEURS->editer_piste_audit($code_session, $url, 'AFFICHAGE', $json['message']);
    if($audit) {
        return $json;
    }else {
        return $audit;
    }

}

function conversion_caracteres_speciaux($txt)
{
    $transliterationTable = array('á' => 'a', 'Á' => 'A', 'ă' => 'a', 'à' => 'a', 'Ă' => 'A', 'â' => 'a', 'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b', 'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c', 'Ċ' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd', 'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'ë' => 'e', 'ê' => 'e', 'é' => 'e', 'è' => 'e', 'ĕ' => 'e', 'Ĕ' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ė' => 'e', 'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ő' => 'o', 'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o', 'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r', 'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS', 'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T', 'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U', 'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th', 'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'E', 'ё' => 'e', 'Ё' => 'E', 'ж' => 'zh', 'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
    return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
}

function salutations()
{
    $moment_jour = strtolower(date('A', time()));
    if ($moment_jour == "am") {
        $salutations = "Bonjour";
    } else {
        $salutations = "Bonsoir";
    }
    return $salutations;
}

function acronyme($entite, $nombre)
{
    $words = explode(" ", $entite);
    $acronym = "";

    $ligne = 1;
    foreach ($words as $w) {
        if ($nombre >= 0) {
            if ($ligne <= $nombre) {
                $acronym .= $w[0];
            }
        } else {
            $acronym .= $w[0];
        }
        $ligne++;
    }
    return $acronym;
}

function envoi_mail($path_deep, $smtp_host, $smtp_username, $smtp_password, $smtp_port, $objet, $message, $expediteur, $destinataires)
{
    require $path_deep . 'vendor/autoload.php';

    require $path_deep.'vendor/phpmailer/phpmailer/src/Exception.php';
    require $path_deep.'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require $path_deep.'vendor/phpmailer/phpmailer/src/SMTP.php';
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";

    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->setLanguage('fr', $path_deep . 'vendor/phpmailer/phpmailer/language/');
        $mail->Encoding = 'base64';
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = $smtp_port;

        //Recipients
        $mail->setFrom($expediteur['email'], $expediteur['nom_prenoms']);
        foreach ($destinataires as $destinataire) {
            $mail->addAddress($destinataire['email'], $destinataire['nom_prenoms']);
        }
        $mail->addReplyTo($expediteur['email'], $expediteur['nom_prenoms']);


        //Content
        $mail->isHTML(true);
        $mail->Subject = $objet;
        $mail->Body = $message;
        $mail->AltBody = $message;

        if ($mail->send()) {
            $json = array(
                'success' => true,
                'message' => "Email envoyé avec succès."
            );
        } else {
            $json = array(
                'success' => false,
                'message' => $mail->ErrorInfo
            );
        }
    } catch (Exception $e) {
        $json = array(
            'success' => false,
            'message' => $mail->ErrorInfo
        );
    }
    return $json;
}

function navigateur()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/android/i', $u_agent)) {
        $platform = 'android';
    } elseif (preg_match('/iphone/i', $u_agent)) {
        $platform = 'iphone';
    } elseif (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }


    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'user_agent' => $u_agent,
        'browser' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

function clean_data($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

function traduction_date($date)
{
    return str_replace(
        'Monday',
        'Lundi',
        str_replace(
            'Tuesday',
            'Mardi',
            str_replace(
                'Wednesday',
                'Mercredi',
                str_replace(
                    'Thursday',
                    'Jeudi',
                    str_replace(
                        'Friday',
                        'Vendredi',
                        str_replace(
                            'Samedi',
                            'Saturday',
                            str_replace(
                                'Sunday',
                                'Dimanche',
                                str_replace(
                                    'January',
                                    'Janvier',
                                    str_replace(
                                        'February',
                                        'Février',
                                        str_replace(
                                            'March',
                                            'Mars',
                                            str_replace(
                                                'April',
                                                'Avril',
                                                str_replace(
                                                    'May',
                                                    'Mai',
                                                    str_replace(
                                                        'June',
                                                        'Juin',
                                                        str_replace(
                                                            'July',
                                                            'Juillet',
                                                            str_replace(
                                                                'August',
                                                                'Août',
                                                                str_replace(
                                                                    'September',
                                                                    'Septembre',
                                                                    str_replace(
                                                                        'October',
                                                                        'Octobre',
                                                                        str_replace(
                                                                            'November',
                                                                            'Novembre',
                                                                            str_replace(
                                                                                'December',
                                                                                'Décembre',
                                                                                $date)))))))))))))))))));
}

function chiffres_en_lettres($a)
{
    $convert = explode('.', $a);
    if (isset($convert[1]) && $convert[1]!='') {
        return chiffres_en_lettres($convert[0]).'Dinars'.' et '.chiffres_en_lettres($convert[1]).'Centimes' ;
    }
    if ($a<0) {
        return 'moins '.chiffres_en_lettres(-$a);
    }
    if ($a<17) {
        switch ($a) {
            case 0:
                return 'zero';
            case 1:
                return 'un';
            case 2:
                return 'deux';
            case 3:
                return 'trois';
            case 4:
                return 'quatre';
            case 5:
                return 'cinq';
            case 6:
                return 'six';
            case 7:
                return 'sept';
            case 8:
                return 'huit';
            case 9:
                return 'neuf';
            case 10:
                return 'dix';
            case 11:
                return 'onze';
            case 12:
                return 'douze';
            case 13:
                return 'treize';
            case 14:
                return 'quatorze';
            case 15:
                return 'quinze';
            case 16:
                return 'seize';
        }
    } elseif ($a<20) {
        return 'dix-'.chiffres_en_lettres($a-10);
    } elseif ($a<100) {
        if ($a%10==0) {
            switch ($a) {
                case 20:
                    return 'vingt';
                case 30:
                    return 'trente';
                case 40:
                    return 'quarante';
                case 50:
                    return 'cinquante';
                case 60:
                    return 'soixante';
                case 70:
                    return 'soixante-dix';
                case 80:
                    return 'quatre-vingt';
                case 90:
                    return 'quatre-vingt-dix';
            }
        } elseif (substr($a, -1)==1) {
            if (((int)($a/10)*10)<70) {
                return chiffres_en_lettres((int)($a/10)*10).'-et-un';
            } elseif ($a==71) {
                return 'soixante-et-onze';
            } elseif ($a==81) {
                return 'quatre-vingt-un';
            } elseif ($a==91) {
                return 'quatre-vingt-onze';
            }
        } elseif ($a<70) {
            return chiffres_en_lettres($a-$a%10).'-'.chiffres_en_lettres($a%10);
        } elseif ($a<80) {
            return chiffres_en_lettres(60).'-'.chiffres_en_lettres($a%20);
        } else {
            return chiffres_en_lettres(80).'-'.chiffres_en_lettres($a%20);
        }
    } elseif ($a==100) {
        return 'cent';
    } elseif ($a<200) {
        return chiffres_en_lettres(100).' '.chiffres_en_lettres($a%100);
    } elseif ($a<1000) {
        return chiffres_en_lettres((int)($a/100)).' '.chiffres_en_lettres(100).' '.chiffres_en_lettres($a%100);
    } elseif ($a==1000) {
        return 'mille';
    } elseif ($a<2000) {
        return chiffres_en_lettres(1000).' '.chiffres_en_lettres($a%1000).' ';
    } elseif ($a<1000000) {
        return chiffres_en_lettres((int)($a/1000)).' '.chiffres_en_lettres(1000).' '.chiffres_en_lettres($a%1000);
    } elseif ($a==1000000) {
        return 'millions';
    } elseif ($a<2000000) {
        return chiffres_en_lettres(1000000).' '.chiffres_en_lettres($a%1000000).' ';
    } elseif ($a<1000000000) {
        return chiffres_en_lettres((int)($a/1000000)).' '.chiffres_en_lettres(1000000).' '.chiffres_en_lettres($a%1000000);
    }
}
