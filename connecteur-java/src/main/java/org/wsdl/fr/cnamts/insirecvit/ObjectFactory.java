
package fr.cnamts.insirecvit;

import javax.xml.bind.JAXBElement;
import javax.xml.bind.annotation.XmlElementDecl;
import javax.xml.bind.annotation.XmlRegistry;
import javax.xml.namespace.QName;


/**
 * This object contains factory methods for each 
 * Java content interface and Java element interface 
 * generated in the fr.cnamts.insirecvit package. 
 * <p>An ObjectFactory allows you to programatically 
 * construct new instances of the Java representation 
 * for XML content. The Java representation of XML 
 * content can consist of schema derived interfaces 
 * and classes representing the binding of schema 
 * type definitions, element declarations and model 
 * groups.  Factory methods for each of these are 
 * provided in this class.
 * 
 */
@XmlRegistry
public class ObjectFactory {

    private final static QName _RECVITALE_QNAME = new QName("http://www.cnamts.fr/INSiRecVit", "RECVITALE");

    /**
     * Create a new ObjectFactory that can be used to create new instances of schema derived classes for package: fr.cnamts.insirecvit
     * 
     */
    public ObjectFactory() {
    }

    /**
     * Create an instance of {@link Beneficiaire }
     * 
     */
    public Beneficiaire createBeneficiaire() {
        return new Beneficiaire();
    }

    /**
     * Create an instance of {@link Matricule }
     * 
     */
    public Matricule createMatricule() {
        return new Matricule();
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link Beneficiaire }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://www.cnamts.fr/INSiRecVit", name = "RECVITALE")
    public JAXBElement<Beneficiaire> createRECVITALE(Beneficiaire value) {
        return new JAXBElement<Beneficiaire>(_RECVITALE_QNAME, Beneficiaire.class, null, value);
    }

}
