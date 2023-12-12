
package fr.cnamts.insiresultat;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlSchemaType;
import javax.xml.bind.annotation.XmlType;
import javax.xml.datatype.XMLGregorianCalendar;


/**
 * <p>Java class for IdentifiantNationalSante complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="IdentifiantNationalSante">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="IdIndividu" type="{http://www.cnamts.fr/INSiResultat}Matricule"/>
 *         &lt;element name="OID" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         &lt;element name="DateDeb" type="{http://www.w3.org/2001/XMLSchema}date" minOccurs="0"/>
 *         &lt;element name="DateFin" type="{http://www.w3.org/2001/XMLSchema}date" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "IdentifiantNationalSante", propOrder = {
    "idIndividu",
    "oid",
    "dateDeb",
    "dateFin"
})
public class IdentifiantNationalSante {

    @XmlElement(name = "IdIndividu", required = true)
    protected Matricule idIndividu;
    @XmlElement(name = "OID", required = true)
    protected String oid;
    @XmlElement(name = "DateDeb")
    @XmlSchemaType(name = "date")
    protected XMLGregorianCalendar dateDeb;
    @XmlElement(name = "DateFin")
    @XmlSchemaType(name = "date")
    protected XMLGregorianCalendar dateFin;

    /**
     * Gets the value of the idIndividu property.
     * 
     * @return
     *     possible object is
     *     {@link Matricule }
     *     
     */
    public Matricule getIdIndividu() {
        return idIndividu;
    }

    /**
     * Sets the value of the idIndividu property.
     * 
     * @param value
     *     allowed object is
     *     {@link Matricule }
     *     
     */
    public void setIdIndividu(Matricule value) {
        this.idIndividu = value;
    }

    /**
     * Gets the value of the oid property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getOID() {
        return oid;
    }

    /**
     * Sets the value of the oid property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setOID(String value) {
        this.oid = value;
    }

    /**
     * Gets the value of the dateDeb property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getDateDeb() {
        return dateDeb;
    }

    /**
     * Sets the value of the dateDeb property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setDateDeb(XMLGregorianCalendar value) {
        this.dateDeb = value;
    }

    /**
     * Gets the value of the dateFin property.
     * 
     * @return
     *     possible object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public XMLGregorianCalendar getDateFin() {
        return dateFin;
    }

    /**
     * Sets the value of the dateFin property.
     * 
     * @param value
     *     allowed object is
     *     {@link XMLGregorianCalendar }
     *     
     */
    public void setDateFin(XMLGregorianCalendar value) {
        this.dateFin = value;
    }

}
