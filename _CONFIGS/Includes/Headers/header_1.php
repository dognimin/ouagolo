<?php
use App\GLOBALS;

require_once "../vendor/autoload.php";
$GLOBALS = new GLOBALS();
$Metas = $GLOBALS->metas();
$Headers = $GLOBALS->headers(1);
$Links = $GLOBALS->links();

require_once $Headers['title'];
?>
<!doctype html>
<html lang="fr" dir="ltr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= $Metas['DESCRIPTION'];?>">
    <meta name="author" content="<?= $Metas['AUTHORS'];?>">

    <meta name="docsearch:language" content="<?= $Metas['LANGUAGE'];?>">
    <meta name="docsearch:version" content="<?= $Metas['VERSION'];?>">

    <title><?= TITLE;?></title>

    <link rel="canonical" href="<?= $Links['URL'];?>">

    <!-- Ouagolo CSS -->
    <link rel="stylesheet" href="<?= $Links['CSS'].'index.css';?>">
    <link rel="stylesheet" href="<?= $Links['CSS'].'ouagolo.css';?>">
    <link rel="stylesheet" href="<?= $Links['CSS'].'loader.css';?>">

    <!-- jQueryUI CSS -->
    <link rel="stylesheet" href="<?= $Links['NODE_MODULES'].'jquery-ui-dist/jquery-ui.css';?>">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $Links['NODE_MODULES'].'bootstrap/dist/css/bootstrap.css';?>">
    <link rel="stylesheet" href="<?= $Links['NODE_MODULES'].'bootstrap/dist/css/bootstrap-grid.css';?>">
    <link rel="stylesheet" href="<?= $Links['NODE_MODULES'].'bootstrap/dist/css/bootstrap-utilities.css';?>">

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="<?= $Links['NODE_MODULES'].'bootstrap-icons/font/bootstrap-icons.css';?>">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="<?= $Links['NODE_MODULES'].'datatables.net-dt/css/jquery.dataTables.css';?>">

    <!-- DateTimePicker CSS -->
    <link rel="stylesheet" href="<?= $Links['NODE_MODULES'].'jquery-datetimepicker/build/jquery.datetimepicker.min.css';?>">

    <link rel="icon" type="image/png" href="<?= $Links['IMAGES'].'logos/logo-o.png';?>" />
</head>
<body>