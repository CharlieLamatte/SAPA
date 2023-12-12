
package org.oasis_open.docs.wss._2004._01.oasis_200401_wss_wssecurity_secext_1_0;

import java.util.ArrayList;
import java.util.List;
import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlType;
import oasis.names.tc.saml._2_0.assertion.AssertionType;


/**
 * <p>Java class for type_Security complex type.
 * 
 * <p>The following schema fragment specifies the expected content contained within this class.
 * 
 * <pre>
 * &lt;complexType name="type_Security">
 *   &lt;complexContent>
 *     &lt;restriction base="{http://www.w3.org/2001/XMLSchema}anyType">
 *       &lt;sequence>
 *         &lt;element ref="{urn:oasis:names:tc:SAML:2.0:assertion}Assertion" maxOccurs="unbounded"/>
 *       &lt;/sequence>
 *     &lt;/restriction>
 *   &lt;/complexContent>
 * &lt;/complexType>
 * </pre>
 * 
 * 
 */
@XmlAccessorType(XmlAccessType.FIELD)
@XmlType(name = "type_Security", propOrder = {
    "assertion"
})
public class TypeSecurity {

    @XmlElement(name = "Assertion", namespace = "urn:oasis:names:tc:SAML:2.0:assertion", required = true)
    protected List<AssertionType> assertion;

    /**
     * Gets the value of the assertion property.
     * 
     * <p>
     * This accessor method returns a reference to the live list,
     * not a snapshot. Therefore any modification you make to the
     * returned list will be present inside the JAXB object.
     * This is why there is not a <CODE>set</CODE> method for the assertion property.
     * 
     * <p>
     * For example, to add a new item, do as follows:
     * <pre>
     *    getAssertion().add(newItem);
     * </pre>
     * 
     * 
     * <p>
     * Objects of the following type(s) are allowed in the list
     * {@link AssertionType }
     * 
     * 
     */
    public List<AssertionType> getAssertion() {
        if (assertion == null) {
            assertion = new ArrayList<AssertionType>();
        }
        return this.assertion;
    }

}
