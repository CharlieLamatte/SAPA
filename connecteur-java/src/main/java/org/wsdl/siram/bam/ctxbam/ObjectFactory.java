
package siram.bam.ctxbam;

import javax.xml.bind.JAXBElement;
import javax.xml.bind.annotation.XmlElementDecl;
import javax.xml.bind.annotation.XmlRegistry;
import javax.xml.namespace.QName;


/**
 * This object contains factory methods for each 
 * Java content interface and Java element interface 
 * generated in the siram.bam.ctxbam package. 
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

    private final static QName _ContexteBAM_QNAME = new QName("urn:siram:bam:ctxbam", "ContexteBAM");

    /**
     * Create a new ObjectFactory that can be used to create new instances of schema derived classes for package: siram.bam.ctxbam
     * 
     */
    public ObjectFactory() {
    }

    /**
     * Create an instance of {@link ContexteBAM }
     * 
     */
    public ContexteBAM createContexteBAM() {
        return new ContexteBAM();
    }

    /**
     * Create an instance of {@link Couverture }
     * 
     */
    public Couverture createCouverture() {
        return new Couverture();
    }

    /**
     * Create an instance of {@link Assure }
     * 
     */
    public Assure createAssure() {
        return new Assure();
    }

    /**
     * Create an instance of {@link NIR }
     * 
     */
    public NIR createNIR() {
        return new NIR();
    }

    /**
     * Create an instance of {@link Beneficiaire }
     * 
     */
    public Beneficiaire createBeneficiaire() {
        return new Beneficiaire();
    }

    /**
     * Create an instance of {@link NIRCertifie }
     * 
     */
    public NIRCertifie createNIRCertifie() {
        return new NIRCertifie();
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link ContexteBAM }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "urn:siram:bam:ctxbam", name = "ContexteBAM")
    public JAXBElement<ContexteBAM> createContexteBAM(ContexteBAM value) {
        return new JAXBElement<ContexteBAM>(_ContexteBAM_QNAME, ContexteBAM.class, null, value);
    }

}
