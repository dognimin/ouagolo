jQuery(function () {

    $("#table_de_valeur_input").change(function () {
        let table_de_valeur = $("#table_de_valeur_input").val().trim();
        if(table_de_valeur) {
            display_tables_de_valeurs(table_de_valeur);
        }
    });

    $(".button_table_de_valeur").click(function () {
        let table_de_valeur = this.id;
        display_tables_de_valeurs(table_de_valeur);
    });
});