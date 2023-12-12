
package fr.cnamts.webservice;

import java.net.URL;
import javax.xml.namespace.QName;
import javax.xml.ws.Service;
import javax.xml.ws.WebEndpoint;
import javax.xml.ws.WebServiceClient;
import javax.xml.ws.WebServiceException;
import javax.xml.ws.WebServiceFeature;


/**
 * service de recherche et de v�rification de l�Identifiant National de Sant� (INS)
 * 
 * This class was generated by the JAX-WS RI.
 * JAX-WS RI 2.2.9-b130926.1035
 * Generated source version: 2.2
 * 
 */
@WebServiceClient(name = "ICIR-v1", targetNamespace = "http://www.cnamts.fr/webservice", wsdlLocation = "/META-INF/wsdl/ServiceIdentiteCertifieeEXP/DESIR_ICIR_EXP_1.5.0.wsdl")
public class ICIRV1
    extends Service
{

    private final static URL ICIRV1_WSDL_LOCATION;
    private final static WebServiceException ICIRV1_EXCEPTION;
    private final static QName ICIRV1_QNAME = new QName("http://www.cnamts.fr/webservice", "ICIR-v1");

    static {
        ICIRV1_WSDL_LOCATION = fr.cnamts.webservice.ICIRV1 .class.getResource("/META-INF/wsdl/ServiceIdentiteCertifieeEXP/DESIR_ICIR_EXP_1.5.0.wsdl");
        WebServiceException e = null;
        if (ICIRV1_WSDL_LOCATION == null) {
            e = new WebServiceException("Cannot find '/META-INF/wsdl/ServiceIdentiteCertifieeEXP/DESIR_ICIR_EXP_1.5.0.wsdl' wsdl. Place the resource correctly in the classpath.");
        }
        ICIRV1_EXCEPTION = e;
    }

    public ICIRV1() {
        super(__getWsdlLocation(), ICIRV1_QNAME);
    }

    public ICIRV1(WebServiceFeature... features) {
        super(__getWsdlLocation(), ICIRV1_QNAME, features);
    }

    public ICIRV1(URL wsdlLocation) {
        super(wsdlLocation, ICIRV1_QNAME);
    }

    public ICIRV1(URL wsdlLocation, WebServiceFeature... features) {
        super(wsdlLocation, ICIRV1_QNAME, features);
    }

    public ICIRV1(URL wsdlLocation, QName serviceName) {
        super(wsdlLocation, serviceName);
    }

    public ICIRV1(URL wsdlLocation, QName serviceName, WebServiceFeature... features) {
        super(wsdlLocation, serviceName, features);
    }

    /**
     * 
     * @return
     *     returns ICIRService
     */
    @WebEndpoint(name = "ICIRService")
    public ICIRService getICIRService() {
        return super.getPort(new QName("http://www.cnamts.fr/webservice", "ICIRService"), ICIRService.class);
    }

    /**
     * 
     * @param features
     *     A list of {@link javax.xml.ws.WebServiceFeature} to configure on the proxy.  Supported features not in the <code>features</code> parameter will have their default values.
     * @return
     *     returns ICIRService
     */
    @WebEndpoint(name = "ICIRService")
    public ICIRService getICIRService(WebServiceFeature... features) {
        return super.getPort(new QName("http://www.cnamts.fr/webservice", "ICIRService"), ICIRService.class, features);
    }

    private static URL __getWsdlLocation() {
        if (ICIRV1_EXCEPTION!= null) {
            throw ICIRV1_EXCEPTION;
        }
        return ICIRV1_WSDL_LOCATION;
    }

}