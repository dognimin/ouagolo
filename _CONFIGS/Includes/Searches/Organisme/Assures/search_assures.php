<?php
require_once '../../../../Functions/Functions.php';
require_once '../../../../Classes/UTILISATEURS.php';
$parametres = array(
    'num_population' => clean_data($_POST['num_population']),
    'num_secu' => clean_data($_POST['num_secu']),
    'nom_prenoms' => clean_data($_POST['nom_prenoms']),
    'code_collectivite' => clean_data($_POST['code_collectivite'])
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
                        $assures = $ORGANISMES->moteur_recherche_assures($organisme['code'], $parametres['num_population'], $parametres['num_secu'], $parametres['nom_prenoms'], $parametres['code_collectivite']);
                        $nb_assures = count($assures);
                        if($nb_assures) {
                            ?>
                            <table class="table table-sm table-bordered table-stripped table-hover" id="table_assures">
                                <thead class="bg-indigo text-white">
                                <tr>
                                    <th style="width: 5px">N°</th>
                                    <th style="width: 80px">N° I.P</th>
                                    <th style="width: 80px">N° SECU</th>
                                    <th style="width: 30px">CIVILITE</th>
                                    <th>NOM & PRENOM(S)</th>
                                    <th style="width: 110px">DATE NAISSANCE</th>
                                    <th>COLLECTIVITE</th>
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
                                        <td class="align_right"><?= $assure['num_population'];?></td>
                                        <td class="align_right"><?= $assure['num_rgb'];?></td>
                                        <td><?= $assure['code_civilite'];?></td>
                                        <td><?= $assure['nom'].' '.$assure['prenoms'];?></td>
                                        <td class="align_center"><?= date('d/m/Y', strtotime($assure['date_naissance']));?></td>
                                        <td><?= $assure['raison_sociale'];?></td>
                                        <td class="bg-info"><a href="<?= URL.'organisme/assures/?num='.$assure['num_population'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                    </tr>
                                    <?php
                                    $ligne++;
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php
                        }
                        else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucune collectivité ne correspond à votre recherche."
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

