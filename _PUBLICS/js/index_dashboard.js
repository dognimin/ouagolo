function etablissement_nombre_patients(date_debut, date_fin) {
    $("#strong_nombre_patients").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/html/search_nombre_patients.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#strong_nombre_patients").html(data);
        }
    });
}
function etablissement_nombre_medecins(date_debut, date_fin) {
    $("#strong_nombre_medecins").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/html/search_nombre_medecins.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#strong_nombre_medecins").html(data);
        }
    });
}
function etablissement_nombre_utilisateurs(date_debut, date_fin) {
    $("#strong_nombre_utilisateurs").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/html/search_nombre_utilisateurs.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#strong_nombre_utilisateurs").html(data);
        }
    });
}
function etablissement_nombre_dossiers(date_debut, date_fin) {
    $("#strong_nombre_dossiers").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/html/search_nombre_dossiers.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#strong_nombre_dossiers").html(data);
        }
    });
}
function etablissement_nombre_factures(date_debut, date_fin) {
    $("#strong_nombre_factures").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/html/search_nombre_factures.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        success: function (data) {
            $("#strong_nombre_factures").html(data);
        }
    });
}
function etablissement_nombre_patients_par_sexe(date_debut, date_fin) {
    $("#canvas_nombre_patients_par_sexe").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/json/search_nombre_patients_par_sexe.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        dataType: 'json',
        success: function (data) {
            let libelle = [],
                effectif = [],
                couleur = [];
            for (let count = 0; count < data.length; count++) {
                libelle.push(data[count]['libelle']);
                effectif.push(data[count]['effectif']);
                couleur.push(data[count]['couleur']);
            }
            let chart_datas = {
                labels: libelle,
                datasets: [
                    {
                        backgroundColor: couleur,
                        color: '#fff',
                        data: effectif
                    }
                ]
            };
            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: "Patients par sexe"
                    }
                }
            };
            const group_chart = $("#canvas_nombre_patients_par_sexe");
            const graph = new Chart(group_chart, {
                type: "pie",
                data: chart_datas,
                options: options
            });




        }
    });
}
function etablissement_nombre_factures_par_type(date_debut, date_fin) {
    $("#canvas_nombre_factures_par_type").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/json/search_nombre_factures_par_type.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        dataType: 'json',
        success: function (data) {
            let libelle = [],
                effectif = [],
                couleur = [];
            for (let count = 0; count < data.length; count++) {
                libelle.push(data[count]['libelle']);
                effectif.push(data[count]['effectif']);
                couleur.push(data[count]['couleur']);
            }
            let chart_datas = {
                labels: libelle,
                datasets: [
                    {
                        backgroundColor: couleur,
                        color: '#fff',
                        data: effectif
                    }
                ]
            };
            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: "Factures par type"
                    }
                }
            };
            const group_chart = $("#canvas_nombre_factures_par_type");
            const graph = new Chart(group_chart, {
                type: "doughnut",
                data: chart_datas,
                options: options
            });




        }
    });
}
function etablissement_nombre_patients_par_organisme(date_debut, date_fin) {
    $("#canvas_nombre_patients_par_organisme").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/json/search_nombre_patients_par_organisme.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        dataType: 'json',
        success: function (data) {
            let libelle = [],
                effectif = [],
                couleur = [];
            for (let count = 0; count < data.length; count++) {
                libelle.push(data[count]['libelle']);
                effectif.push(data[count]['effectif']);
                couleur.push(data[count]['couleur']);
            }
            let chart_datas = {
                labels: libelle,
                datasets: [
                    {
                        label: "Patients par organisme",
                        backgroundColor: couleur,
                        color: '#fff',
                        data: effectif
                    }
                ]
            };
            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            };
            const group_chart = $("#canvas_nombre_patients_par_organisme");
            const graph = new Chart(group_chart, {
                type: "bar",
                data: chart_datas,
                options: options
            });




        }
    });
}
function etablissement_nombre_patients_par_jour(date_debut, date_fin) {
    $("#canvas_nombre_patients_par_jour").html(loading_gif_circle(2));
    $.ajax({
        url: '../../_CONFIGS/Includes/Searches/Etablissement/Dashboard/json/search_nombre_patients_par_jour.php',
        type: 'POST',
        data: {
            'date_debut': date_debut,
            'date_fin': date_fin
        },
        dataType: 'json',
        success: function (data) {
            let date = [],
                effectif_patients = [],
                effectif_factures = [],
                couleur = [];
            for (let count = 0; count < data.length; count++) {
                date.push(data[count]['date']);
                effectif_patients.push(data[count]['effectif_patients']);
                effectif_factures.push(data[count]['effectif_factures']);
                couleur.push(data[count]['couleur']);
            }
            let chart_datas = {
                labels: date,
                datasets: [
                    {
                        label: "Fréquentation",
                        backgroundColor: couleur,
                        color: '#fff',
                        data: effectif_patients
                    },
                    {
                        label: "Factures",
                        backgroundColor: couleur,
                        color: '#fff',
                        data: effectif_factures
                    }
                ]
            };
            let options = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                scales: {
                    x: {
                        display: true,
                    },
                    y: {
                        display: true,
                        min: 0
                    }
                }
            };
            const group_chart = $("#canvas_nombre_patients_par_jour");
            const graph = new Chart(group_chart, {
                type: "line",
                data: chart_datas,
                options: options
            });




        }
    });
}