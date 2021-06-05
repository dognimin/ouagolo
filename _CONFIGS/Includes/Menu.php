
<header class="header">
    <div class="header__container">
        <img src="<?= IMAGES.'logos/logo-o.jpeg';?>" alt="" class="header__img" />

        <a href="#" class="header__logo"><?= ucfirst(strtolower($user['prenoms']));?></a>

        <div class="header__search" hidden>
            <input aria-label="Recherche" type="search" placeholder="Recherche" class="header__input"/>
            <i class="bi bi-search header__icon"></i>
        </div>

        <div class="header__toggle">
            <i class="bi bi-list" id="header-toggle"></i>
        </div>
    </div>
</header>
<!--========== NAV ==========-->
<div class="sidebar" id="navbar">
    <nav class="sidebar__container">
        <div>
            <a href="#" class="sidebar__link sidebar__logo">
                <i class="bi bi-disc sidebar__icon"></i>
                <span class="sidebar__logo-name">Ouagolo</span>
            </a>
            <div class="sidebar__list">
                <div class="sidebar__items">
                    <a href="<?= URL;?>" class="sidebar__link">
                        <i class="bi bi-house sidebar__icon"></i>
                        <span class="sidebar__name">Accueil</span>
                    </a>
                    <div class="sidebar__dropdown">
                        <a href="<?= URL.'parametres/';?>" class="sidebar__link">
                            <i class="bi bi-gear-wide-connected sidebar__icon"></i>
                            <span class="sidebar__name">Paramètres</span>
                            <i class='bi bi-caret-down sidebar__icon sidebar__dropdown-icon'></i>
                        </a>
                        <div class="sidebar__dropdown-collapse">
                            <div class="sidebar__dropdown-content">
                                <a href="<?= URL.'parametres/etablissements/';?>" class="sidebar__dropdown-item"><i class="bi bi-building"></i> Etablissements</a>
                                <a href="<?= URL.'parametres/reseaux-de-soins/';?>" class="sidebar__dropdown-item"><i class="bi bi-diagram-3"></i> Réseaux de soins</a>
                                <a href="<?= URL.'parametres/utilisateurs/';?>" class="sidebar__dropdown-item"><i class="bi bi-person-bounding-box"></i> Utilisateurs</a>
                                <a href="<?= URL.'parametres/referentiels/';?>" class="sidebar__dropdown-item"><i class="bi bi-clipboard-plus"></i> Référentiels</a>
                                <a href="<?= URL.'parametres/tables-de-valeurs';?>" class="sidebar__dropdown-item"><i class="bi bi-award"></i> Tables de valeurs</a>
                                <a href="<?= URL.'parametres/securite/';?>" class="sidebar__dropdown-item"><i class="bi bi-shield-check"></i> Sécurité</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <a href="" class="sidebar__link sidebar__logout" id="a_deconnexion"><i class="bi bi-power sidebar__icon"></i><span class="sidebar__name">Déconnexion</span></a>
    </nav>
</div>