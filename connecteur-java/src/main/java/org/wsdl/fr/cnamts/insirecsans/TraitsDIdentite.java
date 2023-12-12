
package fr.cnamts.insirecsans;

import java.util.ArrayList;
import java.util.List;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for TraitsDIdentite complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="TraitsDIdentite">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="NomNaissance" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         &lt;element name="Prenom" type="{http://www.w3.org/2001/XMLSchema}string" maxOccurs="unbounded" minOccurs="0"/>
 *         &lt;element name="Sexe" type="{http://www.cnamts.fr/INSiRecSans}CodSexe" minOccurs="0"/>
 *         &lt;element name="DateNaissance" type="{http://www.cnamts.fr/INSiRecSans}DateLunaire" minOccurs="0"/>
 *         &lt;element name="LieuNaissance" type="{http://www.cnamts.fr/INSiRecSans}COG" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "TraitsDIdentite", propOrder = {
    "nomNaissance",
    "prenom",
    "sexe",
    "dateNaissance",
    "lieuNaissance"
})
public class TraitsDIdentite {

    @XmlElement(name = "NomNaissance")
    protected String nomNaissance;
    @XmlElement(name = "Prenom")
    protected List<String> prenom;
    @XmlElement(name = "Sexe")
    protected String sexe;
    @XmlElement(name = "DateNaissance")
    protected String dateNaissance;
    @XmlElement(name = "LieuNaissance")
    protected String lieuNaissance;

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
     * Gets the value of the prenom property.
     * 
     * <p>
     * This accessor method returns a reference to the live list,
     * not a snapshot. Therefore any modification you make to the
     * returned list will be present inside the JAXB object.
     * This is why there is not a <CODE>set</CODE> method for the prenom property.
     * 
     * <p>
     * For example, to add a new item, do as follows:
     * <pre>
     *    getPrenom().add(newItem);
     * </pre>
     * 
     * 
     * <p>
     * Objects of the following type(s) are allowed in the list
     * {@link String }
     * 
     * 
     */
    public List<String> getPrenom() {
        if (prenom == null) {
            prenom = new ArrayList<String>();
        }
        return this.prenom;
    }

    /**
     * Gets the value of the sexe property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getSexe() {
        return sexe;
    }

    /**
     * Sets the value of the sexe property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setSexe(String value) {
        this.sexe = value;
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
     * Gets the value of the lieuNaissance property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getLieuNaissance() {
        return lieuNaissance;
    }

    /**
     * Sets the value of the lieuNaissance property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setLieuNaissance(String value) {
        this.lieuNaissance = value;
    }

}
