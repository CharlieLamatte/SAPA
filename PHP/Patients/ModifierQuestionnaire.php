<?php

use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);
if (!$permissions->hasPermission('can_view_page_patient_evaluation')) {
    erreur_permission();
}

//Récupérer id du bénéficiaire
$idPatient = $_GET['idPatient'];
$id_questionnaire_instance = $_GET['id_questionnaire_instance'];
$id_questionnaire = $_GET['id_questionnaire'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Modifier Questionnaire</title>

    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/synthese.css">
    <link rel="stylesheet" href="../../css/evaluation.css">
    <link href="../../css/objectifs.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>
<?php
require '../header.php'; ?>
<div class="container">
    <!-- The toast -->
    <div id="toast"></div>

    <form id="questionnaire"
          data-id_questionnaire="<?php
          echo $id_questionnaire; ?>"
          data-id_questionnaire_instance="<?php
          echo $id_questionnaire_instance; ?>"
          data-id_user="<?php
          echo $_SESSION['id_user']; ?>"
          data-id_patient="<?php
          echo $idPatient; ?>"></form>
</div>

<script type="text/javascript" src="../../js/fixHeader.js"></script>
<script type="text/javascript" src="../../js/questionnaire_common.js"></script>
<script type="text/javascript" src="../../js/modifierQuestionnaire.js"></script>
</body>
</html>