<?php
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_secteur' => clean_data($_POST['code_secteur']),
        'code' => clean_data($_POST['code']),
        'raison_sociale' => clean_data($_POST['raison_sociale'])
    );

    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../../Classes/COLLECTIVITES.php";
                $COLLECTIVITES = new COLLECTIVITES();

                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE COLLECTIVITES', json_encode($parametres));
                if ($audit['success'] == true) {
                    $collectivites = $COLLECTIVITES->moteur_recherche($parametres['code_secteur'], $parametres['code'], $parametres['raison_sociale']);
                    $nb_collectivites = count($collectivites);
                    if($nb_collectivites != 0) {
                        ?>
                        <table class="table table-bordered table-hover table-sm table-striped" id="table_collectivites">
                            <thead  class="bg-secondary">
                            <tr>
                                <th style="width: 5px">N°</th>
                                <th style="width: 105px">SECTEUR</th>
                                <th style="width: 100px">CODE</th>
                                <th>RAISON SOCIALE</th>
                                <th style="width: 150px">PAYS</th>
                                <th style="width: 5px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($collectivites as $collectivite) {
                                ?>
                                <tr>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $collectivite['libelle_secteur_activite'];?></td>
                                    <td><strong><?= $collectivite['code'];?></strong></td>
                                    <td><?= $collectivite['raison_sociale'];?></td>
                                    <td><?= $collectivite['nom_pays'];?></td>
                                    <td><a href="<?= URL.'parametres/referentiels/collectivites/?code='.strtolower($collectivite['code']);?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun résultat correspondant à votre recherche n'a été trouvé"
                        );
                        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                    }
                }else {
                    $json = $audit;
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucune session active pour vérifier cette action."
                );
                echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
            echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
        }
    }else{
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
}
?>
<script>
    $("#table_collectivites").dataTable();
</script>
