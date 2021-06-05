/*==================== SHOW NAVBAR ====================*/
let showMenu = (headerToggle, navbarId) =>{
    let toggleBtn = document.getElementById(headerToggle),
        nav = document.getElementById(navbarId);
    //console.log(nav);
    // Validate that variables exist
    if(headerToggle && navbarId){
        toggleBtn.addEventListener('click', ()=>{
            // We add the show-menu class to the div tag with the nav__menu class
            nav.classList.toggle('show-menu');
        })
    }
}
function initFonction() {
    showMenu('header-toggle', 'navbar');
}
window.onload = initFonction;

/*==================== LINK ACTIVE ====================*/
const linkColor = document.querySelectorAll('.nav__link')

function colorLink(){
    linkColor.forEach(l => l.classList.remove('active'))
    this.classList.add('active')
}

linkColor.forEach(l => l.addEventListener('click', colorLink))


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
    let path;
    if(niveau === 0) {path = '';}else if(niveau === 1) {path = '../';}else if(niveau === 2) {path = '../../';}
    console.log(niveau);
    $.ajax({
        url: path+'_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_deconnexion.php',
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
    let path,
        src;
    if(niveau === 0) {path = '';}else if(niveau === 1) {path = '../';}else if(niveau === 2) {path = '../../';}
    src = path+"_PUBLICS/images/loading.gif";
    return '<p class="align_center"><img style="width: 100px" src="'+src+'" alt="Loading..."></p>'
}


function display_index_page() {
    $("#div_page_index").html(loading_gif(0));
    $.ajax({
        url: '_CONFIGS/Includes/Pages/Index.php',
        success: function (data) {
            $("#div_page_index").html(data);
        }
    });
}
function display_connexion_page() {
    $("#div_page_connexion").html(loading_gif(0));
    $.ajax({
        url: '_CONFIGS/Includes/Pages/Connexion.php',
        success: function (data) {
            $("#div_page_connexion").html(data);
        }
    });

}
function display_mot_de_passe_page() {
    $("#div_page_mot_de_passe").html(loading_gif(0));
    $.ajax({
        url: '_CONFIGS/Includes/Pages/MotDePasse.php',
        success: function (data) {
            $("#div_page_mot_de_passe").html(data);
        }
    });

}
function display_parametres_index_page() {
    $("#div_page_parametres_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Parametres/Index.php',
        success: function (data) {
            $("#div_page_parametres_index").html(data);
        }
    });

}
function display_parametres_etablissements_index_page() {
    $("#div_page_parametres_etablissements_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/Index.php',
        success: function (data) {
            $("#div_page_parametres_etablissements_index").html(data);
        }
    });

}
function display_parametres_etablissements_details_page(code) {
    $("#div_page_parametres_etablissements_detail").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/Details.php',
        type: 'post',
        data: {
            'code': code,
        },
        success: function (data) {
            $("#div_page_parametres_etablissements_detail").html(data);
            display_ets_coordonnees(code);
            display_ets_professionnels_sante(code);
            display_ets_agents(code);
            display_ets_services(code);
        }
    });

}

function display_parametres_utilisateurs_index_page() {
    $("#div_page_parametres_utilisateurs_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Utilisateurs/Index.php',
        success: function (data) {
            $("#div_page_parametres_utilisateurs_index").html(data);
        }
    });

}
function display_parametres_reseaux_de_soins_index_page() {
    $("#div_page_parametres_reseaux_de_soins_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/Index.php',
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_index").html(data);
        }
    });

}
function display_parametres_reseaux_de_soins_details_page(code) {
    $("#div_page_parametres_reseaux_de_soins_details").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/Details.php',
        type: 'POST',
        data: {
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_details").html(data);
        }
    });

}
function display_parametres_reseaux_de_soins_etablissements_page(code) {
    $("#div_page_parametres_reseaux_de_soins_etablissements").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/Etablissements.php',
        type: 'POST',
        data: {
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_etablissements").html(data);
        }
    });

}
function display_parametres_reseaux_de_soins_medicaments_page(code) {
    $("#div_page_parametres_reseaux_de_soins_medicaments").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/Medicaments.php',
        type: 'POST',
        data: {
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_medicaments").html(data);
        }
    });

}
function display_parametres_reseaux_de_soins_actes_medicaux_page(code) {
    $("#div_page_parametres_reseaux_de_soins_actes_medicaux").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/ActesMedicaux.php',
        type: 'POST',
        data: {
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_actes_medicaux").html(data);
        }
    });

}


function display_parametres_securite_index_page() {
    $("#div_page_parametres_securites_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Securite/Index.php',
        success: function (data) {
            $("#div_page_parametres_securite_index").html(data);
        }
    });

}
function display_parametres_securite_mdp_page() {
    $("#div_page_parametres_securite_mdp").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Securite/MotDePasse.php',
        success: function (data) {
            $("#div_page_parametres_securite_mdp").html(data);
        }
    });

}
function display_parametres_securite_compte_page() {
    $("#div_page_parametres_compte").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Securite/Compte.php',
        success: function (data) {
            $("#div_page_parametres_compte").html(data);
        }
    });

}
function display_parametres_utilisateur_details_page(uid) {
    $("#div_page_parametres_utilisateur_details").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Utilisateurs/Details.php',
        type: 'post',
        data: {
            'uid': uid,
        },
        success: function (data) {
            $("#div_page_parametres_utilisateur_details").html(data);
            display_utilisateur_coordonnees(uid);
            display_utilisateur_infos_personnelles(uid);
            display_utilisateur_infos_sante(uid);
        }
    });

}

function display_parametres_referentiels_index_page() {
    $("#div_page_parametres_referentiels_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Index.php',
        success: function (data) {
            $("#div_page_parametres_referentiels_index").html(data);
        }
    });

}
function display_parametres_referentiels_pathologies_page() {
    $("#div_page_parametres_referentiels_pathologies").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies.php',
        success: function (data) {
            $("#div_page_parametres_referentiels_pathologies").html(data);
        }
    });

}
function display_parametres_referentiels_actes_medicaux_page() {
    $("#div_page_parametres_referentiels_actes_medicaux").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux.php',
        success: function (data) {
            $("#div_page_parametres_referentiels_actes_medicaux").html(data);
        }
    });

}
function display_parametres_referentiels_medicaments_page() {
    $("#div_page_parametres_referentiels_medicaments").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments.php',
        success: function (data) {
            $("#div_page_parametres_referentiels_medicaments").html(data);
        }
    });

}

function display_parametres_tables_de_valeurs_page() {
    $("#div_page_parametres_tables_de_valeurs").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs.php',
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
    if(donnee === 'tac') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesAccidents.php',
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
    if(donnee === 'ordre') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/OrdresNationnaux.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'Typ_etab') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesEtablissements.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if(donnee === 'etab_service') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/EtablissementsServices.php',
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
    if(donnee === 'cps') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/CategoriesProfessionnelsSante.php',
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
    if(donnee === 'typ_pers') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesPersonnes.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
}
function display_actes_medicaux(donnee) {
    if(donnee === 'let_cle') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/LettresCles.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if(donnee === 'act_tit') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/Titres.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if(donnee === 'act_cha') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/Chapitres.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if(donnee === 'act_sec') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/Sections.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if(donnee === 'act_art') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/Articles.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if(donnee === 'act_med') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/ActesMedicaux.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }

}
function display_medicaments(donnee) {
    if(donnee === 'med_lab') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/LaboratoiresPharmaceutiques.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if(donnee === 'med_dci') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/DenominationsCommunesInternationales.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }

    if(donnee === 'med_pre'){
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/Presentations.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if(donnee === 'med_ffm') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/FamillesFormes.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if(donnee === 'med_frm') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/Formes.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if(donnee === 'med_typ') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/TypesDeMedicaments.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if(donnee === 'med_cth') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/ClassesTherapeuthiques.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if(donnee === 'med_fra') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/FormesAdministrations.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if(donnee === 'med_unt') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/UnitesDeDosages.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if(donnee === 'med') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/Medicaments.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }

}
function display_pathologies(donnee) {
    if(donnee === 'pat_chap') {
        $("#div_pathologies").html(loading_gif(2));
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies/Chapitres.php',
            success: function (data) {
                $("#div_referentiels_pathologies").html(data);
            }
        });
    }
    if(donnee === 'pat_sch') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies/SousChapitres.php',
            success: function (data) {
                $("#div_referentiels_pathologies").html(data);
            }
        });
    }
    if(donnee === 'pat') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies/Pathologie.php',
            success: function (data) {
                $("#div_referentiels_pathologies").html(data);
            }
        });
    }
}
function display_types_etablissements() {
    $("#div_types_etablissements").html(loading_gif(2));
    $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/TypesEtablissements.php',
            success: function (data) {
                $("#div_types_etablissements").html(data);
            }
        });
}
function display_niveaux_sanitaires() {
    $("#div_niveaux_sanitaires").html(loading_gif(2));
    $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/NiveauxSanitaires.php',
            success: function (data) {
                $("#div_niveaux_sanitaires").html(data);
            }
        });
}

function display_utilisateur_coordonnees(uid) {
    if(uid) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Utilisateurs/AfficherUtilisateurCoordonnees.php',
            type: 'POST',
            data: {
                'uid': uid
            },
            success: function (data) {
                $("#nav-coordonnees").html(data);
            }
        });
    }
}
function display_utilisateur_infos_personnelles(uid) {
    if(uid) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Utilisateurs/AfficherUtilisateurInfosPersonnelles.php',
            type: 'POST',
            data: {
                'uid': uid
            },
            success: function (data) {
                $("#nav-personnel").html(data);
            }
        });
    }
}
function display_utilisateur_infos_sante(uid) {
    if(uid) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Utilisateurs/AfficherUtilisateurInfosSante.php',
            type: 'POST',
            data: {
                'uid': uid
            },
            success: function (data) {
                $("#nav-sante").html(data);
            }
        });
    }
}


function display_ets_coordonnees(code_ets) {
    if(code_ets) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/AfficherEtsCoordonnees.php',
            type: 'POST',
            data: {
                'code_ets': code_ets
            },
            success: function (data) {
                $("#nav-coordonnees").html(data);
            }
        });
    }
}
function display_ets_professionnels_sante(code_ets) {
    if(code_ets) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/AfficherEtsProfessionnelsSante.php',
            type: 'POST',
            data: {
                'code_ets': code_ets
            },
            success: function (data) {
                $("#nav-professionnel-sante").html(data);
            }
        });
    }
}
function display_ets_agents(code_ets) {
    if(code_ets) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/AfficherEtsAgents.php',
            type: 'POST',
            data: {
                'code_ets': code_ets
            },
            success: function (data) {
                $("#nav-agent").html(data);
            }
        });
    }
}
function display_ets_services(code_ets) {
    if(code_ets) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/AfficherEtsServices.php',
            type: 'POST',
            data: {
                'code_ets': code_ets
            },
            success: function (data) {
                $("#nav-service").html(data);
            }
        });
    }
}