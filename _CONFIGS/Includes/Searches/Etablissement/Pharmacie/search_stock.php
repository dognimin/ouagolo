<?php
if (isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'code_produit' => clean_data($_POST['code_produit']),
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
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE ETABLISSEMENT FACTURES', json_encode($parametres));
                            if ($audit['success'] === true) {
                                if (!$_POST['date_debut'] && !$_POST['date_fin']) {
                                    $parametres['date_debut'] = date('Y-m-d', strtotime('-1 WEEK', time()));
                                    $parametres['date_fin'] = date('Y-m-d', time());
                                }
                                $produits = $ETABLISSEMENTS->moteur_recherche_stock($ets['code'], $parametres['code_produit'], $parametres['date_debut'], $parametres['date_fin']);
                                $nb_produits = count($produits);
                                if ($nb_produits !== 0) {
                                    ?>
                                    <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_factures">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">#</th>
                                            <th style="width: 80px">CODE</th>
                                            <th>DESIGNATION</th>
                                            <th style="width: 80px">PERISSABLE</th>
                                            <th style="width: 80px">PRIX VENTE</th>
                                            <th style="width: 70px">QTE SCTE</th>
                                            <th style="width: 50px">QTE RSTE</th>
                                            <th style="width: 70px">MT. STOCK</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($produits as $produit) {
                                            ?>
                                            <tr class="<?php if ($produit['quantite_restante'] === 0) {
                                                echo 'bg-danger text-white';
                                                       } elseif ($produit['quantite_restante'] <= $produit['stock_securite']) {
                                                           echo 'bg-warning';
                                                       }?>">
                                                <td class="align_right"><?= $ligne;?></td>
                                                <td><?= $produit['code'];?></td>
                                                <td><?= $produit['libelle'];?></td>
                                                <td><?= str_replace(0, 'NON', str_replace(1, 'OUI', $produit['statut_perissable']));?></td>
                                                <td class="align_right"><?= number_format($produit['prix_vente'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                <td class="align_right"><strong><?= number_format($produit['stock_securite'], '0', '', ' ');?></strong></td>
                                                <td class="align_right"><strong class="<?= $produit['quantite_restante'] > $produit['stock_securite']? 'text-success': '';?>"><?= number_format($produit['quantite_restante'], '0', '', ' ');?></strong></td>
                                                <td class="align_right"><?= number_format(($produit['quantite_restante'] * $produit['prix_vente']), '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                <td></td>
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
                                        'message' => "Aucun produit trouvé."
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
