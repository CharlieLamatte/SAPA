
package fr.cnamts.insiresultat;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;


/**
 * <p>Java class for CompteRendu complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="CompteRendu">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element name="CodeCR" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *         &lt;element name="LibelleCR" type="{http://www.w3.org/2001/XMLSchema}string"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "CompteRendu", propOrder = {
    "codeCR",
    "libelleCR"
})
public class CompteRendu {

    @XmlElement(name = "CodeCR", required = true)
    protected String codeCR;
    @XmlElement(name = "LibelleCR", required = true)
    protected String libelleCR;

    /**
     * Gets the value of the codeCR property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getCodeCR() {
        return codeCR;
    }

    /**
     * Sets the value of the codeCR property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setCodeCR(String value) {
        this.codeCR = value;
    }

    /**
     * Gets the value of the libelleCR property.
     * 
     * @return
     *     possible object is
     *     {@link String }
     *     
     */
    public String getLibelleCR() {
        return libelleCR;
    }

    /**
     * Sets the value of the libelleCR property.
     * 
     * @param value
     *     allowed object is
     *     {@link String }
     *     
     */
    public void setLibelleCR(String value) {
        this.libelleCR = value;
    }

}
