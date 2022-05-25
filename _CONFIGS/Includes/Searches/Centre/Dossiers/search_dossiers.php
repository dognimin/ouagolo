<?php

if(isset($_POST)) {
    $parametres = $_POST;
    require_once "../../../../Classes/UTILISATEURS.php";
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $utilisateur = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($utilisateur) {

                require_once "../../../../Classes/PATIENTS.php";
                $PATIENTS = new PATIENTS();
                $dossiers = $PATIENTS->monteur_recherche_dossier($parametres['num_secu'],$parametres['nip'],$parametres['num_dossier'],$parametres['date_debut'],$parametres['date_fin']);
                $nb_dossiers = count($dossiers);
                if ($nb_dossiers == 0){
                    echo '<p class="alert alert-info align_center">Aucun résultat correspondant à votre recherche n\'a été trouvé</p>';
                }else{
                    ?>
                    <table class="table table-bordered table-hover table-sm table-striped" >
                        <thead class="bg-info">
                        <tr>
                            <th width="5">N°</th>
                            <th width="80">N° Secu</th>
                            <th width="80">Nip</th>
                            <th width="150">Email</th>
                            <th>NOM & PRENOM(S)</th>
                            <th width="150">EMAIL</th>
                            <th width="5"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($dossiers as $dossier) {
                            ?>
                            <tr>
                                <td class="align_right"><?= $ligne;?></td>
                                <td><?= $dossier['num_secu'];?></td>
                                <td><?= $dossier['nip'];?></td>
                                <td><?= $dossier['nom'].' '.$dossier['prenoms'];?></td>
                                <td><?= $dossier['email'];?></td>
                                <td><a href="<?= URL.'etablissement/dossiers/details?code='.$dossier['code_patient'];?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
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
