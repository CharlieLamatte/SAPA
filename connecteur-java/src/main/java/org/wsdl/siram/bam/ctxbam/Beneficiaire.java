
package siram.bam.ctxbam;

import java.math.BigInteger;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for Beneficiaire complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="Beneficiaire">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="Nir" type="{urn:siram:bam:ctxbam}NIRCertifie" minOccurs="0"/>
 *         &lt;element name="DateNai" type="{urn:siram:bam:ctxbam}DateLunaire" minOccurs="0"/>
 *         &lt;element name="Rang" type="{http://www.w3.org/2001/XMLSchema}integer" minOccurs="0"/>
 *         &lt;element name="Porteur" type="{urn:siram:bam:ctxbam}PATTERN0_CTXBAM_ContexteBAM_Beneficiaire_Porteur" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "Beneficiaire", propOrder = {
    "nir",
    "dateNai",
    "rang",
    "porteur"
})
public class Beneficiaire {

    @XmlElement(name = "Nir")
    protected NIRCertifie nir;
    @XmlElement(name = "DateNai")
    protected String dateNai;
    @XmlElement(name = "Rang")
    protected BigInteger rang;
    @XmlElement(name = "Porteur")
    protected String porteur;

    /**
     * Gets the value of the nir property.
     * 
     * @return
     *     possible object is
     *     {@link NIRCertifie }
     *     
     */
    public NIRCertifie getNir() {
        return nir;
    }

    /**
     * Sets the value of the nir property.
     * 
     * @param value
     *     allowed object is
     *     {@link NIRCertifie }
     *     
     */
    public void setNir(NIRCertifie value) {
        this.nir = value;
    }

    /**
     * Gets the value of the dateNai property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getDateNai() {
        return dateNai;
    }

    /**
     * Sets the value of the dateNai property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setDateNai(String value) {
        this.dateNai = value;
    }

    /**
     * Gets the value of the rang property.
     * 
     * @return
     *     possible object is
     *     {@link BigInteger }
     *     
     */
    public BigInteger getRang() {
        return rang;
    }

    /**
     * Sets the value of the rang property.
     * 
     * @param value
     *     allowed object is
     *     {@link BigInteger }
     *     
     */
    public void setRang(BigInteger value) {
        this.rang = value;
    }

    /**
     * Gets the value of the porteur property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getPorteur() {
        return porteur;
    }

    /**
     * Sets the value of the porteur property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setPorteur(String value) {
        this.porteur = value;
    }

}
