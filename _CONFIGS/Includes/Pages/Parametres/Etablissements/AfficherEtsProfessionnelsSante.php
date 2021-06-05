<?php
if(isset($_POST['code_ets'])) {
    $code_ets = $_POST['code_ets'];
    require_once "../../../../Classes/UTILISATEURS.php";
    require_once "../../../../Classes/ETABLISSEMENTS.php";
    $ETABLISSEMENTS = new ETABLISSEMENTS();
    $ets = $ETABLISSEMENTS->trouver_etablissement($code_ets);
    if($ets) {
        ?>
        <br/>
        <div id="div_ets_ps">
            <p class="align_right">
                <button type="button" class="btn btn-primary btn-sm btn_add_ets_ps"><i class="bi bi-plus-square-fill"></i></button>
            </p>
            <br/>
        </div>
        <div id="div_ets_ps_form">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body row">
                            <h5 class="card-title"></h5>
                            <div class="row justify-content-md-center">
                                <?php include "../../_Forms/form_etablissement_ps.php";?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
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
