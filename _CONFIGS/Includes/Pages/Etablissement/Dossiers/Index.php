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
                                        require_once "../../../../Classes/DOSSIERS.php";
                                        $ETABLISSEMENTS = new ETABLISSEMENTS();
                                        $DOSSIERS = new DOSSIERS();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_ets($user['id_user']);
                                        if ($user_profil) {
                                            $ets = $ETABLISSEMENTS->trouver($user_profil['code_etablissement'], null);
                                            if ($ets) {
                                                $habilitations = $ETABLISSEMENTS->trouver_habilitations($user['id_user']);
                                                $modules = preg_split('/;/', $habilitations['modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                $nb_modules = count($modules);
                                                if ($nb_modules !== 0) {
                                                    $sous_modules = preg_split('/;/', $habilitations['sous_modules'], -1, PREG_SPLIT_NO_EMPTY);
                                                    if (in_array('AFF_DOSS', $modules, true)) {
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] === true) {
                                                                include "../../../Menu.php";
                                                                require_once "../../../../Classes/SORTIESMEDICALES.php";
                                                                $SORTIESMEDICALES = new SORTIESMEDICALES();
                                                                $sorties_medicales = $SORTIESMEDICALES->lister();
                                                                if (isset($_POST['num_dossier']) && $_POST['num_dossier']) {
                                                                    if (in_array('AFF_DOS', $sous_modules, true)) {
                                                                        $dossier = $ETABLISSEMENTS->trouver_dossier($ets['code'], $_POST['num_dossier']);
                                                                        if ($dossier) {
                                                                            $patient = $ETABLISSEMENTS->trouver_patient($ets['code'], $dossier['num_population']);
                                                                            $constantes = $DOSSIERS->trouver_constantes($patient['num_population'], $dossier['code_dossier']);
                                                                            $pathologies = $DOSSIERS->lister_pathologies($dossier['code_dossier']);
                                                                            $bulletins = $DOSSIERS->lister_bulletins_examens($dossier['code_dossier']);
                                                                            $ordonnances = $DOSSIERS->lister_ordonnances($dossier['code_dossier']);
                                                                            $ps = $ETABLISSEMENTS->trouver_professionnel_de_sante($ets['code'], $dossier['code_professionnel']);
                                                                            $professionnels = $ETABLISSEMENTS->lister_professionnels_de_sante($ets['code']);
                                                                            if (!$constantes) {
                                                                                $constantes = array(
                                                                                    'poids' => '',
                                                                                    'temperature' => '',
                                                                                    'pouls' => ''
                                                                                );
                                                                            }
                                                                            $tz  = new DateTimeZone('Africa/Abidjan');
                                                                            $age = DateTime::createFromFormat('Y-m-d', $patient['date_naissance'], $tz)
                                                                                ->diff(new DateTime('now', $tz))
                                                                                ->y;
                                                                            ?>
                                                                            <div class="container-xl" id="div_main_page">
                                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                    <ol class="breadcrumb">
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/dossiers/';?>"><i class="bi bi-folder2-open"></i> Dossiers</a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/patients/?nip='.$patient['num_population'];?>"> <?= $patient['nom'].' '.$patient['prenom'];?></a></li>
                                                                                        <li class="breadcrumb-item active" aria-current="page">Dossier n° <strong id="strong_code_dossier"><?= $dossier['code_dossier'];?></strong></li>
                                                                                    </ol>
                                                                                </nav>
                                                                                <p class="p_page_titre h4"><?= $patient['nom'].' '.$patient['prenom']. ' ('.$age.'ans)'; ?></p>
                                                                                <div class="div_buttons">
                                                                                    <button type="button" class="btn btn-secondary btn-sm" id="button_imprimer_dossier" title="Imprimer le dossier patient"><i class="bi bi-printer"></i> Imprimer</button>
                                                                                    <?php
                                                                                    if (!$dossier['date_fin']) {
                                                                                        if (in_array('EDT_DOS_CSTS', $sous_modules, true)) {
                                                                                            ?>
                                                                                            <button type="button" class="btn btn-dark btn-sm" title="Edition des constantes" data-bs-toggle="modal" data-bs-target="#editionConstantesModal"><i class="bi bi-cone"></i> Constantes</button>
                                                                                            <div class="modal fade" id="editionConstantesModal" tabindex="-1" aria-labelledby="editionConstantesModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                                                    <div class="modal-content bg-white text-dark">
                                                                                                        <div class="modal-header">
                                                                                                            <h5 class="modal-title" id="editionConstantesModalLabel">Edition des constantes</h5>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <?php include "../../_Forms/form_constantes.php";?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php
                                                                                        }
                                                                                        if ($dossier['code_professionnel']) {
                                                                                            if (in_array('EDT_DOS_PLTS', $sous_modules, true)) {
                                                                                                ?>
                                                                                                <button type="button" class="btn btn-warning btn-sm" title="Edition des plaintes" data-bs-toggle="modal" data-bs-target="#editionPlaintesModal"><i class="bi bi-pencil-square"></i> Plaintes</button>
                                                                                                <div class="modal fade" id="editionPlaintesModal" tabindex="-1" aria-labelledby="editionPlaintesModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="editionPlaintesModalLabel">Edition des plaintes du patient</h5>
                                                                                                            </div>
                                                                                                            <div class="modal-body bg-white"><?php include "../../_Forms/form_dossier_plaintes.php"; ?></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                            if (in_array('EDT_DOS_DGTC', $sous_modules, true)) {
                                                                                                ?>
                                                                                                <button type="button" class="btn btn-primary btn-sm" title="Etablissement du diagnostic" data-bs-toggle="modal" data-bs-target="#editionDiagnosticModal"><i class="bi bi-hexagon-fill"></i> Diagnostic</button>
                                                                                                <div class="modal fade" id="editionDiagnosticModal" tabindex="-1" aria-labelledby="editionDiagnosticModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="editionDiagnosticModalLabel">Etablissement du diagnostic</h5>
                                                                                                            </div>
                                                                                                            <div class="modal-body bg-white"><?php include "../../_Forms/form_dossier_diagnostic.php";?></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                            if (in_array('EDT_DOS_PATHG', $sous_modules, true)) {
                                                                                                ?>
                                                                                                <button type="button" class="btn btn-primary btn-sm" title="Pathologies" data-bs-toggle="modal" data-bs-target="#editionPathologiesModal"><i class="bi bi-file-medical-fill"></i> Pathologies</button>
                                                                                                <div class="modal fade" id="editionPathologiesModal" tabindex="-1" aria-labelledby="editionPathologiesModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="editionExamensModalLabel">Pathologies du patient</h5>
                                                                                                            </div>
                                                                                                            <div class="modal-body"><?php include "../../_Forms/form_dossier_pathologies.php";?></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                            if (in_array('EDT_DOS_ORDO', $sous_modules, true)) {
                                                                                                ?>
                                                                                                <button type="button" class="btn btn-primary btn-sm" title="Ordonnance" data-bs-toggle="modal" data-bs-target="#editionOrdonnanceModal"><i class="bi bi-file-earmark-plus-fill"></i> Ordonnance</button>
                                                                                                <div class="modal fade" id="editionOrdonnanceModal" tabindex="-1" aria-labelledby="editionOrdonnanceModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="editionOrdonnanceModalLabel">Nouvelle ordonnance</h5>
                                                                                                            </div>
                                                                                                            <div class="modal-body"><?php include "../../_Forms/form_dossier_ordonnance.php";?></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                            if (in_array('EDT_DOS_EXAMS', $sous_modules, true)) {
                                                                                                ?>
                                                                                                <button type="button" class="btn btn-primary btn-sm" title="Examens" data-bs-toggle="modal" data-bs-target="#editionExamensModal"><i class="bi bi-nut-fill"></i> Examens</button>
                                                                                                <div class="modal fade" id="editionExamensModal" tabindex="-1" aria-labelledby="editionExamensModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="editionExamensModalLabel">Prescription d'examens</h5>
                                                                                                            </div>
                                                                                                            <div class="modal-body"><?php include "../../_Forms/form_dossier_examens.php";?></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                            if (in_array('', $sous_modules, true)) {
                                                                                                ?>
                                                                                                <button type="button" class="btn btn-primary btn-sm" title="Certificat médical" data-bs-toggle="modal" data-bs-target="#editionCertificatMedicalModal" hidden><i class="bi bi-file-earmark-code-fill"></i> Certificat médical</button>
                                                                                                <div class="modal fade" id="editionCertificatMedicalModal" tabindex="-1" aria-labelledby="editionCertificatMedicalModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="editionCertificatMedicalModalLabel">Certificat médical</h5>
                                                                                                            </div>
                                                                                                            <div class="modal-body"><?php include "../../_Forms/form_dossier_certificat_medical.php";?></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                        } else {
                                                                                            if (in_array('EDT_DOS_MEDTRT', $sous_modules, true)) {
                                                                                                ?>
                                                                                                <button type="button" class="btn btn-primary btn-sm" title="Medecin" data-bs-toggle="modal" data-bs-target="#editionMedecinModal"><i class="bi bi-person-rolodex"></i> Medecin traitant</button>
                                                                                                <div class="modal fade" id="editionMedecinModal" tabindex="-1" aria-labelledby="editionMedecinModalLabel" aria-hidden="true">
                                                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                                                        <div class="modal-content bg-white text-dark">
                                                                                                            <div class="modal-header">
                                                                                                                <h5 class="modal-title" id="editionMedecinModalLabel">Medecin traitant</h5>
                                                                                                            </div>
                                                                                                            <div class="modal-body"><?php include "../../_Forms/form_dossier_professionnel_sante.php";?></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        if (in_array('EDT_DOS', $sous_modules, true)) {
                                                                                            ?>
                                                                                            <button type="button" class="btn btn-danger btn-sm" title="Sortie" data-bs-toggle="modal" data-bs-target="#editionSortieModal"><i class="bi bi-arrow-bar-right"></i> Sortie</button>
                                                                                            <div class="modal fade" id="editionSortieModal" tabindex="-1" aria-labelledby="editionSortieModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                                    <div class="modal-content bg-white text-dark">
                                                                                                        <div class="modal-header">
                                                                                                            <h5 class="modal-title" id="editionSortieModalLabel">Sortie</h5>
                                                                                                        </div>
                                                                                                        <div class="modal-body"><?php include "../../_Forms/form_dossier_sortie.php";?></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </div><br />
                                                                                <div class="row">
                                                                                    <div class="col-sm-3">
                                                                                        <div class="card border-dark">
                                                                                            <div class="card-header bg-indigo text-white">
                                                                                                <strong><i class="bi bi-cone"></i> Constantes</strong>
                                                                                            </div>
                                                                                            <div class="card-body" style="height: 120px">
                                                                                                <?php
                                                                                                if (in_array('AFF_DOS_CSTS', $sous_modules, true)) {
                                                                                                    ?>
                                                                                                    <table class="table table-sm table-hover" style="width: 100%">
                                                                                                        <tr>
                                                                                                            <td>Poids</td>
                                                                                                            <td class="align_right" style="width: 60px"><strong><?= $constantes['poids'];?> Kg</strong></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>Température</td>
                                                                                                            <td class="align_right"><strong><?= $constantes['temperature'];?> °C</strong></td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td>Pouls</td>
                                                                                                            <td class="align_right"><strong><?= $constantes['pouls'];?> bpm</strong></td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                    <?php
                                                                                                } else {
                                                                                                    echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm">
                                                                                        <div class="card border-dark">
                                                                                            <div class="card-header bg-dark text-white">
                                                                                                <strong><i class="bi bi-person-rolodex"></i> Medecin traitant</strong>
                                                                                            </div>
                                                                                            <div class="card-body" style="height: 120px">
                                                                                                <?php
                                                                                                if (in_array('AFF_DOS_MEDTRT', $sous_modules, true)) {
                                                                                                    if ($ps) {
                                                                                                        ?>
                                                                                                        <table class="table table-hover table-sm">
                                                                                                            <thead>
                                                                                                            <tr>
                                                                                                                <th style="width: 100px">CODE</th>
                                                                                                                <th>NOM & PRENOM</th>
                                                                                                                <th style="width: 200px">SPECIALITE MEDICALE</th>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                            <tr>
                                                                                                                <td><strong><a href="<?= URL.'etablissement/professionnels-de-sante/?code='.strtolower($ps['code_professionnel']);?>" target="_blank"><?= $ps['code_professionnel'];?></a></strong></td>
                                                                                                                <td><?= $ps['nom'].' '.$ps['prenom'];?></td>
                                                                                                                <td><?= $ps['libelle_specialite_medicale'];?></td>
                                                                                                            </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        <?php
                                                                                                    }  else {
                                                                                                        echo '<p class="align_center alert alert-info">Aucun médecin n\'a encore été enregistré pour ce dossier.</p>';
                                                                                                    }
                                                                                                } else {
                                                                                                    echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div><br />
                                                                                <div class="row">
                                                                                    <div class="col-sm">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-12" style="margin-bottom: 15px">
                                                                                                <div class="card border-dark">
                                                                                                    <div class="card-header bg-indigo text-white">
                                                                                                        <strong><i class="bi bi-pencil-square"></i> Plaintes</strong>
                                                                                                    </div>
                                                                                                    <div class="card-body">
                                                                                                        <?php
                                                                                                        if (in_array('AFF_DOS_PLTS', $sous_modules, true)) {
                                                                                                            if ($dossier['plainte']) {
                                                                                                                echo html_entity_decode($dossier['plainte']);
                                                                                                            } else {
                                                                                                                echo '<p class="align_center alert alert-info">Aucune plainte n\'a encore été enregistrée.</p>';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-12">
                                                                                                <div class="card border-dark">
                                                                                                    <div class="card-header bg-secondary text-white">
                                                                                                        <strong><i class="bi bi-hexagon-fill"></i> Diagnostic</strong>
                                                                                                    </div>
                                                                                                    <div class="card-body">
                                                                                                        <?php
                                                                                                        if (in_array('AFF_DOS_DGTC', $sous_modules, true)) {
                                                                                                            if ($dossier['diagnostic']) {
                                                                                                                echo html_entity_decode($dossier['diagnostic']);
                                                                                                            } else {
                                                                                                                echo '<p class="align_center alert alert-info">Aucune plainte n\'a encore été enregistrée.</p>';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-12" style="margin-bottom: 15px">
                                                                                                <div class="card border-dark">
                                                                                                    <div class="card-header bg-primary text-white">
                                                                                                        <strong><i class="bi bi-file-medical-fill"></i> Pathologies</strong>
                                                                                                    </div>
                                                                                                    <div class="card-body">
                                                                                                        <?php
                                                                                                        if (in_array('AFF_DOS_PATHG', $sous_modules, true)) {
                                                                                                            $nb_pathologies = count($pathologies);
                                                                                                            if ($nb_pathologies != 0) {
                                                                                                                ?>
                                                                                                                <table class="table table-sm table-hover table-stripped">
                                                                                                                    <tbody>
                                                                                                                    <?php
                                                                                                                    foreach ($pathologies as $pathologie) {
                                                                                                                        ?>
                                                                                                                        <tr>
                                                                                                                            <td style="width: 10px"><strong><?= $pathologie['code'];?></strong></td>
                                                                                                                            <td><?= $pathologie['libelle'];?></td>
                                                                                                                        </tr>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                                <?php
                                                                                                            } else {
                                                                                                                echo '<p class="alert alert-info align_center">Aucune pathologie n\'a encore été renregistrée pour ce dossier</p>';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-12">
                                                                                                <div class="card border-dark">
                                                                                                    <div class="card-header bg-danger text-white">
                                                                                                        <strong><i class="bi bi-file-earmark-plus-fill"></i> Ordonnances</strong>
                                                                                                    </div>
                                                                                                    <div class="card-body">
                                                                                                        <?php
                                                                                                        if (in_array('AFF_DOS_ORDO', $sous_modules, true)) {
                                                                                                            $nb_ordonnances = count($ordonnances);
                                                                                                            if ($nb_ordonnances != 0) {
                                                                                                                ?>
                                                                                                                <table class="table table-sm">
                                                                                                                    <?php
                                                                                                                    foreach ($ordonnances as $ordonnance) {
                                                                                                                        ?>
                                                                                                                        <tr>
                                                                                                                            <td style="width: 110px"><?= date('d/m/Y H:i', strtotime($ordonnance['date_creation']));?></td>
                                                                                                                            <td><?= $ordonnance['code'];?></td>
                                                                                                                            <td style="width: 5px"><button type="button" id="<?= $ordonnance['code'];?>" class="badge bg-secondary button_ordonnance_print"><i class="bi bi-printer"></i></button></td>
                                                                                                                        </tr>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                </table>
                                                                                                                <?php
                                                                                                            } else {
                                                                                                                echo '<p class="alert alert-info align_center">Aucune ordonnance n\'a encore été renregistrée pour ce dossier</p>';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                        }
                                                                                                        ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div><br />
                                                                                <div class="row">
                                                                                    <div class="col-sm">
                                                                                        <div class="card border-dark">
                                                                                            <div class="card-header bg-success text-white">
                                                                                                <strong><i class="bi bi-nut-fill"></i> Examens</strong>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <?php
                                                                                                if (in_array('AFF_DOS_EXAMS', $sous_modules, true)) {
                                                                                                    $nb_bulletins = count($bulletins);
                                                                                                    if ($nb_bulletins !== 0) {
                                                                                                        ?>
                                                                                                        <table class="table table-sm table-bordered table-hover table-stripped">
                                                                                                            <tbody>
                                                                                                            <?php
                                                                                                            foreach ($bulletins as $bulletin) {
                                                                                                                $actes = $DOSSIERS->lister_bulletins_examens_actes($bulletin['code']);
                                                                                                                $nb_actes = count($actes);
                                                                                                                $rowspan = 2 + $nb_actes;
                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td rowspan="<?= $rowspan;?>" style="width: 150px; border: 1px solid #19181B" class="align_center"><strong><?= date('d/m/Y H:i', strtotime($bulletin['date_creation']));?></strong></td>
                                                                                                                    <td colspan="2" style="border-top: 1px solid #19181B">BULLETIN N° <strong><?= $bulletin['code'];?></strong></td>
                                                                                                                    <td style="width: 5px; border-top: 1px solid #19181B"><button type="button" id="<?= $bulletin['code'];?>" class="badge bg-secondary button_examen_print"><i class="bi bi-printer"></i></button></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td colspan="3">Reinseignements cliniques: <strong><?= $bulletin['renseignements'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <?php
                                                                                                                foreach ($actes as $acte) {
                                                                                                                    ?>
                                                                                                                    <tr>
                                                                                                                        <td style="width: 100px"><?= $acte['code'];?></td>
                                                                                                                        <td><?= $acte['libelle'];?></td>
                                                                                                                        <td style="width: 5px"><button type="button" class="badge bg-dark" title="Resultat <?= $acte['libelle'];?>"><i class="bi bi-eye"></i></button></td>
                                                                                                                    </tr>
                                                                                                                    <?php
                                                                                                                }
                                                                                                            }
                                                                                                            ?>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        <?php
                                                                                                    } else {
                                                                                                        echo '<p class="alert alert-info align_center">Aucun examen n\'a encore été renregistré pour ce dossier</p>';
                                                                                                    }
                                                                                                } else {
                                                                                                    echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div><br />
                                                                                <div class="row">
                                                                                    <div class="col-sm">
                                                                                        <div class="card border-dark">
                                                                                            <div class="card-header bg-warning text-dark">
                                                                                                <strong><i class="bi bi-journal-check"></i> Factures</strong>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <?php
                                                                                                if (in_array('AFF_FCTS', $modules, true)) {
                                                                                                    $factures = $ETABLISSEMENTS->lister_factures($ets['code'], $patient['num_population'], null);
                                                                                                    $nb_factures = count($factures);
                                                                                                    if ($nb_factures !== 0) {
                                                                                                        ?>
                                                                                                        <table class="table table-bordered table-sm table-hover">
                                                                                                            <thead class="bg-secondary text-white">
                                                                                                            <tr>
                                                                                                                <th style="width: 5px">#</th>
                                                                                                                <th style="width: 110px">DATE HEURE</th>
                                                                                                                <th style="width: 100px">N° FACTURE</th>
                                                                                                                <th>TYPE</th>
                                                                                                                <th style="width: 45px">TAUX</th>
                                                                                                                <th style="width: 100px">MONTANT</th>
                                                                                                                <th style="width: 100px">PART RGB</th>
                                                                                                                <th style="width: 100px">PART ORG.</th>
                                                                                                                <th style="width: 100px">PART PAT.</th>
                                                                                                                <th style="width: 100px">STATUT</th>
                                                                                                                <?php
                                                                                                                if (in_array('AFF_FCT', $sous_modules, true)) {
                                                                                                                    echo '<th style="width: 5px"></th>';
                                                                                                                }
                                                                                                                ?>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                            <?php
                                                                                                            $ligne_facture = 1;
                                                                                                            foreach ($factures as $facture) {
                                                                                                                if ($facture['code_statut'] === 'A') {
                                                                                                                    $statut = 'ANNULE';
                                                                                                                } elseif ($facture['code_statut'] === 'P') {
                                                                                                                    $statut = 'PAYE';
                                                                                                                } elseif ($facture['code_statut'] === 'N') {
                                                                                                                    $statut = 'EN COURS';
                                                                                                                } else {
                                                                                                                    $statut = null;
                                                                                                                }
                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td class="align_right"><?= $ligne_facture;?></td>
                                                                                                                    <td class="align_center"><?= date('d/m/Y H:i', strtotime($facture['date_creation']));?></td>
                                                                                                                    <td class="align_right"><strong><?= $facture['num_facture'];?></strong></td>
                                                                                                                    <td><?= $facture['libelle_type_facture'];?></td>
                                                                                                                    <td class="align_right"><?= $facture['taux_couverture'];?> %</td>
                                                                                                                    <td class="align_right"><?= number_format($facture['montant_depense'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                                                    <td class="align_right"><?= number_format($facture['montant_rgb'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                                                    <td class="align_right"><?= number_format($facture['montant_organisme'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                                                    <td class="align_right"><?= number_format($facture['montant_patient'], '0', '', ' ').' '.$ets['libelle_monnaie'];?></td>
                                                                                                                    <td><strong class="text-<?= str_replace('A', 'danger', str_replace('N', 'warning', str_replace('P', 'success', $facture['code_statut']))); ?>"><?= $statut;?></strong></td>
                                                                                                                    <?php
                                                                                                                    if (in_array('AFF_FCT', $sous_modules, true)) {
                                                                                                                        ?><td><a class="badge bg-secondary" target="_blank" href="<?= URL.'etablissement/factures/?num='.$facture['num_facture'];?>"><i class="bi bi-eye"></i></a></td><?php
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                </tr>
                                                                                                                <?php
                                                                                                                $ligne_facture++;
                                                                                                            }
                                                                                                            ?>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        <?php
                                                                                                    } else {
                                                                                                        ?>
                                                                                                        <p class="alert alert-info">Aucune facture en attente de paiement pour ce patient.</p>
                                                                                                        <?php
                                                                                                    }
                                                                                                } else {
                                                                                                    echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                }
                                                                                                ?>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        } else {
                                                                            echo '<script>window.location.href="'.URL.'etablissement/dossiers/"</script>';
                                                                        }
                                                                    } else {
                                                                        echo '<script>window.location.href="'.URL.'etablissement/dossiers/"</script>';
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-folder2-open"></i> Dossiers</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <div class="row  justify-content-md-center">
                                                                            <div class="row  justify-content-md-center">
                                                                                <div class="col-sm-12"><?php include "../../_Forms/form_search_dossier.php"; ?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <script>
                                                                        let num_dossier = $("#num_dossier_search_input").val().trim(),
                                                                            num_secu    = $("#num_secu_dossier_search_input").val().trim(),
                                                                            num_patient = $("#nip_search_input").val().trim(),
                                                                            nom_prenoms = $("#nom_prenoms_input").val().trim(),
                                                                            date_debut  = $("#date_debut_search_input").val().trim(),
                                                                            date_fin    = $("#date_fin_search_input").val().trim();
                                                                        if (date_debut && date_fin) {
                                                                            display_etablissement_dossiers(num_dossier, num_secu, num_patient, nom_prenoms, date_debut, date_fin);
                                                                            setInterval(function () {
                                                                                display_etablissement_dossiers(num_dossier, num_secu, num_patient, nom_prenoms, date_debut, date_fin);
                                                                            }, 300000);
                                                                        }
                                                                    </script>
                                                                    <?php
                                                                }
                                                                echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                                echo '<script src="'.JS.'page_etablissement_dossiers.js"></script>';
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
