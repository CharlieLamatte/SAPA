/********************************************************
 *  CopyRight....: GIE SESAM VITALE - 2021              *
 *  projet.......: ICIRv1                *
 *  Summary......: Appele au service ICIR *
 *  Date.........: 16 juillet 2021                     *
 ********************************************************/

package org.sapa.pkcs12;

import java.io.FileNotFoundException;
import java.io.IOException;
import java.security.*;
import java.security.cert.CertificateException;
import java.security.cert.X509Certificate;

/**
 * Interface pour utiliser un certificat pkcs12
 * 
 */

public interface Pkcs12 {

	/**
	 * Fonction de connexion au certificat Pkcs12
	 * 
	 * @param certificate
	 *            le certificat Pkcs12
	 * @param pin
	 *            le code du certificat
	 * @throws KeyStoreException
	 * @throws NoSuchAlgorithmException
	 * @throws UnrecoverableKeyException
	 * @throws CertificateException
	 * @throws FileNotFoundException
	 * @throws IOException
	 */
	public void login(String certificate, String pin) throws KeyStoreException,
			NoSuchAlgorithmException, UnrecoverableKeyException,
			CertificateException, FileNotFoundException, IOException;

	/**
	 * Fonction effectuant la deconnexion du pkcs12
	 * 
	 * @throws Exception
	 */
	public void logout() throws Exception;

	/**
	 * Fonction effectuant la signature des donnees passees en parametre
	 * 
	 * @param data
	 *            les donnees a signer
	 * @return les donnees signees
	 */
	public byte[] sign(byte[] sign) throws Exception;

	public KeyStore getCaKs();

	public void setCaKs(KeyStore caKs);

	public String getPin();

	public void setPin(String pin);

	public PrivateKey getKey();

	public void setKey(PrivateKey key);

	public X509Certificate getCertificate();

	public void setCertificate(X509Certificate certificate);
}
