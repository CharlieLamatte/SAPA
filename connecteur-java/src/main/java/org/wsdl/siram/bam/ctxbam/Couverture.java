
package siram.bam.ctxbam;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for Couverture complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="Couverture">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="GrandRegime" type="{urn:siram:bam:ctxbam}IdentiteString" minOccurs="0"/>
 *         &lt;element name="Organisme" type="{urn:siram:bam:ctxbam}IdentiteString" minOccurs="0"/>
 *         &lt;element name="CodeCentre" type="{urn:siram:bam:ctxbam}IdentiteString" minOccurs="0"/>
 *         &lt;element name="ASSURE" type="{urn:siram:bam:ctxbam}Assure" minOccurs="0"/>
 *         &lt;element name="BENEFICIAIRE" type="{urn:siram:bam:ctxbam}Beneficiaire" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "Couverture", propOrder = {
    "grandRegime",
    "organisme",
    "codeCentre",
    "assure",
    "beneficiaire"
})
public class Couverture {

    @XmlElement(name = "GrandRegime")
    protected String grandRegime;
    @XmlElement(name = "Organisme")
    protected String organisme;
    @XmlElement(name = "CodeCentre")
    protected String codeCentre;
    @XmlElement(name = "ASSURE")
    protected Assure assure;
    @XmlElement(name = "BENEFICIAIRE")
    protected Beneficiaire beneficiaire;

    /**
     * Gets the value of the grandRegime property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getGrandRegime() {
        return grandRegime;
    }

    /**
     * Sets the value of the grandRegime property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setGrandRegime(String value) {
        this.grandRegime = value;
    }

    /**
     * Gets the value of the organisme property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getOrganisme() {
        return organisme;
    }

    /**
     * Sets the value of the organisme property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setOrganisme(String value) {
        this.organisme = value;
    }

    /**
     * Gets the value of the codeCentre property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getCodeCentre() {
        return codeCentre;
    }

    /**
     * Sets the value of the codeCentre property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setCodeCentre(String value) {
        this.codeCentre = value;
    }

    /**
     * Gets the value of the assure property.
     * 
     * @return
     *     possible object is
     *     {@link Assure }
     *     
     */
    public Assure getASSURE() {
        return assure;
    }

    /**
     * Sets the value of the assure property.
     * 
     * @param value
     *     allowed object is
     *     {@link Assure }
     *     
     */
    public void setASSURE(Assure value) {
        this.assure = value;
    }

    /**
     * Gets the value of the beneficiaire property.
     * 
     * @return
     *     possible object is
     *     {@link Beneficiaire }
     *     
     */
    public Beneficiaire getBENEFICIAIRE() {
        return beneficiaire;
    }

    /**
     * Sets the value of the beneficiaire property.
     * 
     * @param value
     *     allowed object is
     *     {@link Beneficiaire }
     *     
     */
    public void setBENEFICIAIRE(Beneficiaire value) {
        this.beneficiaire = value;
    }

}
