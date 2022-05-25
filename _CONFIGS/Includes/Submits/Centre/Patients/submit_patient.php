<?php
header('Content-Type: application/json');
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/PATIENTS.php";
    require_once "../../../../Functions/Functions.php";
    $UTILISATEURS = new UTILISATEURS();
    $PATIENTS = new PATIENTS();
    $patients = $PATIENTS->lister_patients();
    $nb_patients = count($patients);
    $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'], null, null);
    if ($utilisateur) {
        $edition = $PATIENTS->editer($parametres['code_patient'],conversion_caracteres_speciaux( $parametres['num_secu']),$parametres['civilite'],strtoupper(conversion_caracteres_speciaux( $parametres['prenoms'])),strtoupper(conversion_caracteres_speciaux( $parametres['nom'])),$parametres['code_assurance'],conversion_caracteres_speciaux( $parametres['num_assurance']),null, $parametres['date_naissance'],$parametres['nationnalite'],$parametres['sexe'],$parametres['situation_fam'],$parametres['csp'],$parametres['pays_naissance'],$parametres['region_naissance'],$parametres['departement_naissance'],$parametres['commune_naissance'],$parametres['pays_residence'],$parametres['region_residence'],$parametres['departement_residence'],$parametres['commune_residence'],$parametres['adresse_geo'],$parametres['adresse_postale'],$parametres['profession'],$parametres['secteur_activite'],$parametres['groupe_sanguin'],$parametres['rhesus'],$utilisateur['id_user']);
        if ($edition['success'] == true) {
            $nb_allergie = count($parametres['allergie']);
            $nb_coordonnee = count($parametres['valeur_coordonnee']);
            $nb_ecu = count($parametres['type_ecu']);

            $allergie = $parametres['allergie'];
            $code_type_coordonnee = $parametres['type_coordonnee'];
            $valeur_coordonnee = $parametres['valeur_coordonnee'];
            $type_ecu = $parametres['type_ecu'];
            $nom_ecu = $parametres['nom_ecu'];
            $prenoms_ecu = $parametres['prenoms_ecu'];
            $numero_ecu = $parametres['numero_ecu'];

            //allergie

                for ($i = 0; $i < $nb_allergie; $i++) {
                    $edition_allergie = $PATIENTS->editer_allergie($edition['id_user'], $allergie[$i], $utilisateur['id_user']);
                }

            //coordonnee

            for ($i = 0; $i < $nb_coordonnee; $i++) {
                $edition_coordonnee = $PATIENTS->editer_coordonnee($edition['id_user'],$code_type_coordonnee[$i], conversion_caracteres_speciaux($valeur_coordonnee[$i]), $utilisateur['id_user']);

            }

            //ecu

            for ($i = 0; $i < $nb_ecu; $i++) {
                $edition_ecu = $PATIENTS->editer_contact_ecu($edition['id_user'],conversion_caracteres_speciaux($nom_ecu[$i]),conversion_caracteres_speciaux($prenoms_ecu[$i]),conversion_caracteres_speciaux($numero_ecu[$i]),$type_ecu[$i], $utilisateur['id_user']);
            }


            $audit = $UTILISATEURS->editer_piste_audit(CLIENT_ADRESSE_IP, ACTIVE_URL, "CREATION", json_encode($parametres), 1);
            if ($audit['success'] == true) {
                    $json = array(
                        'success' => $edition['success'],
                        'message' => $edition['message'],
                    );


            }
        } else {
            $json = $edition;
        }

    } else {
        $json = array(
            'success' => false,
            'message' => "Aucun utilisateur identifié pour effectué cette action."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
echo json_encode($json);