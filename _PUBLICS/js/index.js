let path;

function getUrlVars() {
    let vars = [], hash;
    let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(let i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
function deconnexion(niveau) {
    if(niveau === 0) {path = '';}else if(niveau === 1) {path = '../';}else if(niveau === 2) {path = '../../';}
    $.ajax({
        url: path+'_CONFIGS/Includes/Submits/Utilisateurs/submit_utilisateur_deconnexion.php',
        dataType: 'json',
        success: function (data) {
            if(data['success'] === true) {
                window.location.href="";
            }
        }
    });
}
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}
function passwordChecker(mot_de_passe) {

    let longueur = mot_de_passe.length,
        format = mot_de_passe.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/);
    if(longueur > 0) {
        if(!mot_de_passe.match(/[a-z]/)) {
            $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
            $("#passwordNewHelp").addClass('text-danger')
                .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins une lettre minuscule.');
        }else {
            if(!mot_de_passe.match(/[A-Z]/)) {
                $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
                $("#passwordNewHelp").addClass('text-danger')
                    .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins une lettre majuscule.');
            }else {
                if(!mot_de_passe.match(/[0-9]/)) {
                    $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
                    $("#passwordNewHelp").addClass('text-danger')
                        .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins un chiffre.');
                }else {
                    if(!format) {
                        $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
                        $("#passwordNewHelp").addClass('text-danger')
                            .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins un caractère spécial.');
                    }else {
                        if(longueur < 8) {
                            $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
                            $("#passwordNewHelp").addClass('text-danger')
                                .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins 8 caractères.');
                        }else {
                            $("#nouveau_mot_de_passe_input").removeClass('is-invalid').addClass('is-valid');
                            $("#passwordNewHelp").removeClass('text-danger')
                                .html('');
                        }
                    }
                }
            }
        }
    }else {
        $("#nouveau_mot_de_passe_small").removeClass('alert alert-dark')
            .html('');
    }
}

function loading_gif(niveau) {
    if(niveau === 0) {path = '';}else if(niveau === 1) {path = '../';}else if(niveau === 2) {path = '../../';}
    return path+"_publics/images/loading.gif";
}


function display_index_page() {
    $("#div_page_index").html('<p class="align_center"><img class="img_loading_page" alt="Chargement..." src="'+loading_gif(0)+'" /></p>');
    $.ajax({
        url: '_configs/Includes/Pages/Index.php',
        success: function (data) {
            $("#div_page_index").html(data);
        }
    });
}
function display_connexion_page() {
    $("#div_page_connexion").html('<p class="align_center"><img class="img_loading_page" alt="Chargement..." src="'+loading_gif(0)+'" /></p>');
    $.ajax({
        url: '_configs/Includes/Pages/Connexion.php',
        success: function (data) {
            $("#div_page_connexion").html(data);
        }
    });

}
function display_mot_de_passe_page() {
    $("#div_page_mot_de_passe").html('<p class="align_center"><img class="img_loading_page" alt="Chargement..." src="'+loading_gif(0)+'" /></p>');
    $.ajax({
        url: '_configs/Includes/Pages/MotDePasse.php',
        success: function (data) {
            $("#div_page_mot_de_passe").html(data);
        }
    });

}
function display_parametres_index_page() {
    $("#div_page_parametres_index").html('<p class="align_center"><img class="img_loading_page" alt="Chargement..." src="'+loading_gif(1)+'" /></p>');
    $.ajax({
        url: '../_configs/Includes/Pages/Parametres/Index.php',
        success: function (data) {
            $("#div_page_parametres_index").html(data);
        }
    });

}
function display_parametres_tables_de_valeurs_page() {
    $("#div_page_parametres_tables_de_valeurs").html('<p class="align_center"><img class="img_loading_page" alt="Chargement..." src="'+loading_gif(1)+'" /></p>');
    $.ajax({
        url: '../_configs/Includes/Pages/Parametres/TablesDeValeurs.php',
        success: function (data) {
            $("#div_page_parametres_tables_de_valeurs").html(data);
        }
    });

}

function display_tables_de_valeurs(donnee) {
    if(donnee === 'put') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/ProfilsUtilisateurs.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'csp') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/CategoriesSocioProfessionnelles.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'civ') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Civilites.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'sex') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Sexes.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'sif') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/SituationsFamiliales.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'sct') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/SecteursActivites.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'prf') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Professions.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'qtc') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/QualitesCivilites.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'tco') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesCoordonnees.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'tpi') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesPiecesIdentites.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'dev') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/DevisesMonetaires.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'gsa') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GroupesSanguins.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'rhs') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Rhesus.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'lge') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GeoPays.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'reg') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GeoRegions.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'dep') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GeoDepartements.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'com') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GeoCommunes.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
}