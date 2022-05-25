<?php
if(isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'nip' => clean_data($_POST['nip']),
        'num_secu' => clean_data($_POST['num_secu']),
        'nom_prenom' => clean_data($_POST['nom_prenom'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                require_once "../../../../Classes/ETABLISSEMENTS.php";
                require_once "../../../../Classes/POPULATIONS.php";
                $ETABLISSEMENTS = new ETABLISSEMENTS();
                $POPULATIONS = new POPULATIONS();
                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                if ($profil) {
                    $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                    if ($user_profil) {
                        $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                        if ($ets) {
                            $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                            $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                            $nb_modules = count($modules);
                            if ($nb_modules !== 0) {
                                $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE PATIENTS', json_encode($parametres));
                                if ($audit['success'] === true) {
                                    $patients = $ETABLISSEMENTS->moteur_recherche_patient($ets['code'], $parametres['nip'], $parametres['num_secu'], null, $parametres['nom_prenom']);
                                    $nb_patients = count($patients);
                                    if ($nb_patients !== 0) {
                                        ?>
                                        <table class="table table-sm table-stripped table-hover table-bordered border-dark" id="table_patients">
                                            <thead class="bg-indigo text-white">
                                            <tr>
                                                <th style="width: 5px">N°</th>
                                                <th style="width: 120px">DATE INSCRIPTION</th>
                                                <th style="width: 100px">N° IP</th>
                                                <th style="width: 100px">N° SECU</th>
                                                <th style="width: 10px">CIVILITE</th>
                                                <th>NOM & PRENOM (S)</th>
                                                <th style="width: 10px">SEXE</th>
                                                <th style="width: 120px">DATE NAISSANCE</th>
                                                <?php
                                                if (in_array('AFF_PT', $sous_modules, true)) {
                                                    echo '<th style="width: 5px"></th>';
                                                }
                                                ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $ligne = 1;
                                            foreach ($patients as $patient) {
                                                ?>
                                                <tr>
                                                    <td class="align_right"><?= $ligne;?></td>
                                                    <td class="align_center"><?= date('d/m/Y',strtotime($patient['date_debut']));?></td>
                                                    <td><strong><?= $patient['num_population'];?></strong></td>
                                                    <td><?= $patient['num_rgb'];?></td>
                                                    <td><?= $patient['code_civilite'];?></td>
                                                    <td><?= $patient['nom'].' '.$patient['prenom'];?></td>
                                                    <td><?= $patient['code_sexe'];?></td>
                                                    <td class="align_center"><?= date('d/m/Y',strtotime($patient['date_naissance']));?></td>
                                                    <?php
                                                    if (in_array('AFF_PT', $sous_modules, true)) {
                                                        ?><td class="bg-info"><a href="<?= URL.'etablissement/patients/?nip='.$patient['num_population'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td><?php
                                                    }
                                                    ?>
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
                                            'message' => "Aucun résultat ne correspond à votre recherche."
                                        );
                                        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                                    }
                                }else {
                                    $json = $audit;
                                }
                            } else {
                                $json = array(
                                    'success' => false,
                                    'message' => "Vous ne disposez d'aucune habilitation pour accéder à cette ressource, veuillez SVP contacter votre administrateur."
                                );
                                echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                            }
                        } else {
                            $json = array(
                                'success' => false,
                                'message' => "Aucun établissement correspondant à votre profil n'a été identifié, veuillez SVP contacter votre administrateur."
                            );
                            echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                        }
                    }else {
                        $json = array(
                            'success' => false,
                            'message' => "Aucun utilisateur identifié pour effectué cette action."
                        );
                        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                    }
                }else {
                    $json = array(
                        'success' => false,
                        'message' => "Aucun utilisateur identifié pour effectué cette action."
                    );
                    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
                echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
            echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
        echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
    echo '<p class="alert alert-info align_center">'.$json['message'].'</p>';
}
?>
<script>
    $("#table_patients").dataTable();
</script>
