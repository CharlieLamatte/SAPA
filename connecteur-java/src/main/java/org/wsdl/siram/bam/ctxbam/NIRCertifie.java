
package siram.bam.ctxbam;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlSchemaType;
import javax.xml.bind.annotation.XmlType;
import javax.xml.datatype.XMLGregorianCalendar;


/**
 * <p>Java class for NIRCertifie complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="NIRCertifie">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="Num" type="{urn:siram:bam:ctxbam}PATTERN0_CTXBAM_TypesComplexes_NIRCertifie_Num" minOccurs="0"/>
 *         &lt;element name="Cle" type="{urn:siram:bam:ctxbam}PATTERN0_CTXBAM_TypesComplexes_NIRCertifie_Cle" minOccurs="0"/>
 *         &lt;element name="DateCertification" type="{http://www.w3.org/2001/XMLSchema}date" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "NIRCertifie", propOrder = {
    "num",
    "cle",
    "dateCertification"
})
public class NIRCertifie {

    @XmlElement(name = "Num")
    protected String num;
    @XmlElement(name = "Cle")
    protected String cle;
    @XmlElement(name = "DateCertification")
    @XmlSchemaType(name = "date")
    protected XMLGregorianCalendar dateCertification;

    /**
     * Gets the value of the num property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getNum() {
        return num;
    }

    /**
     * Sets the value of the num property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setNum(String value) {
        this.num = value;
    }

    /**
     * Gets the value of the cle property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getCle() {
        return cle;
    }

    /**
     * Sets the value of the cle property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setCle(String value) {
        this.cle = value;
    }

    /**
     * Gets the value of the dateCertification property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getDateCertification() {
        return dateCertification;
    }

    /**
     * Sets the value of the dateCertification property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setDateCertification(XMLGregorianCalendar value) {
        this.dateCertification = value;
    }

}
