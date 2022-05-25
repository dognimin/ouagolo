<?php

namespace App;

class UTILISATEURS extends BDD
{
    public function editer_piste_audit($code_session, $url, $action, $details): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_log_piste_audit(session_code, piste_audit_url, piste_audit_action, piste_audit_details)
        VALUES(:session_code, :piste_audit_url, :piste_audit_action, :piste_audit_details)");
        $a->execute(array(
            'session_code' => $code_session,
            'piste_audit_url' => $url,
            'piste_audit_action' => $action,
            'piste_audit_details' => $details
        ));
        if ($a->errorCode() == "00000") {
            $b = $this->getBdd()->prepare("UPDATE tb_utilisateurs_sessions SET session_date_derniere_edition = ? WHERE session_code = ?");
            $b->execute(array(date('Y-m-d H:i:s',time()),$code_session));
            if($b->errorCode() == "00000") {
                return array(
                    'success' => true,
                    'message' => 'Mise à jour effectuée avec succès'
                );
            }else {
                return array(
                    'success' => false,
                    'erreur_message' => $b->errorInfo()
                );
            }
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function editer_session($id_user, $code_session, $adresse_ip, $systeme_exploitation, $navigateur, $version, $user_agent, $pattern): array
    {
        if (!$code_session) {
            return $this->ajouter_session($id_user, $adresse_ip, $systeme_exploitation, $navigateur, $version, $user_agent, $pattern);
        } else {
            return $this->fermer_session($code_session);
        }
    }

    private function ajouter_session($id_user, $adresse_ip, $systeme_exploitation, $navigateur, $version, $user_agent, $pattern): array
    {
        $code_session = uniqid(uniqid(sha1(date('YmdHis', time())), true), true);
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_sessions(utilisateur_id, session_code, session_adresse_ip, session_se, session_navigateur, session_navigateur_version, session_user_agent, session_pattern) 
        VALUES(:utilisateur_id, :session_code, :session_adresse_ip, :session_se, :session_navigateur, :session_navigateur_version, :session_user_agent, :session_pattern)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'session_code' => $code_session,
            'session_adresse_ip' => $adresse_ip,
            'session_se' => $systeme_exploitation,
            'session_navigateur' => $navigateur,
            'session_navigateur_version' => $version,
            'session_user_agent' => $user_agent,
            'session_pattern' => $pattern,
        ));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true,
                'code_session' => $code_session
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    private function fermer_session($code_session): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_sessions SET session_date_fin = ? WHERE session_code = ? AND session_date_fin IS NULL");
        $a->execute(array(date('Y-m-d H:i:s', time()), $code_session));
        if ($a->errorCode() == '00000') {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'code' => $a->errorCode(),
                'message' => $a->errorInfo()[2]
            );
        }
    }

    private function trouver_securite_compte() {
        $a = $this->getBdd()->prepare("
SELECT 
       securite_compte_nombre_essais_authentification AS nombre_essais, 
       securite_compte_duree_de_vie_mot_de_passe AS duree_mot_de_passe, 
       securite_compte_autorisation_double_authentification AS double_authentification, 
       securite_compte_autorisation_sms AS autoriser_sms, 
       securite_compte_autorisation_mail AS autoriser_email
FROM 
     tb_securite_compte WHERE securite_compte_date_fin IS NULL");
        $a->execute(array());
        return $a->fetch();
    }

    public function validite_mot_de_passe($id_user) {
        $password = $this->trouver_mot_de_passe($id_user);
        if($password) {
            $securite = $this->trouver_securite_compte();
            if($securite) {
                $validite = $securite['duree_mot_de_passe'];
                $duree = round((int)(strtotime(date('Y-m-d', time())) - strtotime($password['date_debut'])) / (60 * 60 * 24));
                $etat = (int)($validite - $duree);
                return array(
                    'success' => false,
                    'etat' => $etat
                );
            } else {
                return $securite;
            }
        }else {
            return $password;
        }
    }

    public function connexion($email, $mot_de_passe): array
    {
        $utilisateur = $this->trouver(null, $email);
        if ($utilisateur) {
            $echec = $this->trouver_mot_de_passe_echecs($utilisateur['id_user']);
            if(!$echec) {
                $ajouter_echec = $this->ajouter_mot_de_passe_echecs($utilisateur['id_user']);
                if($ajouter_echec['success'] === true) {
                    $nb_echecs = 1;
                }else {
                    $nb_echecs = 0;
                }
            }else {
                $nb_echecs = (int)($echec['echecs'] + 1);
            }
            if($nb_echecs !== 0) {
                $securite = $this->trouver_securite_compte();
                $utilisateur_mdp = $this->trouver_mot_de_passe($utilisateur['id_user']);
                if ($utilisateur_mdp) {
                    if (password_verify($mot_de_passe, $utilisateur_mdp['mot_de_passe'])) {
                        $reset_echec = $this->editer_mot_de_passe_echecs($utilisateur['id_user'], 0);
                        if($reset_echec['success'] === true) {
                            $utilisateur_statut = $this->trouver_statut($utilisateur['id_user']);
                            if ($utilisateur_statut) {
                                if ((int)$utilisateur_statut['statut'] === 1) {
                                    $utilisateur_profil = $this->trouver_profil($utilisateur['id_user']);
                                    if ($utilisateur_profil) {
                                        if($securite) {
                                            $validite = $this->validite_mot_de_passe($utilisateur['id_user']);
                                            if($validite) {
                                                if($validite['etat'] <= 0) {
                                                    $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_mots_de_passe SET user_mot_de_passe_statut = ? WHERE utilisateur_id = ? AND mot_de_passe_date_fin IS NULL");
                                                    $a->execute(array(0, $utilisateur['id_user']));
                                                }
                                                $json = array(
                                                    'success' => true,
                                                    'id_user' => $utilisateur['id_user'],
                                                    'user_type' => $utilisateur_profil['code_profil'],
                                                    'message' => "Connexion effectuée avec succès."
                                                );
                                            }else {
                                                $json = $validite;
                                            }
                                        }else {
                                            $json = array(
                                                'success' => true,
                                                'id_user' => $utilisateur['id_user'],
                                                'user_type' => $utilisateur_profil['code_profil'],
                                                'message' => "Connexion effectuée avec succès."
                                            );
                                        }
                                    } else {
                                        $json = array(
                                            'success' => false,
                                            'message' => "Aucun profil utilisateur n'a été défini pour votre compte. Veuillez SVP contacter l'administrateur."
                                        );
                                    }
                                } elseif((int)$utilisateur_statut['statut'] === 2) {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Trop d'échecs; Votre compte utilisateur a été vérouillé. Veuillez SVP contacter l'administrateur."
                                    );
                                }else {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Votre compte utilisateur est désactivé. Veuillez SVP contacter l'administrateur."
                                    );
                                }
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Une erreur est survenue lors de la vérification du statut de l'utilisateur. Veuillez SVP contacter l'administrateur."
                                );
                            }
                        }else {
                            $json = $reset_echec;
                        }
                    } else {
                        if($securite) {
                            $maj_echec = $this->editer_mot_de_passe_echecs($utilisateur['id_user'], $nb_echecs);
                            if($maj_echec['success'] === true) {
                                $essais_restants = ($securite['nombre_essais'] - $nb_echecs);
                                if($essais_restants > 0) {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Email et/ou mot de passe incorrect. Il vous reste {$essais_restants} essai.s"
                                    );
                                }else {
                                    $verouiller = $this->editer_statut($utilisateur['id_user'], 2, $utilisateur['id_user']);
                                    if($verouiller['success'] === true) {
                                        $reset_echec = $this->editer_mot_de_passe_echecs($utilisateur['id_user'], 0);
                                        if($reset_echec['success'] === true) {
                                            $json = array(
                                                'success' => false,
                                                'message' => "Trop d'échecs; Votre compte utilisateur a été vérouillé. Veuillez SVP contacter l'administrateur."
                                            );
                                        }else {
                                            $json = $reset_echec;
                                        }
                                    }else {
                                        $json = $verouiller;
                                    }
                                }
                            }else {
                                $json = $maj_echec;
                            }
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "Email et/ou mot de passe incorrect."
                            );
                        }
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun mot de passe n'a été enregistré pour cet utilisateur. Veuillez contacter votre administrateur."
                    );
                }
            }else {

            }
        } else {
            $json = array(
                'success' => false,
                'message' => "Email et/ou mot de passe incorrect."
            );
        }
        return $json;
    }

    public function trouver($id_user, $email)
    {
        if ($id_user || $email) {
            $query = "
SELECT 
       A.utilisateur_id AS id_user, 
       B.profil_utilisateur_code AS code_profil, 
       A.utilisateur_nip AS nip, 
       A.utilisateur_email AS email, 
       A.utilisateur_num_secu AS num_secu, 
       A.civilite_code AS code_civilite, 
       A.utilisateur_prenoms AS prenoms, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_nom_patronymique AS nom_patronymique, 
       A.utilisateur_date_naissance AS date_naissance, 
       A.utilisateur_photo AS photo, 
       A.sexe_code AS code_sexe, 
       A.situation_familiale_code AS code_situation_familiale,
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_utilisateurs A 
         JOIN tb_utilisateurs_profils B 
             ON A.utilisateur_id = B.utilisateur_id
                    AND B.utilisateur_profil_date_fin IS NULL 
                    AND A.utilisateur_id LIKE ? 
                    AND A.utilisateur_email LIKE ? 
";
            $a = $this->getBdd()->prepare($query);
            $a->execute(array('%' . $id_user . '%', '%' . $email . '%'));
            return $a->fetch();
        } else {
            return null;
        }
    }

    public function trouver_mot_de_passe($id_user)
    {
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
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function trouver_statut($id_user)
    {
        $query = "
SELECT 
       A.utilisateur_id AS id_user, 
       A.statut AS statut, 
       A.statut_date_debut AS date_debut 
FROM 
     tb_utilisateurs_statuts A 
WHERE 
      A.utilisateur_id = ? AND 
      A.statut_passe_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function trouver_profil($id_user)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.utilisateur_id AS id_user, 
       A.profil_utilisateur_code AS code_profil, 
       B.profil_utilisateur_libelle AS libelle, 
       A.utilisateur_profil_debut AS date_debut 
FROM 
     tb_utilisateurs_profils A JOIN tb_ref_profils_utilisateurs B 
         ON A.profil_utilisateur_code = B.profil_utilisateur_code 
                AND A.utilisateur_id = ? 
                AND A.utilisateur_profil_date_fin IS NULL 
                AND B.profil_utilisateur_date_fin IS NULL");
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function trouver_session($code_session)
    {
        $query = "
SELECT 
       A.utilisateur_id AS id_user, 
       A.session_code AS code_session, 
       A.session_adresse_ip AS adresse_ip, 
       A.session_se AS systeme_exploitation, 
       A.session_navigateur AS navigatreur,
       A.session_date_debut AS date_debut,
       A.session_date_derniere_edition AS date_derniere_edition
FROM 
     tb_utilisateurs_sessions A 
WHERE 
      A.session_code = ? AND 
      A.session_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code_session));
        return $a->fetch();
    }

    public function trouver_utilisateur_ets($id_user)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.utilisateur_id AS id_user, 
       B.etablissement_code AS code_etablissement, 
       B.raison_sociale AS raison_sociale, 
       A.utilisateur_etablissement_date_debut AS date_debut 
FROM 
     tb_utilisateurs_etablissements A 
         JOIN tb_etablissements B 
             ON A.etablissement_code = B.etablissement_code 
                    AND A.utilisateur_id = ? 
                    AND A.utilisateur_etablissement_date_fin IS NULL");
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function trouver_utilisateur_organisme($id_user)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.utilisateur_id AS id_user, 
       A.organisme_code AS code_organisme, 
       B.organisme_libelle AS libelle, 
       A.utilisateur_organisme_date_debut AS date_debut 
FROM 
     tb_utilisateurs_organismes A 
         JOIN tb_organismes B 
             ON A.organisme_code = B.organisme_code 
                    AND A.utilisateur_id = ? 
                    AND A.utilisateur_organisme_date_fin IS NULL");
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function editer_mot_de_passe($id_user, $mot_de_passe, $nouveau_mot_de_passe): array
    {
        if ($mot_de_passe != $nouveau_mot_de_passe) {
            $ancien = $this->trouver_mot_de_passe($id_user);
            if ($ancien) {
                if (password_verify($mot_de_passe, $ancien['mot_de_passe'])) {
                    $date_fin = date('Y-m-d H:i:s', time());
                    $fermer = $this->fermer_mot_de_passe($id_user, $date_fin, $id_user);
                    if ($fermer['success'] == true) {
                        $options = ['cost' => 11];
                        $password = password_hash($nouveau_mot_de_passe, PASSWORD_BCRYPT, $options);
                        $reset = $this->ajouter_mot_de_passe($id_user, $password, 1, $id_user);
                        if ($reset['success'] == true) {
                            return array(
                                'success' => true
                            );
                        } else {
                            return $reset;
                        }
                    } else {
                        return $fermer;
                    }
                } else {
                    return array(
                        'success' => false,
                        'message' => "Le mot de passe actuel est incorrect."
                    );
                }
            } else {
                return array(
                    'success' => false,
                    'message' => "Le numéro identifiant est incorrect."
                );
            }
        } else {
            return array(
                'success' => false,
                'message' => "Le mot de passe actuel et le nouveau mot de passe doivent être différents."
            );
        }
    }

    private function fermer_mot_de_passe($id_user, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_mots_de_passe SET mot_de_passe_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ?");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $id_user));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    private function ajouter_mot_de_passe($id_user, $mot_de_passe, $statut, $user): array
    {
        $utilisateur = $this->trouver_simple($id_user, null);
        if($utilisateur) {
            $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_mots_de_passe(utilisateur_id, mot_de_passe, user_mot_de_passe_statut, mot_de_passe_date_debut, utilisateur_id_creation)
            VALUES(:utilisateur_id, :mot_de_passe, :user_mot_de_passe_statut, :mot_de_passe_date_debut, :utilisateur_id_creation)");
            $a->execute(array(
                'utilisateur_id' => $id_user,
                'mot_de_passe' => $mot_de_passe,
                'user_mot_de_passe_statut' => $statut,
                'mot_de_passe_date_debut' => date('Y-m-d H:i:s', time()),
                'utilisateur_id_creation' => $user
            ));
            if ($a->errorCode() == "00000") {
                return array(
                    'success' => true
                );
            } else {
                return array(
                    'success' => false,
                    'erreur_message' => $a->errorInfo()
                );
            }
        }
        else {
            return array(
                'success' => false,
                'message' => "Utilisateur inconnu pour éditer le mot de passe"
            );
        }
    }

    public function trouver_simple($id_user, $email)
    {
        $query = "
SELECT 
       A.utilisateur_id AS id_user, 
       A.utilisateur_nip AS nip, 
       A.utilisateur_email AS email, 
       A.utilisateur_num_secu AS num_secu, 
       A.civilite_code AS code_civilite, 
       A.utilisateur_prenoms AS prenoms, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_nom_patronymique AS nom_patronymique, 
       A.utilisateur_date_naissance AS date_naissance, 
       A.utilisateur_photo AS photo, 
       A.sexe_code AS code_sexe, 
       A.situation_familiale_code AS code_situation_familiale,
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_utilisateurs A 
WHERE 
      A.utilisateur_id LIKE ? 
  AND A.utilisateur_email LIKE ?";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $id_user . '%','%' . $email . '%'));
        return $a->fetch();
    }

    public function editer_api_logs($id, $client_adresse_ip, $serveur_adresse_ip, $donnees)
    {
        if ($id) {
            $a = $this->getBdd()->prepare("UPDATE tb_log_historique_apis SET api_donnees_sorties = ?, date_edit = ? WHERE api_id = ?");
            $a->execute(array($donnees, date('Y-m-d H:i:s', time()), $id));
            if ($a->errorCode() == "00000") {
                return array(
                    'success' => true,
                    'id_log' => $id
                );
            } else {
                return array(
                    'success' => false,
                    'erreur_message' => $a->errorInfo()
                );
            }
        } else {
            $a = $this->getBdd()->prepare("INSERT INTO tb_log_historique_apis(api_client_adresse_ip, api_serveur_adresse_ip, api_donnees_entrees) 
            VALUES(:api_client_adresse_ip, :api_serveur_adresse_ip, :api_donnees_entrees)");
            $a->execute(array(
                'api_client_adresse_ip' => $client_adresse_ip,
                'api_serveur_adresse_ip' => $serveur_adresse_ip,
                'api_donnees_entrees' => $donnees
            ));
            if ($a->errorCode() == "00000") {
                return array(
                    'success' => true,
                    'id_log' => $this->getBdd()->lastInsertId()
                );
            } else {
                return array(
                    'success' => false,
                    'erreur_message' => $a->errorInfo()
                );
            }
        }
    }

    public function reset_mot_de_passe($id_user, $user): array
    {
        $ancien = $this->trouver_mot_de_passe($id_user);
        if ($ancien) {
            $date_fin = date('Y-m-d H:i:s', time());
            $fermer = $this->fermer_mot_de_passe($id_user, $date_fin, $user);
            if ($fermer['success'] == true) {
                $mot_de_passe = uniqid();
                $options = [
                    'cost' => 11
                ];
                $password = password_hash($mot_de_passe, PASSWORD_BCRYPT, $options);
                $reset = $this->ajouter_mot_de_passe($id_user, $password, 0, $user);
                if ($reset['success'] == true) {
                    return array(
                        'success' => true,
                        'id_user' => $id_user,
                        'pass' => $mot_de_passe,
                        'message' => '<p class="align_center">Mise à jour effectuee avec succes.<br /> Nouveau mot de passe : <b>  ' . $mot_de_passe . '</b></p>'
                    );
                } else {
                    return $reset;
                }
            } else {
                return $fermer;
            }
        } else {
            return array(
                'success' => false,
                'message' => "Le numéro identifiant est incorrect."
            );
        }
    }

    private function trouver_mot_de_passe_echecs($id_user) {
        $a = $this->getBdd()->prepare("SELECT nombre_echecs AS echecs FROM tb_utilisateurs_mots_de_passe_echecs WHERE utilisateur_id = ?");
        $a->execute(array($id_user));
        return $a->fetch();
    }

    private function ajouter_mot_de_passe_echecs($id_user) {
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_mots_de_passe_echecs(utilisateur_id) VALUES(:utilisateur_id)");
        $a->execute(array(
            'utilisateur_id' => $id_user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true,
                'message' => "Enregistrement effectué avec succès"
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()[2]
            );
        }
    }

    private function editer_mot_de_passe_echecs($id_user, $nb_echecs) {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_mots_de_passe_echecs SET nombre_echecs = ?, date_edition = ? WHERE utilisateur_id = ?");
        $a->execute(array($nb_echecs, date('Y-m-d H:i:s', time()), $id_user));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true,
                'message' => "Enregistrement effectué avec succès"
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()[2]
            );
        }
    }

    public function trouver_etablissement($id_user)
    {
        $query = "
SELECT 
       A.utilisateur_id AS id_user,
       A.etablissement_code AS code_etablissement,
       B.raison_sociale AS raison_sociale,
       A.utilisateur_etablissement_date_debut AS date_debut
FROM
     tb_utilisateurs_etablissements A 
         JOIN tb_etablissements B
             ON A.etablissement_code = B.etablissement_code 
                    AND A.utilisateur_id LIKE ?  
                    AND A.utilisateur_etablissement_date_fin IS NULL 
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($id_user));
        return $a->fetch();
    }

    public function monteur_recherche($code_profil, $email, $num_secu, $nom_prenoms): array
    {
        $query = "
SELECT 
       A.utilisateur_id AS id_user, 
       C.profil_utilisateur_code AS code_profil, 
       D.profil_utilisateur_libelle AS libelle_profil, 
       A.utilisateur_email AS email, 
       A.utilisateur_num_secu AS num_secu, 
       A.civilite_code AS code, 
       A.utilisateur_prenoms AS prenoms, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_nom_patronymique AS nom_patronymique, 
       A.utilisateur_date_naissance AS date_naissance, 
       A.sexe_code AS code_sexe, 
       A.situation_familiale_code AS code_situation_familiale, 
       B.statut AS statut,       
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_utilisateurs A 
         JOIN tb_utilisateurs_statuts B 
             ON A.utilisateur_id = B.utilisateur_id 
         JOIN tb_utilisateurs_profils C 
             ON A.utilisateur_id = C.utilisateur_id 
         JOIN tb_ref_profils_utilisateurs D 
             ON C.profil_utilisateur_code = D.profil_utilisateur_code
                    AND B.statut_passe_date_fin IS NULL
                    AND C.utilisateur_profil_date_fin IS NULL
                    AND D.profil_utilisateur_date_fin IS NULL
                    AND A.utilisateur_email LIKE ? 
                    AND A.utilisateur_num_secu LIKE ? 
                    AND C.profil_utilisateur_code LIKE ?
                    AND CONCAT(A.utilisateur_nom,' ',A.utilisateur_prenoms) LIKE ?
ORDER BY A.utilisateur_prenoms, A.utilisateur_nom
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $email . '%', '%' . $num_secu . '%', '%' . $code_profil . '%', '%' . $nom_prenoms . '%'));
        return $a->fetchAll();
    }

    public function editer($id_user, $code_profil, $num_secu, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $code_situation_familiale, $user): array
    {
        $message_erreur = array(
            'erreur_id_user' => "Le numéro identifiant est incorrect.",
            'erreur_email' => "L'adresse Email renseignée a déjà été utilisée par un autre utilisateur.",
            'erreur_pseudo' => "Le nom d'utilisateur renseigné a déjà été utilisé par un autre utilisateur."
        );

        if ($id_user) {
            $utilisateur = $this->trouver_simple($id_user, NULL);
            if ($utilisateur) {
                $trouver_email = $this->trouver_simple(NULL, $email);
                if (!$trouver_email) {
                    $json = $this->modifier($id_user, $num_secu, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $user);
                } else {
                    if ($utilisateur['email'] == $trouver_email['email']) {
                        $json = $this->modifier($id_user, $num_secu, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $user);
                    } else {
                        $json = array(
                            'success' => false,
                            'message' => $message_erreur['erreur_email']
                        );
                    }
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => $message_erreur['erreur_id_user']
                );
            }
        }
        else {
            $trouver_email = $this->trouver_simple(NULL, $email);
            if (!$trouver_email) {
                $json = $this->ajouter($code_profil, $num_secu, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $code_situation_familiale, $user);
            } else {
                $json = array(
                    'success' => false,
                    'message' => $message_erreur['erreur_email']
                );
            }
        }
        return $json;
    }

    private function modifier($id_user, $num_secu, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $sexe, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs SET utilisateur_num_secu = ?, utilisateur_email = ?, civilite_code = ?, utilisateur_nom = ?, utilisateur_nom_patronymique = ?, utilisateur_prenoms = ?, utilisateur_date_naissance = ?, sexe_code = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ?");
        $a->execute(array($num_secu, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $sexe, date('Y-m-d H:i:s', time()), $user, $id_user));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true,
                'type' => 'edit',
                'id_user' => $id_user,
                'message' => "Modification effectuée avec succès"
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()[2]
            );
        }
    }

    private function ajouter($code_profil, $num_secu, $email, $code_civilite, $nom, $nom_patronymique, $prenoms, $date_naissance, $code_sexe, $code_situation_familiale, $user): array
    {
        $id_user = substr(str_replace('.', '', str_replace(':', '', uniqid(CLIENT_ADRESSE_IP . date('YmdHis', time()), true))), 0, 45);

        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs(utilisateur_id, utilisateur_email, utilisateur_num_secu, civilite_code, utilisateur_prenoms, utilisateur_nom, utilisateur_nom_patronymique, utilisateur_date_naissance, sexe_code, situation_familiale_code, utilisateur_id_creation)
        VALUES(:utilisateur_id, :utilisateur_email, :utilisateur_num_secu, :civilite_code, :utilisateur_prenoms, :utilisateur_nom, :utilisateur_nom_patronymique, :utilisateur_date_naissance, :sexe_code, :situation_familiale_code, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'utilisateur_email' => $email,
            'utilisateur_num_secu' => $num_secu,
            'civilite_code' => $code_civilite,
            'utilisateur_prenoms' => $prenoms,
            'utilisateur_nom' => $nom,
            'utilisateur_nom_patronymique' => $nom_patronymique,
            'utilisateur_date_naissance' => $date_naissance,
            'sexe_code' => $code_sexe,
            'situation_familiale_code' => $code_situation_familiale,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            $edition_statut = $this->ajouter_statut($id_user, 1, $user);
            if ($edition_statut['success'] == true) {
                $mot_de_passe = uniqid('', true);
                $options = [
                    'cost' => 11
                ];
                $password = password_hash($mot_de_passe, PASSWORD_BCRYPT, $options);
                $pass = $this->ajouter_mot_de_passe($id_user, $password, 0, $user);
                if ($pass['success'] == true) {
                    $profil = $this->editer_profil($id_user, $code_profil, $user);
                    if ($profil['success'] == true) {
                        $json = array(
                            'success' => true,
                            'id_user' => $id_user,
                            'pass' => $mot_de_passe
                        );
                    } else {
                        $json = $profil;
                    }
                } else {
                    $json = $pass;
                }
            } else {
                $json = $edition_statut;
            }
        } else {
            $json = array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
        return $json;
    }

    private function ajouter_statut($id_user, $statut, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_statuts(utilisateur_id, statut, statut_date_debut, utilisateur_id_creation)
            VALUES(:utilisateur_id, :statut, :statut_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'statut' => $statut,
            'statut_date_debut' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function editer_profil($id_user, $code_profil, $user): array
    {
        $utilisateur = $this->trouver_simple($id_user, null);
        if ($utilisateur) {
            $profil = $this->trouver_profil($utilisateur['id_user']);
            if ($profil) {
                $date_fin = date('Y-m-d H:i:s', time());
                $fermer = $this->fermer_profil($utilisateur['id_user'], $date_fin, $user);
                if ($fermer['success'] == true) {
                    return $this->ajouter_profil($utilisateur['id_user'], $code_profil, $user);
                }else {
                    return $fermer;
                }
            } else {
                return $this->ajouter_profil($utilisateur['id_user'], $code_profil, $user);
            }
        } else {
            return array(
                'success' => false,
                'message' => "Utilisateur inconnu pour éditer le profil"
            );
        }
    }

    private function fermer_profil($id_user, $date_fin, $user): array
    {
        $profil = $this->trouver_profil($id_user);
        if ($profil) {
            $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_profils SET utilisateur_profil_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ? AND utilisateur_profil_date_fin IS NULL");
            $a->execute(array($date_fin, $date_fin, $user, $id_user));
            if ($a->errorCode() == "00000") {
                return array(
                    'success' => true
                );
            } else {
                return array(
                    'success' => false,
                    'erreur_message' => $a->errorInfo()[2]
                );
            }
        } else {
            return array(
                'success' => false,
                'message' => "Utilisateur inconnu"
            );
        }
    }

    private function ajouter_profil($id_user, $code_profil, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_profils(utilisateur_id, profil_utilisateur_code, utilisateur_id_creation)
            VALUES(:utilisateur_id, :profil_utilisateur_code, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'profil_utilisateur_code' => $code_profil,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function editer_statut($id_user, $statut, $user): array
    {
        $utilisateur_statut = $this->trouver_statut($id_user);
        if ($utilisateur_statut) {
            $date_fin = date('Y-m-d H:i:s', time());
            $fermer = $this->fermer_statut($id_user, $date_fin, $user);
            if ($fermer['success'] == true) {
                $reset = $this->ajouter_statut($id_user, $statut, $user);
                if ($reset['success'] == true) {
                    return array(
                        'success' => true,
                        'message' => "Statut mis à jour avec succès"
                    );
                } else {
                    return $reset;
                }
            } else {
                return $fermer;
            }
        } else {
            return array(
                'success' => false,
                'message' => "Le numéro identifiant $id_user est incorrect."
            );
        }
    }

    private function fermer_statut($id_user, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_statuts SET statut_passe_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ?");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $id_user));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
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
       A.civilite_code AS code, 
       A.utilisateur_prenoms AS prenoms, 
       A.utilisateur_nom AS nom, 
       A.utilisateur_nom_patronymique AS nom_patronymique, 
       A.utilisateur_date_naissance AS date_naissance, 
       A.sexe_code AS code_sexe, 
       A.situation_familiale_code AS code_situation_familiale, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_utilisateurs A
ORDER BY A.utilisateur_prenoms, A.utilisateur_nom
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_coordonnnees($id_user): array
    {
        $query = "
SELECT 
     A.utilisateur_id AS utilisateur_id, 
       A.type_coordonnee_code AS type_coordonnee, 
       A.coordonnee_valeur AS valeur,
      B.type_coordonnee_libelle AS libelle,
       A.coordonnee_date_debut AS date_debut 
FROM 
     tb_utilisateurs_coordonnees A  JOIN  tb_ref_types_coordonnees B
     ON A.type_coordonnee_code = B.type_coordonnee_code
WHERE 
    
      A.utilisateur_id = ? AND 
      A.coordonnee_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($id_user));
        return $a->fetchAll();
    }

    public function editer_coordonnee($id_user, $type, $valeur, $user): array
    {
        $coordonnee = $this->trouver_coordonnee($type, $id_user);
        if ($coordonnee) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($coordonnee['date_debut'])) {
                $edition = $this->fermer_coordonnee($id_user, $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_coordonnee($id_user, $type, $valeur, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($coordonnee['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_coordonnee($id_user, $type, $valeur, $user);
        }
        return $json;
    }

    public function trouver_coordonnee($type, $id_user)
    {
        $query = "
SELECT 
       A.utilisateur_id AS utilisateur_id, 
       A.type_coordonnee_code AS type_coordonnee, 
       A.coordonnee_valeur AS valeur, 
       A.coordonnee_date_debut AS date_debut 
FROM 
     tb_utilisateurs_coordonnees A 
WHERE 
      A.type_coordonnee_code = ? AND 
      A.utilisateur_id = ? AND 
      A.coordonnee_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($type, $id_user));
        return $a->fetch();
    }

    private function fermer_coordonnee($id_user, $date_fin, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs_coordonnees  SET coordonnee_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ? AND coordonnee_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $id_user));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectué avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_coordonnee($id_user, $type, $valeur, $user): array
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_utilisateurs_coordonnees(utilisateur_id,type_coordonnee_code, coordonnee_valeur, coordonnee_date_debut, utilisateur_id_creation)
            VALUES(:utilisateur_id, :type_coordonnee_code,:coordonnee_valeur, :coordonnee_date_debut, :utilisateur_id_creation)");
        $a->execute(array(
            'utilisateur_id' => $id_user,
            'type_coordonnee_code' => $type,
            'coordonnee_valeur' => $valeur,
            'coordonnee_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user,
        ));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true,
                'message' => 'Coordonne enregistré avec succes'
            );
        } else {
            return array(
                'success' => false,
                'erreur_message' => $a->errorInfo()
            );
        }
    }

    public function lister_profils() {
        $a = $this->getBdd()->prepare("SELECT A.profil_utilisateur_code AS code, B.profil_utilisateur_libelle AS libelle, COUNT(A.profil_utilisateur_code) AS nombre FROM tb_utilisateurs_profils A JOIN tb_ref_profils_utilisateurs B ON A.profil_utilisateur_code = B.profil_utilisateur_code AND B.profil_utilisateur_date_fin IS NULL GROUP BY A.profil_utilisateur_code, B.profil_utilisateur_libelle");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_photo($id_user, $nom_photo, $user): array
    {
        $a = $this->getBdd()->prepare("UPDATE tb_utilisateurs SET utilisateur_photo = ?, date_edition = ?, utilisateur_id_edition = ? WHERE utilisateur_id = ?");
        $a->execute(array($nom_photo, date('Y-m-d H:i:s',time()), $user, $id_user));
        if ($a->errorCode() == "00000"){
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès.'
            );
        }else{
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_logs($id_user) {
        $a = $this->getBdd()->prepare("
SELECT 
       A.utilisateur_id AS id_user, 
       A.session_navigateur AS navigateur, 
       A.session_navigateur_version AS navigateur_version,
       A.session_adresse_ip AS adresse_ip,
       B.log_id AS id_log, 
       B.session_code AS code_session, 
       B.piste_audit_url AS url, 
       B.piste_audit_action AS action, 
       B.piste_audit_details AS details, 
       B.date_reg 
FROM tb_utilisateurs_sessions A 
    JOIN tb_log_piste_audit B 
        ON A.session_code = B.session_code 
               AND A.utilisateur_id = ? ORDER BY B.date_reg DESC LIMIT 1000");
        $a->execute(array($id_user));
        return $a->fetchAll();
    }
}
