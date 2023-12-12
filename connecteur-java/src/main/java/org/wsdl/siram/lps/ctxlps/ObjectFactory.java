
package siram.lps.ctxlps;

import javax.xml.bind.JAXBElement;
import javax.xml.bind.annotation.XmlElementDecl;
import javax.xml.bind.annotation.XmlRegistry;
import javax.xml.namespace.QName;


/**
 * This object contains factory methods for each 
 * Java content interface and Java element interface 
 * generated in the siram.lps.ctxlps package. 
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

    private final static QName _ContexteLPS_QNAME = new QName("urn:siram:lps:ctxlps", "ContexteLPS");

    /**
     * Create a new ObjectFactory that can be used to create new instances of schema derived classes for package: siram.lps.ctxlps
     * 
     */
    public ObjectFactory() {
    }

    /**
     * Create an instance of {@link ContexteLPS }
     * 
     */
    public ContexteLPS createContexteLPS() {
        return new ContexteLPS();
    }

    /**
     * Create an instance of {@link IdentiteStringRef }
     * 
     */
    public IdentiteStringRef createIdentiteStringRef() {
        return new IdentiteStringRef();
    }

    /**
     * Create an instance of {@link LOGICIEL }
     * 
     */
    public LOGICIEL createLOGICIEL() {
        return new LOGICIEL();
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link ContexteLPS }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "urn:siram:lps:ctxlps", name = "ContexteLPS")
    public JAXBElement<ContexteLPS> createContexteLPS(ContexteLPS value) {
        return new JAXBElement<ContexteLPS>(_ContexteLPS_QNAME, ContexteLPS.class, null, value);
    }

}
