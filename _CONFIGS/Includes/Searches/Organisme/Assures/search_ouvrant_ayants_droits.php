<?php
require_once '../../../../Functions/Functions.php';
require_once '../../../../Classes/UTILISATEURS.php';
$parametres = array(
    'code_contrat' => clean_data($_POST['code_contrat']),
    'nip_contractant' => clean_data($_POST['nip_contractant']),
    'code_qualite_civile' => clean_data($_POST['code_qualite_civile'])
);
if(isset($_POST)) {
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                if($user_profil) {
                    $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                    if($organisme) {
                        require_once "../../../../Classes/COLLEGES.php";
                        $CONTRATS = new COLLEGES();
                        $contrat = $CONTRATS->trouver($organisme['code'], $parametres['code_contrat']);
                        if($contrat){
                            if($parametres['code_qualite_civile'] === 'PAY') {
                                $assures = $CONTRATS->lister_assures_couverts($organisme['code'], $contrat['code'], $parametres['nip_contractant']);
                                $nb_assures = count($assures);
                                if($nb_assures != 0) {
                                    ?>
                                    <table class="table table-bordered table-sm table-hover table-stripped">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">#</th>
                                            <th style="width: 110px">N° I.P</th>
                                            <th style="width: 110px">N° SECU</th>
                                            <th>NOM & PRENOM(S)</th>
                                            <th style="width: 110px">DATE NAISSANCE</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ligne = 1;
                                        foreach ($assures as $assure) {
                                            ?>
                                            <tr>
                                                <td class="align_right"><?= $ligne;?></td>
                                                <td><?= $assure['num_population'];?></td>
                                                <td><?= $assure['num_rgb'];?></td>
                                                <td><?= $assure['nom'].' '.$assure['prenoms'];?></td>
                                                <td class="align_center"><?= date('d/m/Y', strtotime($assure['date_naissance']));?></td>
                                                <td class="bg-info"><a href="<?= URL.'organisme/assures/?num='.$assure['num_population'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
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
                                        'message' => "Aucun ayant-droit n'a encore été enregistré pour cet assuré."
                                    );
                                    echo '<p class="align_center alert alert-info">'.$json['message'].'</p>';
                                }
                            } else {
                                $assure = $CONTRATS->trouver_assure($organisme['code'], $contrat['code'], $parametres['nip_contractant']);
                                if($assure) {
                                    ?>
                                    <table class="table table-bordered table-sm table-hover table-stripped">
                                        <thead class="bg-indigo text-white">
                                        <tr>
                                            <th style="width: 5px">#</th>
                                            <th style="width: 110px">N° I.P</th>
                                            <th style="width: 110px">N° SECU</th>
                                            <th>NOM & PRENOM(S)</th>
                                            <th style="width: 110px">DATE NAISSANCE</th>
                                            <th style="width: 5px"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="align_right">1</td>
                                            <td><?= $assure['num_population'];?></td>
                                            <td><?= $assure['num_rgb'];?></td>
                                            <td><?= $assure['nom'].' '.$assure['prenoms'];?></td>
                                            <td class="align_center"><?= date('d/m/Y', strtotime($assure['date_naissance']));?></td>
                                            <td class="bg-info"><a href="<?= URL.'organisme/assures/?num='.$assure['num_population'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                }
                            }
                        }else {
                            $json = array(
                                'success' => false,
                                'message' => "Le contrat sélectionné est incorrect, veuillez SVP contacter votre administrateur."
                            );
                            echo '<p class="align_center alert alert-info">'.$json['message'].'</p>';
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
    $("#table_assures").DataTable();
</script>

