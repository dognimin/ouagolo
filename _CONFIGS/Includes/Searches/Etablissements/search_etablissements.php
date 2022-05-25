<?php
if(isset($_POST)) {
    require_once "../../../Functions/Functions.php";
    require_once "../../../Classes/UTILISATEURS.php";
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'raison_sociale' => clean_data($_POST['raison_sociale']),
        'niveau' => clean_data($_POST['niveau']),
        'type' => clean_data($_POST['type'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../Classes/ETABLISSEMENTS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $etablissements = $ETABLISSEMENTS->monteur_recherche($parametres['niveau'],$parametres['code'],$parametres['type'],$parametres['raison_sociale']);
                $nb_etablissements = count($etablissements);
                if ($nb_etablissements == 0){
                    echo '<p class="alert alert-info align_center">Aucun résultat correspondant à votre recherche n\'a été trouvé</p>';
                }
                else{
                    ?>
                    <table class="table table-bordered table-hover table-sm table-striped" id="table_etablissements">
                        <thead class="bg-secondary">
                        <tr>
                            <th style="width: 5px">N°</th>
                            <th style="width: 80px">CODE</th>
                            <th>RAISON SOCIALE</th>
                            <th>TYPE ETABLISSEMENT</th>
                            <th>NIVEAU SANITAIRE</th>
                            <th style="width: 5px"></th>

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
                                <td><?= $etablissement['libelle_type'];?></td>
                                <td><?= $etablissement['libelle_niveau'];?></td>
                                <td><a href="<?= URL.'etablissements/?code='.$etablissement['code'];?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
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
                    'message' => "Aucun utilisateur pour vérifier cette action."
                );
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
?>
<script>
    $("#table_etablissements").DataTable();
</script>
