
package fr.cnamts.insiresultat;

import java.util.ArrayList;
import java.util.List;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for Individu complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="Individu">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="INSACTIF" type="{http://www.cnamts.fr/INSiResultat}IdentifiantNationalSante"/>
 *         &lt;element name="INSHISTO" type="{http://www.cnamts.fr/INSiResultat}IdentifiantNationalSante" maxOccurs="unbounded" minOccurs="0"/>
 *         &lt;element name="TIQ" type="{http://www.cnamts.fr/INSiResultat}TraitsDIdentite"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "Individu", propOrder = {
    "insactif",
    "inshisto",
    "tiq"
})
public class Individu {

    @XmlElement(name = "INSACTIF", required = true)
    protected IdentifiantNationalSante insactif;
    @XmlElement(name = "INSHISTO")
    protected List<IdentifiantNationalSante> inshisto;
    @XmlElement(name = "TIQ", required = true)
    protected TraitsDIdentite tiq;

    /**
     * Gets the value of the insactif property.
     * 
     * @return
     *     possible object is
     *     {@link IdentifiantNationalSante }
     *     
     */
    public IdentifiantNationalSante getINSACTIF() {
        return insactif;
    }

    /**
     * Sets the value of the insactif property.
     * 
     * @param value
     *     allowed object is
     *     {@link IdentifiantNationalSante }
     *     
     */
    public void setINSACTIF(IdentifiantNationalSante value) {
        this.insactif = value;
    }

    /**
     * Gets the value of the inshisto property.
     * 
     * <p>
     * This accessor method returns a reference to the live list,
     * not a snapshot. Therefore any modification you make to the
     * returned list will be present inside the JAXB object.
     * This is why there is not a <CODE>set</CODE> method for the inshisto property.
     * 
     * <p>
     * For example, to add a new item, do as follows:
     * <pre>
     *    getINSHISTO().add(newItem);
     * </pre>
     * 
     * 
     * <p>
     * Objects of the following type(s) are allowed in the list
     * {@link IdentifiantNationalSante }
     * 
     * 
     */
    public List<IdentifiantNationalSante> getINSHISTO() {
        if (inshisto == null) {
            inshisto = new ArrayList<IdentifiantNationalSante>();
        }
        return this.inshisto;
    }

    /**
     * Gets the value of the tiq property.
     * 
     * @return
     *     possible object is
     *     {@link TraitsDIdentite }
     *     
     */
    public TraitsDIdentite getTIQ() {
        return tiq;
    }

    /**
     * Sets the value of the tiq property.
     * 
     * @param value
     *     allowed object is
     *     {@link TraitsDIdentite }
     *     
     */
    public void setTIQ(TraitsDIdentite value) {
        this.tiq = value;
    }

}
