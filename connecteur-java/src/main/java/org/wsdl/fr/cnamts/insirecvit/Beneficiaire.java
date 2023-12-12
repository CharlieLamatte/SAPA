
package fr.cnamts.insirecvit;

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
 *         &lt;element name="MatriculeIndividu" type="{http://www.cnamts.fr/INSiRecVit}Matricule" minOccurs="0"/>
 *         &lt;element name="MatriculeOD" type="{http://www.cnamts.fr/INSiRecVit}Matricule" minOccurs="0"/>
 *         &lt;element name="NomNaissance" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         &lt;element name="DateNaissance" type="{http://www.cnamts.fr/INSiRecVit}DateLunaire" minOccurs="0"/>
 *         &lt;element name="RangNaissance" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
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
    "matriculeIndividu",
    "matriculeOD",
    "nomNaissance",
    "dateNaissance",
    "rangNaissance"
})
public class Beneficiaire {

    @XmlElement(name = "MatriculeIndividu")
    protected Matricule matriculeIndividu;
    @XmlElement(name = "MatriculeOD")
    protected Matricule matriculeOD;
    @XmlElement(name = "NomNaissance")
    protected String nomNaissance;
    @XmlElement(name = "DateNaissance")
    protected String dateNaissance;
    @XmlElement(name = "RangNaissance")
    protected String rangNaissance;

    /**
     * Gets the value of the matriculeIndividu property.
     * 
     * @return
     *     possible object is
     *     {@link Matricule }
     *     
     */
    public Matricule getMatriculeIndividu() {
        return matriculeIndividu;
    }

    /**
     * Sets the value of the matriculeIndividu property.
     * 
     * @param value
     *     allowed object is
     *     {@link Matricule }
     *     
     */
    public void setMatriculeIndividu(Matricule value) {
        this.matriculeIndividu = value;
    }

    /**
     * Gets the value of the matriculeOD property.
     * 
     * @return
     *     possible object is
     *     {@link Matricule }
     *     
     */
    public Matricule getMatriculeOD() {
        return matriculeOD;
    }

    /**
     * Sets the value of the matriculeOD property.
     * 
     * @param value
     *     allowed object is
     *     {@link Matricule }
     *     
     */
    public void setMatriculeOD(Matricule value) {
        this.matriculeOD = value;
    }

    /**
     * Gets the value of the nomNaissance property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getNomNaissance() {
        return nomNaissance;
    }

    /**
     * Sets the value of the nomNaissance property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setNomNaissance(String value) {
        this.nomNaissance = value;
    }

    /**
     * Gets the value of the dateNaissance property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getDateNaissance() {
        return dateNaissance;
    }

    /**
     * Sets the value of the dateNaissance property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setDateNaissance(String value) {
        this.dateNaissance = value;
    }

    /**
     * Gets the value of the rangNaissance property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getRangNaissance() {
        return rangNaissance;
    }

    /**
     * Sets the value of the rangNaissance property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setRangNaissance(String value) {
        this.rangNaissance = value;
    }

}
