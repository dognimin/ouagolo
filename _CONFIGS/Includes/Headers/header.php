<?php
require_once "_CONFIGS/Classes/UTILISATEURS.php";
require_once "_CONFIGS/Includes/Titles.php";
?>
<!doctype html>
<html lang="fr" dir="ltr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Ouagolo CSS -->
    <link href="<?= CSS.'index.css';?>" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= CSS.'ouagolo.css';?>" rel="stylesheet" crossorigin="anonymous">

    <!-- jQueryUI CSS -->
    <link href="<?= NODE_MODULES.'jqueryui/jquery-ui.css';?>" rel="stylesheet" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <link href="<?= NODE_MODULES.'bootstrap/dist/css/bootstrap.css';?>" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= NODE_MODULES.'bootstrap/dist/css/bootstrap-grid.css';?>" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= NODE_MODULES.'bootstrap/dist/css/bootstrap-utilities.css';?>" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= NODE_MODULES.'bootstrap-icons/font/bootstrap-icons.css';?>" rel="stylesheet" crossorigin="anonymous">
    <link href="<?= NODE_MODULES.'datatables.net-dt/css/jquery.dataTables.css';?>" rel="stylesheet" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="<?= IMAGES.'logos/logo-o.png';?>" />
    <title><?= TITLE;?></title>
</head>
<body>

