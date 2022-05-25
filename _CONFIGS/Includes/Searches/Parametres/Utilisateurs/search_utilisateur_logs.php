<?php

if (isset($_POST)) {
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    require_once "../../../../Classes/ORGANISMES.php";
    require_once "../../../../Functions/Functions.php";
    $parametres = array(
        'id_user' => clean_data($_POST['id_user'])
    );
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'], null);
            if ($utilisateur) {
                $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], ACTIVE_URL, 'RECHERCHE LOGS UTILISATEUR(S)', json_encode($parametres));
                if($audit['success'] == true) {
                    $logs = $UTILISATEURS->lister_logs($parametres['id_user']);
                    $nb_logs = count($logs);
                    if($nb_logs != 0) {
                        ?>
                        <table class="table table-sm table-stripped table-hover bg-white text-dark">
                            <thead>
                            <tr>
                                <th>N°</th>
                                <th>DATE</th>
                                <th>ADRESSE IP</th>
                                <th>BROWSER</th>
                                <th>VERSION</th>
                                <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne_log = 1;
                            foreach ($logs as $log) {
                                ?>
                                <tr title="URL: <?= str_replace(URL, '', $log['url']);?>">
                                    <td class="align_right"><?= $ligne_log;?></td>
                                    <td><?= date('d/m/Y H:i:s',strtotime($log['date_reg']));?></td>
                                    <td><?= $log['adresse_ip'];?></td>
                                    <td><?= $log['navigateur'];?></td>
                                    <td><?= $log['navigateur_version'];?></td>
                                    <td><?= $log['action'];?></td>
                                </tr>
                                <?php
                                $ligne_log++;
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
