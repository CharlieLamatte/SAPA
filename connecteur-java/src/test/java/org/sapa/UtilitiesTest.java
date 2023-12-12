package org.sapa;

import org.junit.Test;

import java.util.UUID;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertNotNull;
import static org.sapa.util.Utilities.*;
import static org.sapa.util.Utilities.loadSoapResponse;

public class UtilitiesTest {

    @Test
    public void testLoadContexteLPS() {
        siram.lps.ctxlps.ContexteLPS contexteLps = loadContexteLPS("example_data\\contexte\\ContexteLPS.xml");
        assertNotNull(contexteLps);
    }

    @Test
    public void testLoadContexteBAM() {
        siram.bam.ctxbam.ContexteBAM contexteBAM = loadContexteBAM("example_data\\contexte\\ContexteBAM.xml");
        assertNotNull(contexteBAM);
    }

    @Test
    public void testLoadSoapResponse() {
        fr.cnamts.insiresultat.Resultat resultat1 = loadSoapResponse("example_data\\REP_CR01.xml");
        assertNotNull(resultat1);

        fr.cnamts.insiresultat.Resultat resultat2 = loadSoapResponse("example_data\\TEST_1.10.xml");
        assertNotNull(resultat2);

        fr.cnamts.insiresultat.Resultat resultat3 = loadSoapResponse("example_data\\TEST_2.04_cas2.xml");
        assertNotNull(resultat3);

        fr.cnamts.insiresultat.Resultat resultat4 = loadSoapResponse("example_data\\TEST_2.05.xml");
        assertNotNull(resultat4);

        fr.cnamts.insiresultat.Resultat resultat5 = loadSoapResponse("example_data\\TEST_2.08_cas1.xml");
        assertNotNull(resultat5);

        fr.cnamts.insiresultat.Resultat resultat6 = loadSoapResponse("example_data\\TEST_2.08_cas2.xml");
        assertNotNull(resultat6);

        fr.cnamts.insiresultat.Resultat resultat7 = loadSoapResponse("example_data\\TEST_3.05_cas3.xml");
        assertNotNull(resultat7);
    }

    @Test
    public void testLoadInsiRecSansVitale() {
        fr.cnamts.insirecsans.TraitsDIdentite traits = loadInsiRecSansVitale("example_data\\WS_INS2_rechercherInsAvecTraitsIdentite_requete.xml");
        assertNotNull(traits);
    }

    @Test
    public void generateUUIDTest() {
        assertEquals(36, generateUUID().length());
    }
}
