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
import java.security.cert.Certificate;
import java.security.cert.CertificateException;
import java.security.cert.X509Certificate;


/**
 * Implementation du pkcs12 permettant de charger un certificat
 */
public class Pkcs12Impl implements Pkcs12 {

    private KeyStore caKs;

    private String pin;
    private String aliase;

    private PrivateKey key;
    private X509Certificate certificate;
    private Certificate[] certificateChain;

    public void login(String certificateFile, String pin)
            throws KeyStoreException, NoSuchAlgorithmException,
            UnrecoverableKeyException, CertificateException,
            FileNotFoundException, IOException {

        this.pin = pin;

        // recuperation de l'instance du depot de cle gerant les certificats
        // PKCS12
        caKs = KeyStore.getInstance("PKCS12");

        // on initialise le depot avec le certificat fourni en entree
        caKs.load(new java.io.FileInputStream(certificateFile), pin
                .toCharArray());

        // on recupere le premier alias
        aliase = caKs.aliases().nextElement();

        // on recupere la cle de l'alias
        key = (PrivateKey) caKs.getKey(aliase, pin.toCharArray());

        // on recupere le certificat du premier alias
        certificate = (X509Certificate) caKs.getCertificate(aliase);

        certificateChain = caKs.getCertificateChain(aliase);

    }

    public byte[] sign(byte[] dataSign) throws KeyStoreException,
            UnrecoverableKeyException, NoSuchAlgorithmException,
            InvalidKeyException, SignatureException {
        byte[] dataSigned = null;
        // on signe
        Signature sign = Signature.getInstance("SHA1withRSA");

        // on initialise la signature avec la cle du certificat
        sign.initSign(key);

        // on hash et signe les donnees
        sign.update(dataSign);
        dataSigned = sign.sign();

        // on renvoit le hash signe
        return dataSigned;
    }

    public void logout() {
        setCaKs(null);
    }

    public PrivateKey getKey() {
        return key;
    }

    public void setKey(PrivateKey key) {
        this.key = key;
    }

    public X509Certificate getCertificate() {
        return certificate;
    }

    public void setCertificate(X509Certificate certificate) {
        this.certificate = certificate;
    }

    public KeyStore getCaKs() {
        return caKs;
    }

    public void setCaKs(KeyStore caKs) {
        this.caKs = caKs;
    }

    public String getPin() {
        return pin;
    }

    public void setPin(String pin) {
        this.pin = pin;
    }

    public Certificate[] getCertificateChain() {
        return certificateChain;
    }

    public void setCertificateChain(Certificate[] certificateChain) {
        this.certificateChain = certificateChain;
    }

}
