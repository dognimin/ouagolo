<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="<?= IMAGES.'logo-ouagolo.png';?>" alt="" width="30" height="24">
        </a>
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= URL;?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URL.'parametres/';?>">Paramètres</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-danger" id="a_deconnexion" aria-current="page" href="">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>