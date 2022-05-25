<?php

if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    require_once "../../../../Classes/ORGANISMES.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'code_profil' => clean_data($_POST['code_profil']),
        'email' => clean_data($_POST['email']),
        'num_secu' => clean_data($_POST['num_secu']),
        'nom_prenoms' => clean_data($_POST['nom_prenoms'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE UTILISATEUR(S)', json_encode($parametres));
                if($audit['success'] == true) {
                    $utilisateurs = $UTILISATEURS->monteur_recherche($parametres['code_profil'], $parametres['email'], $parametres['num_secu'], $parametres['nom_prenoms']);
                    $nb_utilisateurs = count($utilisateurs);
                    if ($nb_utilisateurs == 0) {
                        echo '<p class="alert alert-info align_center">Aucun résultat correspondant à votre recherche n\'a été trouvé</p>';
                    }
                    else {
                        $ETABLISSEMENTS = new ETABLISSEMENTS();
                        $ORGANISMES = new ORGANISMES();
                        ?>
                        <table class="table table-bordered table-hover table-sm table-striped" id="table_utilisateurs">
                            <thead class="bg-secondary">
                            <tr>
                                <th style="width: 5px">N°</th>
                                <th style="width: 80px">N° SECU</th>
                                <th style="width: 80px">PROFIL</th>
                                <th>NOM & PRENOM(S)</th>
                                <th>EMAIL</th>
                                <th style="width: 5px"><i class="bi bi-person-fill"></i></th>
                                <th style="width: 5px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($utilisateurs as $util) {
                                ?>
                                <tr>
                                    <td class="align_right"><?= $ligne; ?></td>
                                    <td><?= $util['num_secu']; ?></td>
                                    <td><?= $util['libelle_profil']; ?></td>
                                    <td><?= $util['nom'] . ' ' . $util['prenoms']; ?></td>
                                    <td><strong><a href="mailto:<?= $util['email']; ?>"><?= $util['email']; ?></a></strong></td>
                                    <td class="align_center h6"><i class="<?= str_replace(1, 'bi bi-person-check-fill text-success', str_replace(0, 'bi bi-person-x-fill text-danger', $util['statut']));?>"></i></td>
                                    <td><a href="<?= URL . 'parametres/utilisateurs/?uid=' . $util['id_user']; ?>" class="badge bg-info"><i class="bi bi-eye-fill"></i></a></td>
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
                        'message' => "Une erreur est survenue lors de la mise à jour de la piste daudit. Veuillez contacter votre administrateur SVP."
                    );
                    echo '<p class="alert alert-danger align_center">'.$json['message'].'</p>';
                }
            } else {
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
    } else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
        echo '<p class="alert alert-danger align_center">'.$json['message'].'</p>';
    }
} else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
    echo '<p class="alert alert-danger align_center">'.$json['message'].'</p>';
}
?>
<script>
    $("#table_utilisateurs").DataTable();
</script>
