<?php
if (isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'num_dossier' => clean_data($_POST['num_dossier']),
        'num_secu' => clean_data($_POST['num_secu']),
        'num_patient' => clean_data($_POST['num_patient']),
        'nom_prenoms' => clean_data($_POST['nom_prenoms']),
        'date_debut' => clean_data(date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date_debut'])))),
        'date_fin' => clean_data(date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date_fin']))))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/POPULATIONS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                            $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                            $nb_modules = count($modules);
                            if ($nb_modules !== 0) {
                                $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                if (in_array('AFF_DOSS', $modules, true)) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE DOSSIERS PATIENTS', json_encode($parametres));
                                    if ($audit['success'] === true) {
                                        if (!$_POST['date_debut'] && !$_POST['date_fin']) {
                                            $parametres['date_debut'] = date('Y-m-d', strtotime('-1 WEEK', time()));
                                            $parametres['date_fin'] = date('Y-m-d', time());
                                        }

                                        $dossiers = $ETABLISSEMENTS->moteur_recherche_dossiers($ets['code'], $parametres['num_dossier'], $parametres['num_secu'], $parametres['num_patient'], $parametres['nom_prenoms'], $parametres['date_debut'], $parametres['date_fin']);
                                        $nb_dossiers = count($dossiers);
                                        if ($nb_dossiers !== 0) {
                                            ?>
                                            <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_dossiers">
                                                <thead class="bg-indigo text-white">
                                                <tr>
                                                    <th style="width: 5px">#</th>
                                                    <th style="width: 70px">DATE DEBUT</th>
                                                    <th style="width: 70px">DATE FIN</th>
                                                    <th style="width: 70px">N° DOSSIER</th>
                                                    <th style="width: 70px">NIP</th>
                                                    <th style="width: 70px">N° SECU</th>
                                                    <th style="width: 50px">CIVILITE</th>
                                                    <th>NOM & PRENOM(S)</th>
                                                    <th style="width: 70px">DATE NAISS.</th>
                                                    <?php
                                                    if (in_array('AFF_DOS', $sous_modules, true)) {
                                                        echo '<th style="width: 5px"></th>';
                                                    }
                                                    ?>
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
                                                        <td class="align_right"><?= $dossier['code_dossier'];?></td>
                                                        <td class="align_right"><?= $dossier['num_population'];?></td>
                                                        <td class="align_right"><?= $dossier['num_rgb'];?></td>
                                                        <td><?= $dossier['code_civilite'];?></td>
                                                        <td><?= $dossier['nom'].' '.$dossier['prenom'];?></td>
                                                        <td class="align_center"><?= date('d/m/Y', strtotime($dossier['date_naissance']));?></td>
                                                        <?php
                                                        if (in_array('AFF_DOS', $sous_modules, true)) {
                                                            ?><td class="bg-info"><a href="<?= URL.'etablissement/dossiers/?num='.$dossier['code_dossier'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td><?php
                                                        }
                                                        ?>
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
                                        'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
                                    );
                                    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                                }
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
                                );
                                echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
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
