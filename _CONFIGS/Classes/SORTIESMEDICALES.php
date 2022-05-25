<?php
namespace App;

class SORTIESMEDICALES extends BDD
{
    public function lister() {
        $a = $this->getBdd()->prepare("
SELECT 
       sortie_medicale_code AS code, 
       sortie_medicale_libelle AS libelle, 
       sortie_medicale_date_debut AS date_debut, 
       sortie_medicale_date_fin AS date_fin, 
       date_creation, 
       utilisateur_id_creation,
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_ref_sorties_medicales 
WHERE 
      sortie_medicale_date_fin IS NULL");
        $a->execute(array());
        return $a->fetchAll();
    }

    public function trouver($code) {
        $a = $this->getBdd()->prepare("
SELECT 
       sortie_medicale_code AS code, 
       sortie_medicale_libelle AS libelle, 
       sortie_medicale_date_debut AS date_debut, 
       sortie_medicale_date_fin AS date_fin, 
       date_creation, 
       utilisateur_id_creation,
       date_edition, 
       utilisateur_id_edition 
FROM 
     tb_ref_sorties_medicales 
WHERE 
      sortie_medicale_code = ? 
  AND sortie_medicale_date_fin IS NULL");
        $a->execute(array($code));
        return $a->fetch();
    }
}
