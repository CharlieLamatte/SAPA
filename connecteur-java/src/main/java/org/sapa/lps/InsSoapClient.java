package org.sapa.lps;


import fr.cnamts.insirecsans.TraitsDIdentite;
import org.sapa.pkcs12.Pkcs12Impl;
import org.sapa.util.SSLKeyManagers;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.env.Environment;
import org.springframework.stereotype.Component;

import javax.annotation.PostConstruct;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.KeyManager;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.xml.datatype.DatatypeFactory;
import javax.xml.datatype.XMLGregorianCalendar;
import javax.xml.namespace.QName;
import javax.xml.soap.DetailEntry;
import javax.xml.soap.SOAPFault;
import javax.xml.ws.BindingProvider;
import javax.xml.ws.handler.Handler;
import javax.xml.ws.soap.SOAPFaultException;
import java.security.cert.X509Certificate;
import java.time.format.DateTimeFormatter;
import java.time.format.ResolverStyle;
import java.util.*;
import java.util.regex.Pattern;
import java.time.LocalDate;

import static org.sapa.util.Utilities.generateUUID;
import static org.sapa.util.Utilities.loadSoapResponse;

@Component
public class InsSoapClient {
    private static final Logger log = LoggerFactory.getLogger(InsSoapClient.class);

    private final static String PREFIXE_ACTION = "urn:ServiceIdentiteCertifiee:1.0.0:";

    @Autowired
    private Environment env;

    private siram.lps.ctxlps.ContexteLPS contexteLPS;

    private siram.bam.ctxbam.ContexteBAM contexteBAM;

    public enum TypeCertificat {
        INSI_MANU,
        INSI_AUTO
    }

    /**
     * Le type de certificat utilisé pour
     * Par défaut INSI_MANU
     */
    private TypeCertificat typeCertificat = TypeCertificat.INSI_MANU;

    /**
     * Si on injecte le fichier REP_CR01.xml pour simuler une réponse si il y a une faute SOAP
     */
    private boolean injectRep01AfterSoapFault = false;

    @PostConstruct
    public void init() {
        this.contexteLPS = createNewContexteLPS();
    }

    public TypeCertificat getTypeCertificat() {
        return typeCertificat;
    }

    public void setTypeCertificat(TypeCertificat typeCertificat) {
        this.typeCertificat = typeCertificat;
    }

    public boolean isInjectRep01AfterSoapFault() {
        return injectRep01AfterSoapFault;
    }

    public void setInjectRep01AfterSoapFault(boolean injectRep01AfterSoapFault) {
        this.injectRep01AfterSoapFault = injectRep01AfterSoapFault;
    }

    private void setUpProxySSL() throws Exception {
        System.setProperty("java.net.useSystemProxies", "true");
        // keyManager pour l'authentification TLS
        KeyManager[] managers = null;
        managers = new KeyManager[1];
        X509Certificate[] certificatesChain = new X509Certificate[1];
        Pkcs12Impl pkcs12 = new Pkcs12Impl();

        String certificatPath = null;
        String certificatPassword = null;

        switch (this.getTypeCertificat()) {
            case INSI_AUTO:
                certificatPath = "certificates/" + env.getProperty("sapa.insi.p12-auto.path");
                certificatPassword = env.getProperty("sapa.insi.p12-auto.password");
                break;
            case INSI_MANU:
                certificatPath = "certificates/" + env.getProperty("sapa.insi.p12-manu.path");
                certificatPassword = env.getProperty("sapa.insi.p12-manu.password");
                break;
        }

        if (certificatPassword == null) {
            throw new Exception("Le mot de passe du certificat est null");
        }

        pkcs12.login(certificatPath, certificatPassword);
        certificatesChain[0] = pkcs12.getCertificate();

        if (log.isDebugEnabled()) {
            String certificatLogicielDN = certificatesChain[0].getSubjectX500Principal().getName();
            log.debug("DN du certificat logiciel= " + certificatLogicielDN);
        }

        managers[0] = new SSLKeyManagers(certificatesChain, pkcs12
                .getKey());

        TrustManager[] trustCerts = new TrustManager[]{
                new MyTrustManager() // s'assure que le cn se termine bien par ...services-ps.ameli.fr
        };

        SSLContext sc = null;
        try {
            sc = SSLContext.getInstance("TLS");
            sc.init(managers, trustCerts, /*new java.security.SecureRandom()*/null);
            HttpsURLConnection.setDefaultSSLSocketFactory(sc.getSocketFactory());
        } catch (Exception e) {
            log.error("", e);
            throw e;
        }
    }

    /**
     * Création d'un contexteLPS initialisé avec les variables d'environnement
     *
     * @return siram.lps.ctxlps.ContexteLPS Le contexteLPS
     */
    private siram.lps.ctxlps.ContexteLPS createNewContexteLPS() {
        siram.lps.ctxlps.ContexteLPS contexteLPS = new siram.lps.ctxlps.ContexteLPS();

        try {
            siram.lps.ctxlps.IdentiteStringRef identiteStringRef = new siram.lps.ctxlps.IdentiteStringRef();
            identiteStringRef.setR("4");
            identiteStringRef.setValue(env.getProperty("sapa.insi.lps.numeroAutorisation"));

            siram.lps.ctxlps.LOGICIEL logiciel = new siram.lps.ctxlps.LOGICIEL();
            logiciel.setIDAM(identiteStringRef);
            logiciel.setInstance(env.getProperty("sapa.insi.lps.instance"));
            logiciel.setNom("urn:lps:" + env.getProperty("sapa.insi.lps.nom") + ":" + env.getProperty("sapa.insi.lps.version"));
            logiciel.setVersion(env.getProperty("sapa.insi.lps.version"));

            contexteLPS.setLPS(logiciel);
            contexteLPS.setEmetteur(env.getProperty("sapa.insi.lps.emetteur"));
            contexteLPS.setNature("CTXLPS");
            contexteLPS.setVersion("01_00");
            contexteLPS.setId(generateUUID());
            GregorianCalendar now = new GregorianCalendar();
            XMLGregorianCalendar xmlGregorianCalendar = DatatypeFactory.newInstance().newXMLGregorianCalendar(now);
            contexteLPS.setTemps(xmlGregorianCalendar);

            log.info("contexteLPS initialised");
        } catch (Exception e) {
            log.error("Exception initialising contexteLPS: " + e);
            contexteLPS = null;
        }

        return contexteLPS;
    }


    /**
     * Création d'un contexteBAM initialisé avec les variables d'environnement
     *
     * @return siram.bam.ctxbam.ContexteBAM Le contexteBAM
     */
    private siram.bam.ctxbam.ContexteBAM createNewContexteBAM() {
        siram.bam.ctxbam.ContexteBAM contexteBAM = new siram.bam.ctxbam.ContexteBAM();

        try {
            siram.bam.ctxbam.Couverture couverture = new siram.bam.ctxbam.Couverture();

            // cadre d’intéropérabilité – 4.2.1 – page 45
            contexteBAM.setVersion("01_02");
            contexteBAM.setNature("CTXBAM");
            contexteBAM.setEmetteur(env.getProperty("sapa.insi.lps.emetteur"));
            contexteBAM.setCOUVERTURE(couverture);
            contexteBAM.setId(generateUUID());
            GregorianCalendar now = new GregorianCalendar();
            XMLGregorianCalendar xmlGregorianCalendar = DatatypeFactory.newInstance().newXMLGregorianCalendar(now);
            contexteBAM.setTemps(xmlGregorianCalendar);

            log.info("contexteBAM initialised");
        } catch (Exception e) {
            log.error("Exception initialising contexteBAM:  " + e);
            contexteBAM = null;
        }

        return contexteBAM;
    }

    private static void logSoapFault(SOAPFaultException e) {
        if (e.getFault().getFaultRole() != null) {
            log.debug("Role : " + e.getFault().getFaultRole());
        }
        if (e.getFault().getFaultCode() != null) {
            log.debug("Code : " + e.getFault().getFaultCode());
        }
        Iterator subCodeList = e.getFault().getFaultSubcodes();
        while (subCodeList.hasNext()) {
            String subCodeText = ((QName) subCodeList.next()).toString();
            if (subCodeText != null) {
                log.debug("subCode : " + subCodeText);
            }
        }
        if (e.getFault().getFaultString() != null) {
            log.debug("texte : " + e.getFault().getFaultString());
        }
        if (e.getCause() != null) {
            log.debug("Cause : " + e.getCause());
        }
        try {
            SOAPFault faute = e.getFault();
            log.debug("SOAPFaultException : Code = " + faute.getFaultCode()
                    + " - Reason text = " + faute.getFaultString());

            Iterator subCodeList1 = faute.getFaultSubcodes();
            while (subCodeList1.hasNext()) {
                String subCodeText = ((QName) subCodeList1.next()).toString();
                if (subCodeText != null) {
                    log.debug("                     - subCodeText = " + subCodeText);
                }
            }

            // recuperation de l'element Erreur dans le detail de la faute soap
            if (faute.getDetail().hasChildNodes()) {
                Iterator listeDetail = faute.getDetail().getDetailEntries();
                while (listeDetail.hasNext()) {
                    DetailEntry d = (DetailEntry) listeDetail.next();
                    log.debug("DetailEntry = " + d.getElementName().getLocalName());
                    if (d.getElementName().getLocalName().equals("Erreur")) {
                        String code = d.getAttributeValue(new QName("code"));
                        String messageID = d.getAttributeValue(new QName("messageID"));
                        String severite = d.getAttributeValue(new QName("severite"));
                        String value = d.getValue();
                        log.debug("value = " + value);
                        log.debug("code = " + code + ", messageID = " + messageID + ", severite = " + severite);
                    }
                }
            }

        } catch (Exception ex) {
            log.debug("Erreur sur detail faute SOAP", ex);
        }
    }

    public static fr.cnamts.insirecsans.TraitsDIdentite createNewTraitsDIdentite(
            String nomNaissance,
            List<String> prenoms,
            String sexe,
            String dateNaissance) {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = new TraitsDIdentite();
        traitsDIdentite.setNomNaissance(nomNaissance);
        for (String prenom : prenoms) {
            traitsDIdentite.getPrenom().add(prenom);
        }

        traitsDIdentite.setSexe(sexe);
        traitsDIdentite.setDateNaissance(dateNaissance);

        return traitsDIdentite;
    }

    public static fr.cnamts.insirecsans.TraitsDIdentite createNewTraitsDIdentite(
            String nomNaissance,
            List<String> prenoms,
            String sexe,
            String dateNaissance,
            String lieuNaissance) {
        fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite = createNewTraitsDIdentite(
                nomNaissance,
                prenoms,
                sexe,
                dateNaissance);
        traitsDIdentite.setLieuNaissance(lieuNaissance);

        return traitsDIdentite;
    }

    public static boolean isTraitsDIdentiteValid(fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite) {
        // verification que tous les champs obligatoires sont présents
        if (traitsDIdentite.getNomNaissance() == null ||
                traitsDIdentite.getPrenom() == null || traitsDIdentite.getPrenom().isEmpty() ||
                traitsDIdentite.getDateNaissance() == null ||
                traitsDIdentite.getSexe() == null) {
            log.debug("Au moins un champ obligatoire du trait d'identité n'est pas présent");
            return false;
        }
        for (String prenom : traitsDIdentite.getPrenom()) {
            if (prenom == null) {
                log.debug("Au moins un des prénoms est null");
                return false;
            }
        }

        // verification du format du nom de naissance
        // charactères valides: lettres majuscules, -, ', et espace
        Pattern pNom = Pattern.compile("^[A-Z\\-' ]+$");
        if (!pNom.matcher(traitsDIdentite.getNomNaissance()).matches()) {
            log.debug("Le nom " + traitsDIdentite.getNomNaissance() + " est invalide");
            return false;
        }

        // verification du format des noms et prénoms
        // charactères valides: lettres majuscules, -, et '
        Pattern pPrenom = Pattern.compile("^[A-Z\\-']+$");
        for (String prenom : traitsDIdentite.getPrenom()) {
            if (!pPrenom.matcher(prenom).matches()) {
                log.debug("Le prénom " + prenom + " est invalide");
                return false;
            }
        }

        // verification du format du sexe
        Pattern pSexe = Pattern.compile("^[FM]$");
        if (!pSexe.matcher(traitsDIdentite.getSexe()).matches()) {
            log.debug("Le sexe " + traitsDIdentite.getSexe() + " est invalide");
            return false;
        }

        // verification du format de la date
        try {
            // ResolverStyle.STRICT for 30, 31 days checking, and also leap year.
            LocalDate.parse(traitsDIdentite.getDateNaissance(),
                    DateTimeFormatter.ofPattern("uuuu-M-d")
                            .withResolverStyle(ResolverStyle.STRICT)
            );

        } catch (Exception e) {
            log.debug("La date " + traitsDIdentite.getDateNaissance() + " est invalide");
            return false;
        }

        return true;
    }

    public fr.cnamts.insiresultat.Resultat findINS(fr.cnamts.insirecsans.TraitsDIdentite traitsDIdentite) {
        fr.cnamts.insiresultat.Resultat resultat = null;

        if (!isTraitsDIdentiteValid(traitsDIdentite)) {
            return null;
        }

        // init contexteBAM
        this.contexteBAM = createNewContexteBAM();

        // init WebService
        fr.cnamts.webservice.ICIRV1 monService = new fr.cnamts.webservice.ICIRV1();

        List<Handler> handlersChain = new ArrayList<Handler>(2);
        handlersChain.add(new INSSoapHandler());

        fr.cnamts.webservice.ICIRService monInterfaceService = monService.getICIRService(new javax.xml.ws.soap.AddressingFeature());

        ((BindingProvider) monInterfaceService).getBinding().setHandlerChain(handlersChain);

        org.oasis_open.docs.wss._2004._01.oasis_200401_wss_wssecurity_secext_1_0.TypeSecurity security = new org.oasis_open.docs.wss._2004._01.oasis_200401_wss_wssecurity_secext_1_0.TypeSecurity();

        org.w3._2005._08.addressing.AttributedURIType messageId = new org.w3._2005._08.addressing.AttributedURIType();
        org.w3._2005._08.addressing.AttributedURIType action = new org.w3._2005._08.addressing.AttributedURIType();

        try {
            this.setUpProxySSL();
            ((BindingProvider) monInterfaceService).getRequestContext().put(BindingProvider.ENDPOINT_ADDRESS_PROPERTY, env.getProperty("sapa.insi.url"));

            try {
                // appel au service INS pour chaque prénom dans l'ordre (si la personne n'est pas trouvé)
                for (String prenom : traitsDIdentite.getPrenom()) {
                    fr.cnamts.insirecsans.TraitsDIdentite traitsUnPrenom = createNewTraitsDIdentite(
                            traitsDIdentite.getNomNaissance(),
                            Collections.singletonList(prenom), // un seul prénom
                            traitsDIdentite.getSexe(),
                            traitsDIdentite.getDateNaissance(),
                            traitsDIdentite.getLieuNaissance()
                    );

                    messageId.setValue("uuid:" + generateUUID());
                    action.setValue(PREFIXE_ACTION + "rechercherInsAvecTraitsIdentite");

                    // on lance la recherche
                    // et en cas d'erreur on injecte REP_CR01.xml comme réponse si injectRep01AfterSoapFault est true et qu'il y a une faute
                    try {
                        resultat = monInterfaceService.rechercherInsAvecTraitsIdentite(traitsUnPrenom, security, this.contexteLPS, messageId, this.contexteBAM);
                    } catch (Exception exception) {
                        if (this.isInjectRep01AfterSoapFault()) {
                            resultat = loadSoapResponse("example_data/REP_CR01.xml");
                        } else {
                            throw exception;
                        }
                    }

                    try {
                        // si le patient a été trouvé on arrete la recherche
                        if (resultat.getCR().getCodeCR().equals("00")) {
                            break;
                        }
                    } catch (NullPointerException reponse) {
                        log.error("Reponse null", reponse);
                    }
                }

                // si l'individu a plusieurs prénoms et
                // n'a pas été trouvé avec les prénons séparément, appel INS avec tous les prénoms
                if (traitsDIdentite.getPrenom().size() > 1 &&
                        (resultat == null || resultat.getCR() == null || !resultat.getCR().getCodeCR().equals("00"))) {
                    fr.cnamts.insirecsans.TraitsDIdentite traitsTousPrenoms = createNewTraitsDIdentite(
                            traitsDIdentite.getNomNaissance(),
                            Collections.singletonList(String.join(" ", traitsDIdentite.getPrenom())), // tous les prénoms dans l'ordre séparés par un espace
                            traitsDIdentite.getSexe(),
                            traitsDIdentite.getDateNaissance(),
                            traitsDIdentite.getLieuNaissance()
                    );

                    messageId.setValue("uuid:" + generateUUID());
                    action.setValue(PREFIXE_ACTION + "rechercherInsAvecTraitsIdentite");

                    // on lance la recherche avec tous les prénoms
                    // et en cas d'erreur on injecte REP_CR01.xml comme réponse si injectRep01AfterSoapFault est true et qu'il y a une faute
                    try {
                        resultat = monInterfaceService.rechercherInsAvecTraitsIdentite(traitsTousPrenoms, security, this.contexteLPS, messageId, this.contexteBAM);
                    } catch (Exception exception) {
                        if (this.isInjectRep01AfterSoapFault()) {
                            resultat = loadSoapResponse("example_data/REP_CR01.xml");
                        } else {
                            throw exception;
                        }
                    }
                }
            } catch (SOAPFaultException e) {
                log.error("Faute SOAP operation findINS - " + e.toString());
                logSoapFault(e);
            }
        } catch (Exception e) {
            log.error("Exception SOAP operation findINS - " + e);
        }

        return resultat;
    }
}
