<?php
if (isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'code_commande' => clean_data($_POST['code_commande']),
        'code_fournisseur' => clean_data($_POST['code_fournisseur']),
        'statut' => clean_data($_POST['statut']),
        'date_debut' => clean_data(date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date_debut'])))),
        'date_fin' => clean_data(date('Y-m-d', strtotime(str_replace('/', '-', $_POST['date_fin']))))
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
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ETABLISSEMENT FACTURES', json_encode($parametres));
                            if ($audit['success'] == true) {
                                if (!$_POST['date_debut'] && !$_POST['date_fin']) {
                                    $parametres['date_debut'] = date('Y-m-d', strtotime('-1 WEEK', time()));
                                    $parametres['date_fin'] = date('Y-m-d', time());
                                }
                                $commandes = $ETABLISSEMENTS->moteur_recherche_commandes($ets['code'], $parametres['code_commande'], $parametres['code_fournisseur'], $parametres['statut'], $parametres['date_debut'], $parametres['date_fin']);
                                $nb_commandes = count($commandes);
                                if ($nb_commandes != 0) {
                                    ?>
                                    <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_factures">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">#</th>
                                            <th style="width: 80px">DATE</th>
                                            <th style="width: 80px">N° COMMANDE</th>
                                            <th>FOURNISSEUR</th>
                                            <th style="width: 80px">MONTANT</th>
                                            <th style="width: 80px">STATUT</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($commandes as $commande) {
                                            ?>
                                            <tr>
                                                <td class="align_right"><?= $ligne;?></td>
                                                <td><?= date('d/m/Y', strtotime($commande['date_commande']));?></td>
                                                <td class="align_right"><strong><?= $commande['code'];?></strong></td>
                                                <td><?= $commande['libelle_fournisseur'];?></td>
                                                <td class="align_right"><?= number_format($commande['montant'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                <td class="text-<?= str_replace(
                                                    '0',
                                                    'warning',
                                                    str_replace(
                                                        '2',
                                                        'success',
                                                        str_replace('1', 'danger', $commande['statut'])
                                                    )
                                                                ); ?>"><strong><?= str_replace(
                                                    '0',
                                                    'EN COURS',
                                                    str_replace(
                                                                        '2',
                                                                        'RÉCEPTIONNÉ',
                                                                        str_replace('1', 'ANNULÉ', $commande['statut'])
                                                                    )
                                                );?></strong></td>
                                                <td class="bg-info"><a href="<?= URL.'etablissement/pharmacie/commandes?num='.$commande['code'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
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
                                        'message' => "Aucune commande trouvée."
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
    $("#table_factures").DataTable();
</script>
