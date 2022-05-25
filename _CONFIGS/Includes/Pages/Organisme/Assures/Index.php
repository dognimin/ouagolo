<?php
require_once "../../../../Classes/UTILISATEURS.php";
require_once "../../../../Functions/Functions.php";
$parametres = array(
    'url' => clean_data($_POST['url'])
);
if($_SESSION) {
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $user = $UTILISATEURS->trouver($session['id_user'],null);
            if($user) {
                $user_statut = $UTILISATEURS->trouver_statut($user['id_user']);
                if($user_statut) {
                    if($user_statut['statut'] == 1) {
                        $user_mdp = $UTILISATEURS->trouver_mot_de_passe($user['id_user']);
                        if($user_mdp) {
                            if($user_mdp['statut'] == 1) {
                                $profil = $UTILISATEURS->trouver_profil($user['id_user']);
                                if ($profil) {
                                    if($profil['code_profil'] == 'ORGANI') {
                                        require_once "../../../../Classes/ORGANISMES.php";
                                        $ORGANISMES = new ORGANISMES();
                                        $user_profil = $UTILISATEURS->trouver_utilisateur_organisme($user['id_user']);
                                        if($user_profil) {
                                            $organisme = $ORGANISMES->trouver($user_profil['code_organisme']);
                                            if($organisme) {
                                                if (isset($parametres['url'])) {
                                                    $audit = $UTILISATEURS->editer_piste_audit($session['code_session'], $parametres['url'], 'AFFICHAGE', null);
                                                    if($audit['success'] == true) {
                                                        include "../../../Menu.php";
                                                        if(isset($_POST['num']) && $_POST['num']) {
                                                            require_once "../../../../Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                                                            require_once "../../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                                                            require_once "../../../../Classes/SITUATIONSFAMILIALES.php";
                                                            require_once "../../../../Classes/SECTEURSACTIVITES.php";
                                                            require_once "../../../../Classes/TYPESCOORDONNEES.php";
                                                            require_once "../../../../Classes/QUALITESCIVILES.php";
                                                            require_once "../../../../Classes/COLLECTIVITES.php";
                                                            require_once "../../../../Classes/POPULATIONS.php";
                                                            require_once "../../../../Classes/PROFESSIONS.php";
                                                            require_once "../../../../Classes/ORGANISMES.php";
                                                            require_once "../../../../Classes/CIVILITES.php";
                                                            require_once "../../../../Classes/COLLEGES.php";
                                                            require_once "../../../../Classes/SEXES.php";
                                                            $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                                                            $LOCALISATIONSGEOGRAPHIQUES = new LOCALISATIONSGEOGRAPHIQUES();
                                                            $SITUATIONSFAMILIALES = new SITUATIONSFAMILIALES();
                                                            $SECTEURSACTIVITES = new SECTEURSACTIVITES();
                                                            $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                                                            $QUALITESCIVILES = new QUALITESCIVILES();
                                                            $COLLECTIVITES = new COLLECTIVITES();
                                                            $POPULATIONS = new POPULATIONS();
                                                            $PROFESSIONS = new PROFESSIONS();
                                                            $ORGANISMES = new ORGANISMES();
                                                            $CIVILITES = new CIVILITES();
                                                            $COLLEGES = new COLLEGES();
                                                            $SEXES = new SEXES();


                                                            $assure = $ORGANISMES->trouver_assure($organisme['code'], $_POST['num']);
                                                            if($assure) {
                                                                $categories_socio_professionnelles = $CATEGORIESSOCIOPROFESSIONNELLES->lister();
                                                                $situations_familiales = $SITUATIONSFAMILIALES->lister();
                                                                $secteurs_activites = $SECTEURSACTIVITES->lister();
                                                                $Pays = $LOCALISATIONSGEOGRAPHIQUES->lister_pays();
                                                                $qualites_civiles = $QUALITESCIVILES->lister();
                                                                $professions = $PROFESSIONS->lister();
                                                                $civilites = $CIVILITES->lister();
                                                                $sexes = $SEXES->lister();
                                                                $types_coordonnees = $TYPESCOORDONNEES->lister();
                                                                $coordonnees_requises = array('MOBPER','MELPER', 'MELPRO', 'MOBPRO');


                                                                $nationalite_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_pays($assure['code_nationalite'], null);
                                                                $csp_p = $CATEGORIESSOCIOPROFESSIONNELLES->trouver($assure['code_csp']);
                                                                $situation_matrimoniale = $SITUATIONSFAMILIALES->trouver($assure['code_situation_familiale']);
                                                                $civilite_p = $CIVILITES->trouver($assure['code_civilite']);
                                                                $sexe_p = $SEXES->trouver($assure['code_sexe']);
                                                                $profession_p = $PROFESSIONS->trouver($assure['code_profession']);
                                                                $commune_residence_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_commune($assure['code_commune_residence']);
                                                                $collectivite_p = $POPULATIONS->trouver_collectivite($assure['num_population']);


                                                                $regions_naissance = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($assure['code_pays_naissance']);
                                                                $departements_naissance = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($assure['code_region_naissance']);
                                                                $communes_naissance = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($assure['code_departement_naissance']);

                                                                $regions_residence = $LOCALISATIONSGEOGRAPHIQUES->lister_regions($assure['code_pays_residence']);
                                                                $departements_residence = $LOCALISATIONSGEOGRAPHIQUES->lister_departements($assure['code_region_residence']);
                                                                $communes_residence = $LOCALISATIONSGEOGRAPHIQUES->lister_communes($assure['code_departement_residence']);

                                                                $pays_n_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_pays($assure['code_pays_naissance'], null);
                                                                $region_n_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_region($assure['code_region_naissance']);
                                                                $departement_n_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_departement($assure['code_departement_naissance']);
                                                                $commune_n_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_commune($assure['code_commune_naissance']);

                                                                $region_r_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_region($assure['code_region_residence']);
                                                                $departement_r_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_departement($assure['code_departement_residence']);
                                                                $commune_r_p = $LOCALISATIONSGEOGRAPHIQUES->trouver_commune($assure['code_commune_residence']);


                                                                ?>
                                                                <div class="container-xl" id="div_main_page">
                                                                    <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                        <ol class="breadcrumb">
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                            <li class="breadcrumb-item"><a href="<?= URL.'organisme/assures/';?>"><i class="bi bi-person-lines-fill"></i> Assurés</a></li>
                                                                            <li class="breadcrumb-item active" aria-current="page"><?= $assure['nom'].' '.$assure['prenom'];?></li>
                                                                        </ol>
                                                                    </nav>
                                                                    <p class="p_page_titre h4"><i class="bi bi-person-lines-fill"></i> <?= $assure['nom'].' '.$assure['prenom'];?></p>
                                                                    <div class="div_buttons">
                                                                        <button type="button" class="btn btn-warning btn-sm btn_edit" data-bs-toggle="modal" data-bs-target="#editionModal"><i class="bi bi-pencil-square"></i> Editer</button>
                                                                        <div class="modal fade" id="editionModal" tabindex="-1" aria-labelledby="editionModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                <div class="modal-content bg-white text-dark">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editionModalLabel">Edition <?= ucwords(strtolower($assure['nom'])) . ' ' . ucwords(strtolower($assure['prenom'])); ?></h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php include "../../_Forms/form_assure.php";?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button type="button" class="btn btn-warning btn-sm btn_edit" data-bs-toggle="modal" data-bs-target="#editionCoordonneesModal"><i class="bi bi-pencil-square"></i> Coordonnées</button>
                                                                        <div class="modal fade" id="editionCoordonneesModal" tabindex="-1" aria-labelledby="editionCoordonneesModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content bg-white text-dark">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="editionCoordonneesModalLabel">Coordonnées <?= $assure['prenom'];?></h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <?php include "../../_Forms/form_assure_coordonnee.php";?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><br />
                                                                    <div id="div_profil">
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
                                                                                                                <?php if (!$assure['photo']) {
                                                                                                            echo IMAGES.'photos_profil/avatar.png';
                                                                                                        } else {
                                                                                                            echo IMAGES.'photos_profil/populations/'.$assure['num_population'].'/'.$assure['photo'];
                                                                                                        } ?>" style="width: 100%" class="card-img-top" alt="Photo <?= $assure['prenom'];?>"></button>
                                                                                                    <div class="modal fade" id="editionPhotoModal" tabindex="-1" aria-labelledby="editionPhotoModalLabel" aria-hidden="true">
                                                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                                                            <div class="modal-content bg-white text-dark">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="editionPhotoModalLabel">
                                                                                                                        Photo <?= $assure['prenom'];?></h5>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    <?php include "../../_Forms/form_assure_photo.php"; ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm">
                                                                                                <table class="table table-sm table-hover" style="width: 100%">
                                                                                                    <tbody>
                                                                                                    <tr>
                                                                                                        <td>N° IP</td>
                                                                                                        <td class="align_right"><strong id="num_patient_strong"><?= $assure['num_population'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>N° sécu</td>
                                                                                                        <td class="align_right"><strong><?= $assure['num_rgb'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Civilité</td>
                                                                                                        <td class="align_right"><strong><?= $civilite_p['libelle'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Nom</td>
                                                                                                        <td class="align_right"><strong><?php if ($assure['nom_patronymique']) {
                                                                                                                    echo $assure['nom_patronymique'].' Epse ';
                                                                                                                } ?> <?= $assure['nom'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Prénom(s)</td>
                                                                                                        <td class="align_right"><strong><?= $assure['prenom'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Date de naissance</td>
                                                                                                        <td class="align_right"><strong><?= date('d/m/Y', strtotime($assure['date_naissance']));?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Nationalité</td>
                                                                                                        <td class="align_right"><strong><?= $nationalite_p? $nationalite_p['gentile']: null;?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Lieu de naissance</td>
                                                                                                        <td class="align_right"><strong><?= $pays_n_p? $pays_n_p['nom']: null;?></strong></td>
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
                                                                                                        <td>Situation matrimoniale</td>
                                                                                                        <td class="align_right"><strong><?= $situation_matrimoniale['libelle'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Adresse</td>
                                                                                                        <td class="align_right"><strong><?= $departement_r_p['nom'].', '.$commune_r_p['nom'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Adresse géographique</td>
                                                                                                        <td class="align_right"><strong><?= $assure['adresse_geographique'];?></strong></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td>Adresse postale</td>
                                                                                                        <td class="align_right"><strong><?= $assure['adresse_postale'];?></strong></td>
                                                                                                    </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <?php
                                                                                                $coordonnees = $POPULATIONS->lister_coordonnees($assure['num_population']);
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
                                                                                                    <p class="alert alert-info">Aucune coordonnée n'a encore été enregistrée pour cet assuré.</p>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div><br />
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="card border-primary">
                                                                                    <div class="card-header bg-primary text-white">
                                                                                        <strong><i class="bi bi-person-workspace"></i> Informations professionnelles</strong>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <table class="table table-sm table-hover" style="width: 100%">
                                                                                            <tr>
                                                                                                <td>Catégorie socio-professionnelle</td>
                                                                                                <td class="align_right"><strong id="num_patient_strong"><?= $csp_p? $csp_p['libelle']: null;?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Profession</td>
                                                                                                <td class="align_right"><strong id="num_patient_strong"><?= $profession_p? $profession_p['libelle']: null;?></strong></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Collectivité</td>
                                                                                                <td class="align_right"><strong id="num_patient_strong"><?= $collectivite_p? $collectivite_p['raison_sociale']: null;?></strong></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div><br />
                                                                        <div class="row">
                                                                            <div class="col-sm">
                                                                                <div class="card border-success">
                                                                                    <div class="card-header bg-success text-white">
                                                                                        <strong><i class="bi bi-card-text"></i> Contrats</strong>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <?php
                                                                                        $colleges = $COLLEGES->lister_assure_colleges($organisme['code'], $assure['num_population']);
                                                                                        $nb_colleges = count($colleges);
                                                                                        if($nb_colleges !== 0) {
                                                                                            ?>
                                                                                            <table class="table table-bordered table-sm table-hover">
                                                                                                <thead class="bg-indigo text-white">
                                                                                                <tr>
                                                                                                    <th style="width: 5px;">#</th>
                                                                                                    <th style="width: 5px;">TYPE</th>
                                                                                                    <th style="width: 100px;">N° CONTRAT</th>
                                                                                                    <th>COLLECTIVITE</th>
                                                                                                    <th style="width: 100px;">DATE DEBUT</th>
                                                                                                    <th style="width: 100px;">DATE FIN</th>
                                                                                                    <th style="width: 5px;"></th>
                                                                                                    <th style="width: 5px;"></th>
                                                                                                </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                <?php
                                                                                                $ligne_college = 1;
                                                                                                foreach ($colleges as $college) {
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td class="align_right"><?= $ligne_college;?></td>
                                                                                                        <td><strong><?= $college['code_qualite_civile'];?></strong></td>
                                                                                                        <td><?= $college['code'];?></td>
                                                                                                        <td><?= $college['raison_sociale'];?></td>
                                                                                                        <td class="align_center"><?= date('d/m/Y', strtotime($college['date_debut']));?></td>
                                                                                                        <td class="align_center"><?= $college['date_fin']? date('d/m/Y', strtotime($college['date_fin'])): date('d/m/Y', strtotime($college['date_fin_contrat']));?></td>
                                                                                                        <td class=" bg-dark">
                                                                                                            <button type="button" class="btn badge bg-dark button_lister_ouvrant_ayant_droits" id="<?= $college['code'].'|'.$college['num_population_contractant'].'|'.$college['code_qualite_civile'];?>" data-bs-toggle="modal" data-bs-target="#ayantOuvrantDroitsModal" title="<?= ($college['code_qualite_civile'] === 'PAY')? 'Ayants-droits': 'Souscripteur';?>"><i class="bi bi-<?= ($college['code_qualite_civile'] === 'PAY')? 'people-fill': 'person-fill';?>"></i></button>
                                                                                                            <div class="modal fade" id="ayantOuvrantDroitsModal" tabindex="-1" aria-labelledby="ayantOuvrantDroitsModalLabel" aria-hidden="true">
                                                                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                                                                    <div class="modal-content bg-white text-dark">
                                                                                                                        <div class="modal-header">
                                                                                                                            <h5 class="modal-title" id="ayantOuvrantDroitsModalLabel"></h5>
                                                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                        </div>
                                                                                                                        <div class="modal-body" id="ayantOuvrantDroitsModalBody"></div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                        <td class="bg-info"><a target="_blank" href="<?= URL.'organisme/contrats/?code='.$college['code'];?>" class="badge bg-info"><i class="bi bi-eye"></i></a></td>
                                                                                                    </tr>
                                                                                                    <?php
                                                                                                    $ligne_college++;
                                                                                                }
                                                                                                ?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <?php
                                                                                        }else {
                                                                                            echo '<p class="alert alert-info">Aucun contrat n\'a encore éré enregistré pour cet assuré.</p>';
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div><br />
                                                                        <div class="row">
                                                                            <div class="col-sm">
                                                                                <div class="card border-danger">
                                                                                    <div class="card-header bg-danger text-white">
                                                                                        <strong><i class="bi bi-info-lg"></i> Consommations</strong>
                                                                                    </div>
                                                                                    <div class="card-body">

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }else {
                                                                echo '<script>window.location.href="'.URL.'organisme/assures/"</script>';
                                                            }
                                                        } else {
                                                            ?>
                                                            <div class="container-xl" id="div_main_page">
                                                                <nav id="nav_breadcrumb" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item"><a href="<?= URL.'organisme/';?>"><i class="bi bi-award"></i> <?= $organisme['libelle'];?></a></li>
                                                                        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-lines-fill"></i> Assurés</li>
                                                                    </ol>
                                                                </nav>
                                                                <p class="p_page_titre h4"><i class="bi bi-person-lines-fill"></i> Assurés</p>
                                                                <div class="col"><?php include "../../_Forms/form_search_assures.php"; ?></div>
                                                            </div>
                                                            <?php
                                                        }
                                                        echo '<script src="'.JS.'deconnexion_2.js"></script>';
                                                        echo '<script src="'.JS.'page_organisme_assures.js"></script>';
                                                    }else {
                                                        echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                    }
                                                }else {
                                                    echo '<p class="alert alert-danger align_center">Une erreur est survenue lors de la mise à jour de la piste d\'audit, veuillez SVP contacter votre administrateur.</p>';
                                                }
                                            }else {
                                                echo '<p class="alert alert-danger align_center">Aucun organisme correspondant à votre profil n\'a été identifié, veuillez SVP contacter votre administrateur.</p>';
                                            }
                                        }else{
                                            echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été définit pour cet utilisateur, veuillez SVP contacter votre administrateur.</p>';
                                        }
                                    }else {
                                        echo '<script>window.location.href="'.URL.'"</script>';
                                    }
                                }else {
                                    echo '<p class="alert alert-danger align_center">Aucun profil utilisateur n\'a été défini pour cet utilisateur, veuillez contacter votre administrateur.</p>';
                                }
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
            echo '<script>window.location.href="' . URL . 'connexion"</script>';
        }
    }else {
        session_destroy();
        echo '<script>window.location.href="'.URL.'connexion"</script>';
    }
}else {
    session_destroy();
    echo '<script>window.location.href="'.URL.'connexion"</script>';
}