
package fr.cnamts.insiresultat;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for Resultat complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="Resultat">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="CR" type="{http://www.cnamts.fr/INSiResultat}CompteRendu"/>
 *         &lt;element name="INDIVIDU" type="{http://www.cnamts.fr/INSiResultat}Individu" minOccurs="0"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "Resultat", propOrder = {
    "cr",
    "individu"
})
public class Resultat {

    @XmlElement(name = "CR", required = true)
    protected CompteRendu cr;
    @XmlElement(name = "INDIVIDU")
    protected Individu individu;

    /**
     * Gets the value of the cr property.
     * 
     * @return
     *     possible object is
     *     {@link CompteRendu }
     *     
     */
    public CompteRendu getCR() {
        return cr;
    }

    /**
     * Sets the value of the cr property.
     * 
     * @param value
     *     allowed object is
     *     {@link CompteRendu }
     *     
     */
    public void setCR(CompteRendu value) {
        this.cr = value;
    }

    /**
     * Gets the value of the individu property.
     * 
     * @return
     *     possible object is
     *     {@link Individu }
     *     
     */
    public Individu getINDIVIDU() {
        return individu;
    }

    /**
     * Sets the value of the individu property.
     * 
     * @param value
     *     allowed object is
     *     {@link Individu }
     *     
     */
    public void setINDIVIDU(Individu value) {
        this.individu = value;
    }

}
