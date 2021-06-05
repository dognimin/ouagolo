<?php
require_once "../../../../Classes/UTILISATEURS.php";
if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $user = $UTILISATEURS->trouver($_SESSION['nouvelle_session'],null,null);
        if($user) {
            $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
            if($user_statut) {
                if($user_statut['statut'] == 1) {
                    $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                    if($user_mdp) {
                        if($user_mdp['statut'] == 1) {
                            include "../../../Menu.php";
                            require_once "../../../../Classes/PATHOLOGIES.php";
                            $PATHOLOGIES = new PATHOLOGIES();
                            $tables = $PATHOLOGIES->lister_referentiels();
                            ?>
                            <div class="container-xl" id="div_main_page">
                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= URL;?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL.'parametres/';?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                        <li class="breadcrumb-item"><a href="<?= URL.'parametres/referentiels/';?>"><i class="bi bi-clipboard-plus"></i> Référentiels</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Pathologies</li>
                                    </ol>
                                </nav>
                                <p class="p_page_titre h4">Pathologies</p>
                                <div class="row">
                                    <div class="col-sm-3" id="div_sidebar">
                                        <?php include "../../_Forms/form_referentiels.php";?>
                                    </div>
                                    <div class="col-sm" id="div_referentiels_pathologies">
                                        <div class="container">
                                            <div class="row">
                                                <?php
                                                foreach ($tables as $table) {
                                                    ?>
                                                    <div class="col-sm-4">
                                                        <div class="d-grid div_boxes">
                                                            <button class="btn btn-primary btn-sm button_table_de_valeur" id="<?= $table['code'];?>" type="button"><?= $table['libelle'];?></button>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            echo '<script src="'.JS.'deconnexion_2.js"></script>';
                            echo '<script src="'.JS.'page_parametres_pathologies.js"></script>';
                        }else {

                            echo '<script>window.location.href="'.URL.'mot-de-passe"</script>';
                        }
                    }else {
                        session_destroy();
                        echo '<script>window.location.href="'.URL.'connexion"</script>';
                    }
                }else {
                    session_destroy();
                    echo '<script>window.location.href="'.URL.'connexion"</script>';
                }
            }else {
                session_destroy();
                echo '<script>window.location.href="'.URL.'connexion"</script>';
            }
        }else {
            session_destroy();
            echo '<script>window.location.href="'.URL.'connexion"</script>';
        }
    }else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
}else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}