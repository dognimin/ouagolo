jQuery(function () {
    $(".allow_numeric").keyup(function(evt) {
        let self = $(this);
        self.val(format_number(self.val()).replace(/\D/g, ""));
        if ((evt.which < 48 || evt.which > 57)) {evt.preventDefault();}

    });


});
$("#table_assures").dataTable();
$(".datepicker").datepicker({
    maxDate: -1
});
$('.modal').modal({
    show: false,
    backdrop: 'static'
});