package org.sapa.lps;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import javax.net.ssl.X509TrustManager;
import java.io.FileInputStream;
import java.io.IOException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.NoSuchProviderException;
import java.security.SignatureException;
import java.security.cert.*;

public class MyTrustManager implements X509TrustManager {

    private static final String COMMON_NAME_END = "services-ps.ameli.fr";
    private static final String COMMON_NAME_TLSMUT_END = "services-ps-tlsm.ameli.fr";
    private final String commonName;

    /**
     * Trace
     */
    private static final Logger log = LoggerFactory.getLogger(InsSoapClient.class);


    public MyTrustManager(String cn) {
        this.commonName = cn;
    }

    public MyTrustManager() {
        this.commonName = null;
    }

    public void checkClientTrusted(X509Certificate[] chain, String authType)
            throws CertificateException {
    }

    public void checkServerTrusted(X509Certificate[] chain, String authType)
            throws CertificateException {

        // Controle de validite de la chaine de certification
        // --------------------------------------------------

        for (int i = 0; i < chain.length; i++) {
            try {
                // Controle dates
                chain[i].checkValidity();
            } catch (CertificateExpiredException cee) {
                log.error("", cee);
                throw cee;
            } catch (CertificateNotYetValidException cnye) {
                log.error("", cnye);
                throw cnye;
            }
        }
        log.info("Controle de validite de la chaine de certification OK");


        // Chargement des certificats des autorites de certification
        // ---------------------------------------------------------

        X509Certificate caAut = null;
        FileInputStream fis = null;
        try {
            CertificateFactory cf = CertificateFactory.getInstance("X.509");
            fis = new FileInputStream("certificates/asip/ACI-EL-ORG.cer");
            caAut = (X509Certificate) cf.generateCertificate(fis);
        } catch (Exception ex) {
            ex.printStackTrace();
        } finally {
            try {
                fis.close();
            } catch (IOException ex) {
                ex.printStackTrace();
            }
        }

        if (caAut == null) {
            throw new CertificateException("Echec de chargement des certificats des autorites de certification");
        }

        String caAutDN = caAut.getSubjectX500Principal().getName();
        log.debug("DN du certificat des autorites de certification= " + caAutDN);

        // Recuperation du certificat serveur (par convention le premier de la chaine)
        // ---------------------------------------------------------------------------
        X509Certificate certServer = chain[0];


        // Controle de signature du certificat serveur a l'aide de la cle publique de l'autorite
        // -------------------------------------------------------------------------------------
        try {
            certServer.verify(caAut.getPublicKey());
        } catch (InvalidKeyException | NoSuchAlgorithmException | NoSuchProviderException | SignatureException e) {
            e.printStackTrace();
            throw new CertificateException("Echec de vérification de signature du certificat serveur a l'aide de la cle publique de l'autorite ");
        }
        log.info("Controle de la signature du certificat serveur OK");


        // Lecture du DN du serveur
        // -------------

        String tlsDN = certServer.getSubjectX500Principal().getName();
        log.debug("DN recu du serveur= " + tlsDN);


        // Controle du Common Name
        // -----------------------

        int begin = tlsDN.indexOf("=");
        if (begin != -1) {
            int end = tlsDN.indexOf(",");
            String tlsCN = tlsDN.substring(begin + 1, end);
            log.debug("CN= " + tlsCN);

            if (commonName != null) {
                if (!tlsCN.equals(commonName))
                    throw new CertificateException("Common Name invalide");
            } else {
                if (!(tlsCN.endsWith(COMMON_NAME_END) || tlsCN.endsWith(COMMON_NAME_TLSMUT_END)))
                    throw new CertificateException("Common Name invalide");
            }
        } else {
            throw new CertificateException("Common Name non trouve");
        }
        log.info("Controle du CN OK");

		// Controle de revocation du certificat serveur
		// --------------------------------------------
//
//		FileInputStream crlStream = null;
//		try {
//			// Chargement de la liste de revocation de l'ASIP
//			CertificateFactory certFactory = CertificateFactory.getInstance("X.509");
//        	crlStream = new FileInputStream("certificates/asip/ACI-EL-ORG.crl");
//        	X509CRL crl = (X509CRL) certFactory.generateCRL(crlStream);
//
//        	// Verifie que la CRL a ete signee par l'autorite de certification.
//        	crl.verify(caAut.getPublicKey());
//
//        	// Verifie si le certificat serveur est present dans la liste de revocation.
//        	if(crl.isRevoked(certServer)){
//				throw new CertificateException("Le certificat du serveur est revoque");
//			}
//
//        } catch (Exception ex) {
//        	ex.printStackTrace();
//        } finally {
//            try {
//            	crlStream.close();
//            } catch (IOException ex) {
//            	ex.printStackTrace();
//            }
//        }
//  		log.info("Certificat serveur non revoque: OK");
    }


    public X509Certificate[] getAcceptedIssuers() {
        return null;
    }

}
