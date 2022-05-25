<?php
namespace App;

class FOURNISSEURS extends BDD
{
    public function lister()
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.fournisseur_code AS code, 
       A.fournisseur_libelle AS libelle, 
       A.pays_code AS code_pays, 
       B.pays_nom AS nom_pays,
       B.monnaie_code AS code_monnaie,
       F.monnaie_libelle AS libelle_monnaie,
       A.region_code AS code_region, 
       C.region_nom AS nom_region,
       A.departement_code AS code_departement, 
       D.departement_nom AS nom_departement,
       A.commune_code AS code_commune,
       E.commune_nom AS nom_commune,
       A.fournisseur_adresse_postale AS adresse_postale, 
       A.fournisseur_adresse_geographique AS adresse_geographique, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_fournisseurs A 
         JOIN tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code 
         JOIN tb_ref_geo_regions C 
             ON A.region_code = C.region_code 
         JOIN tb_ref_geo_departements D 
             ON A.departement_code = D.departement_code 
         JOIN tb_ref_geo_communes E 
             ON A.commune_code = E.commune_code 
         JOIN tb_ref_monnaies F 
             ON B.monnaie_code = F.monnaie_code
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND F.monnaie_date_fin IS NULL 
ORDER BY 
         fournisseur_libelle");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function trouver($code, $email, $num_telephone)
    {
        $a = $this->getBdd()->prepare("
SELECT 
       A.fournisseur_code AS code, 
       A.fournisseur_libelle AS libelle, 
       A.pays_code AS code_pays, 
       B.pays_nom AS nom_pays,
       B.monnaie_code AS code_monnaie,
       F.monnaie_libelle AS libelle_monnaie,
       A.region_code AS code_region, 
       C.region_nom AS nom_region,
       A.departement_code AS code_departement, 
       D.departement_nom AS nom_departement,
       A.commune_code AS code_commune,
       E.commune_nom AS nom_commune,
       A.fournisseur_adresse_postale AS adresse_postale, 
       A.fournisseur_adresse_geographique AS adresse_geographique, 
       A.date_creation, 
       A.utilisateur_id_creation, 
       A.date_edition, 
       A.utilisateur_id_edition 
FROM 
     tb_fournisseurs A 
         JOIN tb_ref_geo_pays B 
             ON A.pays_code = B.pays_code 
         JOIN tb_ref_geo_regions C 
             ON A.region_code = C.region_code 
         JOIN tb_ref_geo_departements D 
             ON A.departement_code = D.departement_code 
         JOIN tb_ref_geo_communes E 
             ON A.commune_code = E.commune_code 
         JOIN tb_ref_monnaies F 
             ON B.monnaie_code = F.monnaie_code
                    AND B.pays_date_fin IS NULL 
                    AND C.region_date_fin IS NULL 
                    AND D.departement_date_fin IS NULL 
                    AND E.commune_date_fin IS NULL 
                    AND F.monnaie_date_fin IS NULL 
                    AND A.fournisseur_code LIKE ? 
                    AND fournisseur_email LIKE ? 
                    AND (fournisseur_num_telephone_1 LIKE ? OR fournisseur_num_telephone_2 LIKE ?)");
        $a->execute(array('%'.$code.'%', '%'.$email.'%', '%'.$num_telephone.'%', '%'.$num_telephone.'%'));
        return $a->fetch();
    }

    private function ajouter($code, $libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, $user)
    {
        if (!$code) {
            $fournisseurs = $this->lister();
            $nb_fournisseurs = count($fournisseurs);
            $code = 'F'.str_pad((int)($nb_fournisseurs + 1), 5, '0', STR_PAD_LEFT);
        }
        $a = $this->getBdd()->prepare("INSERT INTO tb_fournisseurs(fournisseur_code, fournisseur_libelle, pays_code, region_code, departement_code, commune_code, fournisseur_adresse_postale, fournisseur_adresse_geographique, fournisseur_email, fournisseur_num_telephone_1, fournisseur_num_telephone_2, utilisateur_id_creation)
        VALUES(:fournisseur_code, :fournisseur_libelle, :pays_code, :region_code, :departement_code, :commune_code, :fournisseur_adresse_postale, :fournisseur_adresse_geographique, :fournisseur_email, :fournisseur_num_telephone_1, :fournisseur_num_telephone_2, :utilisateur_id_creation)");
        $a->execute(array(
            'fournisseur_code' => $code,
            'fournisseur_libelle' => $libelle,
            'pays_code' => $code_pays,
            'region_code' => $code_region,
            'departement_code' => $code_departement,
            'commune_code' => $code_commune,
            'fournisseur_adresse_postale' => $adresse_postale,
            'fournisseur_adresse_geographique' => $adresse_geographique,
            'fournisseur_email' => $email,
            'fournisseur_num_telephone_1' => $num_telephone1,
            'fournisseur_num_telephone_2' => $num_telephone2,
            'utilisateur_id_creation' => $user
        ));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                'code' => $code,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                "message" => $a->errorInfo()
            );
        }
    }

    private function modifier($code, $libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, $user)
    {
        $a = $this->getBdd()->prepare("UPDATE tb_fournisseurs SET fournisseur_libelle = ?, pays_code = ?, region_code = ?, departement_code = ?, commune_code = ?, fournisseur_adresse_postale = ?, fournisseur_adresse_geographique = ?, fournisseur_email = ?, fournisseur_num_telephone_1 = ?, fournisseur_num_telephone_2 = ?, date_edition = ?, utilisateur_id_edition = ? WHERE fournisseur_code = ?");
        $a->execute(array($libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, date('Y-m-d H:i:s', time()), $user, $code));
        if ($a->errorCode() == "00000") {
            return array(
                "success" => true,
                "message" => 'Enregistrement effectué avec succès'
            );
        } else {
            return array(
                "success" => false,
                'code' => $code,
                "message" => $a->errorInfo()
            );
        }
    }

    public function editer($code, $libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, $user)
    {
        if (!$code) {
            return $this->ajouter($code, $libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, $user);
        } else {
            $fournisseur = $this->trouver($code, null, null);
            if ($fournisseur) {
                $fournisseur_email = $this->trouver(null, $email, null);
                if ($fournisseur_email) {
                    if ($fournisseur['code'] ==  $fournisseur_email['code']) {
                        $fournisseur_telephone = $this->trouver(null, null, $num_telephone1);
                        if ($fournisseur_telephone) {
                            if ($fournisseur['code'] ==  $fournisseur_telephone['code']) {
                                return $this->modifier($code, $libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, $user);
                            } else {
                                return array(
                                    'success' => false,
                                    'message' => "Ce numéro de téléphone est utilisé pour un autre fournisseur."
                                );
                            }
                        } else {
                            return $this->modifier($code, $libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, $user);
                        }
                    } else {
                        return array(
                            'success' => false,
                            'message' => "Cette adresse email est utilisée pour un autre fournisseur."
                        );
                    }
                } else {
                    return $this->modifier($code, $libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, $user);
                }
            } else {
                return $this->ajouter($code, $libelle, $code_pays, $code_region, $code_departement, $code_commune, $adresse_postale, $adresse_geographique, $email, $num_telephone1, $num_telephone2, $user);
            }
        }
    }
}
