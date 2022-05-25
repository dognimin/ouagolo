<?php
namespace App;

class SECURITE extends BDD
{
    public function trouver_securite_mdp(){
        $a = $this->getBdd()->prepare("
SELECT 
       A.securite_mdp_longueur_minimale AS longueur_minimale, 
       A.securite_mdp_exigence_caracteres_speciaux AS caracteres_speciaux, 
       A.securite_mdp_exigence_majuscules AS majuscules, 
       A.securite_mdp_exigence_minuscules AS minuscules, 
       A.securite_mdp_exigence_chiffres AS chiffres, 
       A.securite_mdp_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation , 
       B.utilisateur_nom AS nom, 
       B.utilisateur_prenoms AS prenoms
FROM 
     tb_securite_mot_de_passe A JOIN tb_utilisateurs B ON A.utilisateur_id_creation = B.utilisateur_id AND  A.securite_mdp_date_fin IS NULL");
        $a->execute(array());
        return $a->fetch();
    }

    public function trouver_securite_compte() {
        $a = $this->getBdd()->prepare("
SELECT 
       A.securite_compte_nombre_essais_authentification AS nombre_essais, 
       A.securite_compte_duree_de_vie_mot_de_passe AS duree_mot_de_passe, 
       A.securite_compte_autorisation_double_authentification AS double_authentification, 
       A.securite_compte_autorisation_sms AS autoriser_sms, 
       A.securite_compte_autorisation_mail AS autoriser_email, 
       A.securite_compte_date_debut AS date_debut, 
       A.date_creation, 
       A.utilisateur_id_creation , 
       B.utilisateur_nom AS nom, 
       B.utilisateur_prenoms AS prenoms
FROM 
     tb_securite_compte A JOIN tb_utilisateurs B ON A.utilisateur_id_creation = B.utilisateur_id AND  A.securite_compte_date_fin IS NULL");
        $a->execute(array());
        return $a->fetch();
    }

    private function ajouter_securite_mdp($longueur_minimale, $caracteres_speciaux, $majuscules, $minuscules, $chiffres, $user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_securite_mot_de_passe(securite_mdp_longueur_minimale, securite_mdp_exigence_caracteres_speciaux, securite_mdp_exigence_majuscules, securite_mdp_exigence_minuscules, securite_mdp_exigence_chiffres, securite_mdp_date_debut, utilisateur_id_creation) 
            VALUES(:securite_mdp_longueur_minimale, :securite_mdp_exigence_caracteres_speciaux, :securite_mdp_exigence_majuscules, :securite_mdp_exigence_minuscules, :securite_mdp_exigence_chiffres, :securite_mdp_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'securite_mdp_longueur_minimale' => $longueur_minimale,
            'securite_mdp_exigence_caracteres_speciaux' => $caracteres_speciaux,
            'securite_mdp_exigence_majuscules' => $majuscules,
            'securite_mdp_exigence_minuscules' => $minuscules,
            'securite_mdp_exigence_chiffres' => $chiffres,
            'securite_mdp_date_debut' => date('Y-m-d',time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function ajouter_securite_compte($nombre_essais, $duree_mot_de_passe, $double_authentification, $autoriser_sms, $autoriser_email, $user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_securite_compte(securite_compte_nombre_essais_authentification, securite_compte_duree_de_vie_mot_de_passe, securite_compte_autorisation_double_authentification, securite_compte_autorisation_sms, securite_compte_autorisation_mail, securite_compte_date_debut, utilisateur_id_creation) 
            VALUES(:securite_compte_nombre_essais_authentification, :securite_compte_duree_de_vie_mot_de_passe, :securite_compte_autorisation_double_authentification, :securite_compte_autorisation_sms, :securite_compte_autorisation_mail, :securite_compte_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'securite_compte_nombre_essais_authentification' => $nombre_essais,
            'securite_compte_duree_de_vie_mot_de_passe' => $duree_mot_de_passe,
            'securite_compte_autorisation_double_authentification' => $double_authentification,
            'securite_compte_autorisation_sms' => $autoriser_sms,
            'securite_compte_autorisation_mail' => $autoriser_email,
            'securite_compte_date_debut' => date('Y-m-d',time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function fermer_securite_mdp($date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_securite_mot_de_passe SET securite_mdp_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE securite_mdp_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function fermer_securite_compte($date_fin, $user) {
        $a = $this->getBdd()->prepare("UPDATE tb_securite_compte SET securite_compte_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE securite_compte_date_fin IS NULL");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    public function editer_securite_mdp($longueur_minimale, $caracteres_speciaux, $majuscules, $minuscules, $chiffres, $user){
        $securite = $this->trouver_securite_mdp();
        if($securite) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($securite['date_debut'])) {
                $edition = $this->fermer_securite_mdp($date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_securite_mdp($longueur_minimale, $caracteres_speciaux, $majuscules, $minuscules, $chiffres, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($securite['date_debut'])))
                );
            }

        }else {
            $json = $this->ajouter_securite_mdp($longueur_minimale, $caracteres_speciaux, $majuscules, $minuscules, $chiffres, $user);
        }
        return $json;
    }

    public function editer_securite_compte($nombre_essais, $duree_mot_de_passe, $double_authentification, $autoriser_sms, $autoriser_email, $user){
        $securite = $this->trouver_securite_compte();
        if($securite) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($securite['date_debut'])) {
                $edition = $this->fermer_securite_compte($date_fin,$user);
                if($edition['success'] == true) {
                    $json = $this->ajouter_securite_compte($nombre_essais, $duree_mot_de_passe, $double_authentification, $autoriser_sms, $autoriser_email, $user);
                }else {
                    $json = $edition;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($securite['date_debut'])))
                );
            }

        }else {
            $json = $this->ajouter_securite_compte($nombre_essais, $duree_mot_de_passe, $double_authentification, $autoriser_sms, $autoriser_email, $user);
        }
        return $json;
    }
}