<?php

use Sportsante86\Sapa\Model\Medecin;
use Sportsante86\Sapa\Model\Mutuelle;
use Sportsante86\Sapa\Model\Patient;
use Sportsante86\Sapa\Outils\Permissions;

require '../../bootstrap/bootstrap.php';

force_connected();

$permissions = new Permissions($_SESSION);

//Récupérer l'id du bénéficiaire
$idPatient = $_GET['idPatient'];

$p = new Patient($bdd);
$patient = $p->readOne($idPatient);
if (!$patient) {
    erreur_invalid_page();
}

if (!empty($patient['id_mutuelle'])) {
    $m = new Mutuelle($bdd);
    $mutuelle = $m->readOne($patient['id_mutuelle']);
}

$m = new Medecin($bdd);
$medecin_prescripteur = $m->readMedecinPrescripteurPatient($idPatient);
$medecin_traitant = $m->readMedecinTraitantPatient($idPatient);
$autres_professionnels_sante = $m->readAutresprofessionnelsSantePatient($idPatient);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Suivi Médical</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/design.css">
    <link rel="stylesheet" href="../../css/modal-details.css">
    <link rel="stylesheet" href="../../css/Ajout_Benef.css">
    <link rel="stylesheet" href="../../css/sante.css">
    <link rel="stylesheet" href="../../css/portfolio-item.css">

    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/commun.js"></script>
    <script type="text/javascript" src="../../js/functions.js"></script>
    <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>
<!-- Page Content -->
<?php
const PAGE_AJOUT_BENEF = 'PAGE_AJOUT_BENEF'; // permet de détecter que l'on est sur la page ajout de bénef

require '../header.php';
require '../Medecins/ModalMedecin.php';
require '../Mutuelles/modalMutuelle.php';
require '../partials/warning_modal.php';

echo '<input id="idPat" name="idPat" value="' . $idPatient . '" class="form-control input-md"  type="hidden">';

function generate_champs_medecin($array)
{
    ?>
    <div class="row">
        <input type="hidden" id="<?php
        echo $array['id_medecin']['id']; ?>"
               name="<?php
               echo $array['id_medecin']['id']; ?>" value="<?php
        echo $array['id_medecin']['value']; ?>">
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['nom']['id']; ?>" class="control-label">Nom</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['nom']['id']; ?>" name="<?php
            echo $array['nom']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['nom']['value'])) {
                echo htmlspecialchars($array['nom']['value']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['prenom']['id']; ?>" class="control-label">Prénom</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['prenom']['id']; ?>"
                   name="<?php
                   echo $array['prenom']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['prenom']['value'])) {
                echo htmlspecialchars($array['prenom']['value']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['specialite']['id']; ?>" class="control-label">Spécialité</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['specialite']['id']; ?>"
                   name="<?php
                   echo $array['specialite']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['specialite']['value'])) {
                echo htmlspecialchars($array['specialite']['value']);
            } else {
                echo 'Non renseignée';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['telephone']['id']; ?>" class="control-label">Numéro de téléphone</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['telephone']['id']; ?>"
                   name="<?php
                   echo $array['telephone']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['telephone']['value'])) {
                echo htmlspecialchars($array['telephone']['value']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['mail']['id']; ?>" class="control-label">Mail</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['mail']['id']; ?>"
                   name="<?php
                   echo $array['mail']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['mail']['value'])) {
                echo htmlspecialchars($array['mail']['value']);
            } else {
                echo 'Non renseignée';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['adresse']['id']; ?>" class="control-label">Adresse</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['adresse']['id']; ?>"
                   name="<?php
                   echo $array['adresse']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['adresse']['value'])) {
                echo htmlspecialchars($array['adresse']['value']);
            } else {
                echo 'Non renseignée';
            }
            ?>">
        </div>
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['complement']['id']; ?>" class="control-label">Complément d'adresse</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['complement']['id']; ?>"
                   name="<?php
                   echo $array['complement']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['complement']['value'])) {
                echo htmlspecialchars($array['complement']['value']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['code_postal']['id']; ?>" class="control-label">Code postal</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['code_postal']['id']; ?>"
                   name="<?php
                   echo $array['code_postal']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['code_postal']['value'])) {
                echo htmlspecialchars($array['code_postal']['value']);
            } else {
                echo 'Non renseigné';
            }
            ?>">
        </div>
        <div class="col-md-2" style="text-align: right">
            <label for="<?php
            echo $array['ville']['id']; ?>" class="control-label">Ville</label>
        </div>
        <div class="col-md-2">
            <input autocomplete="off" id="<?php
            echo $array['ville']['id']; ?>"
                   name="<?php
                   echo $array['ville']['id']; ?>"
                   class="form-control input-md" type="text" readonly value="<?php
            if (!empty($array['ville']['value'])) {
                echo htmlspecialchars($array['ville']['value']);
            } else {
                echo 'Non renseignée';
            }
            ?>">
        </div>
    </div>
    <?php
} ?>
<!-- The toast -->
<div id="toast"></div>

<div class="container">
    <div class="panel-body">
        <center>
            <legend style="color:black">
                <a href="AccueilPatient.php?idPatient=<?php
                echo $idPatient ?>"
                   style="color: black; margin-right: 50px;" class="btn btn-success btn-xs"><span
                            class="glyphicon glyphicon-arrow-left"></span></a>Retour
            </legend>
            <br>
        </center>
        <div>
            <form class="form-horizontal" method="POST"
                  action="../FicheResume/ModifSuiviMed.php?idPatient=<?php
                  echo $idPatient; ?>">
                <input name="idFormulaire" type="hidden" value="form-resume">
                <input id="id_patient" name="id_patient" value="<?= $idPatient; ?>" type="hidden">

                <fieldset class="section-rouge-2">
                    <legend class="section-titre-rouge-2">Suivi Médical</legend>
                    <!----------------------------------------------------------------------------------------------------------------------
                                                            MEDECIN PRESCRIPTEUR
                    -------------------------------------------------------------------------------------------------------------------- -->
                    <div>
                        <legend class="legend_petit_titre ">Médecin prescripteur actuel</legend>
                        <div class="cadre" style="text-align: center">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="choix_prescrip">Choisissez un médecin : </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input autocomplete="off" id="choix_prescrip" name="choix_prescrip" type="text"
                                           placeholder="Tapez les premières lettres du nom du médecin">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input value="+" class="ajout-medecins"
                                           type="button" data-toggle="modal" data-target="#modal" data-backdrop="static"
                                           data-keyboard="false">
                                </div>
                            </div>
                        </div>
                        <div>
                            <?php
                            generate_champs_medecin([
                                'id_medecin' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['id_medecin'] : null,
                                    'id' => 'id_med'
                                ],
                                'nom' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['nom_coordonnees'] : null,
                                    'id' => 'nom_med'
                                ],
                                'prenom' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['prenom_coordonnees'] : null,
                                    'id' => 'prenom_med'
                                ],
                                'specialite' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['nom_specialite_medecin'] : null,
                                    'id' => 'spe_med'
                                ],
                                'telephone' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['tel_fixe_coordonnees'] : null,
                                    'id' => 'tel_med'
                                ],
                                'mail' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['mail_coordonnees'] : null,
                                    'id' => 'mail_med'
                                ],
                                'adresse' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['nom_adresse'] : null,
                                    'id' => 'adresse_med'
                                ],
                                'complement' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['complement_adresse'] : null,
                                    'id' => 'complement_med'
                                ],
                                'code_postal' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['code_postal'] : null,
                                    'id' => 'cp_med'
                                ],
                                'ville' => [
                                    'value' => $medecin_prescripteur ? $medecin_prescripteur['nom_ville'] : null,
                                    'id' => 'ville_med'
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <br><br>
                    <!----------------------------------------------------------------------------------------------------------------------
                                                            MEDECIN traitant
                    -------------------------------------------------------------------------------------------------------------------- -->
                    <div>
                        <legend class="legend_petit_titre ">Médecin traitant</legend>
                        <div class="cadre" style="text-align: center">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="choix_traitant">Choisissez un médecin : </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input autocomplete="off" id="choix_traitant" name="choix_traitant" type="text"
                                           placeholder="Tapez les premières lettres du nom du médecin">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input value="+" class="ajout-medecins"
                                           type="button" data-toggle="modal" data-target="#modal" data-backdrop="static"
                                           data-keyboard="false">
                                </div>
                            </div>
                        </div>

                        <div>
                            <?php
                            generate_champs_medecin([
                                'id_medecin' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['id_medecin'] : null,
                                    'id' => 'id_med_traitant'
                                ],
                                'nom' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['nom_coordonnees'] : null,
                                    'id' => 'nom_med_traitant'
                                ],
                                'prenom' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['prenom_coordonnees'] : null,
                                    'id' => 'prenom_med_traitant'
                                ],
                                'specialite' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['nom_specialite_medecin'] : null,
                                    'id' => 'spe_med_traitant'
                                ],
                                'telephone' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['tel_fixe_coordonnees'] : null,
                                    'id' => 'tel_med_traitant'
                                ],
                                'mail' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['mail_coordonnees'] : null,
                                    'id' => 'mail_med_traitant'
                                ],
                                'adresse' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['nom_adresse'] : null,
                                    'id' => 'adresse_med_traitant'
                                ],
                                'complement' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['complement_adresse'] : null,
                                    'id' => 'complement_med_traitant'
                                ],
                                'code_postal' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['code_postal'] : null,
                                    'id' => 'cp_med_traitant'
                                ],
                                'ville' => [
                                    'value' => $medecin_traitant ? $medecin_traitant['nom_ville'] : null,
                                    'id' => 'ville_med_traitant'
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <br><br>
                    <!----------------------------------------------------------------------------------------------------------------------
                                                            AUTRE PRO
                    -------------------------------------------------------------------------------------------------------------------- -->
                    <div>
                        <legend class="legend_petit_titre ">Autre professionnel de santé</legend>
                        <div class="cadre" style="text-align: center">
                            <div class="row">
                                <div class="col-md-12">
                                    <input value="+" class="ajout-autre-professionnel"
                                           type="button" data-toggle="modal"
                                           data-target="#modal" data-backdrop="static" data-keyboard="false">
                                </div>
                            </div>
                        </div>

                        <br>
                        <div>
                            <?php
                            if (empty($autres_professionnels_sante)) {
                                echo '
                                    <div id="aucun-autre-pro" style="text-align: center">
                                        Aucun professionnel de sante supplémentaire
                                    </div>';
                            } else {
                                $i = 1000; //on commence a 1000 pour pas qu'il y ai de conflit
                                foreach ($autres_professionnels_sante as $autre_professionnel_sante) {
                                    echo '<div class="section-noir" id="div_' . $i . '">';
                                    //echo '<input type="hidden" name="id_a" id="id_a" value="' . $lignes['id_medecin'] . '" >';
                                    echo '<input type="hidden" name="id_autre[' . $i . ']" value="' . $autre_professionnel_sante['id_medecin'] . '" >';

                                    generate_champs_medecin([
                                        'id_medecin' => [
                                            'value' => $autre_professionnel_sante['id_medecin'],
                                            'id' => 'id_a'
                                        ],
                                        'nom' => [
                                            'value' => $autre_professionnel_sante['nom_coordonnees'],
                                            'id' => 'nom_coordonnees' . $autre_professionnel_sante['id_medecin']
                                        ],
                                        'prenom' => [
                                            'value' => $autre_professionnel_sante['prenom_coordonnees'],
                                            'id' => 'prenom_coordonnees' . $autre_professionnel_sante['id_medecin']
                                        ],
                                        'specialite' => [
                                            'value' => $autre_professionnel_sante['nom_specialite_medecin'],
                                            'id' => 'nom_specialite_medecin' . $autre_professionnel_sante['id_medecin']
                                        ],
                                        'telephone' => [
                                            'value' => $autre_professionnel_sante['tel_fixe_coordonnees'],
                                            'id' => 'tel_fixe_coordonnees' . $autre_professionnel_sante['id_medecin']
                                        ],
                                        'mail' => [
                                            'value' => $autre_professionnel_sante['mail_coordonnees'],
                                            'id' => 'mail_coordonnees' . $autre_professionnel_sante['id_medecin']
                                        ],
                                        'adresse' => [
                                            'value' => $autre_professionnel_sante['nom_adresse'],
                                            'id' => 'nom_adresse' . $autre_professionnel_sante['id_medecin']
                                        ],
                                        'complement' => [
                                            'value' => $autre_professionnel_sante['complement_adresse'],
                                            'id' => 'complement_adresse' . $autre_professionnel_sante['id_medecin']
                                        ],
                                        'code_postal' => [
                                            'value' => $autre_professionnel_sante['code_postal'],
                                            'id' => 'code_postal' . $autre_professionnel_sante['id_medecin']
                                        ],
                                        'ville' => [
                                            'value' => $autre_professionnel_sante['nom_ville'],
                                            'id' => 'nom_ville' . $autre_professionnel_sante['id_medecin']
                                        ]
                                    ]);
                                    echo '<br>';
                                    echo '<div class="row" style="text-align: center">';
                                    echo '<div class="col-md-12">';
                                    echo '<button class="btn btn-danger btn-sm supprimer" data-id="div_' . $i . '">Supprimer</button>';

                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    $i++;
                                }
                            }
                            ?>
                            <div id="autres-pro-sup"></div>
                            <br>
                            <div class="row">
                                <div class="col-md-12" style="text-align: center">
                                    <button type="button" onclick="addItem();">
                                        Ajout d'un professionnel de santé supplémentaire
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <!----------------------------------------------------------------------------------------------------------------------
                                                            MUTUELLE
                    -------------------------------------------------------------------------------------------------------------------- -->
                    <div>
                        <legend class="legend_petit_titre ">Mutuelle</legend>
                        <div class="cadre" style="text-align: center">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="choix_mutuelle">Choisissez une mutuelle: </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <input autocomplete="off" id="choix_mutuelle" name="choix_mutuelle" type="text"
                                           placeholder="Tapez les premières lettres de la mutuelle">
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input value="+"
                                           id="ajout-mutuelle" type="button" data-toggle="modal"
                                           data-target="#modal-mutuelle"
                                           data-backdrop="static" data-keyboard="false">
                                </div>
                            </div>
                        </div>

                        <div>
                            <input type="hidden" id="id_mutuelle" name="id_mutuelle" value="<?php
                            if (!empty($mutuelle['id_mutuelle'])) {
                                echo htmlspecialchars($mutuelle['id_mutuelle']);
                            } ?>">>
                            <div class="row">
                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="nom_mutuelle">Nom</label>
                                </div>
                                <div class="col-md-4">
                                    <input autocomplete="off" id="nom_mutuelle" name="nom_mutuelle"
                                           class="form-control input-md" type="text" readonly
                                           value="<?php
                                           if (!empty($mutuelle['nom'])) {
                                               echo htmlspecialchars($mutuelle['nom']);
                                           } ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="tel_mutuelle">Numéro de téléphone</label>
                                </div>
                                <div class="col-md-4">
                                    <input autocomplete="off" id="tel_mutuelle" name="tel_mutuelle"
                                           class="form-control input-md" type="text" readonly
                                           value="<?php
                                           if (!empty($mutuelle['tel_fixe'])) {
                                               echo htmlspecialchars($mutuelle['tel_fixe']);
                                           } ?>">
                                </div>

                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="mail_mutuelle">Mail</label>
                                </div>
                                <div class="col-md-4">
                                    <input autocomplete="off" id="mail_mutuelle" name="mail_mutuelle"
                                           class="form-control input-md" type="text" readonly
                                           value="<?php
                                           if (!empty($mutuelle['email'])) {
                                               echo htmlspecialchars($mutuelle['email']);
                                           } ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="adresse_mutuelle">Adresse</label>
                                </div>
                                <div class="col-md-4">
                                    <input autocomplete="off" id="adresse_mutuelle" name="adresse_mutuelle"
                                           class="form-control input-md" type="text" readonly
                                           value="<?php
                                           if (!empty($mutuelle['nom_adresse'])) {
                                               echo htmlspecialchars($mutuelle['nom_adresse']);
                                           } ?>">
                                </div>

                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="complement_mutuelle">Complément d'adresse</label>
                                </div>
                                <div class="col-md-4">
                                    <input autocomplete="off" id="complement_mutuelle" name="complement_mutuelle"
                                           class="form-control input-md" type="text" readonly
                                           value="<?php
                                           if (!empty($mutuelle['complement_adresse'])) {
                                               echo htmlspecialchars($mutuelle['complement_adresse']);
                                           } ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="cp_mutuelle">Code postal</label>
                                </div>
                                <div class="col-md-4">
                                    <input autocomplete="off" id="cp_mutuelle" name="cp_mutuelle"
                                           class="form-control input-md" type="text" readonly
                                           value="<?php
                                           if (!empty($mutuelle['code_postal'])) {
                                               echo htmlspecialchars($mutuelle['code_postal']);
                                           } ?>">
                                </div>

                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="ville_mutuelle">Ville</label>
                                </div>
                                <div class="col-md-4">
                                    <input autocomplete="off" id="ville_mutuelle" name="ville_mutuelle"
                                           class="form-control input-md" type="text" readonly
                                           value="<?php
                                           if (!empty($mutuelle['nom_ville'])) {
                                               echo htmlspecialchars($mutuelle['nom_ville']);
                                           } ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <!----------------------------------------------------------------------------------------------------------------------
                                                                                    CPAM
                    -------------------------------------------------------------------------------------------------------------------- -->
                    <div>
                        <legend class="legend_petit_titre ">Caisse d'assurance maladie</legend>
                        <div>
                            <div class="row">
                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="id_caisse_assurance_maladie">Régime</label><span
                                            style="color: red">*</span>
                                </div>
                                <div class="col-md-8">
                                    <select name="id_caisse_assurance_maladie" class="form-control"
                                            id="id_caisse_assurance_maladie">
                                        <?php
                                        $req = $bdd->query(
                                            "SELECT * FROM caisse_assurance_maladie ORDER BY nom_regime"
                                        );
                                        while ($data = $req->fetch()) {
                                            echo '<option value="' . $data["id_caisse_assurance_maladie"] . '"';
                                            if ($data['id_caisse_assurance_maladie'] == $patient['id_caisse_assurance_maladie']) {
                                                echo 'selected="selected"';
                                            }
                                            echo '>' . $data["nom_regime"] . '</option>';
                                        }
                                        $req->closeCursor();
                                        echo '</select>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="cp_cpam">Code postal</label><span
                                            style="color: red">*</span>
                                </div>
                                <div class="col-md-4">
                                    <input name="cp_cpam" id="cp_cpam" class="form-control" autocomplete="off"
                                           required
                                           type="text" value="<?php
                                    if (!empty($patient['code_postal_cam'])) {
                                        echo htmlspecialchars($patient['code_postal_cam']);
                                    } ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="text-align: right">
                                    <label class="control-label" for="ville_cpam">Ville</label><span
                                            style="color: red">*</span>
                                </div>
                                <div class="col-md-4">
                                    <input name="ville_cpam" id="ville_cpam" class="form-control" autocomplete="off"
                                           required readonly
                                           type="text" value="<?php
                                    if (!empty($patient['nom_ville_cam'])) {
                                        echo htmlspecialchars($patient['nom_ville_cam']);
                                    } ?>">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div style="text-align: center">
                            <input type="submit" name="enregistrer" id="enregistrer"
                                   value="Enregistrer les modifications" class="btn btn-success btn-xs">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script src="../../js/confirmExitPage.js"></script>
<script src="../../js/autocomplete.js"></script>
<script src="../../js/modalMedecin.js"></script>
<script src="../../js/modalMutuelle.js"></script>
<script src="../../js/ModifMed.js"></script>
<script type="text/javascript" src="../../js/fixHeader.js"></script>
</body>
</html>