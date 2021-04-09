<?php
$type = trim($_GET['type']);
$data = trim($_GET['data']);
require "../_CONFIGS/Classes/UTILISATEURS.php";
if($type == 'csv') {
    if($data == 'put') {
        require "../_CONFIGS/Classes/PROFILSUTILISATEURS.php";
        $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
        $profils = $PROFILSUTILISATEURS->lister();
        $nb_profils = count($profils);
        if($nb_profils != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_PROFIL_UTILISATEURS_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($profils as $profil) {
                fputcsv($fp, array($profil['code'], $profil['libelle'], date('d/m/Y',strtotime($profil['date_debut']))),';');
            }
            fclose($fp);
        }
    }elseif($data == 'csp') {
        require "../_CONFIGS/Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
        $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
        $categories = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
        $nb_categories = count($categories);
        if($nb_categories != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_CATEGORIES_SOCIO_PROFESSIONNELLES_'.date('dmYhis',time()).'.csv"');
            //$donnees = array('CODE', 'LIBELLE', 'DATE EFFET');

            $fp = fopen('php://output', 'wb');
            fputcsv($fp, array('CODE', 'LIBELLE', 'DATE EFFET'),';');
            foreach ($categories as $categorie) {
                fputcsv($fp, array($categorie['code'], $categorie['libelle'], date('d/m/Y',strtotime($categorie['date_debut']))),';');
            }
            fclose($fp);
        }
    }elseif($data == 'civ') {

    }elseif($data == 'sex') {

    }elseif($data == 'sif') {

    }elseif($data == 'sct') {

    }elseif($data == 'prf') {

    }elseif($data == 'qtc') {

    }elseif($data == 'tco') {

    }elseif($data == 'tpi') {

    }elseif($data == 'dev') {

    }elseif($data == 'gsa') {

    }elseif($data == 'rhs') {

    }elseif($data == 'lge') {

    }elseif($data == 'reg') {

    }elseif($data == 'dep') {

    }elseif($data == 'com') {

    }else{
        echo '<p align="center">Cette donnée n\'est pas prise en charge pour l\'export.</p>';
    }
}
elseif($type == 'xls') {
    if($data == 'put') {

    }elseif($data == 'csp') {

    }elseif($data == 'civ') {

    }elseif($data == 'sex') {

    }elseif($data == 'sif') {

    }elseif($data == 'sct') {

    }elseif($data == 'prf') {

    }elseif($data == 'qtc') {

    }elseif($data == 'tco') {

    }elseif($data == 'tpi') {

    }elseif($data == 'dev') {

    }elseif($data == 'gsa') {

    }elseif($data == 'rhs') {

    }elseif($data == 'lge') {

    }elseif($data == 'reg') {

    }elseif($data == 'dep') {

    }elseif($data == 'com') {

    }else{
        echo '<p align="center">Cette donnée n\'est pas prise en charge pour l\'export.</p>';
    }
}
elseif($type == 'pdf') {
    if($data == 'put') {

    }elseif($data == 'csp') {

    }elseif($data == 'civ') {

    }elseif($data == 'sex') {

    }elseif($data == 'sif') {

    }elseif($data == 'sct') {

    }elseif($data == 'prf') {

    }elseif($data == 'qtc') {

    }elseif($data == 'tco') {

    }elseif($data == 'tpi') {

    }elseif($data == 'dev') {

    }elseif($data == 'gsa') {

    }elseif($data == 'rhs') {

    }elseif($data == 'lge') {

    }elseif($data == 'reg') {

    }elseif($data == 'dep') {

    }elseif($data == 'com') {

    }else{
        echo '<p align="center">Cette donnée n\'est pas prise en charge pour l\'export.</p>';
    }
}
elseif($type == 'txt') {
    if($data == 'put') {
        require "../_CONFIGS/Classes/PROFILSUTILISATEURS.php";
        $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
        $profils = $PROFILSUTILISATEURS->lister();
        $nb_profils = count($profils);
        if($nb_profils != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_PROFIL_UTILISATEURS_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",6,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",45,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($profils as $profil) {
                fwrite($fp, str_pad($profil['code'],6,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($profil['libelle'],45,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($profil['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }elseif($data == 'csp') {
        require "../_CONFIGS/Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
        $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
        $categories = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
        $nb_categories = count($categories);
        if($nb_categories != 0) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="EXPORT_CATEGORIES_SOCIO_PROFESSIONNELLES_'.date('dmYhis',time()).'.txt"');

            $fp = fopen('php://output', 'wb');
            fwrite($fp, str_pad("CODE",3,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("LIBELLE",45,' ',STR_PAD_RIGHT)."\t\t\t".str_pad("DATE EFFET",10,' ',STR_PAD_RIGHT)."\n");
            foreach ($categories as $categorie) {
                fwrite($fp, str_pad($categorie['code'],3,' ',STR_PAD_RIGHT)."\t\t\t".str_pad($categorie['libelle'],45,' ',STR_PAD_RIGHT)."\t\t\t".str_pad(date('d/m/Y',strtotime($categorie['date_debut'])),10,' ',STR_PAD_RIGHT)."\n");
            }
            fclose($fp);
        }
    }elseif($data == 'civ') {

    }elseif($data == 'sex') {

    }elseif($data == 'sif') {

    }elseif($data == 'sct') {

    }elseif($data == 'prf') {

    }elseif($data == 'qtc') {

    }elseif($data == 'tco') {

    }elseif($data == 'tpi') {

    }elseif($data == 'dev') {

    }elseif($data == 'gsa') {

    }elseif($data == 'rhs') {

    }elseif($data == 'lge') {

    }elseif($data == 'reg') {

    }elseif($data == 'dep') {

    }elseif($data == 'com') {

    }else{
        echo '<p align="center">Cette donnée n\'est pas prise en charge pour l\'export.</p>';
    }
}
else{
    echo '<p align="center">Ce format n\'est pas pris en charge pour l\'export de données.</p>';
}