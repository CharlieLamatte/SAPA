
package siram.lps.ctxlps;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for LOGICIEL complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="LOGICIEL">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="IDAM" type="{urn:siram:lps:ctxlps}IdentiteStringRef" minOccurs="0"/>
 *         &lt;element name="Version" type="{urn:siram:lps:ctxlps}CodeString" minOccurs="0"/>
 *         &lt;element name="Instance" type="{urn:siram:lps:ctxlps}IdentiteString" minOccurs="0"/>
 *         &lt;element name="Nom" type="{urn:siram:lps:ctxlps}CodeString" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "LOGICIEL", propOrder = {
    "idam",
    "version",
    "instance",
    "nom"
})
public class LOGICIEL {

    @XmlElement(name = "IDAM")
    protected IdentiteStringRef idam;
    @XmlElement(name = "Version")
    protected String version;
    @XmlElement(name = "Instance")
    protected String instance;
    @XmlElement(name = "Nom")
    protected String nom;

    /**
     * Gets the value of the idam property.
     * 
     * @return
     *     possible object is
     *     {@link IdentiteStringRef }
     *     
     */
    public IdentiteStringRef getIDAM() {
        return idam;
    }

    /**
     * Sets the value of the idam property.
     * 
     * @param value
     *     allowed object is
     *     {@link IdentiteStringRef }
     *     
     */
    public void setIDAM(IdentiteStringRef value) {
        this.idam = value;
    }

    /**
     * Gets the value of the version property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getVersion() {
        return version;
    }

    /**
     * Sets the value of the version property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setVersion(String value) {
        this.version = value;
    }

    /**
     * Gets the value of the instance property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getInstance() {
        return instance;
    }

    /**
     * Sets the value of the instance property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setInstance(String value) {
        this.instance = value;
    }

    /**
     * Gets the value of the nom property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getNom() {
        return nom;
    }

    /**
     * Sets the value of the nom property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setNom(String value) {
        this.nom = value;
    }

}
