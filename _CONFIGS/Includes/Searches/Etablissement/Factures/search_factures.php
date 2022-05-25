<?php
if(isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'num_facture' => clean_data($_POST['num_facture']),
        'num_secu' => clean_data($_POST['num_secu']),
        'num_patient' => clean_data($_POST['num_patient']),
        'nom_prenom' => clean_data($_POST['nom_prenom']),
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
                                if (in_array('AFF_FCTS', $modules, true)) {
                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ETABLISSEMENT FACTURES', json_encode($parametres));
                                    if ($audit['success'] === true) {
                                        if (!$_POST['date_debut'] && !$_POST['date_fin']) {
                                            $parametres['date_debut'] = date('Y-m-d', strtotime('-1 WEEK', time()));
                                            $parametres['date_fin'] = date('Y-m-d', time());
                                        }
                                        $factures = $ETABLISSEMENTS->moteur_recherche_factures($ets['code'], $parametres['num_facture'], $parametres['num_secu'], $parametres['num_patient'], $parametres['nom_prenom'], $parametres['date_debut'], $parametres['date_fin']);
                                        $nb_factures = count($factures);
                                        if ($nb_factures !== 0) {
                                            ?>
                                            <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_factures">
                                                <thead class="bg-indigo text-white">
                                                <tr>
                                                    <th style="width: 5px">N°</th>
                                                    <th style="width: 80px">DATE HEURE</th>
                                                    <th style="width: 80px">N° DOSSIER</th>
                                                    <th style="width: 80px">N° FACTURE</th>
                                                    <th style="width: 80px">NIP</th>
                                                    <th style="width: 80px">N° SECU</th>
                                                    <th>NOM & PRENOM(S)</th>
                                                    <th style="width: 80px">MONTANT</th>
                                                    <?php
                                                    if (in_array('AFF_FCT', $sous_modules, true) || in_array('EDT_FCT', $sous_modules, true)) {
                                                        echo '<th style="width: 5px"></th>';
                                                    }
                                                    ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $ligne = 1;
                                                foreach ($factures as $facture) {
                                                    ?>
                                                    <tr>
                                                        <td class="align_right"><?= $ligne;?></td>
                                                        <td><?= date('d/m/Y H:i', strtotime($facture['date_creation']));?></td>
                                                        <td class="align_right"><strong><a href="<?= URL.'etablissement/dossiers/?num='.$facture['code_dossier'];?>" target="_blank"><?= $facture['code_dossier'];?></strong></a></td>
                                                        <td class="align_right"><strong><?= $facture['num_facture'];?></strong></td>
                                                        <td class="align_right"><a href="<?= URL.'etablissement/patients/?nip='.$facture['num_population'];?>" target="_blank"><strong><?= $facture['num_population'];?></strong></a></td>
                                                        <td class="align_right"><?= $facture['num_rgb'];?></td>
                                                        <td><?= $facture['nom'].' '.$facture['prenom'];?></td>
                                                        <td class="align_right"><?= number_format($facture['montant'],'0','',' ').' '.$ets['libelle_monnaie'];?></td>
                                                        <?php
                                                        if (in_array('AFF_FCT', $sous_modules, true) || in_array('EDT_FCT', $sous_modules, true)) {
                                                            ?>
                                                            <td class="<?= $facture['code_statut'] === 'P' ? 'bg-secondary':'bg-warning';?>"><a href="<?= URL.'etablissement/factures/?num='.$facture['num_facture'];?>" class="badge <?= $facture['code_statut'] === 'P' ? 'bg-secondary':'bg-warning';?>"><i class="<?= $facture['code_statut'] === 'P' ? 'bi bi-eye':'bi bi-pencil';?>"></i></a></td>
                                                            <?php
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
                                                'message' => "Aucune facture patient trouvée."
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
    $("#table_factures").DataTable();
</script>
