<?php
if(isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'num_piece' => clean_data($_POST['num_piece']),
        'libelle' => clean_data($_POST['libelle']),
        'date_debut' => clean_data(date('Y-m-d 00:00:00', strtotime(str_replace('/', '-', $_POST['date_debut'])))),
        'date_fin' => clean_data(date('Y-m-d 23:59:59', strtotime(str_replace('/', '-', $_POST['date_fin']))))
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/POPULATIONS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $profil = $UTILISATEURS->trouver_profil($utilisateur['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($utilisateur['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ETABLISSEMENT ECRITURES COMPTABLES', json_encode($parametres));
                            if ($audit['success'] == true) {
                                if (!$_POST['date_debut'] && !$_POST['date_fin']) {
                                    $parametres['date_debut'] = date('Y-m-d', strtotime('-1 WEEK', time()));
                                    $parametres['date_fin'] = date('Y-m-d', time());
                                }
                                $ecritures = $ETABLISSEMENTS->moteur_recherche_ecritures_comptables($ets['code'], $parametres['num_piece'], $parametres['libelle'], $parametres['date_debut'], $parametres['date_fin']);
                                $nb_ecritures = count($ecritures);
                                if ($nb_ecritures != 0) {
                                    ?>
                                    <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_ecritures">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">#</th>
                                            <th style="width: 80px">DATE</th>
                                            <th style="width: 80px">TYPE</th>
                                            <th style="width: 80px">N° PIECE</th>
                                            <th>N° LIBELLE</th>
                                            <th style="width: 80px">MONTANT</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($ecritures as $ecriture) {
                                            ?>
                                            <tr style="background-color: <?= $ecriture['type'] == 'D'? 'rgba(255, 0, 0, 0.2)':'rgba(60, 179, 113, 0.2)';?>">
                                                <td class="align_right"><?= $ligne;?></td>
                                                <td class="align_center"><?= date('d/m/Y H:i', strtotime($ecriture['date_creation']));?></td>
                                                <td><?= $ecriture['type'] == 'D'?'DEPENSE': 'RECETTE';?></td>
                                                <td class="align_right"><strong><?= $ecriture['num_piece'];?></strong></td>
                                                <td><?= $ecriture['libelle'];?></td>
                                                <td class="align_right"><?= str_replace('D', '-', str_replace('R', '+', $ecriture['type'])).number_format($ecriture['montant'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                <td class="bg-secondary"><a href="<?= URL.'etablissement/comptabilite/?num='.$ecriture['num_piece'];?>" class="badge bg-secondary"><i class="bi bi-eye"></i></a></td>
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
                                        'message' => "Aucune écriture comptable trouvée."
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
    $("#table_ecritures").DataTable();
</script>
