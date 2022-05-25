<?php

if(isset($_POST)) {
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Functions/Functions.php";
    $parametres = array(
        'code' => clean_data($_POST['code']),
        'code_rgb' => clean_data($_POST['code_rgb']),
        'libelle' => clean_data($_POST['libelle']),
        'code_pays' => clean_data($_POST['code_pays'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                require_once "../../../Classes/ORGANISMES.php";
                $ORGANISMES = new ORGANISMES();
                $organismes = $ORGANISMES->moteur_recherche($parametres['code'],$parametres['code_rgb'],$parametres['libelle'],$parametres['code_pays']);
                $nb_organismes = count($organismes);
                if ($nb_organismes == 0){
                    echo '<p class="alert alert-info align_center">Aucun résultat correspondant à votre recherche n\'a été trouvé</p>';
                }
                else{
                    ?>
                    <table class="table table-bordered table-hover table-sm table-striped" id="table_organismes">
                        <thead class="bg-secondary">
                        <tr>
                            <th style="width: 5px">N°</th>
                            <th style="width: 80px">CODE</th>
                            <th style="width: 80px">CODE RGB</th>
                            <th>LIBELLE</th>
                            <th>PAYS</th>
                            <th>REGION</th>
                            <th>DEPARTEMENT</th>
                            <th>COMMUNE</th>
                            <th style="width: 5px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($organismes as $organisme) {
                            ?>
                            <tr>
                                <td class="align_right"><?= $ligne;?></td>
                                <td><strong><?= $organisme['code'];?></strong></td>
                                <td><?= $organisme['code_rgb'];?></td>
                                <td><?= $organisme['libelle'];?></td>
                                <td><?= $organisme['nom_pays'];?></td>
                                <td><?= $organisme['nom_region'];?></td>
                                <td><?= $organisme['nom_departement'];?></td>
                                <td><?= $organisme['nom_commune'];?></td>
                                <td><a href="<?= URL.'organismes/?code='.strtolower($organisme['code']);?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
                            </tr>
                            <?php
                            $ligne++;
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                }
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
            echo '<p class="alert alert-danger align_center">'.$json['message'].'</p>';
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
        echo '<p class="alert alert-danger align_center">'.$json['message'].'</p>';
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
    echo '<p class="alert alert-danger align_center">'.$json['message'].'</p>';
}
?>
<script>
    $("#table_organismes").DataTable();
</script>
