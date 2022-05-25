<?php
namespace App;

class ADMISSIONS extends BDD
{
    public function lister_lits($code_chambre) {
        $a = $this->getBdd()->prepare("
SELECT 
       chambre_code AS code_chambre, 
       type_lit_code AS code_type_lit, 
       lit_code AS code, 
       lit_libelle AS libelle, 
       lit_date_debut AS date_debut, 
       lit_date_fin AS date_fin, 
       date_creation, 
       utilisateur_id_creation, 
       date_edition, 
       utilisateur_id_edition
FROM 
     tb_etablissements_chambres_lits 
WHERE 
      chambre_code = ?");
        $a->execute(array($code_chambre));
        return $a->fetchAll();
    }

    public function ajouter_lit() {
        $a = $this->getBdd()->prepare("INSERT INTO tb_etablissements_chambres_lits(chambre_code, type_lit_code, lit_code, lit_libelle, lit_date_debut, utilisateur_id_creation) ");
    }
}
