$("#code_pays_naissance_input").change(function () {
    let code_pays     = $(this).val().trim();
    if(code_pays) {
        $("#button_enregistrer").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Recherche...</i>');

        $("#code_region_naissance_input").prop('disabled',false)
            .empty();
        $.ajax({
            url: '../../_CONFIGS/Includes/Searches/search_localisation.php',
            type: 'post',
            data: {
                'code_pays': code_pays
            },
            dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                $("#code_region_naissance_input").prop('disabled',false)
                    .append('<option value="">Sélectionnez</option>');


                $.each(json, function(index, value) {
                    $("#code_region_naissance_input").append('<option value="'+ index +'">'+ value +'</option>');
                });
            }
        });
        $("#code_pays_naissance_input").removeClass('is-invalid')
            .addClass('is-valid');
        $("#paysHelp")
            .removeClass('text-danger')
            .html("");
    }else {
        $("#code_pays_naissance_input").removeClass('is-valid')
            .addClass('is-invalid');
        $("#paysHelp")
            .addClass('text-danger')
            .html("Veuillez sélectionner un pays SVP.");
    }
});
$("#code_pays_residence_input").change(function () {
    let code_pays     = $(this).val().trim();
    if(code_pays) {
        $("#button_enregistrer").prop('disabled', true)
            .removeClass('btn-primary')
            .addClass('btn-warning')
            .html('<i>Recherche...</i>');

        $("#code_region_residence_input").prop('disabled',false)
            .empty();
        $.ajax({
            url: '../../_CONFIGS/Includes/Searches/search_localisation.php',
            type: 'post',
            data: {
                'code_pays': code_pays
            },
            dataType: 'json',
            success: function(json) {
                $("#button_enregistrer").prop('disabled', false)
                    .removeClass('btn-warning')
                    .addClass('btn-primary')
                    .html('<i class="bi bi-save"></i> Enregistrer');
                $("#code_region_residence_input").prop('disabled',false)
                    .append('<option value="">Sélectionnez</option>');


                $.each(json, function(index, value) {
                    $("#code_region_residence_input").append('<option value="'+ index +'">'+ value +'</option>');
                });
            }
        });
        $("#code_pays_residence_input").removeClass('is-invalid')
            .addClass('is-valid');
        $("#paysHelp")
            .removeClass('text-danger')
            .html("");
    }else {
        $("#code_pays_residence_input").removeClass('is-valid')
            .addClass('is-invalid');
        $("#paysHelp")
            .addClass('text-danger')
            .html("Veuillez sélectionner un pays SVP.");
    }
});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});