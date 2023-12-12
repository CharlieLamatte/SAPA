
package fr.cnamts.insirecsans;

import javax.xml.bind.JAXBElement;
import javax.xml.bind.annotation.XmlElementDecl;
import javax.xml.bind.annotation.XmlRegistry;
import javax.xml.namespace.QName;


/**
 * This object contains factory methods for each 
 * Java content interface and Java element interface 
 * generated in the fr.cnamts.insirecsans package. 
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

    private final static QName _RECSANSVITALE_QNAME = new QName("http://www.cnamts.fr/INSiRecSans", "RECSANSVITALE");

    /**
     * Create a new ObjectFactory that can be used to create new instances of schema derived classes for package: fr.cnamts.insirecsans
     * 
     */
    public ObjectFactory() {
    }

    /**
     * Create an instance of {@link TraitsDIdentite }
     * 
     */
    public TraitsDIdentite createTraitsDIdentite() {
        return new TraitsDIdentite();
    }

    /**
     * Create an instance of {@link Matricule }
     * 
     */
    public Matricule createMatricule() {
        return new Matricule();
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link TraitsDIdentite }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://www.cnamts.fr/INSiRecSans", name = "RECSANSVITALE")
    public JAXBElement<TraitsDIdentite> createRECSANSVITALE(TraitsDIdentite value) {
        return new JAXBElement<TraitsDIdentite>(_RECSANSVITALE_QNAME, TraitsDIdentite.class, null, value);
    }

}
