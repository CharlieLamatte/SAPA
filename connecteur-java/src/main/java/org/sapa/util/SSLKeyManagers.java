package org.sapa.util;


import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import javax.net.ssl.X509ExtendedKeyManager;
import java.net.Socket;
import java.security.Principal;
import java.security.PrivateKey;
import java.security.cert.X509Certificate;


/**
 * Gestionnaire de cle pour l'etablissement du canal SSL
 * 
 */
public class SSLKeyManagers extends X509ExtendedKeyManager {

	private static final Logger log = LoggerFactory.getLogger(SSLKeyManagers.class);

	String aliasForAuthentification = "authentification";
	X509Certificate[] authentificationCertificateChain;
	PrivateKey privateKey;

	/**
	 * constructeur
	 * 
	 * @param ks
	 *            keystore CPS ou logiciel
	 * @param password
	 *            mot de passe d'ouverture ou code PIN
	 * @throws DPConfigurationException
	 *             erreur de configuration
	 */
	public SSLKeyManagers(X509Certificate[] authentificationCertificateChain,
			PrivateKey privateKey) {
		this.authentificationCertificateChain = authentificationCertificateChain;
		this.privateKey = privateKey;
	}

	public String chooseClientAlias(String[] keyType, Principal[] issuers,
			Socket socket) {
		return aliasForAuthentification;

	}

	public String chooseServerAlias(String keyType, Principal[] issuers,
			Socket socket) {
		return null;
	}

	public X509Certificate[] getCertificateChain(String alias) {
		return authentificationCertificateChain;
	}

	public String[] getClientAliases(String keyType, Principal[] issuers) {
		return new String[] { aliasForAuthentification };
	}

	public PrivateKey getPrivateKey(String alias) {
		return privateKey;
	}

	public String[] getServerAliases(String keyType, Principal[] issuers) {
		// TODO Auto-generated method stub
		return null;
	}

}
