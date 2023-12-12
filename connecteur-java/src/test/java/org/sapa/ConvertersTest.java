package org.sapa;

import org.junit.Test;

import static org.junit.jupiter.api.Assertions.assertNotNull;
import static org.sapa.util.Converters.convertResultat;
import static org.sapa.util.Utilities.loadSoapResponse;

public class ConvertersTest {

    @Test
    public void testConvertResultat() {
        fr.cnamts.insiresultat.Resultat resultat1 = loadSoapResponse("example_data/REP_CR01.xml");
        assertNotNull(resultat1);
        assertNotNull(convertResultat(resultat1));

        fr.cnamts.insiresultat.Resultat resultat3 = loadSoapResponse("example_data/TEST_2.04_cas2.xml");
        assertNotNull(convertResultat(resultat3));

        fr.cnamts.insiresultat.Resultat resultat4 = loadSoapResponse("example_data/TEST_2.05.xml");
        assertNotNull(convertResultat(resultat4));

        fr.cnamts.insiresultat.Resultat resultat5 = loadSoapResponse("example_data/TEST_2.08_cas1.xml");
        assertNotNull(convertResultat(resultat5));

        fr.cnamts.insiresultat.Resultat resultat6 = loadSoapResponse("example_data/TEST_2.08_cas2.xml");
        assertNotNull(convertResultat(resultat6));
    }
}
