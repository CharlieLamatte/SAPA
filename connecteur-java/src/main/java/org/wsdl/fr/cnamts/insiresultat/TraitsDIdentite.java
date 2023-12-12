
package fr.cnamts.insiresultat;

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
 *         &lt;element name="Prenom" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         &lt;element name="ListePrenom" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
 *         &lt;element name="Sexe" type="{http://www.cnamts.fr/INSiResultat}CodSexe" minOccurs="0"/>
 *         &lt;element name="DateNaissance" type="{http://www.cnamts.fr/INSiResultat}DateLunaire" minOccurs="0"/>
 *         &lt;element name="LieuNaissance" type="{http://www.w3.org/2001/XMLSchema}string" minOccurs="0"/>
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
    "listePrenom",
    "sexe",
    "dateNaissance",
    "lieuNaissance"
})
public class TraitsDIdentite {

    @XmlElement(name = "NomNaissance")
    protected String nomNaissance;
    @XmlElement(name = "Prenom")
    protected String prenom;
    @XmlElement(name = "ListePrenom")
    protected String listePrenom;
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
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getPrenom() {
        return prenom;
    }

    /**
     * Sets the value of the prenom property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setPrenom(String value) {
        this.prenom = value;
    }

    /**
     * Gets the value of the listePrenom property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getListePrenom() {
        return listePrenom;
    }

    /**
     * Sets the value of the listePrenom property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setListePrenom(String value) {
        this.listePrenom = value;
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
