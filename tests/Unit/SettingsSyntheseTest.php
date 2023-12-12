<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Model\SettingsSynthese;
use Tests\Support\UnitTester;

class SettingsSyntheseTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    private SettingsSynthese $settingsSynthese;

    protected function _before()
    {
        $pdo = $this->getModule('Db')->_getDbh();;
        $this->settingsSynthese = new SettingsSynthese($pdo);
        $this->assertNotNull($this->settingsSynthese);
    }

    protected function _after()
    {
    }

    public function testCreateOkMinimumData()
    {
        $id_structure = "2";

        $settings_synthese_count_before = $this->tester->grabNumRecords('settings_synthese');

        $id_settings_synthese = $this->settingsSynthese->create([
            'id_structure' => $id_structure,
        ]);
        $this->assertNotFalse($id_settings_synthese);

        $settings_synthese_count_after = $this->tester->grabNumRecords('settings_synthese');

        $this->assertEquals($settings_synthese_count_before + 1, $settings_synthese_count_after);

        $this->tester->seeInDatabase('settings_synthese', array(
            'id_structure' => $id_structure,
            'id_settings_synthese' => $id_settings_synthese,
            'introduction_medecin' => null,
            'introduction_beneficiaire' => null,
            'remerciements_medecin' => null,
            'remerciements_beneficiaire' => null,
        ));
    }

    public function testCreateOkAllData()
    {
        $id_structure = "2";

        $introduction_medecin = 'Intro médecin';
        $introduction_beneficiaire = 'Intro bénéficiaire';
        $remerciements_medecin = 'Remerciements médecin';
        $remerciements_beneficiaire = 'Remerciements bénéficiaire';

        $settings_synthese_count_before = $this->tester->grabNumRecords('settings_synthese');

        $id_settings_synthese = $this->settingsSynthese->create([
            'id_structure' => $id_structure,
            'introduction_medecin' => $introduction_medecin,
            'introduction_beneficiaire' => $introduction_beneficiaire,
            'remerciements_medecin' => $remerciements_medecin,
            'remerciements_beneficiaire' => $remerciements_beneficiaire,
        ]);
        $this->assertNotFalse($id_settings_synthese);

        $settings_synthese_count_after = $this->tester->grabNumRecords('settings_synthese');

        $this->assertEquals($settings_synthese_count_before + 1, $settings_synthese_count_after);

        $this->tester->seeInDatabase('settings_synthese', array(
            'id_structure' => $id_structure,
            'id_settings_synthese' => $id_settings_synthese,
            'introduction_medecin' => $introduction_medecin,
            'introduction_beneficiaire' => $introduction_beneficiaire,
            'remerciements_medecin' => $remerciements_medecin,
            'remerciements_beneficiaire' => $remerciements_beneficiaire,
        ));
    }

    public function testCreateNotOkId_structureNull()
    {
        $id_structure = null;

        $introduction_medecin = 'Intro médecin';
        $introduction_beneficiaire = 'Intro bénéficiaire';
        $remerciements_medecin = 'Remerciements médecin';
        $remerciements_beneficiaire = 'Remerciements bénéficiaire';

        $settings_synthese_count_before = $this->tester->grabNumRecords('settings_synthese');

        $id_settings_synthese = $this->settingsSynthese->create([
            'id_structure' => $id_structure,
            'introduction_medecin' => $introduction_medecin,
            'introduction_beneficiaire' => $introduction_beneficiaire,
            'remerciements_medecin' => $remerciements_medecin,
            'remerciements_beneficiaire' => $remerciements_beneficiaire,
        ]);
        $this->assertFalse($id_settings_synthese);

        $settings_synthese_count_after = $this->tester->grabNumRecords('settings_synthese');

        $this->assertEquals($settings_synthese_count_before, $settings_synthese_count_after);
    }

    public function testCreateNotOkId_structureInvalid()
    {
        $id_structure = "-1";

        $introduction_medecin = 'Intro médecin';
        $introduction_beneficiaire = 'Intro bénéficiaire';
        $remerciements_medecin = 'Remerciements médecin';
        $remerciements_beneficiaire = 'Remerciements bénéficiaire';

        $settings_synthese_count_before = $this->tester->grabNumRecords('settings_synthese');

        $id_settings_synthese = $this->settingsSynthese->create([
            'id_structure' => $id_structure,
            'introduction_medecin' => $introduction_medecin,
            'introduction_beneficiaire' => $introduction_beneficiaire,
            'remerciements_medecin' => $remerciements_medecin,
            'remerciements_beneficiaire' => $remerciements_beneficiaire,
        ]);
        $this->assertFalse($id_settings_synthese);

        $settings_synthese_count_after = $this->tester->grabNumRecords('settings_synthese');

        $this->assertEquals($settings_synthese_count_before, $settings_synthese_count_after);
    }

    public function testUpdateOkMinimumData()
    {
        $id_settings_synthese = "1";

        $update_ok = $this->settingsSynthese->update([
            'id_settings_synthese' => $id_settings_synthese,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('settings_synthese', array(
            'id_settings_synthese' => $id_settings_synthese,
            'introduction_medecin' => null,
            'introduction_beneficiaire' => null,
            'remerciements_medecin' => null,
            'remerciements_beneficiaire' => null,
        ));
    }

    public function testUpdateOkAllData()
    {
        $id_settings_synthese = "1";

        $introduction_medecin = 'Intro médecin';
        $introduction_beneficiaire = 'Intro bénéficiaire';
        $remerciements_medecin = 'Remerciements médecin';
        $remerciements_beneficiaire = 'Remerciements bénéficiaire';

        $update_ok = $this->settingsSynthese->update([
            'id_settings_synthese' => $id_settings_synthese,
            'introduction_medecin' => $introduction_medecin,
            'introduction_beneficiaire' => $introduction_beneficiaire,
            'remerciements_medecin' => $remerciements_medecin,
            'remerciements_beneficiaire' => $remerciements_beneficiaire,
        ]);
        $this->assertTrue($update_ok);

        $this->tester->seeInDatabase('settings_synthese', array(
            'id_settings_synthese' => $id_settings_synthese,
            'introduction_medecin' => $introduction_medecin,
            'introduction_beneficiaire' => $introduction_beneficiaire,
            'remerciements_medecin' => $remerciements_medecin,
            'remerciements_beneficiaire' => $remerciements_beneficiaire,
        ));
    }

    public function testUpdateNotOkId_settings_syntheseNull()
    {
        $id_settings_synthese = null;

        $introduction_medecin = 'Intro médecin';
        $introduction_beneficiaire = 'Intro bénéficiaire';
        $remerciements_medecin = 'Remerciements médecin';
        $remerciements_beneficiaire = 'Remerciements bénéficiaire';

        $update_ok = $this->settingsSynthese->update([
            'id_settings_synthese' => $id_settings_synthese,
            'introduction_medecin' => $introduction_medecin,
            'introduction_beneficiaire' => $introduction_beneficiaire,
            'remerciements_medecin' => $remerciements_medecin,
            'remerciements_beneficiaire' => $remerciements_beneficiaire,
        ]);
        $this->assertFalse($update_ok);
    }

    public function testReadOneOk()
    {
        $id_settings_synthese = "1";

        // known data
        $introduction_medecin = 'Intro médecin';
        $introduction_beneficiaire = 'Intro bénéficiaire';
        $remerciements_medecin = 'Remerciements médecin';
        $remerciements_beneficiaire = 'Remerciements bénéficiaire';
        $id_structure = "1";

        $item = $this->settingsSynthese->readOne($id_settings_synthese);
        $this->assertIsArray($item);
        $this->assertArrayHasKey('id_settings_synthese', $item);
        $this->assertArrayHasKey('introduction_medecin', $item);
        $this->assertArrayHasKey('introduction_beneficiaire', $item);
        $this->assertArrayHasKey('remerciements_medecin', $item);
        $this->assertArrayHasKey('remerciements_beneficiaire', $item);
        $this->assertArrayHasKey('id_structure', $item);

        $this->assertEquals($item['id_settings_synthese'], $id_settings_synthese);
        $this->assertEquals($item['introduction_beneficiaire'], $introduction_beneficiaire);
        $this->assertEquals($item['introduction_medecin'], $introduction_medecin);
        $this->assertEquals($item['remerciements_medecin'], $remerciements_medecin);
        $this->assertEquals($item['remerciements_beneficiaire'], $remerciements_beneficiaire);
        $this->assertEquals($item['id_structure'], $id_structure);
    }

    public function testReadOneNotOkId_settings_syntheseNull()
    {
        $id_settings_synthese = null;

        $item = $this->settingsSynthese->readOne($id_settings_synthese);
        $this->assertFalse($item);
    }

    public function testReadOneNotOkId_settings_syntheseInvalid()
    {
        $id_settings_synthese = "-1";

        $item = $this->settingsSynthese->readOne($id_settings_synthese);
        $this->assertFalse($item);
    }

    public function testGetIdSettingsSyntheseOkStructureHasSettings()
    {
        $id_structure = "1";

        $id_settings_synthese = $this->settingsSynthese->getIdSettingsSynthese($id_structure);
        $this->assertNotNull($id_settings_synthese);
        $this->assertEquals("1", $id_settings_synthese);
    }

    public function testGetIdSettingsSyntheseOkStructureHasNoSettings()
    {
        $id_structure = "3";

        $id_settings_synthese = $this->settingsSynthese->getIdSettingsSynthese($id_structure);
        $this->assertNull($id_settings_synthese);
    }
}