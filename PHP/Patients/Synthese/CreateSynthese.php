<?php

use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Model\Synthese;
use Sportsante86\Sapa\Outils\EncryptionManager;

use function Sportsante86\Sapa\Outils\format_date;

require '../../../bootstrap/bootstrap.php';
require '../../../fpdf/custom_pdf.php';
require '../../../Outils/JsonFileProtection.php';

force_connected();

//récupération des données du json
$data = json_decode(file_get_contents("php://input"));
$nom_patient = $data->nom_patient;
$prenom_patient = $data->prenom_patient;
$nom_prenom = $nom_patient . ' ' . $prenom_patient;

$data_eval = [];
add_if_not_empty($data_eval, "nom", trim($data->prenom_evaluateur . " " . $data->nom_evaluateur));
add_if_not_empty($data_eval, "fonction", trim($data->fonction_evaluateur));
add_if_not_empty($data_eval, "email", trim($data->mail_evaluateur));
add_if_not_empty($data_eval, "telephone", trim($data->telephone_evaluateur));

$data_coordo = [];
add_if_not_empty($data_coordo, "nom", trim($data->prenom_coordinateur . " " . $data->nom_coordinateur));
add_if_not_empty($data_coordo, "fonction", trim($data->fonction_coordinateur));
add_if_not_empty($data_coordo, "email", trim($data->mail_coordinateur));
add_if_not_empty($data_coordo, "telephone", trim($data->telephone_coordinateur));

$data_autres_personnes = [];
if (is_array($data->autres_personnes)) {
    foreach ($data->autres_personnes as $autre_personne) {
        $personne = [];
        add_if_not_empty($personne, "nom", trim($autre_personne->prenom . " " . $autre_personne->nom));
        add_if_not_empty($personne, "fonction", trim($autre_personne->fonction));
        add_if_not_empty($personne, "email", trim($autre_personne->mail));
        add_if_not_empty($personne, "telephone", trim($autre_personne->telephone));

        if (!empty($personne)) {
            $data_autres_personnes[] = $personne;
        }
    }
}

$objectifs = $data->objectifs;
$objectif_text = $data->objectif_text;
$activites = $data->activites;
$activites_text = $data->activites_text;
$infos_evaluateur = $data->nom_evaluateur . ', ' . $data->fonction_evaluateur;
$infos_coordonnateur = $data->nom_coordinateur . ', ' . $data->fonction_coordinateur;
$infos_constantes = $data->donnee_anthropometrique;
$infos_6_min = $data->test_6_min;
$infos_equilibre = $data->test_equilibre;
$infos_mobilite = $data->test_mobilite;
$infos_souplesse = $data->test_souplesse;
$infos_force = $data->test_force;
$infos_assis_debout = $data->test_assis_debout;
$logo_fichier = $data->logo_fichier;
$affichage_page = $data->affichage_page;
$affichage_paaco_globule = $data->affichage_paaco_globule;
$affichage_coordonnees_evaluateur = $data->affichage_coordonnees_evaluateur;
$affichage_coordonnees_coordonnateur = $data->affichage_coordonnees_coordonnateur;
$affichage_saut_page_conclusion = $data->affichage_saut_page_conclusion;

$titre_civilite = $data->sexe_patient == 'F' ? 'Mme' : 'M';
$ne = $data->sexe_patient == 'F' ? 'née' : 'né';

$save = $data->save;

$space_between_sections = 4; // space between sections

$normal_txt_size = 10; // taille du texte
$title_txt_size = 12; // taille du texte des titres
$footer_txt_size = 9; // taille du texte des footers

$image_width = 25; // largeur des images
$image_height = 25; // hauteur des images

/**
 * Adds a value to the array if it is not empty
 *
 * @param $a array
 * @param $key string
 * @param $value string the value to add
 * @return void
 */
function add_if_not_empty(&$a, $key, $value)
{
    if (!empty($value)) {
        $a[$key] = $value;
    }
}

/**
 * @param $a array le tableau
 * @return bool si la ligne du tableau est vide
 */
function is_row_empty($a)
{
    for ($i = 1; $i < 4; $i++) {
        if ($a[$i] != null && $a[$i] !== '') {
            return false;
        }
    }

    return true;
}

/**
 * @param $a array le tableau
 * @return bool si la ligne du tableau à au moins une valeur
 */
function is_row_not_empty($a)
{
    return !is_row_empty($a);
}

//Création du pdf
$pdf = new PDF('P', 'mm', 'A4');
//ajout d'une nouvelle page
$pdf->AddPage();
//Polices du texte
$pdf->SetFont('Helvetica', '', $normal_txt_size);
//Couleur du texte
$pdf->SetTextColor(1, 38, 120);
//Compteur nombre de pages
$pdf->AliasNbPages();
if ($affichage_page) {
    $pdf->SetIsFooterDisplayed(true);
}

////////////////////////////////////////////////////
// Logos
////////////////////////////////////////////////////
// affichage du logo pour les MSS
if ($_SESSION['id_statut_structure'] == '1') {
    $pdf->Image("../../../images/logo-mss-centre.png", 175 - ($image_width + 1), 5, $image_width);

    // affichage du logo propre à la structure
    $logo_mss_path = "../../../uploads/logo_mss/" . $logo_fichier;
    if (!empty($logo_fichier) && file_exists($logo_mss_path)) {
        $pdf->Image($logo_mss_path, 175 - (2 * ($image_width + 1)), 5, $image_width);
    }
}

$pdf->Image("../../../images/logo_peps_mobile.png", 175, 5, $image_width);
$pdf->Ln($space_between_sections);

$pdf->Write('5', utf8_decode("Fait le " . format_date($data->date_synthese)));
$pdf->Ln();
$pdf->Ln(10); //saut de 10

////////////////////////////////////////////////////
// Titre
////////////////////////////////////////////////////

$pdf->SetFont('Helvetica', '', $normal_txt_size);
if ($data->version_synthese == 'beneficiaire') {
    $phrase_titre = $titre_civilite . " " . $nom_prenom;
} else {
    $phrase_titre = "Synthèse de " . $titre_civilite . " " . $nom_prenom;
}
$pdf->Cell(190, 15, utf8_decode($phrase_titre), 0, 1, "C", 0);

if ($data->introduction != null && $data->introduction != '') {
    $pdf->SetFont('Helvetica', '', $normal_txt_size);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->MultiCell(190, 5, utf8_decode($data->introduction), 0, 'J', 0);
    $pdf->Ln($space_between_sections);
}

////////////////////////////////////////////////////
// Infos sur l'évaluation
////////////////////////////////////////////////////

$pdf->SetTextColor(1, 38, 120);
$pdf->SetFont('Helvetica', 'B', $normal_txt_size);
$pdf->Write('5', utf8_decode("Date du bilan : "));

$pdf->SetFont('Helvetica', '', $normal_txt_size);
$pdf->Write('5', utf8_decode(format_date($data->date_bilan)));

if ($data->date_bilan_precedent != null &&
    $data->date_bilan_precedent != '' &&
    $data->nom_bilan_precedent != null &&
    $data->nom_bilan_precedent != '') {
    $pdf->SetFont('Helvetica', 'B', $normal_txt_size);
    $pdf->Write('5', utf8_decode(" " . $data->nom_bilan_precedent . " : "));

    $pdf->SetFont('Helvetica', '', $normal_txt_size);
    $pdf->Write('5', utf8_decode(format_date($data->date_bilan_precedent)));
}
$pdf->Ln();

$pdf->SetFont('Helvetica', 'B', $normal_txt_size);
$pdf->Write('5', utf8_decode("Type de bilan : "));

$pdf->SetFont('Helvetica', '', $normal_txt_size);
$pdf->Write('5', utf8_decode($data->type_bilan));

$pdf->Ln();

$pdf->SetFont('Helvetica', 'B', $normal_txt_size);
$pdf->Write('5', utf8_decode("Évaluateur : "));

$pdf->SetFont('Helvetica', '', $normal_txt_size);
$pdf->Write('5', utf8_decode($infos_evaluateur));
$pdf->Ln($space_between_sections);

////////////////////////////////////////////////////
// Objectifs
////////////////////////////////////////////////////

$pdf->SetFont('Helvetica', 'BU', $title_txt_size);
$pdf->SetTextColor(76, 174, 227);
$pdf->Cell(190, 5, utf8_decode("Objectifs"), 0, 1, "C", 0);
$pdf->Ln($space_between_sections);

$pdf->SetTextColor(60, 60, 60);
$pdf->SetFont('Helvetica', '', $normal_txt_size);
if ($data->version_synthese == 'beneficiaire') {
    $phrase_1 = "L'entretien nous a permis de mettre en évidence certains éléments. Ainsi nous avons fixés les objectifs suivants :";
} else {
    $phrase_1 = "L'entretien avec le bénéficiaire a pu mettre en évidence certains éléments. Ainsi nous avons fixés les objectifs suivants :";
}
$pdf->Write(5, utf8_decode($phrase_1));
$pdf->Ln();
$pdf->Ln($space_between_sections);

if (count($objectifs) > 0) {
    for ($i = 0; $i < count($objectifs); $i++) {
        $pdf->EvalTitle("Objectif " . ($i + 1) . ": " . $objectifs[$i]->nom_objectif);

        $avancement_present = $objectifs[$i]->date_dernier_avancement != null &&
            $objectifs[$i]->date_dernier_avancement !== 'Aucune' &&
            $objectifs[$i]->avancement != null &&
            $objectifs[$i]->avancement !== 'Aucun';

        $commentaire_present = $objectifs[$i]->commentaire != null && $objectifs[$i]->commentaire !== '';

        $is_bottom_border = !$avancement_present && !$commentaire_present;
        $pdf->SetEvalRowWidths([35, 59.5, 35, 59.5]);
        $pdf->EvalSize1Row([
            "Date :",
            format_date($objectifs[$i]->date),
        ], $is_bottom_border);

        if ($avancement_present) {
            $is_bottom_border = !$commentaire_present;
            $pdf->EvalSize2Row([
                "Date dernier avancement :",
                format_date($objectifs[$i]->date_dernier_avancement),
                "Avancement :",
                $objectifs[$i]->avancement,
            ], $is_bottom_border);
        }

        if ($commentaire_present) {
            $pdf->SetEvalRowWidths([35, 154]);
            $pdf->EvalSize1Row([
                "Commentaires :",
                $objectifs[$i]->commentaire
            ], true);
        }

        $pdf->ln($space_between_sections);
    }
} else {
    if (!empty($objectif_text)) {
        $pdf->MultiCell(190, 5, utf8_decode($objectif_text), 0, 'J', 0);
    } else {
        $pdf->Write(5, utf8_decode("Aucun objectif fixé."));
        $pdf->Ln();
    }
    $pdf->ln($space_between_sections);
}

////////////////////////////////////////////////////
// Commentaires libre
////////////////////////////////////////////////////

if ($data->commentaires_objectifs !== null && $data->commentaires_objectifs !== "") {
    $pdf->SetFont('Helvetica', 'B', $normal_txt_size);
    $pdf->SetFillColor(141, 198, 63);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->RoundedBorderCell(100, 6, utf8_decode("Commentaires supplémentaires en lien avec les objectifs :"), 0, 'L');
    $pdf->SetFont('Helvetica', '', $normal_txt_size);
    $pdf->SetTextColor(1, 38, 120);
    $pdf->Ln();
    $pdf->ln(2);
    $pdf->MultiCell(190, 4, utf8_decode($data->commentaires_objectifs), 0, 'J', 0);
    $pdf->Ln($space_between_sections);
}

////////////////////////////////////////////////////
// Préconisations
////////////////////////////////////////////////////

if ($data->preconisations !== null && $data->preconisations !== "") {
    $pdf->SetFont('Helvetica', 'B', $normal_txt_size);
    $pdf->SetFillColor(141, 198, 63);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->RoundedBorderCell(30, 6, utf8_decode("Préconisations :"), 0, 'L');
    $pdf->SetFont('Helvetica', '', $normal_txt_size);
    $pdf->SetTextColor(1, 38, 120);
    $pdf->Ln();
    $pdf->ln(2);
    $pdf->MultiCell(190, 4, utf8_decode($data->preconisations), 0, 'J', 0);
    $pdf->Ln($space_between_sections);
}

////////////////////////////////////////////////////
// Point(s) de vigilances (douleurs/difficultés)
////////////////////////////////////////////////////

if ($data->point_vigilances !== null && $data->point_vigilances !== "") {
    $pdf->SetFont('Helvetica', 'B', $normal_txt_size);
    $pdf->SetFillColor(141, 198, 63);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->RoundedBorderCell(77, 6, utf8_decode("Point(s) de vigilances (douleurs/difficultés) :"), 0, 'L');
    $pdf->SetFont('Helvetica', '', $normal_txt_size);
    $pdf->SetTextColor(1, 38, 120);
    $pdf->Ln();
    $pdf->ln(2);
    $pdf->MultiCell(190, 4, utf8_decode($data->point_vigilances), 0, 'J', 0);
    $pdf->Ln($space_between_sections);
}

////////////////////////////////////////////////////
// Orientation
////////////////////////////////////////////////////

$pdf->SetFont('Helvetica', 'BU', $title_txt_size);
$pdf->SetTextColor(76, 174, 227);
$pdf->Cell(190, 5, utf8_decode("Activités"), 0, 1, "C", 0);
$pdf->Ln($space_between_sections);

$pdf->SetFont('Helvetica', '', $normal_txt_size);
$pdf->SetfillColor(236, 0, 140);
$pdf->SetTextColor(60, 60, 60);
if ($data->version_synthese == 'beneficiaire') {
    $phrase_2 = "Suite à nos échanges, nous vous encourageons à poursuivre les activités suivantes :";
} else {
    $phrase_2 = "Suite à votre demande, nous encourageons " . $titre_civilite . " à poursuivre les activités suivantes :";
}
$pdf->MultiCell(190, 5, utf8_decode($phrase_2), 0, 'J', 0);
$pdf->ln($space_between_sections);

if (count($activites) > 0) {
    for ($i = 0; $i < count($activites); $i++) {
        $pdf->EvalTitle("Activité " . ($i + 1) . ": " . $activites[$i]->activite);

        $commentaire_present = $activites[$i]->commentaire != null && $activites[$i]->commentaire !== '';
        $date_demarrage_present = $activites[$i]->date_demarrage != null && $activites[$i]->date_demarrage !== '';

        $pdf->SetEvalRowWidths([35, 59.5, 35, 59.5]);
        $pdf->EvalSize2Row([
            "Structure :",
            $activites[$i]->structure,
            "Orientation :",
            $activites[$i]->orientation,
        ]);

        $is_bottom_border = !$commentaire_present;
        if ($date_demarrage_present) {
            $pdf->EvalSize2Row([
                "Créneau :",
                $activites[$i]->creneaux,
                "Date de démarrage :",
                format_date($activites[$i]->date_demarrage),
            ], $is_bottom_border);
        } else {
            $pdf->EvalSize1Row([
                "Créneau :",
                $activites[$i]->creneaux
            ], $is_bottom_border);
        }

        if ($commentaire_present) {
            $pdf->SetEvalRowWidths([35, 154]);
            $pdf->EvalSize1Row([
                "Commentaires :",
                $activites[$i]->commentaire
            ], true);
        }

        $pdf->ln($space_between_sections);
    }
} else {
    if (!empty($activites_text)) {
        $pdf->MultiCell(190, 5, utf8_decode($activites_text), 0, 'J', 0);
    } else {
        $pdf->Write(5, utf8_decode("Aucune activité proposée."));
        $pdf->Ln();
    }
    $pdf->ln($space_between_sections);
}

////////////////////////////////////////////////////
// Conclusion du programme
////////////////////////////////////////////////////

if ($data->conclusion != null && $data->conclusion != '') {
    $pdf->SetTextColor(76, 174, 76);
    $pdf->SetDrawColor(76, 174, 76);
    $pdf->EvalTitle("Conclusion de l'évaluation", "vert");

    $pdf->SetFont('Helvetica', '', $normal_txt_size);
    $pdf->SetDrawColor(76, 174, 76);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->MultiCell(190, 5, utf8_decode($data->conclusion), 'LRB', 'J', 0);
    $pdf->Ln($space_between_sections);
}

if ($affichage_saut_page_conclusion) {
    $pdf->AddPage(); // saut de page
}

////////////////////////////////////////////////////
// Evaluations
////////////////////////////////////////////////////

//Données anthropométriques
$pdf->SetFont('Helvetica', 'BU', $title_txt_size);
$pdf->SetTextColor(76, 174, 227);
$pdf->SetFillColor(141, 198, 63);
$pdf->Cell(190, 5, utf8_decode("Données anthropométriques"), 0, 1, "C", 0);
$pdf->Ln(3);

//CONSTANTES ANTHROPOMETRIQUES
$pdf->EvalTitle("Test physiologique");

if (!isset($infos_constantes->fait) || !$infos_constantes->fait) {
    $pdf->SetEvalRowWidths([94, 94]);

    $pdf->EvalSize1Row([
        'Test non-effectué car :',
        $infos_constantes->motif
    ], true);
} else {
    $pdf->SetEvalRowWidths([35, 28, 35, 28, 35, 28]);

    $is_ligne1_presente = !empty($infos_constantes->poids) ||
        !empty($infos_constantes->taille) ||
        !empty($infos_constantes->IMC);

    $is_ligne2_presente = !empty($infos_constantes->tour_taille) ||
        !empty($infos_constantes->saturation_repos) ||
        !empty($infos_constantes->borg_repos);

    $is_ligne3_presente = !empty($infos_constantes->fc_repos) ||
        !empty($infos_constantes->fc_max_mesuree) ||
        !empty($infos_constantes->fc_max_theo);

    if ($is_ligne1_presente) {
        $is_bottom_border = !$is_ligne2_presente && !$is_ligne3_presente;
        $pdf->EvalSize3Row([
            "Poids (kg) :",
            $infos_constantes->poids,
            "Taille (cm) :",
            $infos_constantes->taille,
            "IMC :",
            $infos_constantes->IMC
        ], $is_bottom_border);
    }

    if ($is_ligne2_presente) {
        $is_bottom_border = !$is_ligne3_presente;
        $pdf->EvalSize3Row([
            "Tour de taille (cm) :",
            $infos_constantes->tour_taille,
            "Saturation de repos (%) :",
            $infos_constantes->saturation_repos,
            "Borg de repos :",
            $infos_constantes->borg_repos
        ], $is_bottom_border);
    }

    if ($is_ligne3_presente) {
        $pdf->EvalSize3Row([
            "FC de repos (bpm) :",
            $infos_constantes->fc_repos,
            "FC max mesurée (bpm) :",
            $infos_constantes->fc_max_mesuree,
            "FC max théorique (bpm) :",
            $infos_constantes->fc_max_theo
        ], true);
    }
}
$pdf->ln($space_between_sections);

//CONDITION PHYSIQUE
$pdf->SetTextColor(76, 174, 227);
$pdf->SetFont('Helvetica', 'BU', $title_txt_size);
$pdf->Cell(190, 5, utf8_decode("Évaluation de la condition physique"), 0, 1, "C", 0);
$pdf->Ln(3);

//TEST AEROBIE 6 MINUTES
$pdf->EvalTitle("Test de marche de 6 minutes");

if (!isset($infos_6_min->fait) || !$infos_6_min->fait) {
    $pdf->SetEvalRowWidths([94, 94]);
    $pdf->EvalSize1Row([
        'Test non-effectué car :',
        $infos_6_min->motif
    ], true);
} else {
    $pdf->SetEvalRowWidths([35, 59.5, 35, 59.5]);

    $is_distance_parcourue_present = $infos_6_min->distance_parcourue != null && $infos_6_min->distance_parcourue != '';
    $is_pourcentage_distance_theorique_present = $infos_6_min->pourcentage_distance_theorique != null && $infos_6_min->pourcentage_distance_theorique != '';

    if ($is_distance_parcourue_present && $is_pourcentage_distance_theorique_present) {
        $pdf->EvalSize2Row([
            "Distance (m) :",
            $infos_6_min->distance_parcourue,
            "Pourcentage de la distance théorique :",
            $infos_6_min->pourcentage_distance_theorique
        ]);
    } elseif ($is_distance_parcourue_present) {
        $pdf->EvalSize1Row([
            "Distance (m) :",
            $infos_6_min->distance_parcourue
        ]);
    }

    $header = [
        '',
        'Fréquence cardiaque (bpm)',
        'Saturation (% SpO2)',
        'Score Borg'
    ];
    $rows = [
        [
            '1 min',
            $infos_6_min->fc1,
            $infos_6_min->sat1,
            $infos_6_min->borg1
        ],
        [
            '2 min',
            $infos_6_min->fc2,
            $infos_6_min->sat2,
            $infos_6_min->borg2
        ],
        [
            '3 min',
            $infos_6_min->fc3,
            $infos_6_min->sat3,
            $infos_6_min->borg3
        ],
        [
            '4 min',
            $infos_6_min->fc4,
            $infos_6_min->sat4,
            $infos_6_min->borg4
        ],
        [
            '5 min',
            $infos_6_min->fc5,
            $infos_6_min->sat5,
            $infos_6_min->borg5
        ],
        [
            '6 min',
            $infos_6_min->fc6,
            $infos_6_min->sat6,
            $infos_6_min->borg6
        ],
        [
            '7 min, 1 min repos',
            $infos_6_min->fc7,
            $infos_6_min->sat7,
            $infos_6_min->borg7
        ],
        [
            '8 min, 2 min repos',
            $infos_6_min->fc8,
            $infos_6_min->sat8,
            $infos_6_min->borg8
        ],
        [
            '9 min, 3 min repos',
            $infos_6_min->fc9,
            $infos_6_min->sat9,
            $infos_6_min->borg9
        ],
    ];

    $non_empty_rows = array_filter($rows, 'is_row_not_empty');

    $widths = [
        52,
        58,
        44,
        26
    ];

    $commentaire_present = $infos_6_min->commentaires !== null && $infos_6_min->commentaires !== '';

    $pdf->EvalTableRow($header, $non_empty_rows, $widths, !$commentaire_present);

    if ($commentaire_present) {
        $pdf->SetEvalRowWidths([35, 154]);
        $pdf->EvalSize1Row([
            "Commentaires :",
            $infos_6_min->commentaires
        ], true);
    }
}
$pdf->ln($space_between_sections);

//TEST EQUILIBRE
$pdf->EvalTitle("Test d'équilibre unipodal");

if (!isset($infos_equilibre->fait) || !$infos_equilibre->fait) {
    $pdf->SetEvalRowWidths([94, 94]);
    $pdf->EvalSize1Row([
        'Test non-effectué car :',
        $infos_equilibre->motif
    ], true);
} else {
    $pdf->SetEvalRowWidths([35 + 31.5, 28, 35 + 31.5, 28]);
    if ($infos_equilibre->pied_dominant != null && $infos_equilibre->pied_dominant != '') {
        $pdf->EvalSize1Row([
            "Pied dominant :",
            $infos_equilibre->pied_dominant
        ]);
    }

    if ($infos_equilibre->commentaires != null && $infos_equilibre->commentaires !== "") {
        $pdf->EvalSize2Row([
            "Pied gauche au sol (s) :",
            $infos_equilibre->pied_gauche_sol,
            "Pied droit au sol (s) :",
            $infos_equilibre->pied_droit_sol
        ]);

        $pdf->SetEvalRowWidths([35, 154]);
        $pdf->EvalSize1Row([
            "Commentaires :",
            $infos_equilibre->commentaires
        ], true);
    } else {
        $pdf->EvalSize2Row([
            "Pied gauche au sol (s) :",
            $infos_equilibre->pied_gauche_sol,
            "Pied droit au sol (s) :",
            $infos_equilibre->pied_droit_sol
        ], true);
    }
}
$pdf->ln($space_between_sections);

//TEST MOBILITE SCAPULO-HUMERALE
$pdf->EvalTitle("Test de mobilité scapulo-humérale");

if (!isset($infos_mobilite->fait) || !$infos_mobilite->fait) {
    $pdf->SetEvalRowWidths([94, 94]);
    $pdf->EvalSize1Row([
        'Test non-effectué car :',
        $infos_mobilite->motif
    ], true);
} else {
    if ($infos_mobilite->commentaires !== null and $infos_mobilite->commentaires !== "") {
        $pdf->SetEvalRowWidths([35 + 31.5, 28, 35 + 31.5, 28]);
        $pdf->EvalSize2Row([
            "Main gauche en haut (cm) :",
            $infos_mobilite->main_gauche_haut,
            "Main droite en haut (cm) :",
            $infos_mobilite->main_droite_haut,
        ]);

        $pdf->SetEvalRowWidths([35, 154]);
        $pdf->EvalSize1Row([
            "Commentaires :",
            $infos_mobilite->commentaires
        ], true);
    } else {
        $pdf->SetEvalRowWidths([35, 28, 35, 28, 35, 28]);
        $pdf->EvalSize2Row([
            "Main gauche en haut (cm) :",
            $infos_mobilite->main_gauche_haut,
            "Main droite en haut (cm) :",
            $infos_mobilite->main_droite_haut,
        ], true);
    }
}
$pdf->ln($space_between_sections);

//TEST SOUPLESSE
$pdf->EvalTitle("Test de souplesse du tronc et de la chaîne postérieure");

if (!isset($infos_souplesse->fait) || !$infos_souplesse->fait) {
    $pdf->SetEvalRowWidths([94, 94]);
    $pdf->EvalSize1Row([
        'Test non-effectué car :',
        $infos_souplesse->motif
    ], true);
} else {
    $commentaire_present = $infos_souplesse->commentaires != null && $infos_souplesse->commentaires !== '';

    $pdf->SetEvalRowWidths([35 + 31.5, 28, 35 + 31.5, 28]);

    $is_bottom_border = !$commentaire_present;
    $pdf->EvalSize1Row([
        "Distance au sol (cm) :",
        $infos_souplesse->distance
    ], $is_bottom_border);

    if ($commentaire_present) {
        $pdf->SetEvalRowWidths([35, 154]);
        $pdf->EvalSize1Row([
            "Commentaires :",
            $infos_souplesse->commentaires
        ], true);
    }
}
$pdf->ln($space_between_sections);

//TEST FORCE
$pdf->EvalTitle("Test de force de préhension");

if (!isset($infos_force->fait) || !$infos_force->fait) {
    $pdf->SetEvalRowWidths([94, 94]);
    $pdf->EvalSize1Row([
        'Test non-effectué car :',
        $infos_force->motif
    ], true);
} else {
    $pdf->SetEvalRowWidths([35 + 31.5, 28, 35 + 31.5, 28]);
    if ($infos_force->main_forte != null && $infos_force->main_forte != '') {
        $pdf->EvalSize1Row([
            "Main forte :",
            $infos_force->main_forte
        ]);
    }

    if ($infos_force->commentaires !== null and $infos_force->commentaires !== "") {
        $pdf->EvalSize2Row([
            "Main gauche (kg) :",
            $infos_force->mg,
            "Main droite (kg) :",
            $infos_force->md,
        ]);

        $pdf->SetEvalRowWidths([35, 154]);
        $pdf->EvalSize1Row([
            "Commentaires :",
            $infos_force->commentaires
        ], true);
    } else {
        $pdf->EvalSize2Row([
            "Main gauche (kg) :",
            $infos_force->mg,
            "Main droite (kg) :",
            $infos_force->md,
        ], true);
    }
}
$pdf->ln($space_between_sections);

//TEST ASSIS-DEBOUT
$pdf->EvalTitle("Test assis-debout");

if (!isset($infos_assis_debout->fait) || !$infos_assis_debout->fait) {
    $pdf->SetEvalRowWidths([94, 94]);
    $pdf->EvalSize1Row([
        'Test non-effectué car :',
        $infos_assis_debout->motif
    ], true);
} else {
    $pdf->SetEvalRowWidths([35 + 31.5, 28, 35 + 31.5, 28]);

    $commentaire_present = $infos_assis_debout->commentaires != null && $infos_assis_debout->commentaires !== '';

    $pdf->EvalSize2Row([
        "Nombre de levers :",
        $infos_assis_debout->nb_lever,
        "Fréquence cardiaque après 30 secondes (bpm) :",
        $infos_assis_debout->fc30,
    ]);


    $is_bottom_border = !$commentaire_present;
    $pdf->EvalSize2Row([
        "Saturation après 30 secondes (% SpO2) :",
        $infos_assis_debout->sat30,
        "Score sur l'échelle de Borg après 30 secondes :",
        $infos_assis_debout->borg30,
    ], $is_bottom_border);

    if ($commentaire_present) {
        $pdf->SetEvalRowWidths([35, 154]);
        $pdf->EvalSize1Row([
            "Commentaires :",
            $infos_assis_debout->commentaires
        ], true);
    }
}
$pdf->ln($space_between_sections);

//Il nous manque les infos sur cette partie donc c'est en commentaire en attendant
//$pdf -> SetFont('Helvetica','BU',14);
//$pdf -> SetTextColor(76,174,227);
//$pdf -> Cell(190,10,"Analyse comportementale et motivationnelle",0,1,"C",0);
//$pdf -> SetTextColor(0);
//$pdf -> SetFont('Helvetica','B',13);
//$pdf -> SetTextColor(255,255,255);
//$pdf -> Cell(128,5,utf8_decode("Évaluation du niveau d'activité physique et de sédentarité"),0,1,"L",1);
//$pdf -> Cell(79,5,utf8_decode("Évaluation du niveau de motivation"),0,1,"L",1);
//$pdf -> Cell(67,5,utf8_decode("Évaluation de la qualité de vie"),0,1,"L",1);

////////////////////////////////////////////////////
// Remerciements
////////////////////////////////////////////////////

if ($data->remerciements != null && $data->remerciements != '') {
    $pdf->SetFont('Helvetica', '', $normal_txt_size);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->MultiCell(190, 5, utf8_decode($data->remerciements), 0, 'J', 0);
    $pdf->Ln($space_between_sections);
}

////////////////////////////////////////////////////
// Contact
////////////////////////////////////////////////////

// évaluateur
if ($affichage_coordonnees_evaluateur) {
    $pdf->SetDrawColor(76, 174, 76);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetEvalRowWidths([190 / 2, 190 / 2]);
    $pdf->Coordonnes($data_eval);
    $pdf->Ln(2);
}

// coordonnateur PEPS
if ($affichage_coordonnees_coordonnateur) {
    $pdf->SetDrawColor(76, 174, 76);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetEvalRowWidths([190 / 2, 190 / 2]);
    $pdf->Coordonnes($data_coordo);
    $pdf->Ln(2);
}

// coordonnées personnes supplémentaire
if (!empty($data_autres_personnes)) {
    foreach ($data_autres_personnes as $personne) {
        $pdf->SetDrawColor(76, 174, 76);
        $pdf->SetTextColor(60, 60, 60);
        $pdf->SetEvalRowWidths([190 / 2, 190 / 2]);
        $pdf->Coordonnes($personne);
        $pdf->Ln(2);
    }
}

if ($affichage_coordonnees_evaluateur || $affichage_coordonnees_coordonnateur || !empty($data_autres_personnes)) {
    $pdf->Ln(2);
}

// données INS patient
if ($data->version_synthese == 'medecin'
    && $data->id_type_statut_identite == "4") { // identité "Qualifiée"
    $details_patient = [];
    if (!empty($data->nom_naissance)) {
        $details_patient['nom_naissance'] = 'Nom de naissance: ' . $data->nom_naissance;
    }
    if (!empty($data->liste_prenom_naissance)) {
        $details_patient['liste_prenom_naissance'] = 'Prénom(s) de naissance: ' . $data->liste_prenom_naissance;
    }
    if (!empty($data->date_naissance)) {
        $details_patient['date_naissance'] = 'Date de naissance: ' . format_date($data->date_naissance);
    }
    if (!empty($data->sexe_patient)) {
        $details_patient['sexe_patient'] = 'Sexe: ' . $data->sexe_patient;
    }
    if (!empty($data->code_insee_naissance)) {
        $details_patient['code_insee_naissance'] = 'Code lieu naissance: ' . $data->code_insee_naissance;
    }
    if (!empty($data->matricule_ins)) {
        $details_patient['matricule_ins'] = 'Matricule INS: ' . $data->matricule_ins;
    }
    if (!empty($data->nature_oid) && $data->nature_oid != Patient::NATURE_OID_INCONNU) {
        $details_patient['oid'] = "Nature: " . ($data->nature_oid == Patient::NATURE_OID_NIR ? "NIR" : "NIA");
    }
    if (!empty($data->matricule_ins)) {
        $details_patient['adresse_ins'] = "Adresse de messagerie sécurisée de l'usager: " . $data->matricule_ins . "@patient.mssante.fr";
    }

    if ($data->affichage_details_patient_infos_supplementaires) {
        if (!empty($data->premier_prenom_naissance)) {
            $details_patient['premier_prenom_naissance'] = '1er prénom de naissance: ' . $data->premier_prenom_naissance;
        }
        if (!empty($data->nom_utilise)) {
            $details_patient['nom_utilise'] = 'Nom utilisé: ' . $data->nom_utilise;
        }
        if (!empty($data->prenom_utilise)) {
            $details_patient['prenom_utilise'] = 'Prénom utilisé: ' . $data->prenom_utilise;
        }
    }

    $pdf->SetDrawColor(76, 174, 76);
    $pdf->SetTextColor(60, 60, 60);
    $pdf->SetEvalRowWidths([190]);
    $pdf->DetailsPatient($details_patient);
    $pdf->Ln(2);
}

////////////////////////////////////////////////////
// Footer
////////////////////////////////////////////////////

if ($affichage_paaco_globule) {
    $current_y = $pdf->GetY();
    $pdf->SetDrawColor(150, 150, 150);
    $pdf->Line(10, $current_y, 200, $current_y);
    $pdf->Ln(1);
    $pdf->SetFont('Helvetica', '', $footer_txt_size);
    $pdf->SetTextColor(150, 150, 150);
    $pdf->Cell(
        200,
        5,
        utf8_decode(
            "Ce document de bilan est également disponible sous format numérique au sein de l'outil de coordonnateur Paaco-Globule."
        ),
        0,
        1,
        "L",
        0
    );
    $pdf->Cell(
        200,
        5,
        utf8_decode(
            "Pour plus d'informations, n'hésitez pas à contacter l'assistance aux utilisateurs ESEA Nouvelle-Aquitaine 05 64 090 090."
        ),
        0,
        1,
        "L",
        0
    );
}

////////////////////////////////////////////////////
// Génération du fichier pdf
////////////////////////////////////////////////////

if ($data->version_synthese == 'beneficiaire') {
    $filename = date("YmdHis") . '_' . $data->id_patient . '_SyntheseBeneficiaire.pdf';
} else {
    $filename = date("YmdHis") . '_' . $data->id_patient . '_SyntheseMedecin.pdf';
}

if ($save == 0) {
    $pdf->Output($filename, 'I');
} else {
    $synth = new Synthese($bdd);
    $result = $synth->saveSynthese($filename, $data->id_patient, $_SESSION['id_user']);
    if ($result) {
        //cryptage du pdf
        $encrypted_file_path = $root . "/uploads/syntheses/" . $filename;
        $unencrypted_file_path = $root . "/temp/" . $filename . "_temp";

        $pdf->Output($unencrypted_file_path, 'F');
        EncryptionManager::encrypt_file($unencrypted_file_path, $encrypted_file_path);
        unlink($unencrypted_file_path); // suppression du fichier crypté temp

        \Sportsante86\Sapa\Outils\SapaLogger::get()->info(
            'User ' . $_SESSION['email_connecte'] . ' created the file ' . $filename,
            ['event' => 'upload_complete:' . $_SESSION['email_connecte'] . ',' . $filename]
        );
        // set response code - 200 OK
        http_response_code(200);
        echo json_encode(true);
    } else {
        // set response code - 500 Internal Server Error
        http_response_code(500);
        echo json_encode(["message" => "Une erreur inconnue s'est produite."]);
        \Sportsante86\Sapa\Outils\SapaLogger::get()->error(
            'An unexpected error occurred when user ' . $_SESSION['email_connecte'] . ':' . $_SESSION['id_user'] . ' attempted to access a resource',
            [
                'error_message' => $synth->getErrorMessage(),
                'data' => json_encode($data),
            ]
        );
    }
}