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
                    if ((int)($user_statut['statut']) === 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if ($user_mdp) {
                            if ((int)($user_mdp['statut']) === 1) {
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
                                                    if (in_array('AFF_PTS', $modules, true)) {
                                                        if (isset($parametres['url'])) {
                                                            $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                            if ($audit['success'] === true) {
                                                                include "../../../Menu.php";
                                                                require_once "../../../../Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                                                                require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                                require_once "../../../../Classes/SITUATIONSFAMILIALES.php";
                                                                require_once "../../../../Classes/SECTEURSACTIVITES.php";
                                                                require_once "../../../../Classes/COLLECTIVITES.php";
                                                                require_once "../../../../Classes/PROFESSIONS.php";
                                                                require_once "../../../../Classes/ORGANISMES.php";
                                                                require_once "../../../../Classes/CIVILITES.php";
                                                                require_once "../../../../Classes/SEXES.php";
                                                                $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                                                                $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                                $SITUATIONSFAMILIALES = new SITUATIONSFAMILIALES();
                                                                $SECTEURSACTIVITES = new SECTEURSACTIVITES();
                                                                $COLLECTIVITES = new COLLECTIVITES();
                                                                $PROFESSIONS = new PROFESSIONS();
                                                                $ORGANISMES = new ORGANISMES();
                                                                $CIVILITES = new CIVILITES();
                                                                $SEXES = new SEXES();

                                                                $categories_professionnelles = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
                                                                $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                                $situations_familiales = $SITUATIONSFAMILIALES->lister();
                                                                $secteurs_activites = $SECTEURSACTIVITES->lister();
                                                                $professions = $PROFESSIONS->lister();
                                                                $assurances = $ORGANISMES->lister();
                                                                $civilites = $CIVILITES->lister();
                                                                $sexes = $SEXES->lister();
                                                                if (isset($_POST['num_patient']) && $_POST['num_patient']) {
                                                                    if (in_array('AFF_PT', $sous_modules, true)) {
                                                                        require_once "../../../../Classes/TYPESFACTURESMEDICALES.php";
                                                                        require_once "../../../../Classes/TYPESCOORDONNEES.php";
                                                                        require_once "../../../../Classes/POPULATIONS.php";
                                                                        require_once "../../../../Classes/PATIENTS.php";
                                                                        $TYPESFACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                                                                        $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                                                                        $POPULATIONS = new POPULATIONS();
                                                                        $PATIENTS = new PATIENTS();
                                                                        $types_coordonnees = $TYPESCOORDONNEES->lister();
                                                                        $types_factures = $TYPESFACTURESMEDICALES->lister();
                                                                        $patient = $ETABLISSEMENTS->trouver_patient($ets['code'], $_POST['num_patient']);
                                                                        if ($patient) {
                                                                            $patient_organismes = $PATIENTS->lister_organismes($patient['num_population'], date('Y-m-d', time()));
                                                                            $nb_patient_organismes = count($patient_organismes);
                                                                            $coordonnees_requises = array('MOBPER','MELPER', 'MELPRO', 'MOBPRO');
                                                                            $constantes = $PATIENTS->trouver_dernieres_constantes($patient['num_population']);
                                                                            if (!$constantes) {
                                                                                $constantes = array(
                                                                                    'poids' => '--',
                                                                                    'temperature' => '--',
                                                                                    'pouls' => '--'
                                                                                );
                                                                            }
                                                                            $civilite_p = $CIVILITES->trouver($patient['code_civilite']);
                                                                            $sexe_p = $SEXES->trouver($patient['code_sexe']);
                                                                            $profession_p = $PROFESSIONS->trouver($patient['code_profession']);
                                                                            $commune_residence_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_commune($patient['code_commune_residence']);
                                                                            $collectivite_p = $COLLECTIVITES->trouver(null);

                                                                            $regions = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($patient['code_pays_residence']);
                                                                            $departements = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($patient['code_region_residence']);
                                                                            $communes = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($patient['code_departement_residence']);

                                                                            $region_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_region($patient['code_region_residence']);
                                                                            $departement_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_departement($patient['code_departement_residence']);
                                                                            $commune_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_commune($patient['code_commune_residence']);

                                                                            $tz  = new DateTimeZone('Africa/Abidjan');
                                                                            $age = DateTime::createFromFormat('Y-m-d', $patient['date_naissance'], $tz)
                                                                                ->diff(new DateTime('now', $tz))
                                                                                ->y;

                                                                            $dossiers_ouverts = $ETABLISSEMENTS->lister_dossiers_ouverts($ets['code'], $patient['num_population']);
                                                                            $nb_dossiers_ouverts = count($dossiers_ouverts);

                                                                            $ecurgences = $POPULATIONS->lister_ecu($patient['num_population']);
                                                                            $nb_ecurgences = count($ecurgences);
                                                                            ?>
                                                                            <div class="container-xl" id="div_main_page">
                                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                                    <ol class="breadcrumb">
                                                                                        <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                        <li class="breadcrumb-item"><a href="<?= URL . 'etablissement/patients/'; ?>"><i class="bi bi-person-circle"></i> Patients</a></li>
                                                                                        <li class="breadcrumb-item active" aria-current="page"><?= $patient['nom'] . ' ' . $patient['prenom'];?></li>
                                                                                    </ol>
                                                                                </nav>
                                                                                <p class="p_page_titre h4"><?= $patient['nom'].' '.$patient['prenom']. ' ('.$age.'ans)'; ?></p>
                                                                                <div id="div_resultats_user"></div>
                                                                                <div class="div_buttons">
                                                                                    <button type="button" class="btn btn-secondary btn-sm" title="Imprimer la fiche patient"><i class="bi bi-printer"></i> Imprimer</button>
                                                                                    <?php
                                                                                    if (in_array('EDT_PT', $sous_modules, true)) {
                                                                                        ?>
                                                                                        <button type="button" class="btn btn-warning btn-sm btn_edit" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i> Editer</button>
                                                                                        <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                <div class="modal-content bg-white text-dark">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="editionModalLabel">Edition <?= ucwords(strtolower($patient['nom'])) . ' ' . ucwords(strtolower($patient['prenom'])); ?></h5>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <?php include "../../_Forms/form_patient.php";?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <button type="button" class="btn btn-warning btn-sm btn_edit" data-bs-toggle="modal" data-bs-target="#editionCoordonneesModal"><i class="bi bi-pencil-square"></i> Coordonnées</button>
                                                                                        <div class="modal fade" id="editionCoordonneesModal" tabindex="-1" aria-labelledby="editionCoordonneesModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="editionCoordonneesModalLabel">Coordonnées <?= $patient['prenom'];?></h5>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <?php include "../../_Forms/form_patient_coordonnee.php"; ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <button type="button" class="btn btn-warning btn-sm btn_edit" data-bs-toggle="modal" data-bs-target="#editionEnCasDurgenceModal"><i class="bi bi-pencil-square"></i> En cas d'urgence</button>
                                                                                        <div class="modal fade" id="editionEnCasDurgenceModal" tabindex="-1" aria-labelledby="editionEnCasDurgenceModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="editionEnCasDurgenceModalLabel">A prévenir en cas d'urgence</h5>
                                                                                                    </div>
                                                                                                    <div class="modal-body">

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                    if (in_array('EDT_PT_ANTMED', $sous_modules, true)) {
                                                                                        ?>
                                                                                        <button type="button" class="btn btn-warning btn-sm btn_edit" data-bs-toggle="modal" data-bs-target="#editionAntecedantsMedicauxModal"><i class="bi bi-pencil-square"></i> Antécédant médical</button>
                                                                                        <div class="modal fade" id="editionAntecedantsMedicauxModal" tabindex="-1" aria-labelledby="editionAntecedantsMedicauxModalLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                                <div class="modal-content">
                                                                                                    <div class="modal-header">
                                                                                                        <h5 class="modal-title" id="editionAntecedantsMedicauxModal">Antécédant médical</h5>
                                                                                                    </div>
                                                                                                    <div class="modal-body">

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                    if (in_array('EDT_DOS', $sous_modules, true)) {
                                                                                        if ($nb_dossiers_ouverts === 0) {
                                                                                            ?>
                                                                                            <button type="button" class="btn btn-primary btn-sm" title="Nouveau dossier" data-bs-toggle="modal" data-bs-target="#editionDossierModal"><i class="bi bi-folder-plus"></i> Nouveau dossier</button>
                                                                                            <div class="modal fade" id="editionDossierModal" tabindex="-1" aria-labelledby="editionDossierModalLabel" aria-hidden="true">
                                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                                    <div class="modal-content bg-white text-dark">
                                                                                                        <div class="modal-header">
                                                                                                            <h5 class="modal-title" id="editionDossierModalLabel">
                                                                                                                <i class="bi bi-folder-plus"></i> Nouveau dossier pour <?= $patient['prenom'];?></h5>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <?php include "../../_Forms/form_dossier.php"; ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    if (in_array('EDT_FCT', $sous_modules, true)) {
                                                                                        if ($nb_dossiers_ouverts !== 0) {
                                                                                            ?>
                                                                                            <a href="<?= URL.'etablissement/factures/edition?nip='.$patient['num_population'];?>" class="btn btn-primary btn-sm" title="Nouvelle facture"><i class="bi bi-journal-plus"></i> Nouvelle facture</a>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                                <br/>
                                                                                <div id="div_profil">
                                                                                    <?php
                                                                                    if($nb_patient_organismes !== 0) {
                                                                                        ?>
                                                                                        <div class="row">
                                                                                            <div class="col-sm">
                                                                                                <div class="card border-dark">
                                                                                                    <div class="card-header bg-dark text-white">
                                                                                                        <strong><i class="bi bi-info-lg"></i> Assurances</strong>
                                                                                                    </div>
                                                                                                    <div class="card-body">
                                                                                                        <table class="table table-sm table-bordered">
                                                                                                            <thead>
                                                                                                            <tr>
                                                                                                                <th>ASSURANCE</th>
                                                                                                                <th>COLLECTIVITE</th>
                                                                                                                <th style="width: 110px">CONTRAT</th>
                                                                                                                <th>PRODUIT</th>
                                                                                                                <th style="width: 10px">TAUX</th>
                                                                                                                <th style="width: 100px">DEBUT</th>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                            <?php
                                                                                                            foreach ($patient_organismes as $patient_organisme) {
                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td><?= $patient_organisme['libelle_organisme'];?></td>
                                                                                                                    <td><?= $patient_organisme['raison_sociale'];?></td>
                                                                                                                    <td><?= $patient_organisme['code_contrat'];?></td>
                                                                                                                    <td><?= $patient_organisme['libelle_produit'];?></td>
                                                                                                                    <td class="align_right"><strong><?= $patient_organisme['taux_couverture'];?>%</strong></td>
                                                                                                                    <td><?= date('d/m/Y', strtotime($patient_organisme['date_debut_contrat']));?></td>
                                                                                                                </tr>
                                                                                                                <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div><br/>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                    <div class="row">
                                                                                        <div class="col-sm">
                                                                                            <div class="card border-dark">
                                                                                                <div class="card-header bg-indigo text-white">
                                                                                                    <strong><i class="bi bi-info-lg"></i> Données biographiques</strong>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-2">
                                                                                                            <div class="card text-center">
                                                                                                                <button type="button" id="button_population_photo" class="btn" data-bs-toggle="modal" data-bs-target="#editionPhotoModal"><img src="
                                                                                                                <?php if (!$patient['photo']) {
                                                                                                                        echo IMAGES.'photos_profil/avatar.png';
                                                                                                                } else {
                                                                                                                    echo IMAGES.'photos_profil/populations/'.$patient['num_population'].'/'.$patient['photo'];
                                                                                                                } ?>" style="width: 100%" class="card-img-top" alt="Photo <?= $patient['prenom'];?>"></button>
                                                                                                                <?php
                                                                                                                if (in_array('EDT_PT', $sous_modules, true)) {
                                                                                                                    ?>
                                                                                                                    <div class="modal fade" id="editionPhotoModal" tabindex="-1" aria-labelledby="editionPhotoModalLabel" aria-hidden="true">
                                                                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                                                                            <div class="modal-content">
                                                                                                                                <div class="modal-header">
                                                                                                                                    <h5 class="modal-title" id="editionPhotoModalLabel">
                                                                                                                                        Photo <?= $patient['prenom'];?></h5>
                                                                                                                                </div>
                                                                                                                                <div class="modal-body">
                                                                                                                                    <?php include "../../_Forms/form_patient_photo.php"; ?>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <?php
                                                                                                                }
                                                                                                                ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-sm">
                                                                                                            <table class="table table-sm table-hover" style="width: 100%">
                                                                                                                <tbody>
                                                                                                                <tr>
                                                                                                                    <td>N° IP</td>
                                                                                                                    <td class="align_right"><strong id="num_patient_strong"><?= $patient['num_population'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>N° sécu</td>
                                                                                                                    <td class="align_right"><strong><?= $patient['num_rgb'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Civilité</td>
                                                                                                                    <td class="align_right"><strong><?= $civilite_p['libelle'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Nom</td>
                                                                                                                    <td class="align_right"><strong><?php if ($patient['nom_patronymique']) {
                                                                                                                                echo $patient['nom_patronymique'].' Epse ';
                                                                                                                                                    } ?> <?= $patient['nom'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Prénom(s)</td>
                                                                                                                    <td class="align_right"><strong><?= $patient['prenom'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Date de naissance</td>
                                                                                                                    <td class="align_right"><strong><?= date('d/m/Y', strtotime($patient['date_naissance']));?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Sexe</td>
                                                                                                                    <td class="align_right"><strong><?= $sexe_p['libelle'];?></strong></td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                        <div class="col-sm">
                                                                                                            <table class="table table-sm table-hover" style="width: 100%">
                                                                                                                <tbody>
                                                                                                                <tr>
                                                                                                                    <td>Adresse</td>
                                                                                                                    <td class="align_right"><strong><?= $departement_p['nom'].', '.$commune_p['nom'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Adresse géographique</td>
                                                                                                                    <td class="align_right"><strong><?= $patient['adresse_geographique'];?></strong></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td>Adresse postale</td>
                                                                                                                    <td class="align_right"><strong><?= $patient['adresse_postale'];?></strong></td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                            <?php
                                                                                                            $coordonnees = $POPULATIONS->lister_coordonnees($patient['num_population']);
                                                                                                            $nb_coordonnees = count($coordonnees);
                                                                                                            if ($nb_coordonnees != 0) {
                                                                                                                ?>
                                                                                                                <table class="table table-sm table-hover" style="width: 100%">
                                                                                                                    <tbody>
                                                                                                                    <?php
                                                                                                                    foreach ($coordonnees as $coordonnee) {
                                                                                                                        ?>
                                                                                                                        <tr>
                                                                                                                            <td style="width: 5px"><?= str_replace('MOBPER', '<i class="bi bi-whatsapp"></i>', str_replace('MOBPRO', '<i class="bi bi-phone-fill"></i>', str_replace('MELPER', '<i class="bi bi-at"></i>', $coordonnee['code_type'])));?></td>
                                                                                                                            <td><strong><?php if ($coordonnee['code_type'] == 'MELPER') {
                                                                                                                                        echo '<a href="mailto:'.$coordonnee['valeur'].'">'.$coordonnee['valeur'].'</a>';
                                                                                                                                        } else {
                                                                                                                                            echo $coordonnee['valeur'];
                                                                                                                                        } ?></strong></td>
                                                                                                                        </tr>
                                                                                                                        <?php
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                                <?php
                                                                                                            } else {
                                                                                                                ?>
                                                                                                                <p class="alert alert-info">Aucune coordonnée n'a encore été enregistrée pour ce patient.</p>
                                                                                                                <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br/>
                                                                                    <div class="row">
                                                                                        <div class="col-sm">
                                                                                            <div class="card border-dark">
                                                                                                <div class="card-header bg-indigo text-white">
                                                                                                    <strong><i class="bi bi-folder2-open"></i> Dossiers médicaux</strong>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    if (in_array('AFF_DOSS', $modules, true)) {
                                                                                                        $dossiers = $ETABLISSEMENTS->lister_dossiers($ets['code'], $patient['num_population'], 500);
                                                                                                        $nb_dossiers = count($dossiers);
                                                                                                        if ($nb_dossiers != 0) {
                                                                                                            ?>
                                                                                                            <table class="table table-sm table-stripped table-hover">
                                                                                                                <thead class="bg-secondary">
                                                                                                                <tr>
                                                                                                                    <th style="width: 5px">N°</th>
                                                                                                                    <th>DATE HEURE</th>
                                                                                                                    <th>N° DOSSIER</th>
                                                                                                                    <th>DATE DEBUT</th>
                                                                                                                    <th>DATE FIN</th>
                                                                                                                    <?php
                                                                                                                    if (in_array('AFF_DOS', $sous_modules, true)) {
                                                                                                                        echo '<th style="width: 5px"></th>';
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                <?php
                                                                                                                $ligne_dossier = 1;
                                                                                                                foreach ($dossiers as $dossier) {
                                                                                                                    ?>
                                                                                                                    <tr>
                                                                                                                        <td class="align_right"><?= $ligne_dossier;?></td>
                                                                                                                        <td class="align_center"><?= date('d/m/Y H:i', strtotime($dossier['date_creation']));?></td>
                                                                                                                        <td><strong><?= $dossier['code_dossier'];?></strong></td>
                                                                                                                        <td class="align_center"><?= date('d/m/Y', strtotime($dossier['date_debut']));?></td>
                                                                                                                        <td class="align_center"><?= $dossier['date_fin']? date('d/m/Y', strtotime($dossier['date_fin'])): null;?></td>
                                                                                                                        <?php
                                                                                                                        if (in_array('AFF_DOS', $sous_modules, true)) {
                                                                                                                            ?><td><a href="<?= URL.'etablissement/dossiers/?num='.$dossier['code_dossier'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td><?php
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                    </tr>
                                                                                                                    <?php
                                                                                                                    $ligne_dossier++;
                                                                                                                }
                                                                                                                ?>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                            <?php
                                                                                                        } else {
                                                                                                            ?>
                                                                                                            <p class="align_center alert alert-info"><strong>Aucun dossier n'a encore été edité pour ce patient.</strong></p>
                                                                                                            <?php
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                    }
                                                                                                    ?>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm">
                                                                                            <div class="card border-dark">
                                                                                                <div class="card-header bg-warning text-dark">
                                                                                                    <strong><i class="bi bi-journal-check"></i> Factures en attente</strong>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    if (in_array('AFF_FCTS', $modules, true)) {
                                                                                                        $factures = $ETABLISSEMENTS->lister_factures_en_attente($ets['code'], $patient['num_population']);
                                                                                                        $nb_factures = count($factures);
                                                                                                        if ($nb_factures != 0) {
                                                                                                            ?>
                                                                                                            <table class="table table-sm">
                                                                                                                <thead class="bg-secondary">
                                                                                                                <tr>
                                                                                                                    <th style="width: 5px">N°</th>
                                                                                                                    <th>DATE HEURE</th>
                                                                                                                    <th>N° FACTURE</th>
                                                                                                                    <th>N° DOSSIER</th>
                                                                                                                    <th style="width: 5px"></th>
                                                                                                                </tr>
                                                                                                                </thead>
                                                                                                                <tbody>
                                                                                                                <?php
                                                                                                                $ligne_facture = 1;
                                                                                                                foreach ($factures as $facture) {
                                                                                                                    ?>
                                                                                                                    <tr>
                                                                                                                        <td class="align_right"><?= $ligne_facture;?></td>
                                                                                                                        <td class="align_center"><?= date('d/m/Y H:i', strtotime($facture['date_creation']));?></td>
                                                                                                                        <td class="align_right"><strong><?= $facture['num_facture'];?></strong></td>
                                                                                                                        <td class="align_right"><strong><?= $facture['code_dossier'];?></strong></td>
                                                                                                                        <td><button class="badge bg-dark btn_print_bill" id="<?= $facture['num_facture'];?>"><i class="bi bi-printer"></i></button></td>
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
                                                                                                            <p class="align_center alert alert-info"><strong>Aucune facture en attente de paiement pour ce patient.</strong></p>
                                                                                                            <?php
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
                                                                                                <div class="card-header bg-indigo text-white">
                                                                                                    <strong><i class="bi bi-info-lg"></i> Antécédents médicaux</strong>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    if (in_array('AFF_PT_ANTMED', $sous_modules, true)) {
                                                                                                        ?>
                                                                                                        <div class="row">
                                                                                                            <div class="col">1</div>
                                                                                                            <div class="col">2</div>
                                                                                                            <div class="col">3</div>
                                                                                                        </div>
                                                                                                        <?php
                                                                                                    } else {
                                                                                                        echo '<p class="align_center alert alert-danger"><strong>Vous n\'êtes pas autorisé à accéder à cette ressource.</strong></p>';
                                                                                                    }
                                                                                                    ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <br/>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <div class="card border-dark">
                                                                                                <div class="card-header bg-indigo text-white">
                                                                                                    <strong><i class="bi bi-cone"></i> Dernières constantes</strong>
                                                                                                </div>
                                                                                                <div class="card-body">
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
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm">
                                                                                            <div class="card border-dark">
                                                                                                <div class="card-header bg-danger text-white">
                                                                                                    <strong><i class="bi bi-back"></i> En cas d'urgence</strong>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    if ($nb_ecurgences !== 0) {
                                                                                                        ?>
                                                                                                        <table class="table table-sm table-stripped table-hover">
                                                                                                            <thead>
                                                                                                            <tr>
                                                                                                                <th>TYPE</th>
                                                                                                                <th>NOM & PRENOM(s)</th>
                                                                                                                <th>CONTACT</th>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                            <?php
                                                                                                            foreach ($ecurgences as $ecurgence) {
                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td><?= $ecurgence['code_type_personne'];?></td>
                                                                                                                    <td><?= $ecurgence['nom'].' '.$ecurgence['prenoms'];?></td>
                                                                                                                    <td><?= $ecurgence['num_telephone'];?></td>
                                                                                                                </tr>
                                                                                                                <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        <?php
                                                                                                    } else {
                                                                                                        ?>
                                                                                                        <p class="align_center alert alert-info"><strong>Aucune personne n'a encore été enregistrée pour ce patient.</strong></p>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        } else {
                                                                            echo '<script>window.location.href="'.URL.'etablissement/patients/"</script>';
                                                                        }
                                                                    } else {
                                                                        echo '<script>window.location.href="'.URL.'etablissement/patients/"</script>';
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <div class="container-xl" id="div_main_page">
                                                                        <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                            <ol class="breadcrumb">
                                                                                <li class="breadcrumb-item"><a href="<?= URL.'etablissement/';?>"><i class="bi bi-building"></i> <?= acronyme($ets['raison_sociale'], -1);?></a></li>
                                                                                <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-circle"></i> Patients</li>
                                                                            </ol>
                                                                        </nav>
                                                                        <?php
                                                                        if (in_array('EDT_PT', $sous_modules, true)) {
                                                                            ?>
                                                                            <p class="align_right p_button"><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-plus-square-fill"></i></button></p>
                                                                            <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                                <div class="modal-dialog modal-lg">
                                                                                    <div class="modal-content bg-white text-dark">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title" id="editionModalLabel">Nouveau patient</h5>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <?php include "../../_Forms/form_patient.php";?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                        <p class="p_page_titre h4"><i class="bi bi-person-circle"></i> Patients</p>
                                                                        <div class="col-sm-12"><?php include "../../_Forms/form_search_patient.php"; ?></div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                echo '<script src="'.JS.'page_etablissement_patients.js"></script>';
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
                                                echo '<p class="alert alert-danger align_center">Aucun établissement correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        } else {
                                            echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    } else {
                                        echo '<script>window.location.href="'.URL.'etablissement/"</script>';
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
