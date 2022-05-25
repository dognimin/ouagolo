<?php
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'date_debut' => clean_data(date('Y-m-d 00:00:00',strtotime(str_replace('/', '-', $_POST['date_debut'])))),
        'date_fin' => clean_data(date('Y-m-d 23:59:59',strtotime(str_replace('/', '-', $_POST['date_fin'])))),
        'numero' => clean_data($_POST['numero']),
        'nom' => clean_data($_POST['nom'])
    );

    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'],null);
            if($user) {
                require_once "../../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                if($user_profil) {
                    $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                    if($organisme) {
                        require_once "../../../../Classes/POLICES.php";
                        $POLICES = new POLICES();

                        $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE COLLECTIVITES', json_encode($parametres));
                        if ($audit['success'] == true) {
                            $polices = $POLICES->moteur_recherche($organisme['code'], $parametres['numero'], $parametres['nom'], $parametres['date_debut'], $parametres['date_fin']);
                            $nb_polices = count($polices);
                            if($nb_polices != 0) {
                                ?>
                                <table class="table table-bordered table-hover table-sm table-striped border-dark" id="table_collectivites">
                                    <thead  class="bg-indigo text-white">
                                    <tr>
                                        <th style="width: 5px">#</th>
                                        <th style="width: 100px">CODE</th>
                                        <th>LIBELLE</th>
                                        <th>SOUSCRIPTEUR</th>
                                        <th style="width: 70px">DATE EFFET</th>
                                        <th style="width: 5px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ligne = 1;
                                    foreach ($polices as $police) {
                                        ?>
                                        <tr>
                                            <td class="align_right"><?= $ligne;?></td>
                                            <td><strong><?= $police['id_police'];?></strong></td>
                                            <td><strong><?= $police['nom'];?></strong></td>
                                            <td><?= $police['raison_sociale'];?></td>
                                            <td class="align_center"><?= date('d/m/Y', strtotime($police['date_debut']));?></td>
                                            <td class="bg-info"><a href="<?= URL.'organisme/polices/?id='.strtolower($police['id_police']);?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
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
                            'message' => "Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur."
                        );
                    }
                }else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur."
                    );
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
