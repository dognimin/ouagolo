<?php
if(isset($_POST)) {
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Functions/Functions.php";
    $parametres = array(
        'type' => clean_data($_POST['type']),
        'donnee' => clean_data($_POST['donnee'])
    );
    if(isset($_SESSION['nouvelle_session'])) {
        $UTILISATEURS = new UTILISATEURS();
        $session = $UTILISATEURS->trouver_session($_SESSION['nouvelle_session']);
        if ($session) {
            $utilisateur = $UTILISATEURS->trouver($session['id_user'],null);
            if($utilisateur) {
                /**
                 * Tables de valeurs
                 */
                if($parametres['type'] == 'put') {
                    require "../../../Classes/PROFILSUTILISATEURS.php";
                    $PROFILSUTILISATEURS = new PROFILSUTILISATEURS();
                    $json = $PROFILSUTILISATEURS->lister_historique($parametres['donnee']);
                    $nb_profilutilisateur = count($json);
                    if($nb_profilutilisateur != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $profilutilisateur) {
                                ?>
                                <tr <?php if(!$profilutilisateur['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $profilutilisateur['code'];?></td>
                                    <td><?= $profilutilisateur['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($profilutilisateur['date_debut']));?></td>
                                    <td class="align_center"><?php if($profilutilisateur['date_fin']){echo date('d/m/Y',strtotime($profilutilisateur['date_fin']));}?></td>
                                    <td><?=  $profilutilisateur['nom'].' '.$profilutilisateur['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($profilutilisateur['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }

                }
                if($parametres['type'] == 'assur') {
                    require "../../../Classes/ASSURANCES.php";
                    $ASSURANCES = new ASSURANCES();
                    $json = $ASSURANCES->lister_historique($parametres['donnee']);
                    $nb_assurance = count($json);
                    if($nb_assurance != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $assurance) {
                                ?>
                                <tr <?php if(!$assurance['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $assurance['code'];?></td>
                                    <td><?= $assurance['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($assurance['date_debut']));?></td>
                                    <td class="align_center"><?php if($assurance['date_fin']){echo date('d/m/Y',strtotime($assurance['date_fin']));}?></td>
                                    <td><?=  $assurance['nom'].' '.$assurance['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($assurance['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }

                }
                if($parametres['type'] == 'allerg') {
                    require "../../../Classes/ALLERGIES.php";
                    $ALLERGIES = new ALLERGIES();
                    $json = $ALLERGIES->lister_historique($parametres['donnee']);
                    $nb_allergie = count($json);
                    if($nb_allergie != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $allergie) {
                                ?>
                                <tr <?php if(!$allergie['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $allergie['code'];?></td>
                                    <td><?= $allergie['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($allergie['date_debut']));?></td>
                                    <td class="align_center"><?php if($allergie['date_fin']){echo date('d/m/Y',strtotime($allergie['date_fin']));}?></td>
                                    <td><?=  $allergie['nom'].' '.$allergie['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($allergie['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }

                }
                elseif($parametres['type'] == 'csp') {
                    require "../../../Classes/CATEGORIESSOCIOPROFESSIONNELLES.php";
                    $CATEGORIESSOCIOPROFESSIONNELLES = new CATEGORIESSOCIOPROFESSIONNELLES();
                    $json = $CATEGORIESSOCIOPROFESSIONNELLES->lister_historique($parametres['donnee']);
                    $nb_categories = count($json);
                    if($nb_categories != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $categorie) {
                                ?>
                                <tr <?php if(!$categorie['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $categorie['code'];?></td>
                                    <td><?= $categorie['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($categorie['date_debut']));?></td>
                                    <td class="align_center"><?php if($categorie['date_fin']){echo date('d/m/Y',strtotime($categorie['date_fin']));}?></td>
                                    <td><?= $categorie['nom'].' '.$categorie['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($categorie['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'cps') {
                    require "../../../Classes/CATEGORIESPROFESSIONNELSANTES.php";
                    $CATEGORIESPROFESSIONNELSANTES = new CATEGORIESPROFESSIONNELSANTES();
                    $json = $CATEGORIESPROFESSIONNELSANTES->lister_historique($parametres['donnee']);
                    $nb_categories = count($json);
                    if($nb_categories != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $categorie) {
                                ?>
                                <tr <?php if(!$categorie['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $categorie['code'];?></td>
                                    <td><?= $categorie['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($categorie['date_debut']));?></td>
                                    <td class="align_center"><?php if($categorie['date_fin']){echo date('d/m/Y',strtotime($categorie['date_fin']));}?></td>
                                    <td><?= $categorie['nom'].' '.$categorie['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($categorie['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'ordre') {
                    require "../../../Classes/ORDESNATIONAUX.php";
                    $ORDESNATIONNAUX = new ORDESNATIONAUX();
                    $json = $ORDESNATIONNAUX->lister_historique($parametres['donnee']);
                    $nb_ordres = count($json);
                    if($nb_ordres != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $ordre) {
                                ?>
                                <tr <?php if(!$ordre['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $ordre['code'];?></td>
                                    <td><?= $ordre['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($ordre['date_debut']));?></td>
                                    <td class="align_center"><?php if($ordre['date_fin']){echo date('d/m/Y',strtotime($ordre['date_fin']));}?></td>
                                    <td><?= strtoupper($ordre['nom'].' '.$ordre['prenoms']) ;?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($ordre['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'etab_service') {
                    require "../../../Classes/ETABLISSEMENTSSERVICES.php";
                    $ETABLISSEMENTSSERVICES = new ETABLISSEMENTSSERVICES();
                    $json = $ETABLISSEMENTSSERVICES->lister_historique($parametres['donnee']);
                    $nb_ordres = count($json);
                    if($nb_ordres != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $service) {
                                ?>
                                <tr <?php if(!$service['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $service['code'];?></td>
                                    <td><?= $service['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($service['date_debut']));?></td>
                                    <td class="align_center"><?php if($service['date_fin']){echo date('d/m/Y',strtotime($ordre['date_fin']));}?></td>
                                    <td><?= strtoupper($service['nom'].' '.$service['prenoms']) ;?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($service['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'Typ_etab') {
                    require "../../../Classes/ETABLISSEMENTS.php";
                    $ETABLISSEMENTS = new ETABLISSEMENTS();
                    $json = $ETABLISSEMENTS->lister_historique_type_ets($parametres['donnee']);
                    $nb_types_etablissements = count($json);
                    if($nb_types_etablissements != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $typetablissement) {
                                ?>
                                <tr <?php if(!$typetablissement['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $typetablissement['code'];?></td>
                                    <td><?= $typetablissement['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($typetablissement['date_debut']));?></td>
                                    <td class="align_center"><?php if ($typetablissement['date_fin']){echo date('d/m/Y',strtotime($typetablissement['date_fin']));}?></td>
                                    <td><?= $typetablissement['nom'].' '.$typetablissement['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($typetablissement['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'civ') {
                    require "../../../Classes/CIVILITES.php";
                    $CIVILITES = new CIVILITES();
                    $json = $CIVILITES->lister_historique($parametres['donnee']);
                    $nb_civilites = count($json);
                    if($nb_civilites != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $civilite) {
                                ?>
                                <tr <?php if(!$civilite['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $civilite['code'];?></td>
                                    <td><?= $civilite['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($civilite['date_debut']));?></td>
                                    <td class="align_center"><?php if($civilite['date_fin']){echo date('d/m/Y',strtotime($civilite['date_fin']));}?></td>
                                    <td><?= $civilite['nom'].' '.$civilite['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($civilite['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'sex') {
                    require "../../../Classes/SEXES.php";
                    $SEXES = new SEXES();
                    $json = $SEXES->lister_historique($parametres['donnee']);
                    $nb_sexes = count($json);
                    if($nb_sexes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $sexes) {
                                ?>
                                <tr <?php if(!$sexes['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $sexes['code'];?></td>
                                    <td><?= $sexes['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($sexes['date_debut']));?></td>
                                    <td class="align_center"><?php if($sexes['date_fin']){echo date('d/m/Y',strtotime($sexes['date_fin']));}?></td>
                                    <td><?= $sexes['nom'].' '.$sexes['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($sexes['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'ordre') {
                    require "../../../Classes/ORDESNATIONAUX.php";
                    $ORDESNATIONNAUX = new ORDESNATIONAUX();
                    $json = $ORDESNATIONNAUX->lister_historique($parametres['donnee']);
                    $nb_sexes = count($json);
                    if($nb_sexes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $ordre) {
                                ?>
                                <tr <?php if(!$ordre['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $ordre['code'];?></td>
                                    <td><?= $ordre['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($ordre['date_debut']));?></td>
                                    <td class="align_center"><?php if($ordre['date_fin']){echo date('d/m/Y',strtotime($ordre['date_fin']));}?></td>
                                    <td><?= $ordre['nom'].' '.$ordre['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($ordre['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'typ_pers') {
                    require "../../../Classes/TYPESPERSONNES.php";
                    $TYPES_PERSONNES_ECU = new TYPESPERSONNES();
                    $json = $TYPES_PERSONNES_ECU->lister_historique($parametres['donnee']);
                    $nb_sexes = count($json);
                    if($nb_sexes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $ecu) {
                                ?>
                                <tr <?php if(!$ecu['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $ecu['code'];?></td>
                                    <td><?= $ecu['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($ecu['date_debut']));?></td>
                                    <td class="align_center"><?php if($ecu['date_fin']){echo date('d/m/Y',strtotime($ecu['date_fin']));}?></td>
                                    <td><?= $ecu['nom'].' '.$ecu['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($ecu['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'tac') {
                    require "../../../Classes/TYPESACCIDENTS.php";
                    $TYPESACCIDENTS = new TYPESACCIDENTS();
                    $json = $TYPESACCIDENTS->lister_historique($parametres['donnee']);
                    $nb_types_accidents = count($json);
                    if($nb_types_accidents != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $typeaccidennt) {
                                ?>
                                <tr <?php if(!$typeaccidennt['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $typeaccidennt['code'];?></td>
                                    <td><?= $typeaccidennt['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($typeaccidennt['date_debut']));?></td>
                                    <td class="align_center"><?php if($typeaccidennt['date_fin']){echo date('d/m/Y',strtotime($typeaccidennt['date_fin']));}?></td>
                                    <td><?= $typeaccidennt['nom'].' '.$typeaccidennt['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($typeaccidennt['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'sif') {
                    require "../../../Classes/SITUATIONSFAMILIALES.php";
                    $SITUATIONSFAMILIALES = new SITUATIONSFAMILIALES();
                    $json = $SITUATIONSFAMILIALES->lister_historique($parametres['donnee']);
                    $nb_sexes = count($json);
                    if($nb_sexes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $situationfamiliale) {
                                ?>
                                <tr <?php if(!$situationfamiliale['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $situationfamiliale['code'];?></td>
                                    <td><?= $situationfamiliale['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($situationfamiliale['date_debut']));?></td>
                                    <td class="align_center"><?php if($situationfamiliale['date_fin']){echo date('d/m/Y',strtotime($situationfamiliale['date_fin']));}?></td>
                                    <td><?= $situationfamiliale['nom'].' '.$situationfamiliale['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($situationfamiliale['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'sct') {
                    require "../../../Classes/SECTEURSACTIVITES.php";
                    $SECTEURSACTIVITES = new SECTEURSACTIVITES();
                    $json = $SECTEURSACTIVITES->lister_historique($parametres['donnee']);
                    $nb_sexes = count($json);
                    if($nb_sexes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $secteursactivites) {
                                ?>
                                <tr <?php if(!$secteursactivites['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $secteursactivites['code'];?></td>
                                    <td><?= $secteursactivites['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($secteursactivites['date_debut']));?></td>
                                    <td class="align_center"><?php if($secteursactivites['date_fin']){echo date('d/m/Y',strtotime($secteursactivites['date_fin']));}?></td>
                                    <td><?= $secteursactivites['nom'].' '.$secteursactivites['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($secteursactivites['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'prf') {
                    require "../../../Classes/PROFESSIONS.php";
                    $PROFESSIONS = new PROFESSIONS();
                    $json = $PROFESSIONS->lister_historique($parametres['donnee']);
                    $nb_sexes = count($json);
                    if($nb_sexes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $profession) {
                                ?>
                                <tr <?php if(!$profession['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $profession['code'];?></td>
                                    <td><?= $profession['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($profession['date_debut']));?></td>
                                    <td class="align_center"><?php if($profession['date_fin']){echo date('d/m/Y',strtotime($profession['date_fin']));}?></td>
                                    <td><?= $profession['nom'].' '.$profession['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($profession['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'qtc') {
                    require "../../../Classes/QUALITESCIVILES.php";
                    $QUALIESCIVILITES = new QUALITESCIVILES();
                    $json = $QUALIESCIVILITES->lister_historique($parametres['donnee']);
                    $nb_qualitescivilites = count($json);
                    if($nb_qualitescivilites != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $Qualitescivilites) {
                                ?>
                                <tr <?php if(!$Qualitescivilites['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $Qualitescivilites['code'];?></td>
                                    <td><?= $Qualitescivilites['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($Qualitescivilites['date_debut']));?></td>
                                    <td class="align_center"><?php if($Qualitescivilites['date_fin']){echo date('d/m/Y',strtotime($Qualitescivilites['date_fin']));}?></td>
                                    <td><?= $Qualitescivilites['nom'].' '.$Qualitescivilites['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($Qualitescivilites['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'tco') {
                    require "../../../Classes/TYPESCOORDONNEES.php";
                    $TYPESCOORDONNEES = new TYPESCOORDONNEES();
                    $json = $TYPESCOORDONNEES->lister_historique($parametres['donnee']);
                    $nb_typescoord = count($json);
                    if($nb_typescoord != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $typecoordonnee) {
                                ?>
                                <tr <?php if(!$typecoordonnee['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $typecoordonnee['code'];?></td>
                                    <td><?= $typecoordonnee['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($typecoordonnee['date_debut']));?></td>
                                    <td class="align_center"><?php if($typecoordonnee['date_fin']){echo date('d/m/Y',strtotime($typecoordonnee['date_fin']));}?></td>
                                    <td><?= $typecoordonnee['nom'].' '.$typecoordonnee['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($typecoordonnee['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'tpi') {
                    require "../../../Classes/TYPESPIECESIDENTITES.php";
                    $TYPEPIECES = new TYPESPIECESIDENTITES();
                    $json = $TYPEPIECES->lister_historique($parametres['donnee']);
                    $nb_typespieces = count($json);
                    if($nb_typespieces != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $typepiece) {
                                ?>
                                <tr <?php if(!$typepiece['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $typepiece['code'];?></td>
                                    <td><?= $typepiece['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($typepiece['date_debut']));?></td>
                                    <td class="align_center"><?php if($typepiece['date_fin']){echo date('d/m/Y',strtotime($typepiece['date_fin']));}?></td>
                                    <td><?= $typepiece['nom'].' '.$typepiece['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($typepiece['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'dev') {
                    require "../../../Classes/DEVISESMONETAIRES.php";
                    $DEVISES = new DEVISESMONETAIRES();
                    $json = $DEVISES->lister_historique($parametres['donnee']);
                    $nb_devises = count($json);
                    if($nb_devises != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $devise) {
                                ?>
                                <tr <?php if(!$devise['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $devise['code'];?></td>
                                    <td><?= $devise['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($devise['date_debut']));?></td>
                                    <td class="align_center"><?php if($devise['date_fin']){echo date('d/m/Y',strtotime($devise['date_fin']));}?></td>
                                    <td><?= $devise['nom'].' '.$devise['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($devise['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'gsa') {
                    require "../../../Classes/GROUPESSANGUINS.php";
                    $RHESUS = new GROUPESSANGUINS();
                    $json = $RHESUS->lister_historique_groupe_sanguin($parametres['donnee']);
                    $nb_rhesus = count($json);
                    if($nb_rhesus != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $rhesus) {
                                ?>
                                <tr <?php if(!$rhesus['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $rhesus['code'];?></td>
                                    <td><?= $rhesus['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($rhesus['date_debut']));?></td>
                                    <td class="align_center"><?php if($rhesus['date_fin']){echo date('d/m/Y',strtotime($rhesus['date_fin']));}?></td>
                                    <td><?= $rhesus['nom'].' '.$rhesus['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($rhesus['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'rhs') {
                    require "../../../Classes/GROUPESSANGUINS.php";
                    $RHESUS = new GROUPESSANGUINS();
                    $json = $RHESUS->lister_historique_rhesus($parametres['donnee']);
                    $nb_rhesus = count($json);
                    if($nb_rhesus != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $rhesus) {
                                ?>
                                <tr <?php if(!$rhesus['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $rhesus['code'];?></td>
                                    <td><?= $rhesus['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($rhesus['date_debut']));?></td>
                                    <td class="align_center"><?php if($rhesus['date_fin']){echo date('d/m/Y',strtotime($rhesus['date_fin']));}?></td>
                                    <td><?= $rhesus['nom'].' '.$rhesus['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($rhesus['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'lge') {
                    require "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $PAYS = new LOCALISATIONSGEOGRAPHIQUES();
                    $json = $PAYS->lister_historique_pays($parametres['donnee']);
                    $nb_pays = count($json);
                    if($nb_pays != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DEVISE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $Pays) {
                                ?>
                                <tr <?php if(!$Pays['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $Pays['code'];?></td>
                                    <td><?= $Pays['libelle'];?></td>
                                    <td><?= $Pays['devise'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($Pays['date_debut']));?></td>
                                    <td class="align_center"><?php if($Pays['date_fin']){echo date('d/m/Y',strtotime($Pays['date_fin']));}?></td>
                                    <td><?= $Pays['nom'].' '.$Pays['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($Pays['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'reg') {
                    require "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $REGIONS = new LOCALISATIONSGEOGRAPHIQUES();
                    $json = $REGIONS->lister_historique_region($parametres['donnee']);
                    $nb_regions = count($json);
                    if($nb_regions != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>PAYS</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $region) {
                                ?>
                                <tr <?php if(!$region['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $region['code_pays'];?></td>
                                    <td><?= $region['code'];?></td>
                                    <td><?= $region['nom_region'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($region['date_debut']));?></td>
                                    <td class="align_center"><?php if($region['date_fin']){echo date('d/m/Y',strtotime($region['date_fin']));}?></td>
                                    <td><?= $region['nom'].' '.$region['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($region['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'dep') {
                    require "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $DEPARTEMENTS = new LOCALISATIONSGEOGRAPHIQUES();
                    $json = $DEPARTEMENTS->lister_historique_departement($parametres['donnee']);
                    $nb_departements = count($json);
                    if($nb_departements != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>PAYS</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $departement) {
                                ?>
                                <tr <?php if(!$departement['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $departement['nom_pays'];?></td>
                                    <td><?= $departement['code'];?></td>
                                    <td><?= $departement['nom_region'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($departement['date_debut']));?></td>
                                    <td class="align_center"><?php if($departement['date_fin']){echo date('d/m/Y',strtotime($departement['date_fin']));}?></td>
                                    <td><?= $departement['nom'].' '.$departement['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($departement['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'com') {
                    require "../../../Classes/LOCALISATIONSGEOGRAPHIQUES.php";
                    $COMMUNES = new LOCALISATIONSGEOGRAPHIQUES();
                    $json = $COMMUNES->lister_historique_commune($parametres['donnee']);
                    $nb_commune = count($json);
                    if($nb_commune != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>PAYS</th>
                                <th>REGION</th>
                                <th>COMMUNE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $commune) {
                                ?>
                                <tr <?php if(!$commune['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $commune['code'];?></td>
                                    <td><?= $commune['pays_nom'];?></td>
                                    <td><?= $commune['region'];?></td>
                                    <td><?= $commune['departement'];?></td>
                                    <td><?= $commune['nom'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($commune['date_debut']));?></td>
                                    <td class="align_center"><?php if($commune['date_fin']){echo date('d/m/Y',strtotime($commune['date_fin']));}?></td>
                                    <td><?= $commune['nom'].' '.$commune['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($commune['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'tfa') {
                    require "../../../Classes/TYPESFACTURESMEDICALES.php";
                    $FACTURESMEDICALES = new TYPESFACTURESMEDICALES();
                    $types_factures = $FACTURESMEDICALES->lister_historique($parametres['donnee']);
                    $nb_types = count($types_factures);
                    if($nb_types != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($types_factures as $type_facture) {
                                ?>
                                <tr <?php if(!$type_facture['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $type_facture['code'];?></td>
                                    <td><?= $type_facture['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($type_facture['date_debut']));?></td>
                                    <td class="align_center"><?php if($type_facture['date_fin']){echo date('d/m/Y',strtotime($type_facture['date_fin']));}?></td>
                                    <td><?= $type_facture['nom'].' '.$type_facture['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($type_facture['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }

                /**
                 * Fin Tables de valeurs
                 */

                //Pathologies
                elseif($parametres['type'] == 'pat_chap') {
                    require "../../../Classes/PATHOLOGIES.php";
                    $PATHOLOGIECHAPITRES = new PATHOLOGIES();
                    $chapitres = $PATHOLOGIECHAPITRES->lister_historique_chapitre($parametres['donnee']);
                    $nb_chapitres = count($chapitres);
                    if($nb_chapitres != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($chapitres as $chapitre) {
                                ?>
                                <tr <?php if(!$chapitre['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $chapitre['code'];?></td>
                                    <td><?= $chapitre['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($chapitre['date_debut']));?></td>
                                    <td class="align_center"><?php if($chapitre['date_fin']){echo date('d/m/Y',strtotime($chapitre['date_fin']));}?></td>
                                    <td><?= $chapitre['nom'].' '.$chapitre['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($chapitre['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'pat_sch') {
                    require "../../../Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $sous_chapitres = $PATHOLOGIES->lister_historique_sous_chapitre($parametres['donnee']);
                    $nb_sous_chapitres = count($sous_chapitres);
                    if($nb_sous_chapitres != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($sous_chapitres as $sous_chapitre) {
                                ?>
                                <tr <?php if(!$sous_chapitre['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $sous_chapitre['code'];?></td>
                                    <td><?= $sous_chapitre['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($sous_chapitre['date_debut']));?></td>
                                    <td class="align_center"><?php if($sous_chapitre['date_fin']){echo date('d/m/Y',strtotime($sous_chapitre['date_fin']));}?></td>
                                    <td><?= $sous_chapitre['nom'].' '.$sous_chapitre['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($sous_chapitre['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'pat') {
                    require "../../../Classes/PATHOLOGIES.php";
                    $PATHOLOGIES = new PATHOLOGIES();
                    $pathologies = $PATHOLOGIES->lister_historique_pathologie($parametres['donnee']);
                    $nb_patologies = count($pathologies);
                    if($nb_patologies != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($pathologies as $pathologie) {
                                ?>
                                <tr <?php if(!$pathologie['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $pathologie['code'];?></td>
                                    <td><?= $pathologie['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($pathologie['date_debut']));?></td>
                                    <td class="align_center"><?php if($pathologie['date_fin']){echo date('d/m/Y',strtotime($pathologie['date_fin']));}?></td>
                                    <td><?= $pathologie['nom'].' '.$pathologie['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($pathologie['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }

                // ACtes médicaux
                elseif($parametres['type'] == 'let_cle') {
                    require "../../../Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $lettres_cles = $ACTESMEDICAUX->lister_historique_lettre_cle($parametres['donnee']);
                    $nb_lettres_cles = count($lettres_cles);
                    if($nb_lettres_cles != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($lettres_cles as $lettre_cle) {
                                ?>
                                <tr <?php if(!$lettre_cle['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $lettre_cle['code'];?></td>
                                    <td><?= $lettre_cle['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($lettre_cle['date_debut']));?></td>
                                    <td class="align_center"><?php if($lettre_cle['date_fin']){echo date('d/m/Y',strtotime($lettre_cle['date_fin']));}?></td>
                                    <td><?= $lettre_cle['nom'].' '.$lettre_cle['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($lettre_cle['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'act_tit') {
                    require "../../../Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $titres = $ACTESMEDICAUX->lister_historique_titre($parametres['donnee']);
                    $nb_titres = count($titres);
                    if($nb_titres != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($titres as $titre) {
                                ?>
                                <tr <?php if(!$titre['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $titre['code'];?></td>
                                    <td><?= $titre['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($titre['date_debut']));?></td>
                                    <td class="align_center"><?php if($titre['date_fin']){echo date('d/m/Y',strtotime($titre['date_fin']));}?></td>
                                    <td><?= $titre['nom'].' '.$titre['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($titre['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'act_cha') {
                    require "../../../Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $chapitres = $ACTESMEDICAUX->lister_historique_chapitre($parametres['donnee']);
                    $nb_chapitres = count($chapitres);
                    if($nb_chapitres != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($chapitres as $chapitre) {
                                ?>
                                <tr <?php if(!$chapitre['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $chapitre['code'];?></td>
                                    <td><?= $chapitre['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($chapitre['date_debut']));?></td>
                                    <td class="align_center"><?php if($chapitre['date_fin']){echo date('d/m/Y',strtotime($chapitre['date_fin']));}?></td>
                                    <td><?= $chapitre['nom'].' '.$chapitre['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($chapitre['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'act_sec') {
                    require "../../../Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $sections = $ACTESMEDICAUX->lister_historique_section($parametres['donnee']);
                    $nb_sections = count($sections);
                    if($nb_sections != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($sections as $section) {
                                ?>
                                <tr <?php if(!$section['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $section['code'];?></td>
                                    <td><?= $section['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($section['date_debut']));?></td>
                                    <td class="align_center"><?php if($section['date_fin']){echo date('d/m/Y',strtotime($section['date_fin']));}?></td>
                                    <td><?= $section['nom'].' '.$section['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($section['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'act_art') {
                    require "../../../Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $articles = $ACTESMEDICAUX->lister_historique_article($parametres['donnee']);
                    $nb_articles = count($articles);
                    if($nb_articles != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($articles as $article) {
                                ?>
                                <tr <?php if(!$article['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $article['code'];?></td>
                                    <td><?= $article['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($article['date_debut']));?></td>
                                    <td class="align_center"><?php if($article['date_fin']){echo date('d/m/Y',strtotime($article['date_fin']));}?></td>
                                    <td><?= $article['nom'].' '.$article['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($article['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'act_med') {
                    require "../../../Classes/ACTESMEDICAUX.php";
                    $ACTESMEDICAUX = new ACTESMEDICAUX();
                    $actes_medicaux = $ACTESMEDICAUX->lister_historique_acte_medical($parametres['donnee']);
                    $nb_actes_medicaux = count($actes_medicaux);
                    if($nb_actes_medicaux != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($actes_medicaux as $acte_medical) {
                                ?>
                                <tr <?php if(!$acte_medical['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $acte_medical['code'];?></td>
                                    <td><?= $acte_medical['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($acte_medical['date_debut']));?></td>
                                    <td class="align_center"><?php if($acte_medical['date_fin']){echo date('d/m/Y',strtotime($acte_medical['date_fin']));}?></td>
                                    <td><?= $acte_medical['nom'].' '.$acte_medical['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($acte_medical['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }

                //Médicaments
                elseif($parametres['type'] == 'med_lab') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $LABORATOIRES = new MEDICAMENTS();
                    $laboratoires = $LABORATOIRES->lister_historique_laboratoires_pharmaceutiques($parametres['donnee']);
                    $nb_laboratoires = count($laboratoires);
                    if($nb_laboratoires != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($laboratoires as $laboratoire) {
                                ?>
                                <tr <?php if(!$laboratoire['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $laboratoire['code'];?></td>
                                    <td><?= $laboratoire['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($laboratoire['date_debut']));?></td>
                                    <td class="align_center"><?php if($laboratoire['date_fin']){echo date('d/m/Y',strtotime($laboratoire['date_fin']));}?></td>
                                    <td><?= $laboratoire['nom'].' '.$laboratoire['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($laboratoire['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med_cth') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $CLASSESTHERAPEUTIQUES = new MEDICAMENTS();
                    $json = $CLASSESTHERAPEUTIQUES->lister_historique_classe_therapeutique($parametres['donnee']);
                    $nb_classes = count($json);
                    if($nb_classes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $classe) {
                                ?>
                                <tr <?php if(!$classe['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $classe['code'];?></td>
                                    <td><?= $classe['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($classe['date_debut']));?></td>
                                    <td class="align_center"><?php if($classe['date_fin']){echo date('d/m/Y',strtotime($classe['date_fin']));}?></td>
                                    <td><?= $classe['nom'].' '.$classe['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($classe['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $MEDICAMENTS = new MEDICAMENTS();
                    $json = $MEDICAMENTS->lister_historique_medicament($parametres['donnee']);
                    $nb_medicaments = count($json);
                    if($nb_medicaments != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $medicament) {
                                ?>
                                <tr <?php if(!$medicament['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $medicament['code'];?></td>
                                    <td><?= $medicament['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($medicament['date_debut']));?></td>
                                    <td class="align_center"><?php if($medicament['date_fin']){echo date('d/m/Y',strtotime($medicament['date_fin']));}?></td>
                                    <td><?= $medicament['nom'].' '.$medicament['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($medicament['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med_pre') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $PRESENTATIONS = new MEDICAMENTS();
                    $json = $PRESENTATIONS->lister_historique_presentation($parametres['donnee']);
                    $nb_presentations = count($json);
                    if($nb_presentations != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $presentation) {
                                ?>
                                <tr <?php if(!$presentation['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $presentation['code'];?></td>
                                    <td><?= $presentation['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($presentation['date_debut']));?></td>
                                    <td class="align_center"><?php if($presentation['date_fin']){echo date('d/m/Y',strtotime($presentation['date_fin']));}?></td>
                                    <td><?= $presentation['nom'].' '.$presentation['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($presentation['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med_ffm') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $FAMILLESFORMES = new MEDICAMENTS();
                    $json = $FAMILLESFORMES->lister_historique_famille_forme($parametres['donnee']);
                    $nb_famillesformes = count($json);
                    if($nb_famillesformes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $familleforme) {
                                ?>
                                <tr <?php if(!$familleforme['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $familleforme['code'];?></td>
                                    <td><?= $familleforme['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($familleforme['date_debut']));?></td>
                                    <td class="align_center"><?php if($familleforme['date_fin']){echo date('d/m/Y',strtotime($familleforme['date_fin']));}?></td>
                                    <td><?= $familleforme['nom'].' '.$familleforme['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($familleforme['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med_frm') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $FORMES = new MEDICAMENTS();
                    $json = $FORMES->lister_historique_forme($parametres['donnee']);
                    $nb_formes = count($json);
                    if($nb_formes != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $forme) {
                                ?>
                                <tr <?php if(!$forme['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $forme['code'];?></td>
                                    <td><?= $forme['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($forme['date_debut']));?></td>
                                    <td class="align_center"><?php if($forme['date_fin']){echo date('d/m/Y',strtotime($forme['date_fin']));}?></td>
                                    <td><?= $forme['nom'].' '.$forme['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($forme['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med_typ') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $TYPESMEDICAMENTS = new MEDICAMENTS();
                    $json = $TYPESMEDICAMENTS->lister_historique_type($parametres['donnee']);
                    $nb_typesmedicaments = count($json);
                    if($nb_typesmedicaments != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $typemedicament) {
                                ?>
                                <tr <?php if(!$typemedicament['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $typemedicament['code'];?></td>
                                    <td><?= $typemedicament['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($typemedicament['date_debut']));?></td>
                                    <td class="align_center"><?php if($typemedicament['date_fin']){echo date('d/m/Y',strtotime($typemedicament['date_fin']));}?></td>
                                    <td><?= $typemedicament['nom'].' '.$typemedicament['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($typemedicament['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med_fra') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $FORMESADMINISTRATIONS = new MEDICAMENTS();
                    $json = $FORMESADMINISTRATIONS->lister_historique_forme_administration($parametres['donnee']);
                    $nb_formesadministrations = count($json);
                    if($nb_formesadministrations != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $formeadministration) {
                                ?>
                                <tr <?php if(!$formeadministration['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $formeadministration['code'];?></td>
                                    <td><?= $formeadministration['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($formeadministration['date_debut']));?></td>
                                    <td class="align_center"><?php if($formeadministration['date_fin']){echo date('d/m/Y',strtotime($formeadministration['date_fin']));}?></td>
                                    <td><?= $formeadministration['nom'].' '.$formeadministration['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($formeadministration['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med_unt') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $UNITES = new MEDICAMENTS();
                    $json = $UNITES->lister_historique_unite_dosage($parametres['donnee']);
                    $nb_unites = count($json);
                    if($nb_unites != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $unite) {
                                ?>
                                <tr <?php if(!$unite['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $unite['code'];?></td>
                                    <td><?= $unite['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($unite['date_debut']));?></td>
                                    <td class="align_center"><?php if($unite['date_fin']){echo date('d/m/Y',strtotime($unite['date_fin']));}?></td>
                                    <td><?= $unite['nom'].' '.$unite['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($unite['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'med_dci') {
                    require "../../../Classes/MEDICAMENTS.php";
                    $DCI = new MEDICAMENTS();
                    $json = $DCI->lister_historique_dci($parametres['donnee']);
                    $nb_dci = count($json);
                    if($nb_dci != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>UNITE</th>
                                <th>UNITE_DOSAGE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $dci) {
                                ?>
                                <tr <?php if(!$dci['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $dci['code'];?></td>
                                    <td><?= $dci['code_unite'];?></td>
                                    <td><?= $dci['code_forme'];?></td>
                                    <td><?= $dci['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($dci['date_debut']));?></td>
                                    <td class="align_center"><?php if($dci['date_fin']){echo date('d/m/Y',strtotime($dci['date_fin']));}?></td>
                                    <td><?= $dci['nom'].' '.$dci['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($dci['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }

                //ETABLISSEMENTS
                elseif($parametres['type'] == 'etab_niveau') {
                    require "../../../Classes/ETABLISSEMENTS.php";
                    $ETABLISSEMENTS = new ETABLISSEMENTS();
                    $json = $ETABLISSEMENTS->lister_historique_niveau_sanitaire($parametres['donnee']);
                    $nb_patologies = count($json);
                    if($nb_patologies != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE</th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $niveau) {
                                ?>
                                <tr <?php if(!$niveau['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $niveau['code'];?></td>
                                    <td><?= $niveau['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($niveau['date_debut']));?></td>
                                    <td class="align_center"><?php if($niveau['date_fin']){echo date('d/m/Y',strtotime($niveau['date_fin']));}?></td>
                                    <td><?= $niveau['nom'].' '.$niveau['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($niveau['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }


                //RESEAUX DE SOINS
                elseif($parametres['type'] == 'res_med') {
                    require "../../../Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $json = $RESEAUXDESOINS->lister_historique_reseau_medicament($parametres['donnee1'],$parametres['donnee2']);
                    $nb_medicament_reseau = count($json);
                    if($nb_medicament_reseau != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE RESEAU</th>
                                <th>CODE MEDICAMENT</th>
                                <th>TARIFS</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $reseau_medicament) {
                                ?>
                                <tr <?php if(!$reseau_medicament['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $reseau_medicament['code_reseau'];?></td>
                                    <td><?= $reseau_medicament['code_medicament'];?></td>
                                    <td><?= $reseau_medicament['tarif'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($reseau_medicament['date_debut']));?></td>
                                    <td class="align_center"><?php if($reseau_medicament['date_fin']){echo date('d/m/Y',strtotime($reseau_medicament['date_fin']));}?></td>
                                    <td><?= $reseau_medicament['nom'].' '.$reseau_medicament['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($reseau_medicament['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'res') {
                    require "../../../Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $json = $RESEAUXDESOINS->lister_historique($parametres['donnee']);
                    $nb_reseau = count($json);
                    if($nb_reseau != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE </th>
                                <th>LIBELLE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $reseau) {
                                ?>
                                <tr <?php if(!$reseau['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $reseau['code'];?></td>
                                    <td><?= $reseau['libelle'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($reseau['date_debut']));?></td>
                                    <td class="align_center"><?php if($reseau['date_fin']){echo date('d/m/Y',strtotime($reseau['date_fin']));}?></td>
                                    <td><?= $reseau['nom'].' '.$reseau['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($reseau['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'res_etab') {
                    require "../../../Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $json = $RESEAUXDESOINS->lister_historique_reseau_etablissement($parametres['donnee1'],$parametres['donnee2']);
                    $nb_medicament_etablissement = count($json);
                    if($nb_medicament_etablissement != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE RESEAU</th>
                                <th>CODE ETABLISSEMENT</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $reseau_etablissement) {
                                ?>
                                <tr <?php if(!$reseau_etablissement['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $reseau_etablissement['code_reseau'];?></td>
                                    <td><?= $reseau_etablissement['code_medicament'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($reseau_etablissement['date_debut']));?></td>
                                    <td class="align_center"><?php if($reseau_etablissement['date_fin']){echo date('d/m/Y',strtotime($reseau_etablissement['date_fin']));}?></td>
                                    <td><?= $reseau_etablissement['nom'].' '.$reseau_etablissement['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($reseau_etablissement['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                elseif($parametres['type'] == 'res_acte') {
                    require "../../../Classes/RESEAUXDESOINS.php";
                    $RESEAUXDESOINS = new RESEAUXDESOINS();
                    $json = $RESEAUXDESOINS->lister_historique_reseau_acte_medicale($parametres['donnee1'],$parametres['donnee2']);
                    $nb_medicament_acte = count($json);
                    if($nb_medicament_acte != 0) {
                        ?>
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="bg-info">
                            <tr>
                                <th>N°</th>
                                <th>CODE RESEAU</th>
                                <th>CODE ACTE MEDICALE</th>
                                <th>DATE EFFET</th>
                                <th>DATE FIN</th>
                                <th>UTILISATEUR</th>
                                <th>DATE CREATION</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $ligne = 1;
                            foreach ($json as $reseau_acte) {
                                ?>
                                <tr <?php if(!$reseau_acte['date_fin']){echo 'style="font-weight: bold " class="text-success"';} ?>>
                                    <td class="align_right"><?= $ligne;?></td>
                                    <td><?= $reseau_acte['code_reseau'];?></td>
                                    <td><?= $reseau_acte['code_acte'];?></td>
                                    <td class="align_center"><?= date('d/m/Y',strtotime($reseau_acte['date_debut']));?></td>
                                    <td class="align_center"><?php if($reseau_acte['date_fin']){echo date('d/m/Y',strtotime($reseau_acte['date_fin']));}?></td>
                                    <td><?= $reseau_acte['nom'].' '.$reseau_acte['prenoms'];?></td>
                                    <td class="align_center"><?= date('d/m/Y H:i:s',strtotime($reseau_acte['date_creation']));?></td>
                                </tr>
                                <?php
                                $ligne++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                }
                else{
                    $json = array(
                        'success' => false,
                        'message' => "Le type de données demandé est inconnu."
                    );
                }
            }else {
                $json = array(
                    'success' => false,
                    'message' => "Aucun utilisateur identifié pour effectué cette action."
                );
            }
        }else {
            $json = array(
                'success' => false,
                'message' => "Aucune session active pour vérifier cette action."
            );
        }
    }else {
        $json = array(
            'success' => false,
            'message' => "Aucune session active pour vérifier cette action."
        );
    }
}else {
    $json = array(
        'success' => false,
        'message' => "Aucun paramètre n'a été défini pour cette action."
    );
}
//echo json_encode($json);