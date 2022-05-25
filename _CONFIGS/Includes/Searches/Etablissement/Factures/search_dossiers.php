<?php
if(isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'num_dossier' => clean_data($_POST['num_dossier']),
        'num_secu' => clean_data($_POST['num_secu']),
        'num_patient' => clean_data($_POST['num_patient']),
        'date_debut' => clean_data(date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date_debut'])))),
        'date_fin' => clean_data(date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date_fin']))))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if ($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/POPULATIONS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $ETABLISSEMENTS->trouver_utilisateur($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE DOSSIERS PATIENTS', json_encode($parametres));
                            if ($audit['success'] == true) {
                                if (!$_POST['date_debut'] && !$_POST['date_fin']) {
                                    $parametres['date_debut'] = date('Y-m-d', strtotime('-1 WEEK', time()));
                                    $parametres['date_fin'] = date('Y-m-d', time());
                                }

                                $dossiers = $ETABLISSEMENTS->moteur_recherche_dossiers($ets['code'], $parametres['num_dossier'], $parametres['num_secu'], $parametres['num_patient'], $parametres['date_debut'], $parametres['date_fin']);
                                $nb_dossiers = count($dossiers);
                                if ($nb_dossiers != 0) {
                                    ?>
                                    <table class="table table-bordered table-stripped table-hover table-sm" id="table_dossiers">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">N°</th>
                                            <th style="width: 100px">DATE DEBUT</th>
                                            <th style="width: 100px">DATE FIN</th>
                                            <th style="width: 100px">N° DOSSIER</th>
                                            <th style="width: 100px">NIP</th>
                                            <th style="width: 100px">N° SECU</th>
                                            <th>NOM & PRENOM(S)</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($dossiers as $dossier) {
                                            ?>
                                            <tr>
                                                <td class="align_right"><?= $ligne;?></td>
                                                <td class="align_center"><?= date('d/m/Y', strtotime($dossier['date_debut']));?></td>
                                                <td class="align_center"><?= $dossier['date_fin']?date('d/m/Y', strtotime($dossier['date_fin'])):null;?></td>
                                                <td><?= $dossier['code_dossier'];?></td>
                                                <td><?= $dossier['num_population'];?></td>
                                                <td><?= $dossier['num_rgb'];?></td>
                                                <td><?= $dossier['nom'].' '.$dossier['prenom'];?></td>
                                                <td class="bg-info"><a href="<?= URL.'etablissement/dossiers/?num='.$dossier['code_dossier'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                            </tr>
                                            <?php
                                            $ligne++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                } else {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Aucun dossier patient trouvé."
                                    );
                                    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                                }
                            } else {
                                $json = $audit;
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur."
                            );
                            echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                        }
                    } else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
                echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
            }
        } else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
            echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
        }
    }
}
?>
<script>
    $("#table_dossiers").DataTable();
</script>
