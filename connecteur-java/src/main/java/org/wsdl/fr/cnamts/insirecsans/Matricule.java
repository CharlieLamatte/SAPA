
package fr.cnamts.insirecsans;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for Matricule complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="Matricule">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="NumIdentifiant" type="{http://www.cnamts.fr/INSiRecSans}NIR" minOccurs="0"/>
 *         &lt;element name="Cle" type="{http://www.cnamts.fr/INSiRecSans}CLE" minOccurs="0"/>
 *         &lt;element name="TypeMatricule" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "Matricule", propOrder = {
    "numIdentifiant",
    "cle",
    "typeMatricule"
})
public class Matricule {

    @XmlElement(name = "NumIdentifiant")
    protected String numIdentifiant;
    @XmlElement(name = "Cle")
    protected String cle;
    @XmlElement(name = "TypeMatricule")
    protected String typeMatricule;

    /**
     * Gets the value of the numIdentifiant property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getNumIdentifiant() {
        return numIdentifiant;
    }

    /**
     * Sets the value of the numIdentifiant property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setNumIdentifiant(String value) {
        this.numIdentifiant = value;
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
     * Gets the value of the typeMatricule property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getTypeMatricule() {
        return typeMatricule;
    }

    /**
     * Sets the value of the typeMatricule property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setTypeMatricule(String value) {
        this.typeMatricule = value;
    }

}
