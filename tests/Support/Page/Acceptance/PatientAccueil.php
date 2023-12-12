<?php

namespace Tests\Support\Page\Acceptance;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\AcceptanceTester;

class PatientAccueil
{
    // include url of current page
    public static $URL = '/PHP/Patients/AccueilPatient.php?idPatient=';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    private $enregistrerButton = ["css" => "input.btn"];
    //private $voirPlusButton = ["id" => "voir-plus"];

    //
    private $dateAdmissionField = ["id" => "da"];

    // coordonnées patient
    private $nomPatientField = ["id" => "nom-patient"];
    private $prenomPatientField = ["id" => "prenom-patient"];
    private $sexeField = ["id" => "sexe"];
    private $dateNaissanceField = ["id" => "dn"];
    private $telPortablePatientField = ["id" => "tel_p"];
    private $telFixePatientField = ["id" => "tel_f"];
    private $emailPatientField = ["id" => "email"];
    private $adressePatientField = ["id" => "adresse-patient"];
    private $complementAdressePatientField = ["id" => "complement-adresse-patient"];
    private $codePostalPatientField = ["id" => "code-postal-patient"];
    private $firstCodePostalPatient = ["css" => "#code-postal-patientautocomplete-list > div:nth-child(1) > input:nth-child(1)"];
    private $villePatientField = ["id" => "ville-patient"];

    private $code_insee_naissanceField = ["id" => "code_insee_naissance"];
    private $nom_utiliseField = ["id" => "nom_utilise"];
    private $prenom_utiliseField = ["id" => "prenom_utilise"];
    private $liste_prenom_naissanceField = ["id" => "liste_prenom_naissance"];

    // coordonnées contact
    private $nomContactField = ["id" => "nom_urgence"];
    private $prenomContactField = ["id" => "prenom_urgence"];
    private $lienField = ["id" => "id_lien"];
    private $telPortableContactField = ["id" => "tel_urgence_p"];
    private $telFixeContactField = ["id" => "tel_urgence_f"];

    // Autres infos
    private $est_pris_en_chargeField = ["id" => "est-pris-en-charge"];
    private $hauteur_prise_en_chargeField = ["id" => "hauteur-prise-en-charge"];
    private $sit_part_prevention_chuteField = ["id" => "sit_part_prevention_chute"];
    private $sit_part_education_therapeutiqueField = ["id" => "sit_part_education_therapeutique"];
    private $sit_part_grossesseField = ["id" => "sit_part_grossesse"];
    private $sit_part_sedentariteField = ["id" => "sit_part_sedentarite"];
    private $sit_part_autreField = ["id" => "sit_part_autre"];
    private $qpvField = ["id" => "qpv"];
    private $zrrField = ["id" => "zrr"];
    private $intervalleSelect = ["id" => "intervalle"];
    private $intervalleSelectedOption = ["css" => "#intervalle option:checked"];

    // Régime d'assurance maladie
    private $regimeField = ["id" => "TypeRegime"];
    private $codePostalCpamField = ["id" => "cp_cpam"];
    private $villeCpamField = ["id" => "ville_cpam"];

    // mutuelle
    private $nom_mutuelleField = ["id" => "nom_mutuelle"];
    private $tel_mutuelleField = ["id" => "tel_mutuelle"];
    private $mail_mutuelleField = ["id" => "mail_mutuelle"];
    private $adresse_mutuelleField = ["id" => "adresse_mutuelle"];
    private $complement_mutuelleField = ["id" => "complement_mutuelle"];
    private $cp_mutuelleField = ["id" => "cp_mutuelle"];
    private $ville_mutuelleField = ["id" => "ville_mutuelle"];

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    private static function remove_spaces($string)
    {
        return preg_replace('/\s/', '', $string);
    }

    public function verify($paramaters)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::route($paramaters['id_patient']));

        $I->wantTo("Vérifier les coordonnées du bénéficiaire");
        $I->assertEqualsIgnoringCase(
            ChaineCharactere::format_compatible_ins($paramaters['nom_naissance']),
            $I->grabValueFrom($this->nomPatientField)
        );
        $I->assertEqualsIgnoringCase(
            ChaineCharactere::format_compatible_ins($paramaters['premier_prenom_naissance']),
            $I->grabValueFrom($this->prenomPatientField)
        );
        $I->assertEqualsIgnoringCase($paramaters['sexe_text'], $I->grabValueFrom($this->sexeField));
        $formated_date = date_format(date_create($paramaters['date_naissance']), 'd/m/Y');
        $I->assertEquals($formated_date, $I->grabValueFrom($this->dateNaissanceField));
        $I->assertEqualsIgnoringCase($paramaters['adresse_patient'], $I->grabValueFrom($this->adressePatientField));
        $I->assertEquals($paramaters['code_postal_patient'], $I->grabValueFrom($this->codePostalPatientField));
        $I->assertEqualsIgnoringCase($paramaters['ville_patient_text'], $I->grabValueFrom($this->villePatientField));

        if (!empty($paramaters['tel_fixe_patient'])) {
            $actual = self::remove_spaces($I->grabValueFrom($this->telFixePatientField));
            $I->assertEquals(
                $paramaters['tel_fixe_patient'],
                $actual
            );
        }
        if (!empty($paramaters['tel_portable_patient'])) {
            $I->assertEqualsCanonicalizing(
                $paramaters['tel_portable_patient'],
                self::remove_spaces($I->grabValueFrom($this->telPortablePatientField))
            );
        }
        if (!empty($paramaters['email_patient'])) {
            $I->assertEquals($paramaters['email_patient'], $I->grabValueFrom($this->emailPatientField));
        }
        if (!empty($paramaters['complement_adresse_patient'])) {
            $I->assertEqualsIgnoringCase(
                $paramaters['complement_adresse_patient'],
                $I->grabValueFrom($this->complementAdressePatientField)
            );
        }
        if (!empty($paramaters['code_insee_naissance'])) {
            $I->assertEquals($paramaters['code_insee_naissance'], $I->grabValueFrom($this->code_insee_naissanceField));
        }
        if (!empty($paramaters['nom_utilise'])) {
            $I->assertEqualsIgnoringCase(
                ChaineCharactere::format_compatible_ins($paramaters['nom_utilise']),
                $I->grabValueFrom($this->nom_utiliseField)
            );
        }
        if (!empty($paramaters['prenom_utilise'])) {
            $I->assertEqualsIgnoringCase(
                ChaineCharactere::format_compatible_ins($paramaters['prenom_utilise']),
                $I->grabValueFrom($this->prenom_utiliseField)
            );
        }
        if (!empty($paramaters['liste_prenom_naissance'])) {
            $I->assertEqualsIgnoringCase(
                ChaineCharactere::format_compatible_ins($paramaters['liste_prenom_naissance']),
                $I->grabValueFrom($this->liste_prenom_naissanceField)
            );
        }

        $I->wantTo("Vérifier le contact d'urgence");
        if (!empty($paramaters['nom_contact'])) {
            $I->assertEqualsIgnoringCase(
                mb_strtoupper($paramaters['nom_contact']),
                $I->grabValueFrom($this->nomContactField)
            );
        }
        if (!empty($paramaters['prenom_contact'])) {
            $I->assertEqualsIgnoringCase(
                mb_strtoupper($paramaters['prenom_contact']),
                $I->grabValueFrom($this->prenomContactField)
            );
        }
        if (!empty($paramaters['lien'])) {
            $I->assertEqualsIgnoringCase($paramaters['lien_text'], $I->grabValueFrom($this->lienField));
        }
        if (!empty($paramaters['tel_fixe_contact'])) {
            $I->assertEquals(
                $paramaters['tel_fixe_contact'],
                self::remove_spaces($I->grabValueFrom($this->telFixeContactField))
            );
        }
        if (!empty($paramaters['tel_portable_contact'])) {
            $I->assertEquals(
                $paramaters['tel_portable_contact'],
                self::remove_spaces($I->grabValueFrom($this->telPortableContactField))
            );
        }

        $I->wantTo("Vérifier les Autres infos");
        if (!empty($paramaters['intervalle'])) {
            $I->assertEquals($paramaters['intervalle'], $I->grabValueFrom($this->intervalleSelect));
        }
        if ($paramaters['check_autres_infos']) {
            if ($paramaters['est_pris_en_charge'] && !empty($paramaters['hauteur_prise_en_charge'])) {
                $I->assertEquals("OUI", $I->grabValueFrom($this->est_pris_en_chargeField));
                $I->assertEquals(
                    $paramaters['hauteur_prise_en_charge'],
                    $I->grabValueFrom($this->hauteur_prise_en_chargeField)
                );
            } else {
                $I->assertEquals("NON", $I->grabValueFrom($this->est_pris_en_chargeField));
            }
            if ($paramaters['sit_part_prevention_chute']) {
                $I->assertEquals("OUI", $I->grabValueFrom($this->sit_part_prevention_chuteField));
            } else {
                $I->assertEquals("NON", $I->grabValueFrom($this->sit_part_prevention_chuteField));
            }
            if ($paramaters['sit_part_education_therapeutique']) {
                $I->assertEquals("OUI", $I->grabValueFrom($this->sit_part_education_therapeutiqueField));
            } else {
                $I->assertEquals("NON", $I->grabValueFrom($this->sit_part_education_therapeutiqueField));
            }
            if ($paramaters['sit_part_grossesse']) {
                $I->assertEquals("OUI", $I->grabValueFrom($this->sit_part_grossesseField));
            } else {
                $I->assertEquals("NON", $I->grabValueFrom($this->sit_part_grossesseField));
            }
            if ($paramaters['sit_part_sedentarite']) {
                $I->assertEquals("OUI", $I->grabValueFrom($this->sit_part_sedentariteField));
            } else {
                $I->assertEquals("NON", $I->grabValueFrom($this->sit_part_sedentariteField));
            }
            if ($paramaters['sit_part_autre']) {
                $I->assertEqualsIgnoringCase(
                    $paramaters['sit_part_autre'],
                    $I->grabValueFrom($this->sit_part_autreField)
                );
            } else {
                $I->assertEqualsIgnoringCase(
                    $paramaters['sit_part_autre'],
                    $I->grabValueFrom($this->sit_part_autreField)
                );
            }
            if ($paramaters['qpv']) {
                $I->assertEquals("OUI", $I->grabValueFrom($this->qpvField));
            } else {
                $I->assertEquals("NON", $I->grabValueFrom($this->qpvField));
            }
            if ($paramaters['zrr']) {
                $I->assertEquals("OUI", $I->grabValueFrom($this->zrrField));
            } else {
                $I->assertEquals("NON", $I->grabValueFrom($this->zrrField));
            }
        }

        $I->wantTo("Vérifier CPAM");
        if (!empty($paramaters['regime_text'])) {
            $I->assertEqualsIgnoringCase($paramaters["regime_text"], $I->grabValueFrom($this->regimeField));
        }
        if (!empty($paramaters['regime_text'])) {
            $I->assertEquals($paramaters["code_postal_cpam"], $I->grabValueFrom($this->codePostalCpamField));
        }
        if (!empty($paramaters['regime_text'])) {
            $I->assertEqualsIgnoringCase($paramaters["ville_cpam_text"], $I->grabValueFrom($this->villeCpamField));
        }

        $I->wantTo("Vérifier mutuelle");
        if (!empty($paramaters['nom_mutuelle'])) {
            $I->assertEqualsIgnoringCase(
                $paramaters["nom_mutuelle_complete_text"],
                $I->grabValueFrom($this->nom_mutuelleField)
            );
            $I->assertEqualsIgnoringCase(
                $paramaters["tel_mutuelle_text"],
                self::remove_spaces($I->grabValueFrom($this->tel_mutuelleField))
            );
            $I->assertEqualsIgnoringCase(
                $paramaters["mail_mutuelle_text"],
                $I->grabValueFrom($this->mail_mutuelleField)
            );
            $I->assertEqualsIgnoringCase(
                $paramaters["adresse_mutuelle_text"],
                $I->grabValueFrom($this->adresse_mutuelleField)
            );
            $I->assertEqualsIgnoringCase(
                $paramaters["complement_mutuelle_text"],
                $I->grabValueFrom($this->complement_mutuelleField)
            );
            $I->assertEqualsIgnoringCase($paramaters["cp_mutuelle_text"], $I->grabValueFrom($this->cp_mutuelleField));
            $I->assertEqualsIgnoringCase(
                $paramaters["ville_mutuelle_text"],
                $I->grabValueFrom($this->ville_mutuelleField)
            );
        }
    }
}
