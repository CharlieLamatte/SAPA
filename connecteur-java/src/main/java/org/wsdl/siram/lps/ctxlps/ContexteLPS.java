
package siram.lps.ctxlps;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlAttribute;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlSchemaType;
import javax.xml.bind.annotation.XmlType;
import javax.xml.datatype.XMLGregorianCalendar;


/**
 * <p>Java class for ContexteLPS complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="ContexteLPS">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="Id" type="{urn:siram:lps:ctxlps}IdentiteString"/>
 *         &lt;element name="Temps" type="{http://www.w3.org/2001/XMLSchema}dateTime"/>
 *         &lt;element name="Emetteur" type="{urn:siram:lps:ctxlps}IdentiteString" minOccurs="0"/>
 *         &lt;element name="LPS" type="{urn:siram:lps:ctxlps}LOGICIEL" minOccurs="0"/>
 *       &lt;/sequence>
 *       &lt;attribute name="Nature" type="{urn:siram:lps:ctxlps}PATTERN0_CTXLPS_ContexteLPS_ContexteLPS_Nature" />
 *       &lt;attribute name="Version" use="required" type="{urn:siram:lps:ctxlps}CodeString" />
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "ContexteLPS", propOrder = {
    "id",
    "temps",
    "emetteur",
    "lps"
})
public class ContexteLPS {

    @XmlElement(name = "Id", required = true)
    protected String id;
    @XmlElement(name = "Temps", required = true)
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar temps;
    @XmlElement(name = "Emetteur")
    protected String emetteur;
    @XmlElement(name = "LPS")
    protected LOGICIEL lps;
    @XmlAttribute(name = "Nature")
    protected String nature;
    @XmlAttribute(name = "Version", required = true)
    protected String version;

    /**
     * Gets the value of the id property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getId() {
        return id;
    }

    /**
     * Sets the value of the id property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setId(String value) {
        this.id = value;
    }

    /**
     * Gets the value of the temps property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getTemps() {
        return temps;
    }

    /**
     * Sets the value of the temps property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setTemps(XMLGregorianCalendar value) {
        this.temps = value;
    }

    /**
     * Gets the value of the emetteur property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getEmetteur() {
        return emetteur;
    }

    /**
     * Sets the value of the emetteur property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setEmetteur(String value) {
        this.emetteur = value;
    }

    /**
     * Gets the value of the lps property.
     * 
     * @return
     *     possible object is
     *     {@link LOGICIEL }
     *     
     */
    public LOGICIEL getLPS() {
        return lps;
    }

    /**
     * Sets the value of the lps property.
     * 
     * @param value
     *     allowed object is
     *     {@link LOGICIEL }
     *     
     */
    public void setLPS(LOGICIEL value) {
        this.lps = value;
    }

    /**
     * Gets the value of the nature property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getNature() {
        return nature;
    }

    /**
     * Sets the value of the nature property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setNature(String value) {
        this.nature = value;
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

}
