<?php


class SECURITESCOMPTES extends BDD
{
    public function trouver_securite_compte()
    {
        $query = " SELECT * FROM tb_securites_compte 
        ";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetch();
    }

    public function editer_nombre_essaie_authentification($donnee)
    {
        $trouver = $this->trouver_securite_compte();
        if ($trouver) {
            $a = $this->bdd->prepare("UPDATE tb_securites_compte  SET securite_compte_nombre_essaie_authentification = ? ");
            $a->execute(array($donnee));

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
        } else {
            $a = $this->bdd->prepare("INSERT INTO tb_securites_compte(securite_compte_nombre_essaie_authentification )
        VALUES(:securite_compte_nombre_essaie_authentification ) 
        ");
            $a->execute(array(
                'securite_compte_nombre_essaie_authentification' => $donnee
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

    }

    public function editer_duree_de_vie_mot_de_passe($donnee)
    {
        $trouver = $this->trouver_securite_compte();
        if ($trouver) {
            $a = $this->bdd->prepare("UPDATE tb_securites_compte  SET securite_compte_duree_de_vie_mot_de_passe = ? ");
            $a->execute(array($donnee));

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
        } else {
            $a = $this->bdd->prepare("INSERT INTO tb_securites_compte(securite_compte_duree_de_vie_mot_de_passe )
        VALUES(:securite_compte_duree_de_vie_mot_de_passe ) 
        ");
            $a->execute(array(
                'securite_compte_duree_de_vie_mot_de_passe' => $donnee
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
    }

    public function editer_autorisation_double_authentification($donnee)
    {
        $trouver = $this->trouver_securite_compte();
        if ($trouver) {
            $a = $this->bdd->prepare("UPDATE tb_securites_compte  SET securite_compte_autorisation_double_authentification = ? ");
            $a->execute(array($donnee));

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
        } else {
            $a = $this->bdd->prepare("INSERT INTO tb_securites_compte(securite_compte_autorisation_double_authentification)
        VALUES(:securite_compte_autorisation_double_authentification) 
        ");
            $a->execute(array(
                'securite_compte_autorisation_double_authentification' => $donnee
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
    }

    public function editer_autorisation_sms($donnee)
    {
        $trouver = $this->trouver_securite_compte();
        if ($trouver) {
            $a = $this->bdd->prepare("UPDATE tb_securites_compte  SET securite_compte_autorisation_sms = ? ");
            $a->execute(array($donnee));

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
        } else {
            $a = $this->bdd->prepare("INSERT INTO tb_securites_compte(securite_compte_autorisation_sms)
        VALUES(:securite_compte_autorisation_sms) 
        ");
            $a->execute(array(
                'securite_compte_autorisation_sms' => $donnee
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
    }

    public function editer_autorisation_mail($donnee)
    {
        $trouver = $this->trouver_securite_compte();
        if ($trouver) {
            $a = $this->bdd->prepare("UPDATE tb_securites_compte  SET securite_compte_autorisation_mail = ? ");
            $a->execute(array($donnee));

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
        } else {
            $a = $this->bdd->prepare("INSERT INTO tb_securites_compte(securite_compte_autorisation_mail)
        VALUES(:securite_compte_autorisation_mail) 
        ");
            $a->execute(array(
                'securite_compte_autorisation_mail' => $donnee
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
    }


}