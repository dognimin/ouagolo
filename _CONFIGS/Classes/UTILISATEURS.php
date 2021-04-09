<?php

include "BDD.php";
class UTILISATEURS extends BDD
{

    private function ajouter_mot_de_passe($id_user, $mot_de_passe, $statut, $user): array
    {
        $a = $this->bdd->prepare("INSERT INTO tb_utilisateurs_mots_de_passe(utilisateur_id, mot_de_passe, user_mot_de_passe_statut, mot_de_passe_date_debut, utilisateur_id_creation)
            VALUES(:utilisateur_id, :mot_de_passe, :user_mot_de_passe_statut, :mot_de_passe_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'mot_de_passe' => $mot_de_passe,
            'user_mot_de_passe_statut' => $statut,
            'mot_de_passe_date_debut' => date('Y-m-d',time()),
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        }else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    private function fermer_mot_de_passe($id_user, $date_fin, $user): array
    {
        $a = $this->bdd->prepare("UPDATE tb_utilisateurs_mots_de_passe SET mot_de_passe_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ?");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$id_user));
        if($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        }else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function trouver_mot_de_passe($id_user) {
        $query = "
SELECT 
       A.mot_de_passe, 
       A.user_mot_de_passe_statut AS statut, 
       A.mot_de_passe_date_debut AS date_debut 
FROM 
     tb_utilisateurs_mots_de_passe A 
WHERE 
      A.utilisateur_id = ? AND 
      A.mot_de_passe_date_fin IS NULL
";
        $a = $this->bdd->prepare($query);
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function editer_mot_de_passe($id_user, $mot_de_passe, $nouveau_mot_de_passe): array
    {
        if($mot_de_passe != $nouveau_mot_de_passe) {
            $ancien = $this->trouver_mot_de_passe($id_user);
            if($ancien) {
                if(password_verify($mot_de_passe, $ancien['mot_de_passe'])) {
                    $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                    $fermer = $this->fermer_mot_de_passe($id_user, $date_fin, $id_user);
                    if($fermer['success'] == true) {
                        $options = [
                            'cost' => 11
                        ];
                        $password = password_hash($nouveau_mot_de_passe, PASSWORD_BCRYPT, $options);
                        $reset = $this->ajouter_mot_de_passe($id_user,$password,1,$id_user);
                        if($reset['success'] == true) {
                            return array(
                                'success' => true
                            );
                        }else {
                            return $reset;
                        }
                    }else {
                        return $fermer;
                    }
                }else {
                    return array(
                        'success' => false,
                        'message' => "Le mot de passe actuel est incorrect."
                    );
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "Le numéro identifiant est incorrect."
                );
            }
        }else {
            return array(
                'success' => false,
                'message' => "Le mot de passe actuel et le nouveau mot de passe doivent être différents."
            );
        }
    }

    public function reset_mot_de_passe($id_user, $user): array
    {
        $ancien = $this->trouver_mot_de_passe($id_user);
        if($ancien) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($ancien['date_debut'])) {

                $fermer = $this->fermer_mot_de_passe($id_user, $date_fin, $user);
                if($fermer['success'] == true) {
                    $mot_de_passe = uniqid();
                    $options = [
                        'cost' => 11
                    ];
                    $password = password_hash($mot_de_passe, PASSWORD_BCRYPT, $options);
                    $reset = $this->ajouter_mot_de_passe($id_user,$password,0,$user);
                    if($reset['success'] == true) {
                        return array(
                            'success' => true,
                            'id_user' => $id_user,
                            'pass' => $mot_de_passe
                        );
                    }else {
                        return $reset;
                    }
                }else {
                    return $fermer;
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "La modification du mot de passe ne peut se faire que 48h après la dernière mise à jour. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($ancien['date_debut'])))
                );
            }
        }else {
            return array(
                'success' => false,
                'message' => "Le numéro identifiant est incorrect."
            );
        }
    }





    private function ajouter_statut($id_user, $statut, $user): array
    {
        $a = $this->bdd->prepare("INSERT INTO tb_utilisateurs_statuts(utilisateur_id, statut, statut_date_debut, utilisateur_id_creation)
            VALUES(:utilisateur_id, :statut, :statut_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'statut' => $statut,
            'statut_date_debut' => date('Y-m-d',time()),
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        }else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    private function fermer_statut($id_user, $date_fin, $user): array
    {
        $a = $this->bdd->prepare("UPDATE tb_utilisateurs_statuts SET statut_passe_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ?");
        $a->execute(array($date_fin,date('Y-m-d H:i:s',time()),$user,$id_user));
        if($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        }else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function trouver_statut($id_user) {
        $query = "
SELECT 
       A.statut AS statut, 
       A.statut_date_debut AS date_debut 
FROM 
     tb_utilisateurs_statuts A 
WHERE 
      A.utilisateur_id = ? AND 
      A.statut_passe_date_fin IS NULL
";
        $a = $this->bdd->prepare($query);
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function editer_statut($id_user, $statut, $user): array
    {
        $utilisateur_statut = $this->trouver_statut($id_user);
        if($utilisateur_statut) {
            $date_fin = date('Y-m-d',strtotime('-1 day',time()));
            if(strtotime($date_fin) > strtotime($utilisateur_statut['date_debut'])) {

                $fermer = $this->fermer_statut($id_user, $date_fin, $user);
                if($fermer['success'] == true) {
                    $reset = $this->ajouter_statut($id_user,$statut,$user);
                    if($reset['success'] == true) {
                        return array(
                            'success' => true,
                            'message' => "Statut mis à jour avec succès"
                        );
                    }else {
                        return $reset;
                    }
                }else {
                    return $fermer;
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "La modification du statut de l'utilisateur ne peut se faire que 48h après la dernière mise à jour. Veuillez réessayer le ".date('d/m/Y',strtotime('+2 day',strtotime($utilisateur_statut['date_debut'])))
                );
            }
        }else {
            return array(
                'success' => false,
                'message' => "Le numéro identifiant est incorrect."
            );
        }
    }





    public function connexion($email, $mot_de_passe): array
    {
        $utilisateur = $this->trouver(null,null,$email);
        if($utilisateur) {
            $utilisateur_mdp = $this->trouver_mot_de_passe($utilisateur['id_user']);
            if($utilisateur_mdp) {
                if(password_verify($mot_de_passe, $utilisateur_mdp['mot_de_passe'])) {
                    $utilisateur_statut = $this->trouver_statut($utilisateur['id_user']);
                    if($utilisateur_statut) {
                        if($utilisateur_statut['statut'] == 1) {
                            return array(
                                'success' => true,
                                'id_user' => $utilisateur['id_user']
                            );
                        }else {
                            return array(
                                'success' => false,
                                'message' => "Votre compte utilisateur est désactivé. Veuillez SVP contacter l'administrateur."
                            );
                        }
                    }else {
                        return array(
                            'success' => false,
                            'message' => "Une erreur est survenue lors de la vérification du statut de l'utilisateur. Veuillez SVP contacter l'administrateur."
                        );
                    }
                }else {
                    return array(
                        'success' => false,
                        'message' => "Email et/ou mot de passe incorrect."
                    );
                }
            }else {
                return array(
                    'success' => false,
                    'message' => "Email et/ou mot de passe incorrect."
                );
            }
        }else {
            return array(
                'success' => false,
                'message' => "Email et/ou mot de passe incorrect."
            );
        }
    }

    public function lister(): array
    {
        $query = "
SELECT 
       A.utilisateur_id AS id_user, 
       A.utilisateur_email AS email, 
       A.utilisateur_num_secu AS num_secu, 
       A.utilisateur_num_matricule AS num_matricule, 
       A.utilisateur_pseudo AS pseudo, 
       A.civilite_code AS code, 
       A.utilisateur_prenoms AS prenoms, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_nom_patronymique AS nom_patronymique, 
       A.utilisateur_date_naissance AS date_naissance, 
       A.profil_utilisateur_code AS code_profil_utilisateur, 
       A.sexe_code AS code_sexe, 
       A.situation_familiale_code AS code_situation_familiale, 
       A.categorie_socio_professionnelle_code AS code_csp, 
       A.profession_code AS code_profession, 
       A.secteur_activite_code AS code_secteur_activite, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_utilisateurs A
ORDER BY A.utilisateur_prenoms, A.utilisateur_nom
";
        $a = $this->bdd->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function trouver($id_user, $pseudo, $email) {
        $query = "
SELECT 
       A.utilisateur_id AS id_user, 
       A.utilisateur_email AS email, 
       A.utilisateur_num_secu AS num_secu, 
       A.utilisateur_num_matricule AS num_matricule, 
       A.utilisateur_pseudo AS pseudo, 
       A.civilite_code AS code, 
       A.utilisateur_prenoms AS prenoms, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_nom_patronymique AS nom_patronymique, 
       A.utilisateur_date_naissance AS date_naissance, 
       A.profil_utilisateur_code AS code_profil_utilisateur, 
       A.sexe_code AS code_sexe, 
       A.situation_familiale_code AS code_situation_familiale, 
       A.categorie_socio_professionnelle_code AS code_csp, 
       A.profession_code AS code_profession, 
       A.secteur_activite_code AS code_secteur_activite, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_utilisateurs A
WHERE 
      A.utilisateur_id LIKE ? AND 
      A.utilisateur_pseudo LIKE ? AND 
      A.utilisateur_email LIKE ?
";
        $a = $this->bdd->prepare($query);
        $a->execute(array('%'.$id_user.'%', '%'.$pseudo.'%', '%'.$email.'%'));
        return $a->fetch();
    }

    private function ajouter($code_type_utilisateur, $num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $code_situation_familiale, $code_csp, $code_profession, $code_secteur_activite, $user): array
    {

        $id_user = substr(str_replace('.','',str_replace(':','',uniqid(CLIENT_ADRESSE_IP.date('YmdHis',time()),true))),0,45);

        $a = $this->bdd->prepare("INSERT INTO tb_utilisateurs(utilisateur_id, utilisateur_email, utilisateur_num_secu, utilisateur_num_matricule, utilisateur_pseudo, civilite_code, utilisateur_prenoms, utilisateur_nom, utilisateur_nom_patronymique, utilisateur_date_naissance, type_utilisateur_code, sexe_code, situation_familiale_code, categorie_socio_professionnelle_code, profession_code, secteur_activite_code, utilisateur_id_creation)
        VALUES(:utilisateur_id, :utilisateur_email, :utilisateur_num_secu, :utilisateur_num_matricule, :utilisateur_pseudo, :civilite_code, :utilisateur_prenoms, :utilisateur_nom, :utilisateur_nom_patronymique, :utilisateur_date_naissance, :type_utilisateur_code, :sexe_code, :situation_familiale_code, :categorie_socio_professionnelle_code, :profession_code, :secteur_activite_code, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'utilisateur_email' => $email,
            'utilisateur_num_secu' => $num_secu,
            'utilisateur_num_matricule' => $num_matricule,
            'utilisateur_pseudo' => $pseudo,
            'civilite_code' => $code_civilite,
            'utilisateur_prenoms' => $prenoms,
            'utilisateur_nom' => $nom,
            'utilisateur_nom_patronymique' => $nom_patronymique,
            'utilisateur_date_naissance' => $date_naissance,
            'type_utilisateur_code' => $code_type_utilisateur,
            'sexe_code' => $code_sexe,
            'situation_familiale_code' => $code_situation_familiale,
            'categorie_socio_professionnelle_code' => $code_csp,
            'profession_code' => $code_profession,
            'secteur_activite_code' => $code_secteur_activite,
            'utilisateur_id_creation' => $user
        ));
        if($a->errorCode() == "00000") {
            $edition_statut = $this->ajouter_statut($id_user,1,$user);
            if($edition_statut['success'] == true) {
                $mot_de_passe = uniqid();
                $options = [
                    'cost' => 11
                ];
                $password = password_hash($mot_de_passe, PASSWORD_BCRYPT, $options);
                $pass = $this->ajouter_mot_de_passe($id_user, $password,0, $user);
                if($pass['success'] == true) {
                    return array(
                        'success' => true,
                        'id_user' => $id_user,
                        'pass' => $mot_de_passe
                    );
                }else {
                    return $pass;
                }
            }else {
                return $edition_statut;
            }
        }else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    private function modifier($id_user, $num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $sexe, $user): array
    {
        $a = $this->bdd->prepare("UPDATE tb_utilisateurs SET utilisateur_num_secu = ?, utilisateur_num_matricule = ?, utilisateur_pseudo = ?, utilisateur_email = ?, civilite_code = ?, utilisateur_nom = ?, utilisateur_nom_patronymique = ?, utilisateur_prenoms = ?, utilisateur_date_naissance = ?, sexe_code = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ?");
        $a->execute(array($num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $sexe, date('Y-m-d H:i:s',time()), $user, $id_user));
        if($a->errorCode() == "00000") {
            return array(
                'success' => true,
                'id_user' => $id_user
            );
        }else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function editer($id_user, $code_type_utilisateur, $num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $code_situation_familiale, $code_csp, $code_profession, $code_secteur_activite, $user): array
    {
        $message_erreur = array(
            'erreur_id_user' => "Le numéro identifiant est incorrect.",
            'erreur_email' => "L'adresse Email renseignée a déjà été utilisée par un autre utilisateur.",
            'erreur_pseudo' => "Le nom d'utilisateur renseigné a déjà été utilisé par un autre utilisateur."
        );
        $json = NULL;
        if($id_user) {
            $user = $this->trouver($id_user,NULL,NULL);
            if($user) {
                $trouver_email = $this->trouver(NULL,NULL,$email);
                if(!$trouver_email) {
                    $trouver_pseudo = $this->trouver(NULL,$pseudo,NULL);
                    if(!$trouver_pseudo){
                        $json = $this->modifier($id_user, $num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $user);
                    }else {
                        if($user['pseudo'] == $trouver_pseudo['pseudo']) {
                            $json = $this->modifier($id_user, $num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $user);
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => $message_erreur['erreur_pseudo']
                            );
                        }
                    }
                }else {
                    if($user['email'] == $trouver_email['email']) {
                        $trouver_pseudo = $this->trouver(NULL,$pseudo,NULL);
                        if(!$trouver_pseudo){
                            $json = $this->modifier($id_user, $num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $user);
                        }else {
                            if($user['pseudo'] == $trouver_pseudo['pseudo']) {
                                $json = $this->modifier($id_user, $num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $user);
                            }else {
                                $json = array(
                                    'success' => false,
                                    'message' => $message_erreur['erreur_pseudo']
                                );
                            }
                        }
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => $message_erreur['erreur_pseudo']
                        );
                    }
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => $message_erreur['erreur_id_user']
                );
            }
        }
        else {
            $trouver_email = $this->trouver(NULL,NULL,$email);
            if(!$trouver_email) {
                $trouver_pseudo = $this->trouver(NULL,$pseudo,NULL);
                if(!$trouver_pseudo) {
                    $json = $this->ajouter($code_type_utilisateur, $num_secu, $num_matricule, $pseudo, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $code_situation_familiale, $code_csp, $code_profession, $code_secteur_activite, $user);
                }else {
                    $json = array(
                        'success' => false,
                        'message' => $message_erreur['erreur_pseudo']
                    );
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => $message_erreur['erreur_email']
                );
            }
        }
        return $json;
    }

    public function editer_piste_audit($client_adresse_ip, $url, $action, $details, $user): array
    {
        $a = $this->bdd->prepare("INSERT INTO tb_log_historique_piste_audit(piste_audit_adresse_ip, piste_audit_url, piste_audit_action, piste_audit_details, utilisateur_id)
        VALUES(:piste_audit_adresse_ip, :piste_audit_url, :piste_audit_action, :piste_audit_details, :utilisateur_id)");
        $a->execute(array(
            'piste_audit_adresse_ip' => $client_adresse_ip,
            'piste_audit_url' => $url,
            'piste_audit_action' => $action,
            'piste_audit_details' => $details,
            'utilisateur_id' => $user
        ));
        if($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        }else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function editer_connexion($id_user, $adresse_ip): array
    {
        $a = $this->bdd->prepare("INSERT INTO tb_log_historique_connexions(utilisateur_id, connexion_adresse_ip) VALUES(:utilisateur_id, :connexion_adresse_ip)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'connexion_adresse_ip' => $adresse_ip
        ));
        if($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        }else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }
}