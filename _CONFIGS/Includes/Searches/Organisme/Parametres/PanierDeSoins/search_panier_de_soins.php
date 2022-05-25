<?php
require_once '../../../../../Functions/Functions.php';
require_once '../../../../../Classes/UTILISATEURS.php';
if (isset($_SESSION['nouvelle_session'])) {
    $UTILISATEURS = new UTILISATEURS();
    $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
    if ($session) {
        $user = $UTILISATEURS->trouver($session['id_user'], null);
        if ($user) {
            require_once "../../../../../Classes/ORGANISMES.php";
            $ORGANISMES = new ORGANISMES();
            $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
            if($user_profil) {
                $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                if($organisme) {
                    require_once "../../../../../Classes/PANIERSDESOINS.php";
                    $PANIERSDESOINS = new PANIERSDESOINS();
                    $parametres = array(
                        'type_donnee' => clean_data($_POST['type_donnee']),
                        'code_panier' => clean_data($_POST['code_panier'])
                    );
                    $panier = $PANIERSDESOINS->trouver($organisme['code'], $parametres['code_panier']);
                    if($panier) {
                       ?>
                        <div class="table-responsive">
                            <?php
                            if($parametres['type_donnee'] == 'btn_afficher_actes') {
                                $actes = $PANIERSDESOINS->lister_panier_actes_medicaux($panier['code']);
                                $nb_actes = count($actes);
                                if($nb_actes != 0) {
                                    ?>
                                    <table class="table table-bordered table-sm table-stripped table-hover align-middle" id="table_paniers_de_soins">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">N°</th>
                                            <th style="width: 70px">CODE</th>
                                            <th>LIBELLE</th>
                                            <th style="width: 70px">TARIF</th>
                                            <th style="width: 5px">EP</th>
                                            <th style="width: 70px">DATE EFFET</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($actes as $acte) {
                                            ?>
                                            <tr>
                                                <td class="align_right"><?= $ligne;?></td>
                                                <td><strong><?= $acte['code_acte'];?></strong></td>
                                                <td><?= $acte['libelle_acte'];?></td>
                                                <td class="align_right"><?= number_format($acte['tarif'], '0', '', ' ').' '.$organisme['symbole_monnaie'];?></td>
                                                <td class="align_center"><strong class="text-<?= ((int)$acte['statut_ep'] === 1)? 'warning': 'primary';?>"><i class="bi bi-<?= ((int)$acte['statut_ep'] === 1)? 'bell-fill': 'bell-slash-fill';?>"></i></strong></td>
                                                <td class="align_center"><?= date('d/m/Y',strtotime($acte['date_debut']));?></td>
                                                <td class="align_center"><a href=""><i class="bi bi-x"></i></a></td>
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
                                        'message' => "Aucun acte médical n'a encore été enregistré pour ce panier de soins."
                                    );
                                    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                                }
                            }
                            elseif($parametres['type_donnee'] == 'btn_afficher_medicaments') {
                                $medicaments = $PANIERSDESOINS->lister_panier_medicaments($panier['code']);
                                $nb_medicaments = count($medicaments);
                                if($nb_medicaments != 0) {
                                    ?>
                                    <table class="table table-bordered table-sm table-stripped table-hover align-middle" id="table_paniers_de_soins">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">N°</th>
                                            <th style="width: 70px">CODE</th>
                                            <th>LIBELLE</th>
                                            <th style="width: 70px">TARIF</th>
                                            <th style="width: 70px">DATE EFFET</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($medicaments as $medicament) {
                                            ?>
                                            <tr>
                                                <td><?= $ligne;?></td>
                                                <td><?= $medicament['code_medicament'];?></td>
                                                <td><?= $medicament['libelle_medicament'];?></td>
                                                <td class="align_right"><?= number_format($medicament['tarif'], '0', '', ' ').' '.$organisme['symbole_monnaie'];?></td>
                                                <td class="align_center"><?= date('d/m/Y',strtotime($medicament['date_debut']));?></td>
                                                <td class="align_center"><a href=""><i class="bi bi-x"></i></a></td>
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
                                        'message' => "Aucun médicament n'a encore été enregistré pour ce panier de soins."
                                    );
                                    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                                }
                            }
                            elseif($parametres['type_donnee'] == 'btn_afficher_pathologies') {
                                $pathologies = $PANIERSDESOINS->lister_panier_pathologies($panier['code']);
                                $nb_pathologies = count($pathologies);
                                if($nb_pathologies != 0) {
                                    ?>
                                    <table class="table table-bordered table-sm table-stripped table-hover align-middle" id="table_paniers_de_soins">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">N°</th>
                                            <th style="width: 70px">CODE</th>
                                            <th>LIBELLE</th>
                                            <th style="width: 70px">DATE EFFET</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($pathologies as $pathologie) {
                                            ?>
                                            <tr>
                                                <td><?= $ligne;?></td>
                                                <td><?= $pathologie['code_pathologie'];?></td>
                                                <td><?= $pathologie['libelle_pathologie'];?></td>
                                                <td class="align_center"><?= date('d/m/Y',strtotime($pathologie['date_debut']));?></td>
                                                <td class="align_center"><a href=""><i class="bi bi-x"></i></a></td>
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
                                        'message' => "Aucune pathologie n'a encore été enregistrée pour ce panier de soins."
                                    );
                                    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                                }
                            }
                            else {

                            }
                            ?>
                        </div>
                        <?php
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucune collectivité ne correspond à votre recherche."
                        );
                        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                    }
                }
            }
        }
    }
}
?>
<script>
    $("#table_paniers_de_soins").dataTable();
</script>
