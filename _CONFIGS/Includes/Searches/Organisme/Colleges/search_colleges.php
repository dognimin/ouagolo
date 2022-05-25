<?php
require_once '../../../../Functions/Functions.php';
require_once '../../../../Classes/UTILISATEURS.php';
$parametres = array(
    'annee' => clean_data($_POST['annee']),
    'raison_sociale' => clean_data($_POST['raison_sociale'])
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
                        $COLLEGES = new COLLEGES();
                        $colleges = $COLLEGES->moteur_recherche($organisme['code'], $parametres['annee'], $parametres['raison_sociale']);
                        $nb_colleges = count($colleges);
                        if($nb_colleges) {
                            ?>
                            <table class="table table-sm table-bordered table-stripped table-hover" id="table_colleges">
                                <thead class="bg-indigo text-white">
                                <tr>
                                    <th style="width: 5px">N°</th>
                                    <th>POLICE</th>
                                    <th style="width: 90px">DATE DEBUT</th>
                                    <th style="width: 90px">DATE FIN</th>
                                    <th style="width: 150px">CODE</th>
                                    <th>LIBELLE</th>
                                    <th style="width: 5px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ligne = 1;
                                foreach ($colleges as $college) {
                                    ?>
                                    <tr>
                                        <td class="align_right"><?= $ligne;?></td>
                                        <td><a target="_blank" href="<?= URL.'organisme/polices/?id='.strtolower($college['id_police']);?>"><b><?= $college['libelle_police'];?></b></a></td>
                                        <td class="align_center"><?= date('d/m/Y',strtotime($college['date_debut']));?></td>
                                        <td class="align_center"><?= $college['date_fin']? date('d/m/Y',strtotime($college['date_fin'])): null;?></td>
                                        <td><strong><?= $college['code'];?></strong></td>
                                        <td><?= $college['libelle'];?></td>
                                        <td class="bg-info"><a class="badge bg-info" href="<?= URL.'organisme/colleges/?id-police='.$college['id_police'].'&code='.$college['code'];?>"><i class="bi bi-eye-fill"></i></a></td>
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
    $("#table_colleges").DataTable();
</script>

