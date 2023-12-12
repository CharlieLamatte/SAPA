<?php

use Sportsante86\Sapa\Outils\Permissions;

?>

<!-- Navigation -->
<!-- Ce header permet d'obtenir le chapeau en haut de la page web, spécifique à l'accueil. -->
<nav id="main-navbar" class="navbar navbar-inverse navbar-fixed-top" style="width:auto; background-color: #191970;">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div class="navbar-left" href="#">
            <!-- Après avoir inclus les classes nav, on importe le lo   go de l'application -->
            <img src="/../images/logo-sapa-2.png" style="max-height: 100px; margin-right: 1px" alt="logoSapa"/><img
                src="/../images/logo_na_horiz_QUADRI_2019.jpg" style="max-height: 100px; margin-right: 1px"
                alt="logoSapa"/><?php
            if ($_SESSION['est_en_nouvelle_aquitaine']): ?><img
                src="/../images/LogoPEPS.jpg" style="max-height: 100px; margin-right: 1px" alt="logoPeps"/>
            <?php
            endif; ?><?php
            if (!empty($_SESSION['logo_fichier'])): ?><img
                src="/../Outils/DownloadLogo.php?filename=<?= $_SESSION['logo_fichier']; ?>" style="max-height: 100px"
                alt="logo-structure"/>
            <?php
            endif; ?>
        </div>

        <p class="navbar-text" style="font-variant: small-caps;font-size: 18px; color: white">
            <i><b>Bonjour <?= $_SESSION['prenom_connecte']; ?> <?= $_SESSION['nom_connecte']; ?> <?= $_SESSION['id_type_territoire'] == \Sportsante86\Sapa\Model\Territoire::TYPE_TERRITOIRE_DEPARTEMENT ? "du département" : "de la région" ?> <?= $_SESSION['nom_territoire']; ?></b></i>
            <br>
            <i><b>Role : <?= $_SESSION['role_user']; ?></b></i>
        </p>

        <!-- Inclusion des divers icones ainsi que leur liens : paramètres, accueil et déconnexion -->
        <ul class="nav navbar-nav navbar-right" style="margin-right: 5px">
            <li>
                <a id="version-info" tabindex="0" role="button" data-toggle="popover" title="À propos de SAPA"
                   data-content="
                   Version: <?= $_ENV['VERSION']; ?> <br>
                   Date: <?= $_ENV['DATE']; ?> <br>
                   Développé avec le soutien de la région Nouvelle-Aquitaine">
                    <span class="glyphicon glyphicon-info-sign text-center"></span></a>
            </li>
            <?php
            require 'partials/notification_icon.php'; ?>
            <li>
                <a href="/../PHP/Settings/Settings.php" id="administration-link">
                    <span class="glyphicon glyphicon-cog text-center"></span>
                </a>
            </li>

            <?php
            if ($permissions->hasPermission('can_view_page_patient') &&
                !$permissions->hasRole(Permissions::RESPONSABLE_STRUCTURE)):
                ?>
                <li>
                    <a href="/../PHP/Accueil_liste.php" id="accueil-link">
                        <span class="glyphicon glyphicon-home text-center"></span>
                    </a>
                </li>
            <?php
            endif; ?>
            <?php
            if ($permissions->hasRole(Permissions::RESPONSABLE_STRUCTURE)):
                ?>
                <li>
                    <a href="/../PHP/ResponsableStructure/Accueil.php" id="accueil-link">
                        <span class="glyphicon glyphicon-home text-center"></span>
                    </a>
                </li>
            <?php
            endif; ?>
            <?php
            if ($permissions->hasRole(Permissions::SUPER_ADMIN)):
                ?>
                <li>
                    <a href="/../PHP/Settings/TableauDeBord.php" id="accueil-link">
                        <span class="glyphicon glyphicon-home text-center"></span>
                    </a>
                </li>
            <?php
            endif; ?>
            <li>
                <a href="/../PHP/deconnexion.php" id="deconnexion-link"
                   onclick="return confirm('Etes-vous sûr de vouloir vous déconnecter ?');">
                    <span class="glyphicon glyphicon-off text-center"></span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div id="notification-menu" class="sidenava" data-id_user="<?= $_SESSION['id_user']; ?>">
    <a href="javascript:void(0)" class="closebtn" id="close-notification">&times;</a>
    <?php
    if ($_ENV['ENVIRONNEMENT'] === 'TEST'): ?>
        <a href="javascript:void(0)" class="deletebtn" id="delete-notifications">Vider</a>
    <?php
    endif; ?>
</div>

<script type="text/javascript" src="/js/notification.js"></script>
<script type="text/javascript" src="/js/version.js"></script>