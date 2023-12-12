
package siram;

import javax.xml.bind.JAXBElement;
import javax.xml.bind.annotation.XmlElementDecl;
import javax.xml.bind.annotation.XmlRegistry;
import javax.xml.namespace.QName;


/**
 * This object contains factory methods for each 
 * Java content interface and Java element interface 
 * generated in the siram package. 
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

    private final static QName _Erreur_QNAME = new QName("urn:siram", "Erreur");

    /**
     * Create a new ObjectFactory that can be used to create new instances of schema derived classes for package: siram
     * 
     */
    public ObjectFactory() {
    }

    /**
     * Create an instance of {@link TypeErreur }
     * 
     */
    public TypeErreur createTypeErreur() {
        return new TypeErreur();
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link TypeErreur }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "urn:siram", name = "Erreur")
    public JAXBElement<TypeErreur> createErreur(TypeErreur value) {
        return new JAXBElement<TypeErreur>(_Erreur_QNAME, TypeErreur.class, null, value);
    }

}
