<?php
require_once '../../../../../Functions/Functions.php';
require_once '../../../../../Classes/UTILISATEURS.php';
$parametres = array(
    'num_facture' => clean_data($_POST['num_facture']),
    'num_secu' => clean_data($_POST['num_secu']),
    'nom_prenoms' => clean_data($_POST['nom_prenoms']),
    'code_etablissement' => clean_data($_POST['code_etablissement']),
    'rubrique' => clean_data($_POST['rubrique'])
);
if(isset($_POST)) {
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
                        require_once "../../../../../Classes/FACTURESMEDICALES.php";
                        $FACTURESMEDICALES = new FACTURESMEDICALES();

                        $factures = $FACTURESMEDICALES->moteur_recherche_organisme_factures($organisme['code'], $parametres['rubrique'], $parametres['num_facture'], $parametres['num_secu'], $parametres['nom_prenoms'], $parametres['code_etablissement']);
                        $nb_factures = count($factures);
                        if($nb_factures !== 0) {
                            ?>
                            <table class="table table-sm table-bordered table-stripped table-hover border-dark">
                                <thead class="bg-indigo text-white">
                                <tr>
                                    <th style="width: 5px">#</th>
                                    <th style="width: 100px">DATE SOINS</th>
                                    <?= $parametres['rubrique'] == 'liquidation'? '<th style="width: 100px">DATE RECEPTION</th>': null;?>
                                    <th style="width: 50px">TYPE</th>
                                    <th style="width: 100px">N° FACTURE</th>
                                    <th style="width: 100px">N° BON</th>
                                    <th>ETABLISSEMENT</th>
                                    <th>NOM & PRENOM(S)</th>
                                    <th style="width: 5px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ligne = 1;
                                foreach ($factures as $facture) {
                                    ?>
                                    <tr>
                                        <td><?= $ligne;?></td>
                                        <td class="align_center"><?= date('d/m/Y', strtotime($facture['date_soins']));?></td>
                                        <?= $parametres['rubrique'] == 'liquidation'? '<td class="align_center">'.date('d/m/Y', strtotime($facture['date_reception'])).'</td>': null;?>
                                        <td><?= $facture['code_type_facture'];?></td>
                                        <td class="align_right"><strong><?= $facture['num_facture'];?></strong></td>
                                        <td class="align_right"><strong><?= $facture['num_bon'];?></strong></td>
                                        <td><?= $facture['raison_sociale'];?></td>
                                        <td><a href="<?= URL.'organisme/assures/?num='.$facture['num_population'];?>" target="_blank"><?= $facture['nom'].' '.$facture['prenoms'];?></a></td>
                                        <td class="<?= $parametres['rubrique'] == 'liquidation'? 'bg-info': null;?>">
                                            <?php
                                            if($parametres['rubrique'] == 'liquidation') {
                                                echo '<a class="badge bg-info" href="'.URL.'organisme/prestations/factures?r=liquidation&num='.$facture['num_facture'].'"><i class="bi bi-eye"></i></a>';
                                            }else {
                                                ?>
                                                <div class="form-switch">
                                                    <input class="form-check-input factures_recues" type="checkbox" role="switch" value="<?= $facture['num_facture'];?>" id="facture_<?= $facture['num_facture'];?>" aria-label="">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php
                        }else {
                            echo '<p class="align_center alert alert-info">Aucune facture correspondant à votre recherche n\'a été identifiée.</p>';
                        }
                    }
                    else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur."
                        );
                        echo '<p class="align_center alert alert-info">'.$json['message'].'</p>';
                    }
                }
                else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur."
                    );
                    echo '<p class="align_center alert alert-info">'.$json['message'].'</p>';
                }
            }
            else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié, veuillez SVP contacter votre administrateur."
                );
                echo '<p class="align_center alert alert-info">'.$json['message'].'</p>';
            }
        }
        else {
            $json = array(
                'success' => false,
                'message' => "Aucune session identifiée, veuillez SVP contacter votre administrateur."
            );
            echo '<p class="align_center alert alert-info">'.$json['message'].'</p>';
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session identifiée, veuillez SVP contacter votre administrateur."
        );
        echo '<p class="align_center alert alert-info">'.$json['message'].'</p>';
    }
}
?>
<script>
    $(".factures_recues").click(function () {
        //$("#resultats_p").hide();
        let id = this.id,
            tab = id.split('_'),
            num_facture = tab[1];
        if ($("#"+id).is(':checked')) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Prestations/Factures/submit_etat_verification.php',
                type: 'POST',
                data: {
                    'num_facture': num_facture,
                    'type': 1,
                },
                dataType: 'json',
                success: function (data) {
                    if(data['success'] === true) {
                        $("#"+id).closest("tr").addClass("bg-secondary text-white");
                    }else {

                    }
                }
            });
        }else {
            $.ajax({
                url: '../../_CONFIGS/Includes/Submits/Organisme/Prestations/Factures/submit_etat_verification.php',
                type: 'POST',
                data: {
                    'num_facture': num_facture,
                    'type': 0,
                },
                dataType: 'json',
                success: function (data) {
                    if(data['success'] === true) {
                        $("#"+id).closest("tr").removeClass("bg-secondary text-white");
                    }else {

                    }
                }
            });
        }
    });
</script>

