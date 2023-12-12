package org.sapa;

import fr.cnamts.insirecsans.TraitsDIdentite;
import org.junit.Test;

import org.junit.runner.RunWith;
import org.sapa.lps.InsSoapClient;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.test.context.junit4.SpringRunner;

import java.util.*;

import static org.junit.jupiter.api.Assertions.*;
import static org.sapa.lps.InsSoapClient.*;

@RunWith(SpringRunner.class)
@SpringBootTest(classes = {InsSoapClient.class})
public class ConformiteTest {

    @Autowired
    private InsSoapClient insSoapClient;

    @Test
    public void testCreateNewTraitsDIdentite() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "D'ARTAGNAN DE L'HERAULT",
                Collections.singletonList("PIERRE-ALAIN"),
                "M",
                "2001-06-17",
                "63220"
        );

       assertEquals("D'ARTAGNAN DE L'HERAULT", traitsDIdentite.getNomNaissance());
       assertEquals("M", traitsDIdentite.getSexe());
       assertEquals("2001-06-17", traitsDIdentite.getDateNaissance());
       assertEquals("63220", traitsDIdentite.getLieuNaissance());
       assertEquals("PIERRE-ALAIN", traitsDIdentite.getPrenom().get(0));
    }

    @Test
    public void testIsValidOkMinimumData() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-01"
        );
        assertTrue(isTraitsDIdentiteValid(traitsDIdentite));
    }

    @Test
    public void testIsValidOkAllData() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-01",
                "63220"
        );
        assertTrue(isTraitsDIdentiteValid(traitsDIdentite));
    }

    @Test
    public void testIsValidNotOkEmpty() {
        fr.cnamts.insirecsans.TraitsDIdentite empty = new TraitsDIdentite();
        assertFalse(isTraitsDIdentiteValid(empty));
    }

    @Test
    public void testIsValidNotOkNomNaissanceMissing() {
        fr.cnamts.insirecsans.TraitsDIdentite nomNaissanceEmpty = createNewTraitsDIdentite(
                "",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(nomNaissanceEmpty));

        fr.cnamts.insirecsans.TraitsDIdentite nomNaissanceNull = createNewTraitsDIdentite(
                null,
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(nomNaissanceNull));
    }

    @Test
    public void testIsValidNotOkNomNaissanceInvalid() {
        fr.cnamts.insirecsans.TraitsDIdentite contientMinuscule = createNewTraitsDIdentite(
                "ADRDEUXa",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(contientMinuscule));

        fr.cnamts.insirecsans.TraitsDIdentite contientAccent = createNewTraitsDIdentite(
                "ADRDEUXé",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(contientAccent));

        fr.cnamts.insirecsans.TraitsDIdentite contientCharspecial = createNewTraitsDIdentite(
                "ADRD+EUX",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(contientCharspecial));
    }

    @Test
    public void testIsValidNotOkPrenomMissing() {
        fr.cnamts.insirecsans.TraitsDIdentite prenomEmpty = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList(""),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(prenomEmpty));
    }

    @Test
    public void testIsValidNotOkPrenomInvalid() {
        fr.cnamts.insirecsans.TraitsDIdentite contientMinuscule = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURaENT"),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(contientMinuscule));

        fr.cnamts.insirecsans.TraitsDIdentite contientAccent = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAUREéNT"),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(contientAccent));

        fr.cnamts.insirecsans.TraitsDIdentite contientCharspecial = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAUR+ENT"),
                "M",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(contientCharspecial));
    }

    @Test
    public void testIsValidNotOkDateNaissanceMissing() {
        fr.cnamts.insirecsans.TraitsDIdentite dateNaissanceEmpty = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                ""
        );
        assertFalse(isTraitsDIdentiteValid(dateNaissanceEmpty));

        fr.cnamts.insirecsans.TraitsDIdentite dateNaissanceNull = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                null
        );
        assertFalse(isTraitsDIdentiteValid(dateNaissanceNull));
    }

    @Test
    public void testIsValidNotOkDateNaissanceInvalid() {
        fr.cnamts.insirecsans.TraitsDIdentite formatInvalide = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                "01/01/1981"
        );
        assertFalse(isTraitsDIdentiteValid(formatInvalide));

        fr.cnamts.insirecsans.TraitsDIdentite moisInvalide = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-13-01"
        );
        assertFalse(isTraitsDIdentiteValid(moisInvalide));

        fr.cnamts.insirecsans.TraitsDIdentite jourInvalide = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-32"
        );
        assertFalse(isTraitsDIdentiteValid(jourInvalide));

        fr.cnamts.insirecsans.TraitsDIdentite charInvalide1 = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                "198z-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(charInvalide1));

        fr.cnamts.insirecsans.TraitsDIdentite charInvalide2 = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-0z-01"
        );
        assertFalse(isTraitsDIdentiteValid(charInvalide2));

        fr.cnamts.insirecsans.TraitsDIdentite charInvalide3 = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "M",
                "1981-01-0a"
        );
        assertFalse(isTraitsDIdentiteValid(charInvalide3));
    }

    @Test
    public void testIsValidNotOkSexeMissing() {
        fr.cnamts.insirecsans.TraitsDIdentite sexeEmpty = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(sexeEmpty));

        fr.cnamts.insirecsans.TraitsDIdentite sexeNull = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                null,
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(sexeNull));
    }

    @Test
    public void testIsValidNotOkSexeInvalid() {
        fr.cnamts.insirecsans.TraitsDIdentite sexeMinuscule1 = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "m",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(sexeMinuscule1));

        fr.cnamts.insirecsans.TraitsDIdentite sexeMinuscule2 = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "f",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(sexeMinuscule2));

        fr.cnamts.insirecsans.TraitsDIdentite sexeLettreInvalide = createNewTraitsDIdentite(
                "ADRDEUX",
                Collections.singletonList("LAURENT"),
                "A",
                "1981-01-01"
        );
        assertFalse(isTraitsDIdentiteValid(sexeLettreInvalide));
    }

    @Test
    public void testIsValidOkTest2_03_Cas1() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "D'ARTAGNAN DE L'HERAULT",
                Collections.singletonList("PIERRE-ALAIN"),
                "M",
                "2001-06-17",
                "63220"
        );
        assertTrue(isTraitsDIdentiteValid(traitsDIdentite));
    }

    @Test
    public void testIsValidOkTest2_03_Cas2() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "ADRTROIS",
                Collections.singletonList("TOUSSAINT"),
                "M",
                "1960-01-01",
                "2B020"
        );
        assertTrue(isTraitsDIdentiteValid(traitsDIdentite));
    }

    @Test
    public void testIsValidNotOkTest2_03_Cas3() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "D’ÆION",
                Collections.singletonList("CŒUR"),
                "M",
                "1987-01-01",
                "2B020"
        );
        assertFalse(isTraitsDIdentiteValid(traitsDIdentite));
    }

    @Test
    public void testFindIns2_03_Cas1() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "D'ARTAGNAN DE L'HERAULT",
                Collections.singletonList("PIERRE-ALAIN"),
                "M",
                "2001-06-17",
                "63220"
        );

        this.insSoapClient.setTypeCertificat(TypeCertificat.INSI_AUTO);
        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
    }

    @Test
    public void testFindIns2_03_Cas2() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "ADRTROIS",
                Collections.singletonList("TOUSSAINT"),
                "M",
                "1960-01-01",
                "2B020"
        );

        this.insSoapClient.setTypeCertificat(TypeCertificat.INSI_AUTO);
        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
    }

    @Test
    public void testFindIns2_03_Cas3() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "D’ÆION", // Æ invalide
                Collections.singletonList("CŒUR"), // Œ invalide
                "M",
                "1987-01-01",
                "2B020"
        );

        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNull(resultat);
    }

    @Test
    public void testFindIns2_04_Cas1() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "ECETINSI",
                Collections.singletonList("PIERRE-ALAIN"),
                "M",
                "2009-07-14"
        );

        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
    }

    @Test
    public void testFindIns2_04_Cas2() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "ECETINSI",
                Collections.singletonList("PIERRE-ALAIN"),
                "M",
                "2009-07-14"
        );

        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
    }

    @Test
    public void testFindIns2_05() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "PROVISOIRE",
                Collections.singletonList("MATRICULE"),
                "M",
                "2009-07-01"
        );

        // ce test renvoie une erreur technique
        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
    }

    @Test
    public void testFindIns2_06_Cas1() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "DE VINCI",
                Collections.singletonList("LEONARDO"),
                "M",
                "2014-02-01"
        );

        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
        assertEquals("02", resultat.getCR().getCodeCR());
    }

    @Test
    public void testFindIns2_06_Cas2() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "DE VINCI",
                Collections.singletonList("LEONARDO"),
                "M",
                "2014-02-01",
                "63220"
        );

        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
        assertEquals("00", resultat.getCR().getCodeCR());
    }

    @Test
    public void testFindIns2_07_Cas1() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "TCHITCHI",
                Arrays.asList("OLA", "CATARINA", "BELLA"),
                "F",
                "1936-06-21"
        );

        this.insSoapClient.setInjectRep01AfterSoapFault(true);
        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
        assertEquals("00", resultat.getCR().getCodeCR());
    }

    @Test
    public void testFindIns2_07_Cas2() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "HOUILLES",
                Arrays.asList("PIERRE", "PAUL", "JACQUES"),
                "M",
                "1993-01-27"
        );
        assertTrue(isTraitsDIdentiteValid(traitsDIdentite));

        this.insSoapClient.setInjectRep01AfterSoapFault(true);
        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
        assertEquals("01", resultat.getCR().getCodeCR());
    }

    @Test
    public void testFindIns2_08_Cas1() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "CORSE",
                Collections.singletonList("ANTHONY"),
                "M",
                "1980-03-02"
        );
        assertTrue(isTraitsDIdentiteValid(traitsDIdentite));

        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
    }

    @Test
    public void testFindIns2_08_Cas2() {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                "HERMAN",
                Collections.singletonList("GATIEN"),
                "M",
                "1981-03-24"
        );
        assertTrue(isTraitsDIdentiteValid(traitsDIdentite));

        fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(traitsDIdentite);
        assertNotNull(resultat);
    }
}