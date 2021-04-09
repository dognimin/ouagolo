<?php
require_once "../../../Classes/UTILISATEURS.php";
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
                            include "../../Menu.php";
                            require_once "../../../Classes/TABLESDEVALEURS.php";
                            $TABLESDEVALEURS = new TABLESDEVALEURS();
                            $tables = $TABLESDEVALEURS->lister();
                            ?>
                            <nav id="nav_breadcrumb" style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= URL;?>">Accueil</a></li>
                                    <li class="breadcrumb-item"><a href="<?= URL.'parametres/';?>">Paramètres</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tables de valeurs</li>
                                </ol>
                            </nav>
                            <div class="container-xl" id="div_main_page">
                                <div class="row">
                                    <div class="col-sm-3" id="div_sidebar">
                                        <?php include "../_Forms/form_tables_de_valeurs.php";?>
                                    </div>
                                    <div class="col-sm" id="div_tables_de_valeurs">
                                        <div class="container">
                                            <div class="row g-3">
                                                <?php
                                                foreach ($tables as $table) {
                                                    ?>
                                                    <div class="col-4">
                                                        <div class="d-grid gap-2">
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
                            echo '<script src="'.JS.'page_parametres_tables_de_valeurs.js"></script>';
                            echo '<script src="'.JS.'deconnexion_1.js"></script>';
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