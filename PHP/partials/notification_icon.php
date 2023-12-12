<?php

$n = new \Sportsante86\Sapa\Model\Notification($bdd);
$count = $n->readNewCount($_SESSION['id_user']) ?? 0;
?>

<li>
    <a href="#" class="notification" id="notification" data-id_user="<?= $_SESSION['id_user']; ?>">
        <span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
        <span id="notification-badge"
              class="badge" <?= $count == 0 ? 'style="display: none;"' : 'style="display: inline;"'; ?>><?= $count; ?></span>
    </a>
</li>