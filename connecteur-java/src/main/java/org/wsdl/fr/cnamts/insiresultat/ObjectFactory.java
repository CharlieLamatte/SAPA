
package fr.cnamts.insiresultat;

import javax.xml.bind.JAXBElement;
import javax.xml.bind.annotation.XmlElementDecl;
import javax.xml.bind.annotation.XmlRegistry;
import javax.xml.namespace.QName;


/**
 * This object contains factory methods for each 
 * Java content interface and Java element interface 
 * generated in the fr.cnamts.insiresultat package. 
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

    private final static QName _RESULTAT_QNAME = new QName("http://www.cnamts.fr/INSiResultat", "RESULTAT");

    /**
     * Create a new ObjectFactory that can be used to create new instances of schema derived classes for package: fr.cnamts.insiresultat
     * 
     */
    public ObjectFactory() {
    }

    /**
     * Create an instance of {@link Resultat }
     * 
     */
    public Resultat createResultat() {
        return new Resultat();
    }

    /**
     * Create an instance of {@link CompteRendu }
     * 
     */
    public CompteRendu createCompteRendu() {
        return new CompteRendu();
    }

    /**
     * Create an instance of {@link Individu }
     * 
     */
    public Individu createIndividu() {
        return new Individu();
    }

    /**
     * Create an instance of {@link IdentifiantNationalSante }
     * 
     */
    public IdentifiantNationalSante createIdentifiantNationalSante() {
        return new IdentifiantNationalSante();
    }

    /**
     * Create an instance of {@link Matricule }
     * 
     */
    public Matricule createMatricule() {
        return new Matricule();
    }

    /**
     * Create an instance of {@link TraitsDIdentite }
     * 
     */
    public TraitsDIdentite createTraitsDIdentite() {
        return new TraitsDIdentite();
    }

    /**
     * Create an instance of {@link JAXBElement }{@code <}{@link Resultat }{@code >}}
     * 
     */
    @XmlElementDecl(namespace = "http://www.cnamts.fr/INSiResultat", name = "RESULTAT")
    public JAXBElement<Resultat> createRESULTAT(Resultat value) {
        return new JAXBElement<Resultat>(_RESULTAT_QNAME, Resultat.class, null, value);
    }

}
