<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mot de passe oublié</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/portfolio-item.css" rel="stylesheet">

    <script type="text/javascript" src='../../js/jquery.js'></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

</head>

<body>
<?php

use Sportsante86\Sapa\Outils\UserManager;

require '../../bootstrap/bootstrap.php';
require '../header_index.php';

if (!empty($_POST['identifiant'])) {
    $manager = new UserManager($bdd);
    if ($manager->send_recovery_email($_POST['identifiant'])) {
        $success_message = "L'email de récupération a été envoyé a " . $_POST['identifiant'];
        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'Recovery mail sent to ' . $_POST['identifiant'] . ' successfully',
            ['event' => 'recovery_mail_sent_success:' . $_POST['identifiant']]
        );
    } else {
        $error_message = "Une erreur s'est produite lors de l'envoi du mail de récupération";
    }
}

if (isset($error_message)) {
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'Error when sending recovery link',
        [
            'error_message' => isset($manager) ? $manager->getErrorMessage() : "",
            'error_message2' => $error_message,
            'data' => $_POST
        ]
    );
}
?>

<!-- Page Content -->
<div class="container">
    <fieldset id="connexion">
        <?php
        if (isset($success_message)): ?>
            <fieldset id="info-success">
                <br><br>
                <div class="alert alert-success" role="alert"><?= $success_message; ?><br>
                    Si vous ne voyez pas l'email dans votre boîte mail, regardez dans les spams.
                </div>
            </fieldset>
        <?php
        else: ?>
            <div style="text-align: center">
                <legend id="legendCo">Mot de passe oublié</legend>
            </div>

            <fieldset id="info">
                <div class="alert alert-info" role="alert"><b>Vous avez oublié le mot de passe de votre compte?</b><br>
                    Entrez votre adresse mail et nous allons vous envoyer un lien sur lequel il faudra cliquer dans les
                    60 minutes pour renouveler votre mot de passe
                </div>
            </fieldset>

            <form id="form" class="form-horizontal" method="post">
                <div class="form-group">
                    <label for="identifiant" class="col-sm-2 control-label">Adresse mail</label>
                    <div class="col-sm-10">
                        <input type="email" name="identifiant" id="identifiant" autofocus placeholder="Adresse mail"
                               class="form-control" size="30" required/>
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
</body>

</html>