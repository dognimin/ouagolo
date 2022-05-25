jQuery(function () {
    $(".button_jour_calendrier").click(function () {
        $("#calendrierJourDetailsModalLabel").html('');
        $("#div_details_calendrier").html('');
        let date = this.id;
        if (date) {
            $.ajax({
                url: '../../_CONFIGS/Includes/Searches/search_traduction_date.php',
                type: 'POST',
                data: {
                    'date': date
                },
                dataType: 'json',
                success: function (data) {
                    if (data['success'] === true) {
                        $("#calendrierJourDetailsModalLabel").html(data['date']);
                        $("#div_details_calendrier").html(loading_gif(2));
                        $.ajax({
                            url: '../../_CONFIGS/Includes/Searches/Etablissement/RendezVous/search_rendez_vous.php',
                            type: 'POST',
                            data: {
                                'date': date
                            },
                            success: function (data_calendar) {
                                $("#div_details_calendrier").html(data_calendar);
                            }
                        });
                    }
                }
            });
        }
    });
});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});