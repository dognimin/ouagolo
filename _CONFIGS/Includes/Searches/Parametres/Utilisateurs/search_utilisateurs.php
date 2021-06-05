<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {

                require_once "../../../../Classes/UTILISATEURS.php";
                $UTILISATEURS = new UTILISATEURS();
                $utilisateurs = $UTILISATEURS->monteur_recherche($parametres['email'],$parametres['num_secu'],$parametres['nom_utilisateur'],$parametres['nom_prenoms']);
                $nb_utilisateurs = count($utilisateurs);
                if ($nb_utilisateurs == 0){
                    echo '<p class="alert alert-info align_center">Aucun résultat correspondant à votre recherche n\'a été trouvé</p>';
                }else{
                    ?>
                    <table class="table table-bordered table-hover table-sm table-striped" >
                        <thead class="bg-info">
                        <tr>
                            <th width="5">N°</th>
                            <th width="80">N° SECU</th>
                            <th width="150">NOM UTILISATEUR</th>
                            <th>NOM & PRENOM(S)</th>
                            <th width="150">EMAIL</th>
                            <th width="5"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($utilisateurs as $utilisateur) {
                            ?>
                            <tr>
                                <td class="align_right"><?= $ligne;?></td>
                                <td><?= $utilisateur['num_secu'];?></td>
                                <td><?= $utilisateur['pseudo'];?></td>
                                <td><?= $utilisateur['nom'].' '.$utilisateur['prenoms'];?></td>
                                <td><?= $utilisateur['email'];?></td>
                                <td><a href="<?= URL.'parametres/utilisateurs/details?uid='.$utilisateur['id_user'];?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
                            </tr>
                            <?php
                            $ligne++;
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php

                }


    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else{
        $json = count($parametres);
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
