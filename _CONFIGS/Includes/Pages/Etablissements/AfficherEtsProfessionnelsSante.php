<?php
if(isset($_POST['code_ets'])) {
    $code_ets = $_POST['code_ets'];
    require_once "../../../Classes/UTILISATEURS.php";
    require_once "../../../Classes/ETABLISSEMENTS.php";
    $ETABLISSEMENTS = new ETABLISSEMENTS();
    $ets = $ETABLISSEMENTS->trouver($code_ets,null);
    if($ets) {

    }
}
?>
<script>
    $(".btn_add_ets_ps").click(function () {
        $("#div_ets_ps").hide();
        $("#div_ets_ps_form").slideDown();
        $(".card-title").html('Nouveau PS');
        return false;
    });
    $("#button_ets_ps_retourner").click(function () {
        $("#div_ets_ps_form").hide();
        $("#div_ets_ps").slideDown();
        return false;
    });
</script>
