<?php
$formats = array(
    array(
        'code' => "csv",
        'libelle' => "CSV"
    ),
    array(
        'code' => "xls",
        'libelle' => "EXCEL"
    ),
    array(
        'code' => "pdf",
        'libelle' => "PDF"
    ),
    array(
        'code' => "txt",
        'libelle' => "TEXTE"
    )
);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="row justify-content-md-center">
            <div class="col-sm-4">
                <label for="export_input" class="form-label"></label>
                <select class="form-select form-select-sm" id="export_input" aria-label=".form-select-sm" aria-describedby="exportHelp">
                    <option value="">Exporter</option>
                    <?php
                    foreach ($formats as $format) {
                        echo '<option value="'.$format['code'].'">'.$format['libelle'].'</option>';
                    }
                    ?>
                </select>
                <i id="codePaysHelp" class="form-text"></i>
            </div>
        </div>
    </div>
</div><br />