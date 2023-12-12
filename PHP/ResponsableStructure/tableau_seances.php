<?php

$query = "
    SELECT YEARWEEK(NOW(), 1)                  as current_week_number,
           YEARWEEK(NOW() - interval 7 day, 1) as previous_week_number,
           YEARWEEK(NOW() + interval 7 day, 1) as next_week_number,
           DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(NOW(), 1), ' Monday'), '%x%v %W'),
                       '%d/%m/%Y')             as current_week_date_start,
           DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(NOW() - interval 7 day, 1), ' Monday'), '%x%v %W'),
                       '%d/%m/%Y')             as previous_week_date_start,
           DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(NOW() + interval 7 day, 1), ' Monday'), '%x%v %W'),
                       '%d/%m/%Y')             as next_week_date_start,
           DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(NOW(), 1), ' Sunday'), '%x%v %W'),
                       '%d/%m/%Y')             as current_week_date_end,
           DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(NOW() - interval 7 day, 1), ' Sunday'), '%x%v %W'),
                       '%d/%m/%Y')             as previous_week_date_end,
           DATE_FORMAT(STR_TO_DATE(CONCAT(YEARWEEK(NOW() + interval 7 day, 1), ' Sunday'), '%x%v %W'),
                       '%d/%m/%Y')             as next_week_date_end";
$stmt = $bdd->prepare($query);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$current_week_number = $data['current_week_number'];
$previous_week_number = $data['previous_week_number'];
$next_week_number = $data['next_week_number'];

$current_week_date_start = $data['current_week_date_start'];
$previous_week_date_start = $data['previous_week_date_start'];
$next_week_date_start = $data['next_week_date_start'];

$current_week_date_end = $data['current_week_date_end'];
$previous_week_date_end = $data['previous_week_date_end'];
$next_week_date_end = $data['next_week_date_end'];
?>

<div style="text-align: center; padding-top: 5px">
    <label>
        <select id="filter-week">
            <option value="<?= $current_week_number; ?>" data-week_date_start="<?= $current_week_date_start; ?>"
                    data-week_date_end="<?= $current_week_date_end; ?>" selected>Semaine actuelle
            </option>
            <option value="<?= $next_week_number; ?>" data-week_date_start="<?= $next_week_date_start; ?>"
                    data-week_date_end="<?= $next_week_date_end; ?>">Semaine suivante
            </option>
            <option value="<?= $previous_week_number; ?>" data-week_date_start="<?= $previous_week_date_start; ?>"
                    data-week_date_end="<?= $previous_week_date_end; ?>">Semaine précédente
            </option>
        </select>
    </label>

    <div>
        <p>Semaine du <span id="week_date_start"><?= $current_week_date_start; ?></span> au <span
                    id="week_date_end"><?= $current_week_date_end; ?></span></p>
    </div>
</div>

<div class="body" style="width: 100%;border : 3px #fdfefe solid;">
    <table id="table2_id" class="stripe hover row-border compact" style="width:100%">
        <thead>
        <tr>
            <th>Antenne</th>
            <th>N° téléphone</th>
            <th>Date</th>
            <th>Heure de début</th>
            <th>Liste des bénéficiaires</th>
            <th>Intervenant</th>
            <th>Type de structure</th>
            <th>Lieu</th>
        </tr>
        </thead>
        <tbody id="table2_id-body">
        </tbody>
    </table>
</div>