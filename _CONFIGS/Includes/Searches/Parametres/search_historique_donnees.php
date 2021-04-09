<?php
if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {
            if($parametres['type'] == 'put') {

            }elseif($parametres['type'] == 'csp') {
                require "../../../Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                $json = $CATEGORIESSOCIOPROFESSIONNELLES->lister_historique($parametres['donnee']);
                $nb_categories = count($json);
                if($nb_categories != 0) {
                    ?>
                    <table class="table table-bordered table-sm table-striped">
                        <thead class="bg-info">
                        <tr>
                            <th>N°</th>
                            <th>CODE</th>
                            <th>LIBELLE</th>
                            <th>DATE EFFET</th>
                            <th>DATE FIN</th>
                            <th>UTILISATEUR</th>
                            <th>DATE CREATION</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($json as $categorie) {
                            ?>
                            <tr <?php if(!$categorie['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                <td class="align_right"><?= $ligne;?></td>
                                <td><?= $categorie['code'];?></td>
                                <td><?= $categorie['libelle'];?></td>
                                <td class="align_center"><?= date('d/m/Y',strtotime($categorie['date_debut']));?></td>
                                <td class="align_center"><?php if($categorie['date_fin']){echo date('d/m/Y',strtotime($categorie['date_fin']));}?></td>
                                <td><?= $categorie['nom'].' '.$categorie['prenoms'];?></td>
                                <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($categorie['date_creation']));?></td>
                            </tr>
                            <?php
                            $ligne++;
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                }
            }elseif($parametres['type'] == 'civ') {

            }elseif($parametres['type'] == 'sex') {

            }elseif($parametres['type'] == 'sif') {

            }elseif($parametres['type'] == 'sct') {

            }elseif($parametres['type'] == 'prf') {

            }elseif($parametres['type'] == 'qtc') {

            }elseif($parametres['type'] == 'tco') {

            }elseif($parametres['type'] == 'tpi') {

            }elseif($parametres['type'] == 'dev') {

            }elseif($parametres['type'] == 'gsa') {

            }elseif($parametres['type'] == 'rhs') {

            }elseif($parametres['type'] == 'lge') {

            }elseif($parametres['type'] == 'reg') {

            }elseif($parametres['type'] == 'dep') {

            }elseif($parametres['type'] == 'com') {

            }else{
                $json = array(
                    'success' => false,
                    'message' => "Le type de données demandé est inconnu."
                );
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucun utilisateur identifié pour effectué cette action."
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
//echo json_encode($json);