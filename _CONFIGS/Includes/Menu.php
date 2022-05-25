<header class="header">
    <div class="header__container">
        <img src="<?= $Links['IMAGES'] . 'logos/logo-o.jpeg'; ?>" alt="" class="header__img"/>
        <a href="<?= $Links['URL'].'profil';?>" class="header__logo"><img src="<?= $autorisation['photo']? $Links['IMAGES'].'photos_profil/utilisateurs/'.$autorisation['id_user'].'/'.$autorisation['photo']: $Links['IMAGES'].'photos_profil/avatar.png';?>" style="width: 50px; border-radius: 40px" class="card-img-top" alt="Photo <?= $autorisation['prenoms'];?>"> <?= ucfirst(strtolower($autorisation['prenoms'])); ?></a>
        <?php
        if ($profil['code_profil'] == 'ETABLI') {
            ?>
            <img src="<?= !$ets['logo']? $Links['IMAGES'] . 'logos/etablissements/avatar.png': $Links['IMAGES'] . 'logos/etablissements/' . $ets['code'] . '/' . $ets['logo'];?>" style="height: 50px" alt="Logo <?= $ets['raison_sociale'];?>">
            <?php
        } elseif ($profil['code_profil'] == 'ORGANI') {
            ?>
            <img src="<?= !$organisme['logo']? $Links['IMAGES'] . 'logos/organismes/avatar.png': $Links['IMAGES'] . 'logos/organismes/' . $organisme['code'] . '/' . $organisme['logo'];?>" style="height: 50px" alt="Logo <?= $organisme['libelle'];?>">
            <?php
        }
        ?>
        <div class="header__toggle">
            <i class="bi bi-list" id="header-toggle"></i>
        </div>
    </div>
</header>
<!--========== NAV ==========-->
<div class="sidebar" id="navbar">
    <nav class="sidebar__container">
        <?php
        if ($profil['code_profil'] == 'ADMN') {
            ?>
            <div>
                <a href="<?= $Links['URL']; ?>" class="sidebar__link sidebar__logo">
                    <i class="bi bi-disc sidebar__icon"></i>
                    <span class="sidebar__logo-name">Ouagolo</span>
                </a>
                <div class="sidebar__list">
                    <div class="sidebar__items">
                        <a href="<?= $Links['URL']; ?>" class="sidebar__link">
                            <i class="bi bi-house sidebar__icon"></i>
                            <span class="sidebar__name">Accueil</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'etablissements/'; ?>" class="sidebar__link">
                            <i class="bi bi-building sidebar__icon"></i>
                            <span class="sidebar__name">Etablissements</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organismes/'; ?>" class="sidebar__link">
                            <i class="bi bi-award sidebar__icon"></i>
                            <span class="sidebar__name">Organismes</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'factures/'; ?>" class="sidebar__link">
                            <i class="bi bi-file-earmark-spreadsheet sidebar__icon"></i>
                            <span class="sidebar__name">Factures</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'comptabilite/'; ?>" class="sidebar__link">
                            <i class="bi bi-wallet sidebar__icon"></i>
                            <span class="sidebar__name">Comptabilité</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'support/'; ?>" class="sidebar__link">
                            <i class="bi bi-question-circle sidebar__icon"></i>
                            <span class="sidebar__name">Support</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'dashboard/'; ?>" class="sidebar__link">
                            <i class="bi bi-graph-up sidebar__icon"></i>
                            <span class="sidebar__name">Dashboard</span>
                        </a>
                        <div class="sidebar__dropdown">
                            <a href="<?= $Links['URL'] . 'parametres/'; ?>" class="sidebar__link">
                                <i class="bi bi-gear-wide-connected sidebar__icon"></i>
                                <span class="sidebar__name">Paramètres</span>
                                <i class='bi bi-caret-down sidebar__icon sidebar__dropdown-icon'></i>
                            </a>
                            <div class="sidebar__dropdown-collapse">
                                <div class="sidebar__dropdown-content">
                                    <a href="<?= $Links['URL'] . 'parametres/reseaux-de-soins/'; ?>"
                                       class="sidebar__dropdown-item"><i class="bi bi-diagram-3"></i> Réseaux de
                                        soins</a>
                                    <a href="<?= $Links['URL'] . 'parametres/utilisateurs/'; ?>" class="sidebar__dropdown-item"><i
                                                class="bi bi-person-bounding-box"></i> Utilisateurs</a>
                                    <a href="<?= $Links['URL'] . 'parametres/referentiels/'; ?>" class="sidebar__dropdown-item"><i
                                                class="bi bi-clipboard-plus"></i> Référentiels</a>
                                    <a href="<?= $Links['URL'] . 'parametres/tables-de-valeurs'; ?>"
                                       class="sidebar__dropdown-item"><i class="bi bi-award"></i> Tables de valeurs</a>
                                    <a href="<?= $Links['URL'] . 'parametres/securite/'; ?>" class="sidebar__dropdown-item"><i
                                                class="bi bi-shield-check"></i> Sécurité</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        elseif ($profil['code_profil'] === 'ETABLI') {
            $services_ph = $ETABLISSEMENTS->lister_servies($ets['code']);
            ?>
            <div>
                <a href="<?= $Links['URL']; ?>" class="sidebar__link sidebar__logo">
                    <i class="bi bi-disc sidebar__icon"></i>
                    <span class="sidebar__logo-name"><?= $ets['raison_sociale']; ?></span>
                </a>
                <div class="sidebar__list">
                    <div class="sidebar__items">
                        <?php
                        if(isset($nb_modules)) {
                            if ($nb_modules > 1) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/'; ?>" class="sidebar__link">
                                    <i class="bi bi-house sidebar__icon"></i>
                                    <span class="sidebar__name">Accueil</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_PTS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/patients/'; ?>" class="sidebar__link">
                                    <i class="bi bi-person-circle sidebar__icon"></i>
                                    <span class="sidebar__name">Patients</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_DOSS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/dossiers/'; ?>" class="sidebar__link">
                                    <i class="bi bi-folder2-open sidebar__icon"></i>
                                    <span class="sidebar__name">Dossiers</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_FCTS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/factures/'; ?>" class="sidebar__link">
                                    <i class="bi bi-journal-check sidebar__icon"></i>
                                    <span class="sidebar__name">Factures</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_CPTS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/comptabilite/'; ?>" class="sidebar__link">
                                    <i class="bi bi-cash-coin sidebar__icon"></i>
                                    <span class="sidebar__name">Comptabilité</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_FRNSS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/fournisseurs'; ?>" class="sidebar__link">
                                    <i class="bi bi-circle-square sidebar__icon"></i>
                                    <span class="sidebar__name">Fournisseurs</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_PHCIE', $modules, true)) {
                                foreach ($services_ph as $service_ph) {
                                    if (in_array('PHCIE', $service_ph, true)) {
                                        ?>
                                        <div class="sidebar__dropdown">
                                            <a href="<?= $Links['URL'] . 'etablissement/pharmacie/'; ?>" class="sidebar__link">
                                                <i class="bi bi-dpad-fill sidebar__icon"></i>
                                                <span class="sidebar__name">Pharmacie</span>
                                                <i class='bi bi-caret-down sidebar__icon sidebar__dropdown-icon'></i>
                                            </a>
                                            <div class="sidebar__dropdown-collapse">
                                                <div class="sidebar__dropdown-content">
                                                    <?php
                                                    if (in_array('AFF_PHCIE_VNTS', $sous_modules, true)) {
                                                        ?>
                                                        <a href="<?= $Links['URL'] . 'etablissement/pharmacie/ventes'; ?>"
                                                           class="sidebar__dropdown-item"><i class="bi bi-cart-fill"></i> Ventes</a>
                                                        <?php
                                                    }
                                                    if (in_array('AFF_PHCIE_PDTS', $sous_modules, true)) {
                                                        ?>
                                                        <a href="<?= $Links['URL'] . 'etablissement/pharmacie/produits'; ?>" class="sidebar__dropdown-item"><i
                                                                    class="bi bi-bullseye"></i> Produits</a>
                                                        <?php
                                                    }
                                                    if (in_array('AFF_PHCIE_CMDS', $sous_modules, true)) {
                                                        ?>
                                                        <a href="<?= $Links['URL'] . 'etablissement/pharmacie/commandes'; ?>" class="sidebar__dropdown-item"><i
                                                                    class="bi bi-tv-fill"></i> Commandes</a>
                                                        <?php
                                                    }
                                                    if (in_array('AFF_PHCIE_STK', $sous_modules, true)) {
                                                        ?>
                                                        <a href="<?= $Links['URL'] . 'etablissement/pharmacie/stock'; ?>"
                                                           class="sidebar__dropdown-item"><i class="bi bi-shop"></i> Stock</a>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            if (in_array('AFF_PFSS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/professionnels-de-sante/'; ?>" class="sidebar__link">
                                    <i class="bi bi-person-rolodex sidebar__icon"></i>
                                    <span class="sidebar__name">Professionnels de santé</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_RDVS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/rendez-vous/'; ?>" class="sidebar__link">
                                    <i class="bi bi-calendar2-week sidebar__icon"></i>
                                    <span class="sidebar__name">Rendez-vous</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_LABOS', $modules, true)) {
                                foreach ($services_ph as $service_ph) {
                                    if (in_array('LABO', $service_ph, true)) {
                                        ?>
                                        <a href="<?= $Links['URL'] . 'etablissement/laboratoire/'; ?>" class="sidebar__link">
                                            <i class="bi bi-eyedropper sidebar__icon"></i>
                                            <span class="sidebar__name">Laboratoire</span>
                                        </a>
                                        <?php
                                    }
                                }
                            }
                            if (in_array('AFF_DSHBS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/dashboard/'; ?>" class="sidebar__link">
                                    <i class="bi bi-graph-up sidebar__icon"></i>
                                    <span class="sidebar__name">Dashboard</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_SPPTS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/support/'; ?>" class="sidebar__link">
                                    <i class="bi bi-question-circle sidebar__icon"></i>
                                    <span class="sidebar__name">Support</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_APRPS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/a-propos/'; ?>" class="sidebar__link">
                                    <i class="bi bi-info-circle sidebar__icon"></i>
                                    <span class="sidebar__name">A propos</span>
                                </a>
                                <?php
                            }
                            if (in_array('AFF_PRMTRS', $modules, true)) {
                                ?>
                                <a href="<?= $Links['URL'] . 'etablissement/parametres/'; ?>" class="sidebar__link">
                                    <i class="bi bi-gear-wide-connected sidebar__icon"></i>
                                    <span class="sidebar__name">Paramètes</span>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        elseif ($profil['code_profil'] == 'ORGANI') {
            ?>
            <div>
                <a href="<?= $Links['URL'].'organisme/'; ?>" class="sidebar__link sidebar__logo">
                    <i class="bi bi-disc sidebar__icon"></i>
                    <span class="sidebar__logo-name"><?= $organisme['libelle']; ?></span>
                </a>
                <div class="sidebar__list">
                    <div class="sidebar__items">
                        <a href="<?= $Links['URL'] . 'organisme/'; ?>" class="sidebar__link">
                            <i class="bi bi-house sidebar__icon"></i>
                            <span class="sidebar__name">Accueil</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organisme/polices/'; ?>" class="sidebar__link">
                            <i class="bi bi-file-earmark-font-fill sidebar__icon"></i>
                            <span class="sidebar__name">Polices</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organisme/colleges/'; ?>" class="sidebar__link">
                            <i class="bi bi-menu-up sidebar__icon"></i>
                            <span class="sidebar__name">Collèges</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organisme/assures/'; ?>" class="sidebar__link">
                            <i class="bi bi-person-lines-fill sidebar__icon"></i>
                            <span class="sidebar__name">Assurés</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organisme/prestations/'; ?>" class="sidebar__link">
                            <i class="bi bi-file-earmark-medical sidebar__icon"></i>
                            <span class="sidebar__name">Prestations</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organisme/remboursements/'; ?>" hidden class="sidebar__link">
                            <i class="bi bi-app-indicator sidebar__icon"></i>
                            <span class="sidebar__name">Remboursements</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organisme/support/'; ?>" class="sidebar__link">
                            <i class="bi bi-question-circle sidebar__icon"></i>
                            <span class="sidebar__name">Support</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organisme/dashboard/'; ?>" class="sidebar__link">
                            <i class="bi bi-graph-up sidebar__icon"></i>
                            <span class="sidebar__name">Dashboard</span>
                        </a>
                        <a href="<?= $Links['URL'] . 'organisme/parametres/'; ?>" class="sidebar__link">
                            <i class="bi bi-gear-wide-connected sidebar__icon"></i>
                            <span class="sidebar__name">Paramètes</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        } else {

        }
        ?>
        <a href="" class="sidebar__link sidebar__logout text-danger" id="a_deconnexion"><i
                    class="bi bi-power sidebar__icon"></i><span class="sidebar__name">Déconnexion</span></a>
    </nav>
</div>
<?php
$validite = $UTILISATEURS->validite_mot_de_passe($autorisation['id_user']);
if($validite) {
    if($validite['etat'] <= 7) {
        ?>
        <div id="div_infos">
            <span>Urgent</span>
            <ul>
                <li><a target="_blank" href="<?= $Links['URL'].'profil';?>">Votre mot de passe expire dans <strong><?= $validite['etat'];?>  jour.s</strong>, pensez à le mettre à jour.</a></li>;
            </ul>
        </div>
        <?php
    }
}
?>