<?php
if(isset($_POST)) {
    require_once '../../../../Functions/Functions.php';
    require_once '../../../../Classes/UTILISATEURS.php';
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'libelle' => clean_data($_POST['libelle']),
        'nature' => clean_data($_POST['nature']),
        'type' => clean_data($_POST['type'])
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
                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE DOSSIERS PATIENTS', json_encode($parametres));
                            if ($audit['success'] == true) {
                                $produits = $ETABLISSEMENTS->moteur_recherche_produits($ets['code'], $parametres['code'], $parametres['libelle'], $parametres['nature'], $parametres['type']);
                                $nb_produits = count($produits);
                                if ($nb_produits != 0) {
                                    ?>
                                    <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_dossiers">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">#</th>
                                            <th style="width: 70px">NATURE</th>
                                            <th style="width: 100px">CODE</th>
                                            <th>LIBELLE</th>
                                            <th style="width: 40px">PERISSABLE</th>
                                            <th style="width: 70px">EN VENTE</th>
                                            <th style="width: 100px">STOCK CRITIQUE</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($produits as $produit) {
                                            ?>
                                            <tr>
                                                <td class="align_right"><?= $ligne;?></td>
                                                <td><?= str_replace('MED', 'MEDICAMENT', str_replace('AUT', 'AUTRE', $produit['nature']));?></td>
                                                <td><strong><?= $produit['code_produit'];?></strong></td>
                                                <td><?= $produit['libelle'];?></td>
                                                <td class="align_center"><i class="bi bi-<?= $produit['statut_perissable']? 'check2-all text-success':'x text-danger';?>"></i></td>
                                                <td class="align_center"><i class="bi bi-<?= $produit['statut_vente']? 'check2-all text-success':'x text-danger';?>"></i></td>
                                                <td class="align_right"><?= number_format($produit['limite_stock'], '0', '', ' ');?></td>
                                                <td class="bg-info"><a href="<?= URL.'etablissement/pharmacie/produits?code='.$produit['code_produit'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
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
    $("#table_dossiers").DataTable();
</script>
