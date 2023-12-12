<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Réinitialisation du mot de passe</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">
    <link href="../../css/modal-details.css" rel="stylesheet">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>
<?php

use Sportsante86\Sapa\Outils\UserManager;

require '../../bootstrap/bootstrap.php';
require '../header_index.php';

$token = $_GET['t'];

if (!empty($token)) {
    $manager = new UserManager($bdd);
    if (!$manager->is_token_valid($token)) {
        $error_message = "Le lien de récupération a expiré";
    }
} else {
    $error_message = "Le lien de récupération est invalide";
}

if (isset($error_message)) {
    \Sportsante86\Sapa\Outils\SapaLogger::get()->warning(
        'Error when accessing a recovery link',
        [
            'error_message' => isset($manager) ? $manager->getErrorMessage() : "",
            'error_message2' => $error_message,
            'data' => $_GET
        ]
    );
}
?>

<!-- Page Content -->
<div class="container">
    <fieldset id="connexion">
        <?php
        if (isset($error_message)): ?>
            <fieldset id="info-error">
                <br><br>
                <div class="alert alert-warning" role="alert"><?= $error_message; ?></div>
            </fieldset>
        <?php
        else: ?>
            <div style="text-align: center">
                <legend id="legendCo">Réinitialisation du mot de passe</legend>
            </div>

            <fieldset id="info">
                <div class="alert alert-info" role="alert">Entrez votre nouveau mot de passe
                </div>
            </fieldset>

            <form id="form" class="form-horizontal" method="post" action="final.php">
                <input id="token" type="hidden" name="token" value="<?= $token; ?>">
                <div id="mdp-row" style="text-align: left">
                    <div class="row">
                        <div class="col-md-2" style="text-align: left">
                            <label class="control-label" for="mdp" id="mdp-label">Mot de passe<span
                                        style="color: red">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input id="mdp" name="mdp" value="" class="form-control" type="password"
                                       minlength="8"
                                       pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                       required>
                                <span class="input-group-addon clickable" id="mdp-show"><span
                                            class="glyphicon glyphicon-eye-open"></span></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="confirm-mdp-row">
                        <div class="col-md-2">
                            <label class="control-label" for="confirm-mdp" id="confirm-mdp-label">Confirmer<span
                                        style="color: red">*</span></label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input id="confirm-mdp" name="confirm-mdp" value="" class="form-control"
                                       type="password"
                                       minlength="8"
                                       pattern="(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                                       required>
                                <span class="input-group-addon clickable" id="confirm-mdp-show"><span
                                            class="glyphicon glyphicon-eye-open"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="mdp-row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <p class="help-block">8 caractères minimum, un chiffre, majuscule, minuscule et
                                caractère spécial</p>
                        </div>
                    </div>
                    <div class="row" id="message">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <p id="2-passwords" class="valid">Les 2 mots de passes sont identiques et respectent les contraintes</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button id="enregistrer" type="submit" class="btn btn-default">Enregistrer</button>
                    </div>
                </div>
            </form>

            <?php
            if (isset($error_message)): ?>
                <p id="connexion-error-message" style="color: red" class="text-center">
                    <?= $error_message; ?>
                </p>
            <?php
            endif; ?>
        <?php
        endif; ?>

        <br><br>
        <div class="text-center">
            <a href="../../index.php">Retour page de connexion</a>
        </div>
    </fieldset>

    <?php
    require '../footer.php'; ?>
</div>
<!-- /content -->

<!-- jQuery -->
<script src="../../js/jquery.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/fixHeader.js"></script>
<script src="../../js/recover_account.js"></script>
</body>

</html>