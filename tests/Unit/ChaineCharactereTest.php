<?php

namespace Tests\Unit;

use Sportsante86\Sapa\Outils\ChaineCharactere;
use Tests\Support\UnitTester;

class ChaineCharactereTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testStr_shuffle_unicodeOkEmpty()
    {
        $not_shuffled = "";
        $shuffled = ChaineCharactere::str_shuffle_unicode($not_shuffled);
        $this->assertEquals("", $shuffled);
    }

    public function testStr_shuffle_unicodeOkNull()
    {
        $not_shuffled = null;
        $shuffled = ChaineCharactere::str_shuffle_unicode($not_shuffled);
        $this->assertEquals("", $shuffled);
    }

    public function testStr_shuffle_unicodeOk()
    {
        // test1
        $not_shuffled = "ésdfsdfsdfgsdfgsdfglmkfgmlhkfghfghgmlkjfgh";
        $shuffled = ChaineCharactere::str_shuffle_unicode($not_shuffled);
        $this->assertTrue(str_contains($shuffled, "é"));
        $this->assertEquals(strlen($not_shuffled), strlen($shuffled));
        $this->assertNotEquals($not_shuffled, $shuffled, "Cet assertion peut très rarement échoué");

        // test2
        $not_shuffled = "éèôsdfsdfsdfgsdfgsdfglmkfgmlhkfghfghgmlkjfgh";
        $shuffled = ChaineCharactere::str_shuffle_unicode($not_shuffled);
        $this->assertTrue(str_contains($shuffled, "é"));
        $this->assertTrue(str_contains($shuffled, "è"));
        $this->assertTrue(str_contains($shuffled, "ô"));
        $this->assertEquals(strlen($not_shuffled), strlen($shuffled));
        $this->assertNotEquals($not_shuffled, $shuffled, "Cet assertion peut très rarement échoué");
    }

    public function testMb_ucfirstOkEmpty()
    {
        $string = "";
        $result = ChaineCharactere::mb_ucfirst($string);
        $this->assertEquals("", $result);
    }

    public function testMb_ucfirstOk()
    {
        // test 1
        $string = "ésdfé";
        $result = ChaineCharactere::mb_ucfirst($string);
        $this->assertEquals("Ésdfé", $result);

        // test 2
        $string = "èsdfé";
        $result = ChaineCharactere::mb_ucfirst($string);
        $this->assertEquals("Èsdfé", $result);

        // test 3
        $string = "ôsdfé";
        $result = ChaineCharactere::mb_ucfirst($string);
        $this->assertEquals("Ôsdfé", $result);

        // test 4
        $string = "çsdfé";
        $result = ChaineCharactere::mb_ucfirst($string);
        $this->assertEquals("Çsdfé", $result);

        // test 5
        $string = "esdfé";
        $result = ChaineCharactere::mb_ucfirst($string);
        $this->assertEquals("Esdfé", $result);
    }

    public function testRemove_accentsOk()
    {
        // test 1
        $string = "ésdfé";
        $result = ChaineCharactere::remove_accents($string);
        $this->assertEquals("esdfe", $result);

        // test 2
        $string = "ôsdfï";
        $result = ChaineCharactere::remove_accents($string);
        $this->assertEquals("osdfi", $result);

        // test 2
        $string = "ÉÈÔ";
        $result = ChaineCharactere::remove_accents($string);
        $this->assertEquals("EEO", $result);
    }

    public function testRemove_accentsOkEmpty()
    {
        $string = "";
        $result = ChaineCharactere::remove_accents($string);
        $this->assertEquals("", $result);
    }

    public function testRemove_accentsOkNull()
    {
        $string = null;
        $result = ChaineCharactere::remove_accents($string);
        $this->assertEquals("", $result);
    }

    public function testRemove_multiple_spacesOk()
    {
        // test 1
        $string = "ze  r";
        $result = ChaineCharactere::remove_multiple_spaces($string);
        $this->assertEquals("ze r", $result);

        // test 2
        $string = "ze     r";
        $result = ChaineCharactere::remove_multiple_spaces($string);
        $this->assertEquals("ze r", $result);

        // test 3
        $string = "         zer";
        $result = ChaineCharactere::remove_multiple_spaces($string);
        $this->assertEquals(" zer", $result);

        // test 4
        $string = "zer         ";
        $result = ChaineCharactere::remove_multiple_spaces($string);
        $this->assertEquals("zer ", $result);

        // test 5
        $string = "    z    e    r         ";
        $result = ChaineCharactere::remove_multiple_spaces($string);
        $this->assertEquals(" z e r ", $result);

        // test 6
        $string = "z er";
        $result = ChaineCharactere::remove_multiple_spaces($string);
        $this->assertEquals("z er", $result);
    }

    public function testRemove_multiple_spacesOkEmpty()
    {
        $string = "";
        $result = ChaineCharactere::remove_multiple_spaces($string);
        $this->assertEquals("", $result);
    }

    public function testRemove_multiple_spacesOkNull()
    {
        $string = null;
        $result = ChaineCharactere::remove_multiple_spaces($string);
        $this->assertEquals("", $result);
    }

    public function testRemove_invalid_ins_name_charactersOk()
    {
        // test 1
        $string = "<ÉÈÔ>çé()=+zer";
        $result = ChaineCharactere::remove_invalid_ins_name_characters($string);
        $this->assertEquals("zer", $result);

        // test 2
        $string = "zer";
        $result = ChaineCharactere::remove_invalid_ins_name_characters($string);
        $this->assertEquals("zer", $result);

        // test 3
        $string = "z er";
        $result = ChaineCharactere::remove_invalid_ins_name_characters($string);
        $this->assertEquals("z er", $result);
    }

    public function testRemove_invalid_ins_name_charactersOkEmpty()
    {
        $string = "";
        $result = ChaineCharactere::remove_invalid_ins_name_characters($string);
        $this->assertEquals("", $result);
    }

    public function testRemove_invalid_ins_name_charactersOkNull()
    {
        $string = null;
        $result = ChaineCharactere::remove_invalid_ins_name_characters($string);
        $this->assertEquals("", $result);
    }

    public function testFormat_compatible_insOk()
    {
        // test 1
        $string = "<ÉÈÔ>çé()=+zer'-";
        $result = ChaineCharactere::format_compatible_ins($string);
        $this->assertEquals("EEOCEZER'-", $result);

        // test 2
        $string = "zer";
        $result = ChaineCharactere::format_compatible_ins($string);
        $this->assertEquals("ZER", $result);

        // test 3
        $string = "z er";
        $result = ChaineCharactere::format_compatible_ins($string);
        $this->assertEquals("Z ER", $result);
    }

    public function testFormat_compatible_insOkEmpty()
    {
        $string = "";
        $result = ChaineCharactere::format_compatible_ins($string);
        $this->assertEquals("", $result);
    }

    public function testFormat_compatible_insOkNull()
    {
        $string = null;
        $result = ChaineCharactere::format_compatible_ins($string);
        $this->assertEquals("", $result);
    }
}