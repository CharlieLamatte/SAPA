
package siram.bam.ctxbam;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlAttribute;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlSchemaType;
import javax.xml.bind.annotation.XmlType;
import javax.xml.datatype.XMLGregorianCalendar;


/**
 * <p>Java class for ContexteBAM complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="ContexteBAM">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="Id" type="{urn:siram:bam:ctxbam}IdentiteString"/>
 *         &lt;element name="Temps" type="{http://www.w3.org/2001/XMLSchema}dateTime"/>
 *         &lt;element name="Emetteur" type="{urn:siram:bam:ctxbam}IdentiteString" minOccurs="0"/>
 *         &lt;element name="DateRef" type="{http://www.w3.org/2001/XMLSchema}dateTime" minOccurs="0"/>
 *         &lt;element name="COUVERTURE" type="{urn:siram:bam:ctxbam}Couverture"/>
 *       &lt;/sequence>
 *       &lt;attribute name="Nature" type="{urn:siram:bam:ctxbam}PATTERN0_CTXBAM_ContexteBAM_ContexteBAM_Nature" />
 *       &lt;attribute name="Version" use="required" type="{urn:siram:bam:ctxbam}CodeString" />
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "ContexteBAM", propOrder = {
    "id",
    "temps",
    "emetteur",
    "dateRef",
    "couverture"
})
public class ContexteBAM {

    @XmlElement(name = "Id", required = true)
    protected String id;
    @XmlElement(name = "Temps", required = true)
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar temps;
    @XmlElement(name = "Emetteur")
    protected String emetteur;
    @XmlElement(name = "DateRef")
    @XmlSchemaType(name = "dateTime")
    protected XMLGregorianCalendar dateRef;
    @XmlElement(name = "COUVERTURE", required = true)
    protected Couverture couverture;
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
     * Gets the value of the dateRef property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getDateRef() {
        return dateRef;
    }

    /**
     * Sets the value of the dateRef property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setDateRef(XMLGregorianCalendar value) {
        this.dateRef = value;
    }

    /**
     * Gets the value of the couverture property.
     * 
     * @return
     *     possible object is
     *     {@link Couverture }
     *     
     */
    public Couverture getCOUVERTURE() {
        return couverture;
    }

    /**
     * Sets the value of the couverture property.
     * 
     * @param value
     *     allowed object is
     *     {@link Couverture }
     *     
     */
    public void setCOUVERTURE(Couverture value) {
        this.couverture = value;
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
