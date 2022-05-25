<?php
if (isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'code_organisme' => clean_data($_POST['code_organisme']),
        'type_facture' => clean_data($_POST['type_facture']),
        'date_debut' => clean_data(date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $_POST['date_debut'])))),
        'date_fin' => clean_data(date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $_POST['date_fin']))))
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
                                if (in_array('AFF_FCTS', $modules, true) && in_array('AFF_FCTS_BRDRS', $sous_modules, true)) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ETABLISSEMENT BORDEREAUX', json_encode($parametres));
                                    if ($audit['success'] === true) {
                                        if (!$_POST['date_debut'] && !$_POST['date_fin']) {
                                            $parametres['date_debut'] = date('Y-m-d', strtotime('-1 WEEK', time()));
                                            $parametres['date_fin'] = date('Y-m-d', time());
                                        }
                                        $bordereaux = $ETABLISSEMENTS->moteur_recherche_bordereaux($ets['code'], $parametres['code_organisme'], $parametres['type_facture'], $parametres['date_debut'], $parametres['date_fin']);
                                        $nb_bordereaux = count($bordereaux);
                                        if($nb_bordereaux != 0) {
                                            ?>
                                            <table class="table table-bordered table-stripped table-hover table-sm" id="table_bordereaux">
                                                <thead class="bg-indigo text-white">
                                                <tr>
                                                    <th style="width: 5px">#</th>
                                                    <th style="width: 50px">N° BDR.</th>
                                                    <th style="width: 50px">DEBUT</th>
                                                    <th style="width: 50px">FIN</th>
                                                    <th>ORGANISME</th>
                                                    <th>TYPE FACTURE</th>
                                                    <th style="width: 50px">NOMBRE</th>
                                                    <th style="width: 100px">MT. RGB</th>
                                                    <th style="width: 100px">MT. ORGANISME</th>
                                                    <th style="width: 5px"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $ligne = 1;
                                                foreach ($bordereaux as $bordereau) {
                                                    ?>
                                                    <tr>
                                                        <td class="align_right"><?= $ligne;?></td>
                                                        <td class="align_right"><?= $bordereau['num_bordereau'];?></td>
                                                        <td class="align_center"><?= date('d/m/Y', strtotime($bordereau['date_debut']));?></td>
                                                        <td class="align_center"><?= date('d/m/Y', strtotime($bordereau['date_fin']));?></td>
                                                        <td><?= $bordereau['libelle_organisme'];?></td>
                                                        <td><?= $bordereau['libelle_type_facture'];?></td>
                                                        <td class="align_right"><?= number_format($bordereau['nombre_factures'], '0', '', ' ');?></td>
                                                        <td class="align_right"><?= number_format($bordereau['montant_rgb'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                        <td class="align_right"><?= number_format($bordereau['montant_rc'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                        <td class=" bg-info"><a href="<?= URL . 'etablissement/factures/bordereaux?num=' . $bordereau['num_bordereau']; ?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
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
                                                'message' => "Aucun résultat correspondant à votre recherche n'a été trouvé."
                                            );
                                            echo '<p class="alert alert-primary">'.$json['message'].'</p>';
                                        }

                                    } else {
                                        $json = $audit;
                                    }
                                } else {
                                    $json = array(
                                        'success' => false,
                                        'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
                                    );
                                    echo '<p class="alert alert-primary">'.$json['message'].'</p>';
                                }
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Vous n'êtes pas habilité à effectuer cette action, veuillez SVP contacter votre administrateur."
                                );
                                echo '<p class="alert alert-primary">'.$json['message'].'</p>';
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur."
                            );
                            echo '<p class="alert alert-primary">'.$json['message'].'</p>';
                        }
                    } else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                        echo '<p class="alert alert-primary">'.$json['message'].'</p>';
                    }
                } else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                    echo '<p class="alert alert-primary">'.$json['message'].'</p>';
                }
            } else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
                echo '<p class="alert alert-primary">'.$json['message'].'</p>';
            }
        } else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
            echo '<p class="alert alert-primary">'.$json['message'].'</p>';
        }
    }
}
?>
<script>
    $("#table_bordereaux").DataTable();
</script>
