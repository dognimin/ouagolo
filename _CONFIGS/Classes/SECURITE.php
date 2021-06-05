<?php


class SECURITE extends BDD
{
    public function trouver_securite_mdp(){
        $a = $this->bdd->prepare("SELECT securite_mdp_longueur_minimale AS longueur_minimale, securite_mdp_exigence_caracteres_speciaux AS caracteres_speciaux, securite_mdp_exigence_majuscules AS majuscules, securite_mdp_exigence_minuscules AS miniscules, securite_mdp_exigence_chiffres AS chiffres, securite_mdp_date_debut AS date_debut, utilisateur_id_creation FROM tb_securite_mot_de_passe WHERE securite_mdp_date_fin IS NULL");
        $a->execute(array());
        return $a->fetch();
    }

    private function ajouter_securite_mdp($longueur_minimale, $caracteres_speciaux, $majuscules, $minuscules, $chiffres, $user) {
        $a = $this->bdd->prepare("INSERT INTO tb_securite_mot_de_passe(securite_mdp_longueur_minimale, securite_mdp_exigence_caracteres_speciaux, securite_mdp_exigence_majuscules, securite_mdp_exigence_minuscules, securite_mdp_exigence_chiffres, securite_mdp_date_debut, utilisateur_id_creation) 
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

    private function fermer_securite_mdp($date_fin, $user) {
        $a = $this->bdd->prepare("UPDATE tb_securite_mot_de_passe SET securite_mdp_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE securite_mdp_date_fin IS NULL");
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
}