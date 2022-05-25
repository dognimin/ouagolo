<?php
namespace App;

class ACTESMEDICAUX extends BDD
{
    public function lister_referentiels(): array
    {
        return array(
            array(
                'code' => "let_cle",
                'libelle' => "Lettres Clés"
            ),
            array(
                'code' => "act_tit",
                'libelle' => "Titres"
            ),
            array(
                'code' => "act_cha",
                'libelle' => "Chapitres"
            ),
            array(
                'code' => "act_sec",
                'libelle' => "Sections"
            ),
            array(
                'code' => "act_art",
                'libelle' => "Articles"
            ),

            array(
                'code' => "act_med",
                'libelle' => " Actes médicaux"
            )
        );
    }

    public function lister_lettres_cles()
    {
        $query = "
SELECT 
       	lettre_cle_code  AS code,
       	lettre_cle_libelle AS libelle,
       	lettre_cle_prix_unitaire AS prix_unitaire,
       	lettre_cle_date_debut AS date_debut,
       utilisateur_id_creation
FROM 
     tb_ref_lettres_cles  WHERE lettre_cle_date_fin IS NULL
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function lister_coefficient($code)
    {
        $query = "
SELECT 
      	A.lettre_cle_code  AS code_cle,
      	A.acte_code  AS code_acte,
       	A.coefficient_valeur AS valeur,
       	B.lettre_cle_libelle AS libelle_lettre_cle,
       	A.coefficient_date_debut AS date_debut,
        A.utilisateur_id_creation
FROM 
     tb_ref_actes_medicaux_coefficients A 
         JOIN tb_ref_lettres_cles B
             ON A.lettre_cle_code = B.lettre_cle_code 
                    AND	A.coefficient_date_fin IS NULL 
                    AND A.acte_code LIKE ?
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function editer_lettre_cle($code, $libelle, $prix, $user): array
    {
        $lettres = $this->trouver_lettre_cle($code);
        if ($lettres) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($lettres['date_debut'])) {
                $edition = $this->fermer_lettre_cle($lettres['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_lettre_cle($code, $libelle, $prix, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($lettres['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_lettre_cle($code, $libelle, $prix, $user);
        }
        return $json;
    }

    public function trouver_lettre_cle($code)
    {
        $query = "
SELECT 
       	lettre_cle_code  AS code,
       	lettre_cle_libelle AS libelle,
       	lettre_cle_prix_unitaire AS prix_unitaire,
       	lettre_cle_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_lettres_cles
WHERE lettre_cle_code LIKE ? AND
      lettre_cle_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_lettre_cle($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_lettres_cles  SET 	lettre_cle_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	lettre_cle_code = ? AND 	lettre_cle_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_lettre_cle($code, $libelle, $prix_unitaire, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_lettres_cles(lettre_cle_code,lettre_cle_libelle,lettre_cle_prix_unitaire,lettre_cle_date_debut ,utilisateur_id_creation)
        VALUES(:lettre_cle_code,:lettre_cle_libelle,:lettre_cle_prix_unitaire,:lettre_cle_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'lettre_cle_code' => $code,
            'lettre_cle_libelle' => $libelle,
            'lettre_cle_prix_unitaire' => $prix_unitaire,
            'lettre_cle_date_debut' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectue avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer_titre($code, $libelle, $user)
    {
        $titres = $this->trouver_titre($code);
        if ($titres) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($titres['date_debut'])) {
                $edition = $this->fermer_titre($titres['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_titre($code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($titres['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_titre($code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_titre($code)
    {
        $query = "
SELECT 
       titre_code AS code,
       titre_libelle AS libelle,
       titre_date_debut AS date_debut,
       utilisateur_id_creation
FROM
     tb_ref_actes_titres
WHERE titre_code LIKE ? AND
      titre_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_titre($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_actes_titres  SET titre_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE titre_code  = ? AND titre_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_titre($code, $libelle, $user)
    {
        if(!$code) {
            $titres = $this->lister_titres();
            $nb_titres = count($titres);
            $code = 'T'.str_pad(intval($nb_titres + 1), 6, '0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_actes_titres(titre_code,titre_libelle,titre_date_debut,utilisateur_id_creation)
        VALUES(:titre_code,:titre_libelle,:titre_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'titre_code' => $code,
            'titre_libelle' => $libelle,
            'titre_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectue avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_titres()
    {
        $query = "
SELECT 
        A.titre_code AS code,
       A.titre_libelle AS libelle,
       A.titre_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM
     tb_ref_actes_titres A

WHERE 
      A.titre_date_fin IS NULL 
ORDER BY A.titre_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array());
        return $a->fetchAll();
    }

    public function editer_chapitre($code, $code_titre, $libelle, $user)
    {

        $chapitres = $this->trouver_chapitre($code);
        if ($chapitres) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($chapitres['date_debut'])) {
                $edition = $this->fermer_chapitre($chapitres['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_chapitre($code, $code_titre, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($chapitres['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_chapitre($code, $code_titre, $libelle, $user);
        }

        return $json;
    }

    public function trouver_chapitre($code)
    {
        $query = "
SELECT 
       	chapitre_code AS code,
       	chapitre_libelle AS libelle,
       	chapitre_date_debut AS date_debut,
        utilisateur_id_creation
FROM
     tb_ref_actes_chapitres
WHERE
      chapitre_code LIKE ? AND 
      chapitre_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_chapitre($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_actes_chapitres  SET chapitre_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE chapitre_code = ? AND chapitre_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_chapitre($code, $code_titre, $libelle, $user)
    {
        if(!$code) {
            $chapitres = $this->lister_chapitres(null);
            $nb_chapitres = count($chapitres);
            $code = 'C'.str_pad(intval($nb_chapitres + 1), 6, '0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_actes_chapitres(chapitre_code,titre_code,chapitre_libelle,chapitre_date_debut,utilisateur_id_creation)
        VALUES(:chapitre_code,:titre_code,:chapitre_libelle,:chapitre_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'chapitre_code' => $code,
            'titre_code' => $code_titre,
            'chapitre_libelle' => $libelle,
            'chapitre_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectue avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_chapitres($code)
    {
        $query = "
SELECT 
        	A.chapitre_code AS code,
        	A.titre_code AS code_titre,
       	A.chapitre_libelle AS libelle,
       	A.chapitre_date_debut AS date_debut,
        A.utilisateur_id_creation,
        B.titre_libelle AS nom_titre
FROM
     tb_ref_actes_chapitres A JOIN tb_ref_actes_titres B 
     ON A.titre_code = B.titre_code 
WHERE 
      A.chapitre_date_fin IS NULL AND B.titre_date_fin is NULL AND A.titre_code LIKE ?
ORDER BY A.chapitre_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }

    public function editer_section($code, $sous_chapitre, $libelle, $user)
    {
        $sections = $this->trouver_section($code);
        if ($sections) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($sections['date_debut'])) {
                $edition = $this->fermer_section($sections['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_section($code, $sous_chapitre, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($sections['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_section($code, $sous_chapitre, $libelle, $user);
        }
        return $json;
    }

    public function trouver_section($code)
    {
        $query = "
SELECT 
       	section_code AS code,
       	section_libelle AS libelle,
       	section_date_debut AS date_debut,
       	section_date_fin AS date_fin,
        utilisateur_id_creation
FROM
     tb_ref_actes_sections
WHERE
      section_code LIKE ? AND 
      section_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_section($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_actes_sections  SET 	section_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE section_code = ? AND section_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_section($code, $code_capitre, $libelle, $user)
    {
        if(!$code) {
            $sections = $this->lister_sections(null);
            $nb_sections = count($sections);
            $code = 'S'.str_pad(intval($nb_sections + 1), 6, '0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_actes_sections(section_code,chapitre_code,section_libelle,section_date_debut,utilisateur_id_creation)
        VALUES(:section_code,:chapitre_code,:section_libelle,:section_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'section_code' => $code,
            'chapitre_code' => $code_capitre,
            'section_libelle' => $libelle,
            'section_date_debut' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectue avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_sections($code)
    {
        $query = "
SELECT 
    A.section_code AS code,
    A.chapitre_code AS code_chapitre,
    B.chapitre_libelle AS libelle_chapitre,
    A.section_libelle AS libelle,
    A.section_date_debut AS date_debut,
    A.utilisateur_id_creation,
    C.titre_code AS code_titre, 
    C.titre_libelle AS libelle_titre
FROM 
     tb_ref_actes_sections A 
         JOIN tb_ref_actes_chapitres B
             ON A.chapitre_code = B.chapitre_code 
         JOIN tb_ref_actes_titres C 
             ON B.titre_code = C.titre_code 
                    AND  A.section_date_fin IS NULL 
                    AND C.titre_date_fin IS NULL 
                    AND B.chapitre_date_fin IS NULL 
                    AND A.chapitre_code LIKE ? ORDER BY A.section_code
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }

    public function editer_article($code_chapitre, $code_section, $code, $libelle, $user)
    {
        $articles = $this->trouver_article($code);
        if ($articles) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($articles['date_debut'])) {
                $edition = $this->fermer_article($articles['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_article($code_chapitre, $code_section, $code, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($articles['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_article($code_chapitre, $code_section, $code, $libelle, $user);
        }
        return $json;
    }

    public function trouver_article($code)
    {
        $query = "
SELECT 
       		article_code AS code,
       		article_libelle AS libelle,
       		article_date_debut AS date_debut,
        utilisateur_id_creation
FROM
     tb_ref_actes_articles
WHERE
      article_code LIKE ? AND 
      article_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_article($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_actes_articles  SET  article_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE 	article_code = ? AND 	article_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_article($code_chapitre, $code_section, $code, $libelle, $user)
    {
        if(!$code) {
            $articles = $this->lister_articles(null);
            $nb_articles = count($articles);
            $code = 'A'.str_pad(intval($nb_articles + 1), 6, '0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_actes_articles(article_code,chapitre_code,section_code,article_libelle,article_date_debut ,utilisateur_id_creation)
        VALUES(:article_code,:chapitre_code,:section_code,:article_libelle,:article_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'article_code' => $code,
            'chapitre_code' => $code_chapitre,
            'section_code' => $code_section,
            'article_libelle' => $libelle,
            'article_date_debut' => date('Y-m-d H:i:s', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectue avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_articles($code)
    {
        $query = "
SELECT 
       D.titre_code AS code_titre,
       D.titre_libelle AS libelle_titre,
       C.chapitre_code AS code_chapitre,
       C.chapitre_libelle AS libelle_chapitre,
       A.article_code AS code,
       A.section_code AS code_section,
       B.section_libelle AS libelle_section,
       A.article_libelle AS libelle,
       A.article_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM
     tb_ref_actes_articles A 
         JOIN tb_ref_actes_sections B 
             ON A.section_code = B.section_code 
         JOIN tb_ref_actes_chapitres C 
             ON B.chapitre_code = C.chapitre_code 
         JOIN tb_ref_actes_titres D 
             ON C.titre_code = D.titre_code
                    AND A.article_date_fin IS NULL 
                    AND B.section_date_fin IS NULL 
                    AND C.chapitre_date_fin IS NULL 
                    AND  D.titre_date_fin IS NULL 
                    AND  A.section_code LIKE ?
ORDER BY A.article_libelle
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $code . '%'));
        return $a->fetchAll();
    }

    public function editer_acte_medical($code_article, $code, $libelle, $user)
    {
        $actes = $this->trouver_acte_medical($code);
        if ($actes) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($actes['date_debut'])) {
                $edition = $this->fermer_acte_medical($actes['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_acte_medical($code, $code_article, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($actes['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_acte_medical($code, $code_article, $libelle, $user);
        }
        return $json;
    }

    public function trouver_acte_medical($code): ?array
    {
        $query = "SELECT acte_code  AS code, acte_libelle AS libelle, acte_date_debut AS date_debut, utilisateur_id_creation FROM tb_ref_actes_medicaux WHERE acte_code  LIKE ? AND acte_date_fin IS NULL";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        $acte = $a->fetch();
        $tarif = 0;
        if($acte) {
            $b = $this->getBdd()->prepare("SELECT A.acte_code AS code_acte, A.lettre_cle_code AS code_lettre_cle, B.lettre_cle_libelle AS libelle_lettre_cle, B.lettre_cle_prix_unitaire AS prix_unitaire, A.coefficient_valeur AS coefficient FROM tb_ref_actes_medicaux_coefficients A JOIN tb_ref_lettres_cles B ON A.lettre_cle_code = B.lettre_cle_code AND A.acte_code = ? AND A.coefficient_date_fin IS NULL AND B.lettre_cle_date_fin IS NULL");
            $b->execute(array($acte['code']));
            $coefficients = $b->fetchAll();
            foreach ($coefficients as $coefficient) {
                $tarif = $tarif + intval($coefficient['coefficient'] * $coefficient['prix_unitaire']);
            }

            return array(
                'code' => $acte['code'],
                'libelle' => $acte['libelle'],
                'date_debut' => $acte['date_debut'],
                'utilisateur_id_creation' => $acte['utilisateur_id_creation'],
                'tarif' => $tarif
            );
        }else {
            return null;
        }
    }

    private function fermer_acte_medical($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_actes_medicaux  SET  acte_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE acte_code  = ? AND 	acte_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_acte_medical($code, $code_article, $libelle, $user)
    {
        if(!$code) {
            $actes = $this->lister_actes_medicaux(null);
            $nb_actes = count($actes);
            $code = 'AM'.str_pad(intval($nb_actes + 1), 5, '0',STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_actes_medicaux(acte_code,article_code,acte_libelle,acte_date_debut ,utilisateur_id_creation)
        VALUES(:acte_code,:article_code,:acte_libelle,:acte_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'acte_code' => $code,
            'article_code' => $code_article,
            'acte_libelle' => $libelle,
            'acte_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                'success' => true,
                'code' => $code,
                'message' => 'Enregistrement effectue avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_actes_medicaux($libelle)
    {
        $query = "
SELECT 
       E.titre_code AS code_titre,
       E.titre_libelle AS libelle_titre,
       D.chapitre_code AS code_chapitre, 
       D.chapitre_libelle AS libelle_chapitre,
       C.section_code AS code_section,
       C.section_libelle AS libelle_section,
       B.article_code AS code_article, 
       B.article_code AS libelle_article,
       A.acte_code  AS code,
       A.acte_libelle AS libelle,
       A.acte_date_debut AS date_debut,
       A.utilisateur_id_creation
FROM 
     tb_ref_actes_medicaux A 
         JOIN tb_ref_actes_articles B
             ON  A.article_code = B.article_code 
         JOIN tb_ref_actes_sections C 
             ON B.section_code = C.section_code 
         JOIN tb_ref_actes_chapitres D 
             ON D.chapitre_code = C.chapitre_code 
         JOIN tb_ref_actes_titres E 
             ON D.titre_code = E.titre_code 
                    AND A.acte_date_fin IS NULL 
                    AND B.article_date_fin IS NULL 
                    AND C.section_date_fin IS NULL 
                    AND D.chapitre_date_fin IS NULL 
                    AND E.titre_date_fin IS NULL 
                    AND A.acte_libelle LIKE ?
ORDER BY A.acte_libelle  
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array('%' . $libelle . '%'));
        $actes = $a->fetchAll();
        $json = array();
        foreach ($actes as $acte) {
            $tarif = 0;
            $b = $this->getBdd()->prepare("SELECT A.acte_code AS code_acte, A.lettre_cle_code AS code_lettre_cle, B.lettre_cle_libelle AS libelle_lettre_cle, B.lettre_cle_prix_unitaire AS prix_unitaire, A.coefficient_valeur AS coefficient FROM tb_ref_actes_medicaux_coefficients A JOIN tb_ref_lettres_cles B ON A.lettre_cle_code = B.lettre_cle_code AND A.acte_code = ? AND A.coefficient_date_fin IS NULL AND B.lettre_cle_date_fin IS NULL");
            $b->execute(array($acte['code']));
            $coefficients = $b->fetchAll();
            foreach ($coefficients as $coefficient) {
                $tarif = $tarif + intval($coefficient['coefficient'] * $coefficient['prix_unitaire']);
            }

            $json[] = array(
                'code_titre' => $acte['code_titre'],
                'libelle_titre' => $acte['libelle_titre'],
                'code_chapitre' => $acte['code_chapitre'],
                'libelle_chapitre' => $acte['libelle_chapitre'],
                'code_section' => $acte['code_section'],
                'libelle_section' => $acte['libelle_section'],
                'code_article' => $acte['code_article'],
                'libelle_article' => $acte['libelle_article'],
                'code' => $acte['code'],
                'libelle' => $acte['libelle'],
                'date_debut' => $acte['date_debut'],
                'tarif' => $tarif,
            );
        }
        return $json;
    }

    public function editer_acte_coefficient($code_lettre, $code_act, $libelle, $user)
    {
        $coefficient = $this->trouver_acte_coefficient($code_lettre);
        if ($coefficient) {
            $date_fin = date('Y-m-d', strtotime('-1 day', time()));
            if (strtotime($date_fin) > strtotime($coefficient['date_debut'])) {
                $edition = $this->fermer_acte_coefficient($coefficient['code'], $date_fin, $user);
                if ($edition['success'] == true) {
                    $json = $this->ajouter_acte_coefficient($code_act, $code_lettre, $libelle, $user);
                } else {
                    $json = $edition;
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "La mise à jour de cette donnée ne peut se faire que 48h après la dernière modification. Veuillez réessayer le " . date('d/m/Y', strtotime('+2 day', strtotime($coefficient['date_debut'])))
                );
            }
        } else {
            $json = $this->ajouter_acte_coefficient($code_act, $code_lettre, $libelle, $user);
        }
        return $json;
    }

    public function trouver_acte_coefficient($code)
    {
        $query = "
SELECT 
       	lettre_cle_code  AS code,
       	acte_code  AS acte_code,
       	coefficient_valeur AS libelle,
       	coefficient_date_debut AS date_debut,
        utilisateur_id_creation
FROM
     tb_ref_actes_medicaux_coefficients
WHERE
      acte_code  LIKE ? AND 
      coefficient_date_fin IS NULL
        ";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetch();
    }

    private function fermer_acte_coefficient($code, $date_fin, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_ref_actes_medicaux_coefficients  SET  coefficient_date_fin = ?, date_edition = ?, utilisateur_id_edition = ? WHERE lettre_cle_code  = ? AND 	coefficient_date_fin IS NULL");
        $a->execute(array($date_fin, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "messages" => 'Enregistrement effectue avec succès.'
            );
        } else {
            return array(
                "success" => false,
                "messages" => $a->errorInfo()
            );
        }
    }

    private function ajouter_acte_coefficient($code_acte, $code_lettre, $coefficient, $user)
    {
        $a = $this->getBdd()->prepare("INSERT INTO tb_ref_actes_medicaux_coefficients(acte_code,lettre_cle_code,coefficient_valeur,coefficient_date_debut ,utilisateur_id_creation)
        VALUES(:acte_code,:lettre_cle_code,:coefficient_valeur,:coefficient_date_debut,:utilisateur_id_creation) 
        ");
        $a->execute(array(
            'acte_code' => $code_acte,
            'lettre_cle_code' => $code_lettre,
            'coefficient_valeur' => $coefficient,
            'coefficient_date_debut' => date('Y-m-d', time()),
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectue avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    public function lister_historique_lettre_cle($code)
    {
        $query = "
SELECT 
       A.lettre_cle_code AS code, 
       A.lettre_cle_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.lettre_cle_date_debut AS date_debut, 
       A.lettre_cle_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_lettres_cles A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.lettre_cle_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_titre($code)
    {
        $query = "
SELECT 
       A.titre_code AS code, 
       A.titre_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.titre_date_debut AS date_debut, 
       A.titre_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_actes_titres A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.titre_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_chapitre($code)
    {
        $query = "
SELECT 
       A.chapitre_code  AS code, 
       A.chapitre_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.chapitre_date_debut AS date_debut, 
       A.chapitre_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_actes_chapitres A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.chapitre_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_section($code)
    {
        $query = "
SELECT 
       A.section_code AS code, 
       A.section_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.section_date_debut AS date_debut, 
       A.section_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_actes_sections A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.section_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_article($code)
    {
        $query = "
SELECT 
       A.article_code AS code, 
       A.article_code AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.article_date_debut AS date_debut, 
       A.article_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_actes_articles A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.article_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

    public function lister_historique_acte_medical($code)
    {
        $query = "
SELECT 
       A.acte_code AS code, 
       A.acte_libelle AS libelle, 
       B.utilisateur_nom AS nom,
       B.utilisateur_prenoms AS prenoms, 
       A.acte_date_debut AS date_debut, 
       A.acte_date_fin AS date_fin, 
       A.date_creation, 
       A.utilisateur_id_creation
FROM 
     tb_ref_actes_medicaux A JOIN tb_utilisateurs B 
         ON 
             A.utilisateur_id_creation = B.utilisateur_id AND A.acte_code LIKE ?
ORDER BY 
         A.date_creation DESC
";
        $a = $this->getBdd()->prepare($query);
        $a->execute(array($code));
        return $a->fetchAll();
    }

}