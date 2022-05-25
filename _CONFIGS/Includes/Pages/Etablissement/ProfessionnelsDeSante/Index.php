<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Functions/Functions.php";
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if ($_SESSION) {
    if (isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'], null);
            if ($user) {
                $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
                if ($user_statut) {
                    if ((int)$user_statut['statut'] === 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if ($user_mdp) {
                            if ((int)$user_mdp['statut'] === 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if ($profil['code_profil'] === 'ETABLI') {
                                        require_once "../../../../Classes/ETABLISSEMENTS.php";
                                        $ETABLISSEMENTS = new ETABLISSEMENTS();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                        if ($user_profil) {
                                            $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                            if ($ets) {
                                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                $nb_modules = count($modules);
                                                if ($nb_modules !== 0) {
                                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                    if (in_array('AFF_PFSS', $modules, true)) {
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] == true) {
                                                                include "../../../Menu.php";

                                                                require_once "../../../../Classes/SEXES.php";
                                                                require_once "../../../../Classes/CIVILITES.php";
                                                                require_once "../../../../Classes/PROFILSUTILISATEURS.php";
                                                                require_once "../../../../Classes/SPECIALITESMEDICALES.php";

                                                                $SEXES = new SEXES();
                                                                $CIVILITES = new CIVILITES();
                                                                $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                                                                $SPECIALITESMEDICALES = new SPECIALITESMEDICALES();

                                                                $civilites = $CIVILITES->lister();
                                                                $sexes = $SEXES->lister();
                                                                $profils = $PROFILSUTILISATEURS->lister();
                                                                $specialites_medicales = $SPECIALITESMEDICALES->lister();
                                                                $etablissements = $ETABLISSEMENTS->lister($ets['code'], null);

                                                                $professionnels = $ETABLISSEMENTS->lister_professionnels_de_sante($ets['code']);
                                                                $nb_professionnels = count($professionnels);
                                                                if (isset($_POST['code_ps']) && $_POST['code_ps']) {
                                                                    if (in_array('AFF_PFS', $sous_modules, true)) {
                                                                        $ps = $ETABLISSEMENTS->trouver_professionnel_de_sante($ets['code'], strtoupper($_POST['code_ps']));
                                                                        if ($ps) {
                                                                            ?>
                                                                            <div class="container-xl" id="div_main_page">
                                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                    <ol class="breadcrumb">
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/professionnels-de-sante/';?>"><i class="bi bi-person-rolodex"></i> Professionnels de santé</a></li>
                                                                                        <li class="breadcrumb-item active" aria-current="page"><?= $ps['nom'].' '.$ps['prenom'];?></li>
                                                                                    </ol>
                                                                                </nav>
                                                                                <p class="p_page_titre h4"><?= ucwords(strtolower($ps['code_civilite'] . '. ' .$ps['nom'] . ' ' . $ps['prenom']));?></p>
                                                                                <div id="div_profil">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-5">
                                                                                                    <table class="table table-bordered table-sm table-stripped table-hover">
                                                                                                        <tr>
                                                                                                            <td style="width: 150px"><strong>Statut</strong></td>
                                                                                                            <td>
                                                                                                                <div class="form-check form-switch"></div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><strong>Code RGB</strong></td>
                                                                                                            <td><?= $ps['code_rgb'];?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><strong>Civilité</strong></td>
                                                                                                            <td><?= $ps['code_civilite'];?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><strong>Nom</strong></td>
                                                                                                            <td><?= $ps['nom'];?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><strong>Prénom(s)</strong></td>
                                                                                                            <td><?= $ps['prenom'];?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><strong>Date de naissance</strong></td>
                                                                                                            <td><?= date('d/m/Y', strtotime($ps['date_naissance']));?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><strong>Sexe</strong></td>
                                                                                                            <td><?= $ps['code_sexe'];?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><strong>Spécialité médicale</strong></td>
                                                                                                            <td><?= $ps['libelle_specialite_medicale'];?></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td><strong>Email</strong></td>
                                                                                                            <td>
                                                                                                                <a href="mailto:<?= $ps['email']; ?>"><?= $ps['email'];?></a></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </div>
                                                                                                <div class="col-sm"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        } else {
                                                                            echo '<script>window.location.href="'.URL.'etablissement/professionnels-de-sante/"</script>';
                                                                        }
                                                                    } else {
                                                                        echo '<script>window.location.href="'.URL.'etablissement/professionnels-de-sante/"</script>';
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-rolodex"></i> Professionnels de santé</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <?php
                                                                        if (in_array('EDT_PFS', $sous_modules, true)) {
                                                                            ?>
                                                                            <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" title="Ajouter un professionnel de santé" data-bs-toggle="modal" data-bs-target="#editionPsModal"><i class="bi bi-person-workspace"></i></button></p>
                                                                            <div class="modal fade" id="editionPsModal" tabindex="-1" aria-labelledby="editionPsModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="editionConstantesModalLabel">Nouveau professionnel de santé</h5>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <?php include "../../_Forms/form_utilisateur.php";?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <p class="p_page_titre h4"><i class="bi bi-person-rolodex"></i> Professionnels de santé</p>
                                                                        <?php
                                                                        if ($nb_professionnels != 0) {
                                                                            ?>
                                                                            <table class="table table-sm table-bordered table-stripped table-hover" id="table_professionnels_sante">
                                                                                <thead class="bg-indigo text-white">
                                                                                <tr>
                                                                                    <th style="width: 5px">N°</th>
                                                                                    <th style="width: 10px">CODE</th>
                                                                                    <th style="width: 10px">CIVILITE</th>
                                                                                    <th>NOM</th>
                                                                                    <th>PRENOM</th>
                                                                                    <th>SPECIALITE MEDICALE</th>
                                                                                    <?php
                                                                                    if (in_array('AFF_PFS', $sous_modules, true)) {
                                                                                        echo '<th style="width: 5px"></th>';
                                                                                    }
                                                                                    ?>

                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php
                                                                                $ligne = 1;
                                                                                foreach ($professionnels as $professionnel) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td class="align_right"><?= $ligne;?></td>
                                                                                        <td><?= $professionnel['code_professionnel'];?></td>
                                                                                        <td><?= $professionnel['code_civilite'];?></td>
                                                                                        <td><?= $professionnel['nom'];?></td>
                                                                                        <td><?= $professionnel['prenom'];?></td>
                                                                                        <td><?= $professionnel['libelle_specialite_medicale'];?></td>
                                                                                        <?php
                                                                                        if (in_array('AFF_PFS', $sous_modules, true)) {
                                                                                            ?><td class="bg-info"><a href="<?= URL.'etablissement/professionnels-de-sante/?code='.strtolower($professionnel['code_professionnel']);?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td><?php
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
                                                                        } else {
                                                                            echo '<p class="align_center alert alert-info">Aucun profrssionnel de santé n\'a encore été enregistré.</p>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                echo '<script src="'.JS.'page_etablissement_professionnel_sante.js"></script>';
                                                                echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                            } else {
                                                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                            }
                                                        } else {
                                                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                        }
                                                    } else {
                                                        echo '<script>window.location.href="'.URL.'etablissement/"</script>';
                                                    }
                                                } else {
                                                    echo '<script>window.location.href="'.URL.'etablissement/"</script>';
                                                }
                                            } else {
                                                echo '<p class="alert alert-danger align_center">Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        } else {
                                            echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    } else {
                                        echo '<script>window.location.href="'.URL.'"</script>';
                                    }
                                } else {
                                    echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez contacter votre administrateur.</p>';
                                }
                            } else {
                                echo '<script>window.location.href="'.URL.'mot-de-passe"</script>';
                            }
                        } else {
                            session_destroy();
                            echo '<script>window.location.href="'.URL.'connexion"</script>';
                        }
                    } else {
                        session_destroy();
                        echo '<script>window.location.href="'.URL.'connexion"</script>';
                    }
                } else {
                    session_destroy();
                    echo '<script>window.location.href="'.URL.'connexion"</script>';
                }
            } else {
                session_destroy();
                echo '<script>window.location.href="'.URL.'connexion"</script>';
            }
        } else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
} else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}
