package org.sapa.util;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import javax.xml.bind.JAXBContext;
import javax.xml.bind.JAXBElement;
import javax.xml.bind.JAXBException;
import javax.xml.bind.Unmarshaller;
import javax.xml.namespace.QName;
import javax.xml.stream.XMLInputFactory;
import javax.xml.stream.XMLStreamReader;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.util.UUID;

public class Utilities {
    private static final Logger log = LoggerFactory.getLogger(Utilities.class);

    public static fr.cnamts.insirecsans.TraitsDIdentite loadInsiRecSansVitale(String fileName) {
        log.info(">>getInsiRecSansVitale(" + fileName + ")");

        fr.cnamts.insirecsans.TraitsDIdentite assertion = new fr.cnamts.insirecsans.ObjectFactory().createTraitsDIdentite();
        try {
            JAXBContext context = JAXBContext
                    .newInstance("fr.cnamts.insirecsans");
            Unmarshaller u = context.createUnmarshaller();
            JAXBElement<fr.cnamts.insirecsans.TraitsDIdentite> jbEl = new JAXBElement(new QName("http://www.cnamts.fr/INSiRecSans",
                    "RECSANSVITALE"),
                    assertion.getClass(),
                    assertion);
            jbEl = (JAXBElement<fr.cnamts.insirecsans.TraitsDIdentite>) u.unmarshal(new FileInputStream(fileName));
            assertion = jbEl.getValue();
        } catch (FileNotFoundException e) {
            log.info("FileNotFoundException " + e);
            assertion = null;
        } catch (JAXBException e) {
            // On encapsule dans une exception non controlee
            log.info("RECSANSVITALE : JAXBException " + e);
            assertion = null;
        }
        log.info(assertion.toString());
        log.info("<<getInsiRecSansVitale");
        return assertion;
    }

    public static fr.cnamts.insiresultat.Resultat loadSoapResponse(String fileName) {
        log.info(">>loadSoapResponse(" + fileName + ")");

        fr.cnamts.insiresultat.Resultat assertion = new fr.cnamts.insiresultat.ObjectFactory().createResultat();
        try {
            XMLInputFactory xif = XMLInputFactory.newFactory();
            XMLStreamReader xsr = xif.createXMLStreamReader(new FileReader(fileName));
            xsr.nextTag(); // Advance to Envelope tag
            xsr.nextTag(); // Advance to Body tag
            xsr.nextTag(); // Advance to RESULTAT tag

            JAXBContext context = JAXBContext.newInstance("fr.cnamts.insiresultat");
            Unmarshaller unmarshaller = context.createUnmarshaller();
            JAXBElement<fr.cnamts.insiresultat.Resultat> jbEl = unmarshaller.unmarshal(xsr, fr.cnamts.insiresultat.Resultat.class);

            assertion = jbEl.getValue();
        } catch (Exception e) {
            log.info("loadSoapResponse Exception " + e);
            assertion = null;
        }
        log.info("<<loadSoapResponse");

        return assertion;
    }

    public static siram.lps.ctxlps.ContexteLPS loadContexteLPS(String fileName) {
        log.debug(">>getContexteLPS(" + fileName + ")");
        siram.lps.ctxlps.ContexteLPS assertion = new siram.lps.ctxlps.ContexteLPS();
        try {
            JAXBContext context = JAXBContext
                    .newInstance("siram.lps.ctxlps");
            Unmarshaller u = context.createUnmarshaller();
            JAXBElement<siram.lps.ctxlps.ContexteLPS> jbEl = new JAXBElement(new QName("urn:siram.lps.ctxlps",
                    "ContexteLPS"),
                    assertion.getClass(),
                    assertion);
            jbEl = (JAXBElement<siram.lps.ctxlps.ContexteLPS>) u.unmarshal(new FileInputStream(fileName));
            assertion = jbEl.getValue();
        } catch (FileNotFoundException e) {
            log.debug("ContexteLPS : FileNotFoundException " + e);
            assertion = null;
        } catch (JAXBException e) {
            // On encapsule dans une exception non controlee
            log.debug("ContexteLPS : JAXBException " + e);
            assertion = null;
        }
        log.debug("<<getContexteLPS");
        return assertion;
    }

    public static siram.bam.ctxbam.ContexteBAM loadContexteBAM(String fileName) {
        log.debug(">>getContexteBAM(" + fileName + ")");
        siram.bam.ctxbam.ContexteBAM assertion = new siram.bam.ctxbam.ContexteBAM();
        try {
            JAXBContext context = JAXBContext
                    .newInstance("siram.bam.ctxbam");
            Unmarshaller u = context.createUnmarshaller();
            JAXBElement<siram.bam.ctxbam.ContexteBAM> jbEl = new JAXBElement(new QName("urn:siram.bam.ctxbam",
                    "ContexteBAM"),
                    assertion.getClass(),
                    assertion);
            jbEl = (JAXBElement<siram.bam.ctxbam.ContexteBAM>) u.unmarshal(new FileInputStream(fileName));
            assertion = jbEl.getValue();
        } catch (FileNotFoundException e) {
            log.debug("FileNotFoundException " + e);
            assertion = null;
        } catch (JAXBException e) {
            // On encapsule dans une exception non controlee
            log.debug("ContexteBAM : JAXBException " + e);
            assertion = null;
        }
        log.debug("<<getContexteBAM");
        return assertion;
    }

    /**
     *
     * @return a UUID
     */
    public static String generateUUID() {
        return String.valueOf(UUID.randomUUID());
    }
}
