<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {

                require_once "../../../../Classes/ETABLISSEMENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $etablissements = $ETABLISSEMENTS->monteur_recherche($parametres['niveau'],$parametres['code'],$parametres['type'],$parametres['raison_sociale']);
                $nb_etablissements = count($etablissements);
                if ($nb_etablissements == 0){
                    echo '<p class="alert alert-info align_center">Aucun résultat correspondant à votre recherche n\'a été trouvé</p>';
                }else{
                    ?>
                    <table class="table table-bordered table-hover table-sm table-striped" >
                        <thead class="bg-secondary">
                        <tr>
                            <th width="5">N°</th>
                            <th width="80">CODE</th>
                            <th>RAISON SOCIALE</th>
                            <th>TYPE ETABLISSEMENT</th>
                            <th>NIVEAU SANITAIRE</th>
                            <th width="5"></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($etablissements as $etablissement) {
                            ?>
                            <tr>
                                <td class="align_right"><?= $ligne;?></td>
                                <td><strong><?= $etablissement['code'];?></strong></td>
                                <td><?= $etablissement['raison_sociale'];?></td>
                                <td><?= $etablissement['type_code'];?></td>
                                <td><?= $etablissement['niveau_sanitaire'];?></td>
                                <td><a href="<?= URL.'parametres/etablissements/details?code='.$etablissement['code'];?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
                            </tr>
                            <?php
                            $ligne++;
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php

                }


    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else{
        $json = count($parametres);
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
