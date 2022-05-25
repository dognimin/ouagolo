<?php
require_once "../../../../../Classes/UTILISATEURS.php";
require_once "../../../../../Classes/MEDICAMENTS.php";
$MEDICAMENTS = new MEDICAMENTS();
if(isset($_POST['code'])) {
    require_once "../../../../../Functions/Functions.php";
    $parametres = array(
        'url' => clean_data($_POST['url']),
        'code' => clean_data($_POST['code'])
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
                        if ($user_statut['statut'] == 1) {
                            $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                            if ($user_mdp) {
                                if ($user_mdp['statut'] == 1) {
                                    $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                    if ($profil) {
                                        if ($profil['code_profil'] == 'ADMN') {
                                            $medicament = $MEDICAMENTS->trouver($parametres['code']);
                                            if($medicament) {
                                                $dci = $MEDICAMENTS->trouver_dci($medicament['code_dci']);
                                                $dci_dosages = $MEDICAMENTS->lister_dci_dosages($dci['code']);
                                                if (isset($parametres['url'])) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                    if ($audit['success'] == true) {
                                                        include "../../../../Menu.php";
                                                        ?>
                                                        <div class="container-xl" id="div_main_page">
                                                            <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                <ol class="breadcrumb">
                                                                    <li class="breadcrumb-item"><a href="<?= URL; ?>"><i class="bi bi-house-door-fill"></i> Accueil</a></li>
                                                                    <li class="breadcrumb-item"><a href="<?= URL . 'parametres/'; ?>"><i class="bi bi-gear-wide-connected"></i> Paramètres</a></li>
                                                                    <li class="breadcrumb-item"><a href="<?= URL . 'parametres/referentiels/'; ?>"><i class="bi bi-clipboard-plus"></i> Référentiels</a></li>
                                                                    <li class="breadcrumb-item"><a href="<?= URL . 'parametres/referentiels/medicaments'; ?>"><i class="bi bi-clipboard-plus"></i> Médicaments</a></li>
                                                                    <li class="breadcrumb-item active" aria-current="page"><?= $medicament['libelle'];?></li>
                                                                </ol>
                                                            </nav>
                                                            <p class="p_page_titre h4"><?= $medicament['libelle'];?></p>
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <div class="card border-dark">
                                                                        <div class="card-body">
                                                                            <p class="align_right"><button type="button" class="btn btn-warning btn-sm" title="Edition du médicament"><i class="bi bi-pen"></i></button></p>
                                                                            <table class="table table-bordered table-sm table-stripped table-hover">
                                                                                <tr>
                                                                                    <td>Code</td>
                                                                                    <td><strong><?= $medicament['code'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Code EAN 13</td>
                                                                                    <td><strong><?= $medicament['code_ean13'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Libllé</td>
                                                                                    <td><strong><?= $medicament['libelle'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Type</td>
                                                                                    <td><strong><?= $medicament['libelle_type'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Présentation primaire</td>
                                                                                    <td><strong><?= $medicament['libelle_presentation_primaire'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Présentation secondaire</td>
                                                                                    <td><strong><?= $medicament['libelle_presentation_secondaire'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Laboratoire</td>
                                                                                    <td><strong><?= $medicament['libelle_laboratoire'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>DCI</td>
                                                                                    <td><strong class="text-primary"><?= $medicament['libelle_dci'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Groupe</td>
                                                                                    <td><strong><?= $dci['libelle_groupe'].' / '.$dci['libelle_sous_groupe'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Classe thérapeutique</td>
                                                                                    <td><strong><?= $dci['libelle_classe'].' / '.$dci['libelle_sous_classe'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Forme</td>
                                                                                    <td><strong><?= $dci['libelle_forme'];?></strong></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Dosage</td>
                                                                                    <td>
                                                                                        <strong>
                                                                                            <?php foreach ($dci_dosages as $dci_dosage) {
                                                                                                echo $dci_dosage['dosage'].$dci_dosage['unite'];
                                                                                            } ?>
                                                                                        </strong>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <?php
                                                                    $notice = $MEDICAMENTS->trouver_notice($medicament['code']);
                                                                    ?>
                                                                    <div class="card border-dark">
                                                                        <div class="card-body">
                                                                            <p class="align_right"><button type="button" class="btn btn-warning btn-sm" title="Edition de la notice"><i class="bi bi-pen"></i></button></p>
                                                                            <div class="accordion" id="accordionExample">
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingOne">
                                                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                                            Indications
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['indications'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingTwo">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                                            Comment le prendre
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['comment_prendre'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingThree">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                                            Effets indésirables possibles
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['effets_indesirables'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingFour">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                                                            Contre-indications
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['contre_indications'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingFive">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                                                            Précautions d'emploi
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['precautions_emploi'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingSix">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                                                            Intéractions médicamenteuses
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['interactions_medicamenteuses'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingSeven">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                                                                            Surdosage
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['surdosage'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingEight">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                                                                            Grossesse & allaitement
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['grossesse_allaitement'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingNine">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                                                                            Aspect & forme
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['aspect_forme'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingTen">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                                                                            Composition
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['composition'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingEleven">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                                                                            Mécanisme d'action
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['mecanisme_action'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="headingTwelve">
                                                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                                                                                            Autres informations
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve" data-bs-parent="#accordionExample">
                                                                                        <div class="accordion-body">
                                                                                            <?php
                                                                                            if($notice) {
                                                                                                echo $notice['autres_informations'];
                                                                                            }else {
                                                                                                echo '<p class="alert-info">Aucune information encore enregistrée.</p>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        echo '<script src="' . JS . 'deconnexion_2.js"></script>';
                                                        echo '<script src="' . JS . 'page_parametres_medicaments.js"></script>';
                                                    } else {
                                                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                    }
                                                } else {
                                                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                }
                                            }
                                            else {
                                                echo '<script>window.location.href="' . URL . 'prarametres/referentiels/medicaments"</script>';
                                            }
                                        } else {
                                            echo '<script>window.location.href="' . URL . '"</script>';
                                        }
                                    } else {
                                        echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                    }
                                } else {
                                    echo '<script>window.location.href="' . URL . 'mot-de-passe"</script>';
                                }
                            } else {
                                $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                                if ($fermer_session['success'] == true) {
                                    session_destroy();
                                    echo '<script>window.location.href="' . URL . 'connexion"</script>';
                                } else {
                                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                                }
                            }
                        } else {
                            $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                            if ($fermer_session['success'] == true) {
                                session_destroy();
                                echo '<script>window.location.href="' . URL . 'connexion"</script>';
                            } else {
                                echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                            }
                        }
                    } else {
                        $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                        if ($fermer_session['success'] == true) {
                            session_destroy();
                            echo '<script>window.location.href="' . URL . 'connexion"</script>';
                        } else {
                            echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                        }
                    }
                } else {
                    $fermer_session = $UTILISATEURS->editer_session(null, $session['code_session'], null, null, null, null, null, null);
                    if ($fermer_session['success'] == true) {
                        session_destroy();
                        echo '<script>window.location.href="' . URL . 'connexion"</script>';
                    } else {
                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la clôture de la session, veuillez SVP contacter votre administrateur.</p>';
                    }
                }
            } else {
                session_destroy();
                echo '<script>window.location.href="' . URL . 'connexion"</script>';
            }
        } else {
            session_destroy();
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    } else {
        session_destroy();
        echo '<script>window.location.href="' . URL . 'connexion"</script>';
    }
}else {
    $medicaments = $MEDICAMENTS->lister(null, null);
    $classes_therapeutiques = $MEDICAMENTS->lister_classes_therapeutiques();
    $dcis = $MEDICAMENTS->lister_dci();
    $familles_formes = $MEDICAMENTS->lister_familles_formes();
    $formes_administrations = $MEDICAMENTS->lister_formes_administrations();
    $laboratoires = $MEDICAMENTS->lister_laboratoires_pharmaceutiques();
    $presentations = $MEDICAMENTS->lister_presentations();
    $types = $MEDICAMENTS->lister_types();
    $unites_dosages = $MEDICAMENTS->lister_unites_dosages();
    $nb_medicaments = count($medicaments);
    ?>
    <p class="h4">Médicaments</p>
    <p class="align_right">
        <button type="button" class="btn btn-primary btn-sm btn_add"><i class="bi bi-plus-square-fill"></i></button>
    </p>
    <div id="div_form">
        <div class="row justify-content-md-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body row">
                        <h5 class="card-title"></h5>
                        <div class="row justify-content-md-center">
                            <?php include "../../../_Forms/form_medicament.php";?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="div_datas">
        <?php
        if($nb_medicaments == 0) {
            ?>
            <p class="align_center alert alert-warning">Aucun medicament n'a encore été enregistré. <br />Cliquez sur <a href="" class="btn_add"><i class="bi bi-plus-square-fill"></i></a> pour ajouter un nouveau</p>
            <?php
        }else {
            include "../../../_Forms/form_export.php";
            ?>
            <table class="table table-bordered table-hover table-sm table-striped" id="tableDeValeurs">
                <thead class="bg-secondary">
                <tr>
                    <th style="width: 5px">N°</th>
                    <th style="width: 10px">CODE</th>
                    <th>EAN13</th>
                    <th>DCI</th>
                    <th>LIBELLE</th>
                    <th>PRESENTATION</th>
                    <th style="width: 100px">DATE EFFET</th>
                    <th style="width: 5px"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $ligne = 1;
                foreach ($medicaments as $medicament) {
                    $date_edition = date('Y-m-d',strtotime('+1 day',strtotime($medicament['date_debut'])));
                    $date_fin = date('Y-m-d',strtotime('-1 day',time()));
                    if(strtotime($date_fin) > strtotime($date_edition)) {
                        $validite_edition = 1;
                    }else {
                        $validite_edition = 0;
                    }
                    ?>
                    <tr>
                        <td class="align_right"><?= $ligne;?></td>
                        <td><strong><?= $medicament['code'];?></strong></td>
                        <td><?= $medicament['code_ean13'];?></td>
                        <td><?= $medicament['libelle_dci'];?></td>
                        <td><?= $medicament['libelle'];?></td>
                        <td><?= $medicament['libelle_presentation_primaire'];?></td>
                        <td class="align_center"><?= date('d/m/Y',strtotime($medicament['date_debut']));?></td>
                        <td><a href="<?= URL.'parametres/referentiels/medicaments?code='.$medicament['code'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                    </tr>
                    <?php
                    $ligne++;
                }
                ?>
                </tbody>
            </table>
            <div class="modal fade" id="historiqueModal" tabindex="-1" aria-labelledby="historiqueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="historiqueModalLabel"><i class="bi bi-clock-history"></i> Historique des modifications</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="div_historique"></div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <script>
        $(".btn_add").click(function () {
            $("#div_datas").hide();
            $("#div_form").slideDown();
            $(".card-title").html('Nouveau medicament');
            return false;
        });


        $("#code_dci_input").change(function () {
            let code_dci = $(this).val().trim();
            if(code_dci) {
                $("#button_enregistrer").prop('disabled', true)
                    .removeClass('btn-primary')
                    .addClass('btn-warning')
                    .html('<i>Recherche...</i>');
                $.ajax({
                    url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_medicaments_dci.php',
                    type: 'POST',
                    data: {
                        'code_dci': code_dci
                    },
                    dataType: 'json',
                    success: function (data) {
                        $("#button_enregistrer").prop('disabled', false)
                            .removeClass('btn-warning')
                            .addClass('btn-primary')
                            .html('<i class="bi bi-save"></i> Enregistrer');
                        $("#div_medicament_forme").show();
                        $("#div_medicament_groupe").show();
                        $("#div_medicament_classe").show();
                        if(data['success'] === true) {
                            $("#div_medicament_forme").append('<label for="code_forme_input" class="form-label">Forme</label>' +
                                '<select class="form-select form-select-sm" id="code_forme_input" aria-label=".form-select-sm" aria-describedby="codeFormeHelp" disabled>' +
                                '<option value="'+data['code_forme']+'">'+data['libelle_forme']+'</option>' +
                                '</select>' +
                                '<div id="codeFormeHelp" class="form-text"></div>');

                            $("#div_medicament_groupe_classe").append('' +
                                '<div class="row">' +
                                '<div class="col-sm-6">' +
                                '<label for="code_groupe_input" class="form-label">Groupe</label>' +
                                '<select class="form-select form-select-sm" id="code_groupe_input" aria-label=".form-select-sm" aria-describedby="codeGroupeHelp" disabled>' +
                                '<option value="'+data['code_groupe']+'">'+data['libelle_groupe']+'</option>' +
                                '</select>' +
                                '<div id="codeGroupeHelp" class="form-text"></div>' +
                                '</div>' +
                                '<div class="col-sm-6">' +
                                '<label for="code_sous_groupe_input" class="form-label">Sous-groupe</label>' +
                                '<select class="form-select form-select-sm" id="code_sous_groupe_input" aria-label=".form-select-sm" aria-describedby="codeSousGroupeHelp" disabled>' +
                                '<option value="'+data['code_sous_groupe']+'">'+data['libelle_sous_groupe']+'</option>' +
                                '</select>' +
                                '<div id="codeSousGroupeHelp" class="form-text"></div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="row">' +
                                '<div class="col-sm-6">' +
                                '<label for="code_classe_input" class="form-label">Classe thérapeutique</label>' +
                                '<select class="form-select form-select-sm" id="code_classe_input" aria-label=".form-select-sm" aria-describedby="codeClasseHelp" disabled>' +
                                '<option value="'+data['code_classe']+'">'+data['libelle_classe']+'</option></select>' +
                                '<div id="codeClasseHelp" class="form-text"></div>' +
                                '</div>' +
                                '<div  class="col-sm-6">' +
                                '<label for="code_sous_classe_input" class="form-label">Sous-classe thérapeutique</label>' +
                                '<select class="form-select form-select-sm" id="code_sous_classe_input" aria-label=".form-select-sm" aria-describedby="codeSousClasseHelp" disabled>' +
                                '<option value="'+data['code_sous_classe']+'">'+data['libelle_sous_classe']+'</option>' +
                                '</select>' +
                                '<div id="codeSousClasseHelp" class="form-text"></div>' +
                                '</div>' +
                                '</div>');

                            $.each(data['dosages'], function(index, value) {
                                $("#div_medicament_dosage").append('<div class="col-sm-3">' +
                                    '<label for="dosage_1_input" class="form-label">Dosage</label>' +
                                    '<input type="text" class="form-control form-control-sm" value="'+value['dosage']+'" id="dosage_1_input" maxlength="20" placeholder="Dosage" aria-describedby="dosage1Help" autocomplete="off" readonly>' +
                                    '<div id="dosage1Help" class="form-text"></div>' +
                                    '</div>');
                            });
                        }else {
                            $("#code_forme_input")
                                .append('<option value="" selected></option>')
                                .removeClass('is-valid')
                                .addClass('is-invalid');
                            $("#code_groupe_input")
                                .append('<option value="" selected></option>')
                                .removeClass('is-valid')
                                .addClass('is-invalid');
                            $("#code_sous_groupe_input")
                                .append('<option value="" selected></option>')
                                .removeClass('is-valid')
                                .addClass('is-invalid');
                            $("#code_classe_input")
                                .append('<option value="" selected></option>')
                                .removeClass('is-valid')
                                .addClass('is-invalid');
                            $("#code_sous_classe_input")
                                .append('<option value="" selected></option>')
                                .removeClass('is-valid')
                                .addClass('is-invalid');
                            $("#div_medicament_dosage").html('');
                        }
                    }
                });
                $("#code_dci_input").removeClass('is-invalid')
                    .addClass('is-valid');
                $("#codeDciHelp")
                    .removeClass('text-danger')
                    .html("");
            }
            else {
                $("#code_dci_input").removeClass('is-valid')
                    .addClass('is-invalid');
                $("#codeDciHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner la DCI du medicament SVP.");

                $("#div_medicament_forme").html('');
                $("#div_medicament_groupe_classe").html('');
                $("#div_medicament_dosage").html('');
            }
        });
        $("#code_type_input").change(function () {
            let code_type = $(this).val().trim();
            if(code_type) {
                $("#code_type_input").removeClass('is-invalid')
                    .addClass('is-valid');
                $("#codeTypeHelp")
                    .removeClass('text-danger')
                    .html("");
            }else {
                $("#code_type_input").removeClass('is-valid')
                    .addClass('is-invalid');
                $("#codeTypeHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le type de medicament SVP.");
            }
        });
        $("#libelle_input").keyup(function () {
            let libelle     = $(this).val().trim();
            if(libelle && libelle.length > 3) {
                $("#libelle_input").removeClass('is-invalid')
                    .addClass('is-valid');
                $("#libelleHelp")
                    .removeClass('text-danger')
                    .html("");
            }else {
                $("#libelle_input").removeClass('is-valid')
                    .addClass('is-invalid');
                $("#libelleHelp")
                    .addClass('text-danger')
                    .html("Veuillez renseigner un libellé SVP.");
            }
        });
        $("#code_ean13_input").keyup(function () {
            let code_ean13 = $(this).val().trim();
            if(code_ean13) {
                $("#code_ean13_input").removeClass('is-invalid')
                    .addClass('is-valid');
                $("#codeEan13Help")
                    .removeClass('text-danger')
                    .html("");
            }else {
                $("#aen13_code").removeClass('is-valid');
            }
        });
        $("#code_laboratoire_input").change(function () {
            let code_laboratoire = $(this).val().trim();
            if(code_laboratoire) {
                $("#code_laboratoire_input").removeClass('is-invalid')
                    .addClass('is-valid');
                $("#codeLaboratoireHelp")
                    .removeClass('text-danger')
                    .html("");
            }else {
                $("#code_laboratoire_input").removeClass('is-valid')
                    .addClass('is-invalid');
                $("#codeLaboratoireHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le laboratoire pharmaceutique SVP.");
            }
        });
        $("#code_conditionnement_primaire_input").change(function () {
            let code_conditionnement_primaire = $(this).val().trim();
            if(code_conditionnement_primaire) {
                $("#code_conditionnement_primaire_input").removeClass('is-invalid')
                    .addClass('is-valid');
                $("#codeConditionnementPrimaireHelp")
                    .removeClass('text-danger')
                    .html("");
            }else {
                $("#code_conditionnement_primaire_input").removeClass('is-valid')
                    .addClass('is-invalid');
                $("#codeConditionnementPrimaireHelp")
                    .addClass('text-danger')
                    .html("Veuillez sélectionner le condtionnement primaire du médicament SVP.");
            }
        });


        $("#form_medicament").submit(function () {
            let code                            = $("#code_input").val().trim(),
                libelle                         = $("#libelle_input").val().trim().toUpperCase(),
                code_dci                        = $("#code_dci_input").val().trim(),
                code_type                       = $("#code_type_input").val().trim(),
                code_ean13                      = $("#code_ean13_input").val().trim(),
                code_laboratoire                = $("#code_laboratoire_input").val().trim(),
                code_conditionnement_primaire   = $("#code_conditionnement_primaire_input").val().trim(),
                code_conditionnement_secondaire = $("#code_conditionnement_secondaire_input").val().trim();
            if(libelle && code_dci && code_type && code_laboratoire && code_conditionnement_primaire) {
                $("#button_enregistrer").prop('disabled', true)
                    .removeClass('btn-primary')
                    .addClass('btn-warning')
                    .html('<i>Traitement...</i>');
                $.ajax({
                    url: '../../_CONFIGS/Includes/Submits/Parametres/Referentiels/Medicaments/submit_medicament.php',
                    type: 'POST',
                    data: {
                        'code': code,
                        'libelle': libelle,
                        'code_dci': code_dci,
                        'code_type': code_type,
                        'code_ean13': code_ean13,
                        'code_laboratoire': code_laboratoire,
                        'code_conditionnement_primaire': code_conditionnement_primaire,
                        'code_conditionnement_secondaire': code_conditionnement_secondaire
                    },
                    dataType: 'json',
                    success: function (data) {
                        $("#button_enregistrer").prop('disabled', false)
                            .removeClass('btn-warning')
                            .addClass('btn-primary')
                            .html('<i class="bi bi-save"></i> Enregistrer');
                        if (data['success'] === true) {
                            $("#form_medicament").hide();
                            $("#p_medicament_resultats").removeClass('alert alert-danger')
                                .addClass('alert alert-success')
                                .html(data['message']);
                            setTimeout(function () {
                                display_medicaments('med');
                            },5000);
                        }else {
                            $("#p_medicament_resultats").removeClass('alert alert-success')
                                .addClass('alert alert-danger')
                                .html(data['message']);
                        }
                    }
                });
            }
            else {
                if(!code) {
                    $("#code_input").addClass('is-invalid');
                    $("#codeHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner le code SVP.");
                }
                if(!libelle) {
                    $("#libelle_input").addClass('is-invalid');
                    $("#libelleHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner le libellé SVP.");
                }
                if(!forme) {
                    $("#forme_code").addClass('is-invalid');
                    $("#formeHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner la forme du medicament SVP.");
                }
                if(!aen13) {
                    $("#aen13_code").addClass('is-invalid');
                    $("#aen13Help")
                        .addClass('text-danger')
                        .html("Veuillez renseigner le AEN13 SVP.");
                }
                if(!dci) {
                    $("#dci_input").addClass('is-invalid');
                    $("#dciHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner le DCI du médicament SVP.");
                }
                if(!laboratoire) {
                    $("#laboratoire_code").addClass('is-invalid');
                    $("#laboHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner le laboratoire  SVP.");
                }
                if(!classe) {
                    $("#classe_therapeuthique_code").addClass('is-invalid');
                    $("#classHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner la classe  SVP.");
                }
                if(!famille_forme) {
                    $("#famille_forme_code").addClass('is-invalid');
                    $("#familleFormeHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner la famille forme  SVP.");
                }
                if(!forme_administration) {
                    $("#forme_administration_code").addClass('is-invalid');
                    $("#formeAdministrationHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner la forme d'administration  SVP.");
                }
                if(!type) {
                    $("#type_medicament_code").addClass('is-invalid');
                    $("#typeHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner le type du médicament  SVP.");
                }
                if(!presenation) {
                    $("#presentations_code").addClass('is-invalid');
                    $("#presentationHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner la présentation  SVP.");
                }
                if(!dosage) {
                    $("#dosage_input").addClass('is-invalid');
                    $("#dosageHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner le dosage  SVP.");
                }
                if(!unite_doage_code) {
                    $("#unite_dosage_code").addClass('is-invalid');
                    $("#uniteDosageHelp")
                        .addClass('text-danger')
                        .html("Veuillez renseigner l'unité de dosage  SVP.");
                }
            }
            return false;
        });

        $(".btn_edit").click(function () {
            $("#div_datas").hide();
            $("#div_form").slideDown();

            let this_id = this.id,
                tableau = this_id.split('|'),
                code = tableau[0],
                libelle = tableau[1],
                aen13 = tableau[3],
                dosage = tableau[2],
                forme = tableau[4],
                dci = tableau[5],
                labo = tableau[6],
                classe = tableau[7],
                famille_forme = tableau[8],
                forme_administration = tableau[9],
                type = tableau[10],
                presentation = tableau[11],
                unite_dosage = tableau[12];
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/Parametres/Referentiels/search_dci.php',
                type: 'post',
                data: {
                    'code_forme': forme,
                },
                dataType: 'json',
                success: function(json) {
                    $("#button_enregistrer").prop('disabled', false)
                        .removeClass('btn-warning')
                        .addClass('btn-primary')
                        .html('<i class="bi bi-save"></i> Enregistrer');
                    $("#dci_input").prop('disabled',false)
                    $.each(json, function(index, value) {
                        $("#dci_input").append('<option value="' + index + ' ">' + value + '</option>');
                    });
                }
            });

            $("#code_input").val(code).prop('disabled',true);
            $("#libelle_input").val(libelle);
            $("#dosage_input").val(dosage);
            $("#forme_code").val(forme);
            $("#aen13_code").val(aen13);
            $("#forme_code").val(forme);
            $("#dci_input").val(dci);
            $("#laboratoire_code").val(labo);
            $("#classe_therapeuthique_code").val(classe);
            $("#famille_forme_code").val(famille_forme);
            $("#forme_administration_code").val(forme_administration);
            $("#type_medicament_code").val(type);
            $("#presentations_code").val(presentation);
            $("#unite_dosage_code").val(unite_dosage);


            $(".card-title").html('Edition d\'un médicament');

        });

        $('#historiqueModal').modal({
            show: false,
            backdrop: 'static'
        });

        $(".button_historique").click(function () {
            let this_id = this.id,
                tableau = this_id.split('|'),
                donnee = tableau[0],
                type_donnee = tableau[1];
            if(donnee && type_donnee) {
                $.ajax({
                    url: '../../_CONFIGS/Includes/Searches/Parametres/search_historique_donnees.php',
                    type: 'POST',
                    data: {
                        'donnee': donnee,
                        'type': type_donnee
                    },
                    success: function (data) {
                        $("#div_historique").html(data);
                    }
                });
            }
        });

        $('#tableDeValeurs').DataTable();

        $("#export_input").change(function () {
            let code_export = $("#export_input").val();
            if(code_export) {
                window.open("../exporter-referentiels.php?type="+code_export+"&data=med", "PopupWindow", "width=600,height=600,scrollbars=yes,resizable=no");
            }
        });
    </script>
    <?php
}

?>
