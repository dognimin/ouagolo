jQuery.datetimepicker.setLocale('fr');

/*==================== SHOW NAVBAR ====================*/

let showMenu = (headerToggle, navbarId) => {
    let toggleBtn = $("#headerToggle")[0],
        nav = $("#navbarId")[0];
    //console.log(nav);
    // Validate that variables exist
    if (headerToggle && navbarId) {
        toggleBtn.addEventListener('click', () => {
            // We add the show-menu class to the div tag with the nav__menu class
            nav.classList.toggle('show-menu');
        })
    }
}

/*==================== LINK ACTIVE ====================*/
const linkColor = document.querySelectorAll('.nav__link')

function colorLink()
{
    linkColor.forEach(l => l.classList.remove('active'))
    this.classList.add('active')
}

linkColor.forEach(l => l.addEventListener('click', colorLink))


function getUrlVars()
{
    let vars = [], hash;
    let hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (let i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function deconnexion_manuelle(niveau)
{
    let path;
    if (niveau === 0) {
        path = '';} else if (niveau === 1) {
        path = '../';} else if (niveau === 2) {
            path = '../../';}
        $.ajax({
            url: path + '_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_deconnexion_manuelle.php',
            dataType: 'json',
            success: function (data) {
                if (data['success'] === true) {
                    window.location.href="";
                }

            }
        });
}

function deconnexion_automatique(niveau)
{
    let path;
    if (niveau === 0) {
        path = '';} else if (niveau === 1) {
        path = '../';} else if (niveau === 2) {
            path = '../../';}
        $.ajax({
            url: path + '_CONFIGS/Includes/Submits/Parametres/Utilisateurs/submit_deconnexion_automatique.php',
            dataType: 'json',
            success: function (data) {
                if (data['success'] === true) {
                    let myAudio = new Audio(path + '_PUBLICS/audio/562188__gristi__snd-elevator-power-down.wav');
                    myAudio.play();
                    $("#div_main_page").append('<div id="dialog">\n' +
                    '  <p class="align_center h6"><br />' +
                    'Vous êtes déconnecté<br /><br /><br />' +
                    '<button id="button_deconnexion" type="button" class="btn btn-dark btn-sm"><i class="bi bi-arrow-return-left"></i> Quitter</button></p>\n' +
                    '</div>');
                    $("#dialog").dialog({
                        resizable: false,
                        height: 150,
                        width: 300,
                        modal: true,
                        title: false
                    });
                    $(".ui-dialog-titlebar").hide();
                    $("#button_deconnexion").click(function () {
                        window.location.reload();
                    });
                }

            }
        });
}

function isValidEmailAddress(emailAddress)
{
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function passwordChecker(mot_de_passe)
{

    let longueur = mot_de_passe.length,
        format = mot_de_passe.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/);
    if (longueur > 0) {
        if (!mot_de_passe.match(/[a-z]/)) {
            $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
            $("#passwordNewHelp").addClass('text-danger')
                .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins une lettre minuscule.');
        } else {
            if (!mot_de_passe.match(/[A-Z]/)) {
                $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
                $("#passwordNewHelp").addClass('text-danger')
                    .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins une lettre majuscule.');
            } else {
                if (!mot_de_passe.match(/[0-9]/)) {
                    $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
                    $("#passwordNewHelp").addClass('text-danger')
                        .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins un chiffre.');
                } else {
                    if (!format) {
                        $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
                        $("#passwordNewHelp").addClass('text-danger')
                            .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins un caractère spécial.');
                    } else {
                        if (longueur < 8) {
                            $("#nouveau_mot_de_passe_input").removeClass('is-valid').addClass('is-invalid');
                            $("#passwordNewHelp").addClass('text-danger')
                                .html('<i class="fa fa-dot-circle"></i> Le mot de passe doit contenir au moins 8 caractères.');
                        } else {
                            $("#nouveau_mot_de_passe_input").removeClass('is-invalid').addClass('is-valid');
                            $("#passwordNewHelp").removeClass('text-danger')
                                .html('');
                        }
                    }
                }
            }
        }
    } else {
        $("#nouveau_mot_de_passe_small").removeClass('alert alert-dark')
            .html('');
    }
}

function loading_gif(niveau)
{
    /*
    let path,
        src;
    if (niveau === 0) {
        path = '';
    } else if (niveau === 1) {
        path = '../';
    } else if (niveau === 2) {
        path = '../../';
    }
    src = path + "_PUBLICS/images/loading.gif";
    */
    return '<div id="div_loader">' +
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">\n' +
        '<g transform="translate(26.5,26.5)">\n' +
        '  <rect x="-20.5" y="-20.5" width="41" height="41" fill="#007ec2">\n' +
        '    <animateTransform attributeName="transform" type="scale" repeatCount="indefinite" dur="0.5319148936170213s" keyTimes="0;1" values="1.1300000000000001;1" begin="-0.15957446808510636s"></animateTransform>\n' +
        '  </rect>\n' +
        '</g>\n' +
        '<g transform="translate(73.5,26.5)">\n' +
        '  <rect x="-20.5" y="-20.5" width="41" height="41" fill="#ffffff">\n' +
        '    <animateTransform attributeName="transform" type="scale" repeatCount="indefinite" dur="0.5319148936170213s" keyTimes="0;1" values="1.1300000000000001;1" begin="-0.10638297872340426s"></animateTransform>\n' +
        '  </rect>\n' +
        '</g>\n' +
        '<g transform="translate(26.5,73.5)">\n' +
        '  <rect x="-20.5" y="-20.5" width="41" height="41" fill="#000000">\n' +
        '    <animateTransform attributeName="transform" type="scale" repeatCount="indefinite" dur="0.5319148936170213s" keyTimes="0;1" values="1.1300000000000001;1" begin="0s"></animateTransform>\n' +
        '  </rect>\n' +
        '</g>\n' +
        '<g transform="translate(73.5,73.5)">\n' +
        '  <rect x="-20.5" y="-20.5" width="41" height="41" fill="#fd0000">\n' +
        '    <animateTransform attributeName="transform" type="scale" repeatCount="indefinite" dur="0.5319148936170213s" keyTimes="0;1" values="1.1300000000000001;1" begin="-0.05319148936170213s"></animateTransform>\n' +
        '  </rect>\n' +
        '</g>\n' +
        '</svg>' +
        '</div>'
}
function loading_gif_circle(niveau)
{
    let path,
        src;
    if (niveau === 0) {
        path = '';
    } else if (niveau === 1) {
        path = '../';
    } else if (niveau === 2) {
        path = '../../';
    }
    src = path + "_PUBLICS/images/loading_circle.gif";
    return '<img style="width: 20px" src="' + src + '" alt="Loading...">'
}


function display_index_page(url)
{
    $("#div_page_index").html(loading_gif(0));
    $.ajax({
        url: '_CONFIGS/Includes/Pages/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_index").html(data);
        }
    });
}

function display_profil_page(url)
{
    $("#div_page_profil").html(loading_gif(0));
    $.ajax({
        url: '_CONFIGS/Includes/Pages/Profil.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_profil").html(data);
        }
    });
}

function display_introuvable_page()
{
    $("#div_page_introuvable").html(loading_gif(0));
    $.ajax({
        url: '_CONFIGS/Includes/Pages/PageIntrouvable.php',
        success: function (data) {
            $("#div_page_introuvable").html(data);
        }
    });
}

function display_connexion_page()
{
    $("#div_page_connexion").html(loading_gif(0));
    $.ajax({
        url: '_CONFIGS/Includes/Pages/Connexion.php',
        success: function (data) {
            $("#div_page_connexion").html(data);
        }
    });

}

function display_mot_de_passe_page(url)
{
    $("#div_page_mot_de_passe").html(loading_gif(0));
    $.ajax({
        url: '_CONFIGS/Includes/Pages/MotDePasse.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_mot_de_passe").html(data);
        }
    });

}



function display_etablissement_index_page(url)
{
    $("#div_page_etablissement_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Etablissement/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_index").html(data);
        }
    });

}
function display_etablissement_fournisseurs_page(url, code)
{
    $("#div_page_etablissement_fournisseurs").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Etablissement/Fournisseurs.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_etablissement_fournisseurs").html(data);
        }
    });

}
function display_etablissement_patients_index_page(url, num_patient)
{
    $("#div_page_etablissement_patients_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Patients/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'num_patient': num_patient
        },
        success: function (data) {
            $("#div_page_etablissement_patients_index").html(data);
        }
    });

}
function display_etablissement_dossiers_index_page(url, num_dossier)
{
    $("#div_page_etablissement_dossiers_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Dossiers/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'num_dossier': num_dossier
        },
        success: function (data) {
            $("#div_page_etablissement_dossiers_index").html(data);
        }
    });

}
function display_etablissement_pharmacie_index_page(url)
{
    $("#div_page_etablissement_pharmacie_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Pharmacie/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_pharmacie_index").html(data);
        }
    });

}
function display_etablissement_pharmacie_ventes_page(url)
{
    $("#div_page_etablissement_pharmacie_ventes").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Pharmacie/Ventes.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_pharmacie_ventes").html(data);
        }
    });

}
function display_etablissement_pharmacie_stock_page(url)
{
    $("#div_page_etablissement_pharmacie_stock").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Pharmacie/Stock.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_pharmacie_stock").html(data);
        }
    });

}
function display_etablissement_pharmacie_produits_page(url, code)
{
    $("#div_page_etablissement_pharmacie_produits").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Pharmacie/Produits.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_etablissement_pharmacie_produits").html(data);
        }
    });

}
function display_etablissement_pharmacie_commandes_page(url, numero)
{
    $("#div_page_etablissement_pharmacie_commandes").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Pharmacie/Commandes.php',
        type: 'POST',
        data: {
            'url': url,
            'numero': numero
        },
        success: function (data) {
            $("#div_page_etablissement_pharmacie_commandes").html(data);
        }
    });

}

function display_etablissement_factures_index_page(url, num_facture)
{
    $("#div_page_etablissement_factures_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Factures/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'num_facture': num_facture
        },
        success: function (data) {
            $("#div_page_etablissement_factures_index").html(data);
        }
    });

}
function display_etablissement_factures_bordereaux_page(url, num_bordereau)
{
    $("#div_page_etablissement_factures_bordereaux").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Factures/Bordereaux.php',
        type: 'POST',
        data: {
            'url': url,
            'num_bordereau': num_bordereau
        },
        success: function (data) {
            $("#div_page_etablissement_factures_bordereaux").html(data);
        }
    });

}
function display_etablissement_factures_edition_page(url, num_patient, num_facture)
{
    $("#div_page_etablissement_factures_edition").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Factures/Edition.php',
        type: 'POST',
        data: {
            'url': url,
            'num_patient': num_patient,
            'num_facture': num_facture
        },
        success: function (data) {
            $("#div_page_etablissement_factures_edition").html(data);
        }
    });

}
function display_etablissement_comptabilite_index_page(url)
{
    $("#div_page_etablissement_compatabilite_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Comptabilite/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_compatabilite_index").html(data);
        }
    });

}
function display_etablissement_services_index_page(url)
{
    $("#div_page_etablissement_services_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Services/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_services_index").html(data);
        }
    });

}
function display_etablissement_professionnels_de_sante_index_page(url, code_ps)
{
    $("#div_page_etablissement_professionnels_de_sante_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/ProfessionnelsDeSante/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'code_ps': code_ps
        },
        success: function (data) {
            $("#div_page_etablissement_professionnels_de_sante_index").html(data);
        }
    });

}
function display_etablissement_rdv_index_page(url, annee, mois)
{
    $("#div_page_etablissement_rdv_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/RendezVous/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'annee': annee,
            'mois': mois
        },
        success: function (data) {
            $("#div_page_etablissement_rdv_index").html(data);
        }
    });

}
function display_etablissement_laboratoire_index_page(url)
{
    $("#div_page_etablissement_laboratoire_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Laboratoire/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_laboratoire_index").html(data);
        }
    });

}
function display_etablissement_dashboard_index_page(url)
{
    $("#div_page_etablissement_dashboard_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Dashboard/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_dashboard_index").html(data);
        }
    });

}
function display_etablissement_support_index_page(url)
{
    $("#div_page_etablissement_support_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Support/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_support_index").html(data);
        }
    });

}
function display_etablissement_apropos_index_page(url)
{
    $("#div_page_etablissement_apropos_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Apropos/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_apropos_index").html(data);
        }
    });

}
function display_etablissement_parametres_index_page(url)
{
    $("#div_page_etablissement_parametres_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Parametres/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_parametres_index").html(data);
        }
    });

}
function display_etablissement_parametres_panier_soins_page(url)
{
    $("#div_page_etablissement_parametres_panier_soins").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Parametres/PanierDeSoins.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_etablissement_parametres_panier_soins").html(data);
        }
    });

}
function display_etablissement_parametres_profils_utilisateurs_page(url, pid)
{
    $("#div_page_etablissement_parametres_profils_utilisateurs").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Parametres/ProfilsUtilisateurs.php',
        type: 'POST',
        data: {
            'url': url,
            'pid': pid
        },
        success: function (data) {
            $("#div_page_etablissement_parametres_profils_utilisateurs").html(data);
        }
    });

}
function display_etablissement_parametres_utilisateurs_page(url, uid)
{
    $("#div_page_etablissement_parametres_utilisateurs").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Parametres/Utilisateurs.php',
        type: 'POST',
        data: {
            'url': url,
            'uid': uid
        },
        success: function (data) {
            $("#div_page_etablissement_parametres_utilisateurs").html(data);
        }
    });

}
function display_etablissement_parametres_chambres_page(url, code_chambre)
{
    $("#div_page_etablissement_parametres_chambres").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Etablissement/Parametres/Chambres.php',
        type: 'POST',
        data: {
            'url': url,
            'code_chambre': code_chambre
        },
        success: function (data) {
            $("#div_page_etablissement_parametres_chambres").html(data);
        }
    });

}


function display_etablissements_index_page(url, code)
{
    $("#div_page_etablissements_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Etablissements/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_etablissements_index").html(data);
            if (code) {
                display_ets_coordonnees(1, code);
            }
        }
    });

}

function display_organisme_index_page(url)
{
    $("#div_page_organisme_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Organisme/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_organisme_index").html(data);
        }
    });
}
function display_organisme_prestations_index_page(url)
{
    $("#div_page_organisme_prestations_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Prestations/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_organisme_prestations_index").html(data);
        }
    });
}
function display_organisme_prestations_factures_page(url, rubrique, num_facture)
{
    $("#div_page_organisme_prestations_factures").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Prestations/Factures.php',
        type: 'POST',
        data: {
            'url': url,
            'rubrique': rubrique,
            'num_facture': num_facture
        },
        success: function (data) {
            $("#div_page_organisme_prestations_factures").html(data);
        }
    });
}

function display_organisme_prestations_demandes_page(url)
{
    $("#div_page_organisme_prestations_demandes").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Prestations/Demandes.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_organisme_prestations_demandes").html(data);
        }
    });
}
function display_organisme_parametres_produits_page(url, code)
{
    $("#div_page_organisme_parametres_produits").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Parametres/Produits.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_organisme_parametres_produits").html(data);
        }
    });
}
function display_organisme_parametres_reseaux_de_soins_page(url, code)
{
    $("#div_page_organisme_parametres_reseaux_de_soins").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Parametres/ReseauxDeSoins.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_organisme_parametres_reseaux_de_soins").html(data);
        }
    });
}
function display_organisme_parametres_paniers_de_soins_page(url, code)
{
    $("#div_page_organisme_parametres_paniers_de_soins").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Parametres/PaniersDeSoins.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_organisme_parametres_paniers_de_soins").html(data);
        }
    });
}
function display_organisme_parametres_index_page(url)
{
    $("#div_page_organisme_parametres_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Parametres/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_organisme_parametres_index").html(data);
        }
    });
}
function display_organisme_parametres_utilisateurs_page(url, uid)
{
    $("#div_page_organisme_parametres_utilisateurs").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Parametres/Utilisateurs.php',
        type: 'POST',
        data: {
            'url': url,
            'uid': uid
        },
        success: function (data) {
            $("#div_page_organisme_parametres_utilisateurs").html(data);
        }
    });

}

function display_organisme_remboursements_index_page(url)
{
    $("#div_page_organisme_remboursements_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Remboursements/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_organisme_remboursements_index").html(data);
        }
    });
}
function display_organisme_colleges_index_page(url, id_police, code)
{
    $("#div_page_organisme_colleges_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Colleges/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'id_police': id_police,
            'code': code
        },
        success: function (data) {
            $("#div_page_organisme_colleges_index").html(data);
        }
    });
}
function display_organisme_colleges_edition_page(url)
{
    $("#div_page_organisme_colleges_edition").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Colleges/Edition.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_organisme_colleges_edition").html(data);
        }
    });
}
function display_organisme_assures_index_page(url, num)
{
    $("#div_page_organisme_assures_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Assures/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'num': num
        },
        success: function (data) {
            $("#div_page_organisme_assures_index").html(data);
        }
    });
}
function display_organisme_polices_index_page(url, id_police)
{
    $("#div_page_organisme_polices_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Polices/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'id': id_police
        },
        success: function (data) {
            $("#div_page_organisme_polices_index").html(data);
        }
    });
}
function display_organisme_support_index_page(url)
{
    $("#div_page_organisme_support_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Support/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_organisme_support_index").html(data);
        }
    });
}
function display_organisme_dashboard_index_page(url)
{
    $("#div_page_organisme_dashboard_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Organisme/Dashboard/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_organisme_dashboard_index").html(data);
        }
    });
}


function display_organismes_index_page(url, code)
{
    $("#div_page_organismes_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Organismes/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_organismes_index").html(data);
        }
    });
}
function display_organismes_baremes_page(url, code)
{
    $("#div_page_organismes_baremes").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Organismes/Baremes.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_organismes_baremes").html(data);
        }
    });
}
function display_organismes_utilisateurs_page(url, code)
{
    $("#div_page_organismes_utilisateurs").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Organismes/Utilisateurs.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_organismes_utilisateurs").html(data);
        }
    });
}

function display_support_index_page(url)
{
    $("#div_page_support_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Support/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_support_index").html(data);
        }
    });

}

function display_comptabilite_index_page(url)
{
    $("#div_page_comptabilite_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Comptabilite/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_comptabilite_index").html(data);
        }
    });

}

function display_factures_index_page(url)
{
    $("#div_page_factures_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Factures/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_factures_index").html(data);
        }
    });

}

function display_dashboard_index_page(url)
{
    $("#div_page_dashboard_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Dashboard/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_dashboard_index").html(data);
        }
    });

}

function display_parametres_index_page(url)
{
    $("#div_page_parametres_index").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Parametres/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_index").html(data);
        }
    });

}

function display_parametres_etablissements_index_page(url)
{
    $("#div_page_parametres_etablissements_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_etablissements_index").html(data);
        }
    });

}

function display_parametres_etablissements_details_page(code)
{
    $("#div_page_parametres_etablissements_detail").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Etablissements/Details.php',
        type: 'post',
        data: {
            'code': code,
        },
        success: function (data) {
            $("#div_page_parametres_etablissements_detail").html(data);
            display_ets_coordonnees(1, code);
            display_ets_professionnels_sante(code);
            display_ets_services(1, code);
        }
    });

}

function display_parametres_utilisateurs_index_page(url, uid)
{
    $("#div_page_parametres_utilisateurs_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Utilisateurs/Index.php',
        type: 'post',
        data: {
            'url': url,
            'uid': uid
        },
        success: function (data) {
            $("#div_page_parametres_utilisateurs_index").html(data);
        }
    });

}

function display_parametres_support_index_page(url)
{
    $("#div_page_parametres_support_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Support/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_support_index").html(data);
        }
    });

}

function display_parametres_reseaux_de_soins_index_page(url, code)
{
    $("#div_page_parametres_reseaux_de_soins_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/Index.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_index").html(data);
        }
    });

}
function display_parametres_reseaux_de_soins_etablissements_page(url, code)
{
    $("#div_page_parametres_reseaux_de_soins_etablissements").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/Etablissements.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_etablissements").html(data);
        }
    });

}
function display_parametres_reseaux_de_soins_medicaments_page(url, code)
{
    $("#div_page_parametres_reseaux_de_soins_medicaments").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/Medicaments.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_medicaments").html(data);
        }
    });

}
function display_parametres_reseaux_de_soins_actes_medicaux_page(url, code)
{
    $("#div_page_parametres_reseaux_de_soins_actes_medicaux").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/ReseauxDeSoins/ActesMedicaux.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_reseaux_de_soins_actes_medicaux").html(data);
        }
    });

}

function display_parametres_securite_index_page(url)
{
    $("#div_page_parametres_securites_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Securite/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_securite_index").html(data);
        }
    });

}
function display_parametres_securite_mdp_page(url)
{
    $("#div_page_parametres_securite_mdp").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Securite/MotDePasse.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_securite_mdp").html(data);
        }
    });

}
function display_parametres_securite_compte_page(url)
{
    $("#div_page_parametres_compte").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Securite/Compte.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_compte").html(data);
        }
    });

}

function display_parametres_referentiels_index_page(url)
{
    $("#div_page_parametres_referentiels_index").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Index.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_referentiels_index").html(data);
        }
    });

}
function display_parametres_referentiels_pathologies_page(url)
{
    $("#div_page_parametres_referentiels_pathologies").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_referentiels_pathologies").html(data);
        }
    });

}
function display_parametres_referentiels_actes_medicaux_page(url)
{
    $("#div_page_parametres_referentiels_actes_medicaux").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_referentiels_actes_medicaux").html(data);
        }
    });

}
function display_parametres_referentiels_medicaments_page(url)
{
    $("#div_page_parametres_referentiels_medicaments").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_referentiels_medicaments").html(data);
        }
    });

}
function display_parametres_referentiels_medicaments_medicament_page(url, code)
{
    $("#div_page_parametres_referentiels_medicaments").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/Medicaments.php',
        type: 'POST',
        data: {
            'url': url,
            'code': code
        },
        success: function (data) {
            $("#div_page_parametres_referentiels_medicaments").html(data);
        }
    });

}
function display_parametres_referentiels_collectivites_page(url)
{
    $("#div_page_parametres_referentiels_collectivites").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Collectivites.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_referentiels_collectivites").html(data);
        }
    });

}

function display_parametres_tables_de_valeurs_page(url)
{
    $("#div_page_parametres_tables_de_valeurs").html(loading_gif(1));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs.php',
        type: 'POST',
        data: {
            'url': url
        },
        success: function (data) {
            $("#div_page_parametres_tables_de_valeurs").html(data);
        }
    });

}

function display_etablissement_search_factures(code_organisme, type_facture, date_debut, date_fin)
{
    $("#btn_enregistrer").prop('disabled', true)
        .removeClass('btn-primary')
        .addClass('btn-warning')
        .html('<i>...</i>');

    $("#multiselect").empty();
    $("#multiselect_to").empty();
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Factures/search_nouveau_bordereau_factures.php',
        type: 'POST',
        data: {
            'code_organisme': code_organisme,
            'type_facture': type_facture,
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        dataType: 'json',
        success: function (json) {
            $("#btn_enregistrer").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-primary')
                .html('<i class="bi bi-save"></i>');

            $.each(json, function (index, value) {
                $("#multiselect").append('<option value="'+ value['value'] +'">'+ value['label'] +'</option>');
            });
        }
    });
}

function display_etablissement_search_borderaux(code_organisme, type_facture, date_debut, date_fin)
{
    $("#btn_search").prop('disabled', true)
        .removeClass('btn-success')
        .addClass('btn-warning')
        .html('<i>...</i>');

    $("#div_resultats").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Factures/search_bordereaux.php',
        type: 'POST',
        data: {
            'code_organisme': code_organisme,
            'type_facture': type_facture,
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            $("#div_resultats").html(data);
        }
    });
}

function display_etablissement_dossiers(num_dossier, num_secu, num_patient, nom_prenoms, date_debut, date_fin)
{
    $("#btn_search").prop('disabled', true)
        .removeClass('btn-primary')
        .addClass('btn-warning')
        .html('<i>...</i>');

    $("#div_resultats").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dossiers/search_dossiers.php',
        type: 'POST',
        data: {
            'num_dossier': num_dossier,
            'num_secu': num_secu,
            'num_patient': num_patient,
            'nom_prenoms': nom_prenoms,
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            $("#div_resultats").html(data);
        }
    });
}

function display_etablissement_factures(num_facture, num_secu, num_patient, nom_prenom, date_debut, date_fin)
{
    $("#btn_search").prop('disabled', true)
        .removeClass('btn-primary')
        .addClass('btn-warning')
        .html('<i>...</i>');

    $("#div_resultats").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Factures/search_factures.php',
        type: 'POST',
        data: {
            'num_facture': num_facture,
            'num_secu': num_secu,
            'num_patient': num_patient,
            'nom_prenom': nom_prenom,
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            $("#div_resultats").html(data);
        }
    });
}

function display_etablissement_commandes(code_commande, code_fournisseur, statut, date_debut, date_fin)
{
    $("#btn_search").prop('disabled', true)
        .removeClass('btn-primary')
        .addClass('btn-warning')
        .html('<i>...</i>');

    $("#div_resultats").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Pharmacie/search_commandes.php',
        type: 'POST',
        data: {
            'code_commande': code_commande,
            'code_fournisseur': code_fournisseur,
            'statut': statut,
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            $("#div_resultats").html(data);
        }
    });
}

function display_etablissement_stock(code_produit, date_debut, date_fin)
{
    $("#btn_search").prop('disabled', true)
        .removeClass('btn-primary')
        .addClass('btn-warning')
        .html('<i>...</i>');

    $("#div_resultats").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Pharmacie/search_stock.php',
        type: 'POST',
        data: {
            'code_produit': code_produit,
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            $("#div_resultats").html(data);
        }
    });
}

function display_etablissement_ecritures_comptables(num_piece, libelle, date_debut, date_fin)
{
    $("#btn_search").prop('disabled', true)
        .removeClass('btn-primary')
        .addClass('btn-warning')
        .html('<i>...</i>');

    $("#div_resultats").html(loading_gif(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Comptabilite/search_ecritures.php',
        type: 'POST',
        data: {
            'num_piece': num_piece,
            'libelle': libelle,
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#btn_search").prop('disabled', false)
                .removeClass('btn-warning')
                .addClass('btn-success')
                .html('<i class="bi bi-search"></i>');
            $("#div_resultats").html(data);
        }
    });
}

function display_tables_de_valeurs(donnee)
{
    if (donnee === 'put') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/ProfilsUtilisateurs.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'assur') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Assurances.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'allerg') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Allergies.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'tac') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesAccidents.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'csp') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/CategoriesSocioProfessionnelles.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'ordre') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/OrdresNationnaux.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'Typ_etab') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesEtablissements.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'etab_service') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/EtablissementsServices.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'civ') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Civilites.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'sex') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Sexes.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'sif') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/SituationsFamiliales.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'sct') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/SecteursActivites.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'prf') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Professions.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'qtc') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/QualitesCivilites.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'tco') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesCoordonnees.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'nsa') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/NiveauxSanitaires.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'tets') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesEtablissements.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'tpi') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesPiecesIdentites.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'dev') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/DevisesMonetaires.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'gsa') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GroupesSanguins.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'rhs') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/Rhesus.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'cps') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/CategoriesProfessionnelsSante.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'lge') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GeoPays.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'reg') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GeoRegions.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'dep') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GeoDepartements.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'com') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/GeoCommunes.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'typ_pers') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesPersonnes.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'sme') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/SpecialitesMedicales.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'stfm') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/StatutsFacturesMedicales.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'tfa') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesFactures.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
    if (donnee === 'typ_reg') {
        $.ajax({
            url: '../_CONFIGS/Includes/Pages/Parametres/TablesDeValeurs/TypesReglements.php',
            success: function (data) {
                $("#div_tables_de_valeurs").html(data);
            }
        });
    }
}

function display_actes_medicaux(donnee)
{
    if (donnee === 'let_cle') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/LettresCles.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if (donnee === 'act_tit') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/Titres.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if (donnee === 'act_cha') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/Chapitres.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if (donnee === 'act_sec') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/Sections.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if (donnee === 'act_art') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/Articles.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }
    if (donnee === 'act_med') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/ActesMedicaux/ActesMedicaux.php',
            success: function (data) {
                $("#div_referentiels_actes_medicaux").html(data);
            }
        });
    }

}

function display_medicaments(donnee)
{
    if (donnee === 'med_lab') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/LaboratoiresPharmaceutiques.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_dci') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/DenominationsCommunesInternationales.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_group') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/Groupes.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_sgroup') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/SousGroupes.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_pre') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/Presentations.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_ffm') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/FamillesFormes.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_frm') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/Formes.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_typ') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/TypesDeMedicaments.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_cth') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/ClassesTherapeutiques.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_scth') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/SousClassesTherapeutiques.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_fra') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/FormesAdministrations.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med_unt') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/UnitesDeDosages.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }
    if (donnee === 'med') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Medicaments/Medicaments.php',
            success: function (data) {
                $("#div_referentiels_medicaments").html(data);
            }
        });
    }

}

function display_pathologies(donnee)
{
    if (donnee === 'pat_chap') {
        $("#div_pathologies").html(loading_gif(2));
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies/Chapitres.php',
            success: function (data) {
                $("#div_referentiels_pathologies").html(data);
            }
        });
    } else if (donnee === 'pat_sch') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies/SousChapitres.php',
            success: function (data) {
                $("#div_referentiels_pathologies").html(data);
            }
        });
    } else if (donnee === 'pat') {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies/Pathologies.php',
            success: function (data) {
                $("#div_referentiels_pathologies").html(data);
            }
        });
    } else {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Parametres/Referentiels/Pathologies.php',
            success: function (data) {
                $("#div_referentiels_pathologies").html(data);
            }
        });
    }
}

function display_types_etablissements()
{
    $("#div_types_etablissements").html(loading_gif(2));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Parametres/Etablissements/TypesEtablissements.php',
        success: function (data) {
            $("#div_types_etablissements").html(data);
        }
    });
}

function display_niveaux_sanitaires()
{
    $("#div_niveaux_sanitaires").html(loading_gif(2));
    $.ajax({
        url: '../_CONFIGS/Includes/Pages/Parametres/Etablissements/NiveauxSanitaires.php',
        success: function (data) {
            $("#div_niveaux_sanitaires").html(data);
        }
    });
}

function display_utilisateur_coordonnees(uid)
{
    if (uid) {
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

function display_utilisateur_infos_personnelles(uid)
{
    if (uid) {
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

function display_patient_infos_personnelles(code_patient)
{
    if (code_patient) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Etablissement/Patients/AfficherPatientInfosPersonnelles.php',
            type: 'POST',
            data: {
                'code_patient': code_patient
            },
            success: function (data) {
                $("#nav-personnel").html(data);
            }
        });
    }
}

function display_utilisateur_infos_sante(uid)
{
    if (uid) {
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

function display_patient_coordonnees(code_patient)
{
    if (code_patient) {
        $.ajax({
            url: '../../_CONFIGS/Includes/Pages/Etablissement/Patients/AfficherpatientCoordonnees.php',
            type: 'POST',
            data: {
                'code_patient': code_patient
            },
            success: function (data) {
                $("#nav-coordonnees").html(data);
            }
        });
    }
}

function display_ets_coordonnees(niveau, code_ets)
{
    let the_url;
    if (niveau === 0) {
        the_url = '_CONFIGS/Includes/Pages/Etablissements/AfficherEtsCoordonnees.php';} else if (niveau === 1) {
        the_url = '../_CONFIGS/Includes/Pages/Etablissements/AfficherEtsCoordonnees.php';} else if (niveau === 2) {
            the_url = '../../_CONFIGS/Includes/Pages/Etablissement/Apropos/AfficherEtsCoordonnees.php';}
        $("#div_ets_donnees").html(loading_gif(niveau));
        $.ajax({
            url: the_url,
            type: 'POST',
            data: {
                'code_ets': code_ets
            },
            success: function (data) {
                $("#div_ets_donnees").html(data);
            }
        });
}
function display_ets_professionnels_sante(path, code_ets)
{
    let niveau;
    if (path === '') {
        niveau = 0;} else if (path === '../') {
        niveau = 1;} else if (path === '../../') {
            niveau = 2;}
        $("#div_ets_donnees").html(loading_gif(niveau));
        $.ajax({
            url: path+'_CONFIGS/Includes/Pages/Etablissements/AfficherEtsProfessionnelsSante.php',
            type: 'POST',
            data: {
                'code_ets': code_ets
            },
            success: function (data) {
                $("#div_ets_donnees").html(data);
            }
        });
}
function display_ets_utilisateurs(niveau, code_ets)
{
    let the_url;
    if (niveau === 0) {
        the_url = '_CONFIGS/Includes/Pages/Etablissements/AfficherEtsUtilisateurs.php';} else if (niveau === 1) {
        the_url = '../_CONFIGS/Includes/Pages/Etablissements/AfficherEtsUtilisateurs.php';} else if (niveau === 2) {
            the_url = '../../_CONFIGS/Includes/Pages/Etablissement/Apropos/AfficherEtsUtilisateurs.php';}
        $("#div_ets_donnees").html(loading_gif(niveau));
        $.ajax({
            url: the_url,
            type: 'POST',
            data: {
                'code_ets': code_ets
            },
            success: function (data) {
                $("#div_ets_donnees").html(data);
            }
        });
}
function display_ets_services(niveau, code_ets)
{
    let the_url;
    if (niveau === 0) {
        the_url = '_CONFIGS/Includes/Pages/Etablissements/AfficherEtsServices.php';} else if (niveau === 1) {
        the_url = '../_CONFIGS/Includes/Pages/Etablissements/AfficherEtsServices.php';} else if (niveau === 2) {
            the_url = '../../_CONFIGS/Includes/Pages/Etablissements/AfficherEtsServices.php';}
        $("#div_ets_donnees").html(loading_gif(niveau));
        $.ajax({
            url: the_url,
            type: 'POST',
            data: {
                'code_ets': code_ets
            },
            success: function (data) {
                $("#div_ets_donnees").html(data);
            }
        });
}




function format_number(num)
{
    let str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
    if (str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for (let j = 0, len = str.length; j < len; j++) {
        if (str[j] !== ",") {
            output.push(str[j]);
            if (i%3 === 0 && j < (len - 1)) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return("$" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
}
