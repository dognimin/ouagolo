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
                $patients = $PATIENTS->monteur_recherche($parametres['num_secu'],$parametres['assurance'],$parametres['nom_prenoms']);
                $nb_patients = count($patients);
                if ($nb_patients == 0){
                    echo '<p class="alert alert-info align_center">Aucun résultat correspondant à votre recherche n\'a été trouvé</p>';
                }else{
                    ?>
                    <table class="table table-bordered table-hover table-sm table-striped" >
                        <thead class="bg-info">
                        <tr>
                            <th width="5">N°</th>
                            <th width="80">N° SECU</th>
                            <th width="150">N° ASSURANCE</th>
                            <th width="300">NOM & PRENOM(S)</th>
                            <th width="5"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ligne = 1;
                        foreach ($patients as $patient) {
                            ?>
                            <tr>
                                <td class="align_right"><?= $ligne;?></td>
                                <td><?= $patient['num_secu'];?></td>
                                <td class="align_center"><?= $patient['num_assurance'];?></td>
                                <td><?= $patient['nom'].' '.$patient['prenoms'];?></td>
                                <td><a href="<?= URL.'etablissement/patients/details?code='.$patient['code_patient'];?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
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
