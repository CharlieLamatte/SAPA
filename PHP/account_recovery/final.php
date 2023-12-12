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

if (!empty($_POST['mdp'] && !empty($_POST['confirm-mdp']) && !empty($_POST['token']))) {
    if (hash_equals($_POST['mdp'], $_POST['confirm-mdp'])) {
        $manager = new UserManager($bdd);
        $result = $manager->update_password($_POST['token'], $_POST['mdp']);
        if ($result['ok']) {
            $success_message = "Le mot de passe a été mis à jour avec succès";
            \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
                'Password of user ' . $result['email'] . ' updated successfully',
                ['event' => 'recovery_mail_sent_success:' . $result['email']]
            );
        } else {
            $error_message = "Une erreur s'est produite lors du changement de mot de passe";
        }
    } else {
        $error_message = "Le mot de passe de confirmation et le mot de passe sont différents";
    }
} else {
    $error_message = "Il manque un paramètre";
}

if (isset($error_message)) {
    \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
        'User failed the final step to recover password',
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
                </div>
            </fieldset>
        <?php
        elseif (isset($error_message)): ?>
            <fieldset id="info-error">
                <br><br>
                <div class="alert alert-danger" role="alert"><?= $error_message; ?><br>
                </div>
            </fieldset>
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