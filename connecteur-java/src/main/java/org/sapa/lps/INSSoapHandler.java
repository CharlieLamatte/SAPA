package org.sapa.lps;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.w3c.dom.Element;

import javax.xml.namespace.QName;
import javax.xml.soap.MimeHeader;
import javax.xml.soap.MimeHeaders;
import javax.xml.soap.SOAPMessage;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;
import javax.xml.ws.handler.MessageContext;
import javax.xml.ws.handler.soap.SOAPHandler;
import javax.xml.ws.handler.soap.SOAPMessageContext;
import java.io.ByteArrayOutputStream;
import java.io.FileOutputStream;
import java.util.Iterator;
import java.util.Set;

public class INSSoapHandler implements SOAPHandler<SOAPMessageContext> {
    private static final Logger log = LoggerFactory.getLogger(INSSoapHandler.class);

    public Set<QName> getHeaders() {
        return null;
    }

    public boolean handleFault(SOAPMessageContext context) {
//        if (log.isDebugEnabled()) {
//            //logMessage(context, "SOAP fault Message is : ");
//            try {
//                Element requete = context.getMessage().getSOAPPart().getDocumentElement();
//
//                TransformerFactory factory = TransformerFactory.newInstance();
//                Transformer t = factory.newTransformer();
//                Boolean isRequest = (Boolean) context.get(MessageContext.MESSAGE_OUTBOUND_PROPERTY);
//                if (isRequest) {
//                    t.transform(new DOMSource(requete),
//                            new StreamResult(
//                                    new FileOutputStream("req-faute.xml")));
//                } else {
//                    log.debug("Reponse");
//                    t.transform(new DOMSource(requete),
//                            new StreamResult(
//                                    new FileOutputStream("rep-faute.xml")));
//                }
//            } catch (Exception e) {
//                log.error("", e);
//            }
//        }

        return logMessage(context, "SOAP fault");
    }

    public boolean handleMessage(SOAPMessageContext context) {
//        try {
//            Boolean isRequest = (Boolean) context.get(MessageContext.MESSAGE_OUTBOUND_PROPERTY);
//            if (isRequest) {
//                log.debug("Requete");
//                if (log.isDebugEnabled()) {
//                    Element requete = context.getMessage().getSOAPPart().getDocumentElement();
//                    TransformerFactory factory = TransformerFactory.newInstance();
//                    Transformer t = factory.newTransformer();
//                    t.transform(new DOMSource(requete),
//                            new StreamResult(
//                                    new FileOutputStream("req.xml")));
//                }
//            } else {
//                log.debug("Reponse");
//                if (log.isDebugEnabled()) {
//                    Element reponse = context.getMessage().getSOAPPart().getDocumentElement();
//                    TransformerFactory factory = TransformerFactory.newInstance();
//                    Transformer t = factory.newTransformer();
//                    t.transform(new DOMSource(reponse),
//                            new StreamResult(
//                                    new FileOutputStream("rep.xml")));
//                }
//            }
//        } catch (Exception e) {
//            log.error("", e);
//        }

        return logMessage(context, "SOAP Message");
    }

    private boolean logMessage(MessageContext mc, String type) {
        try {
            if (log.isDebugEnabled()) {
                Boolean isRequest = (Boolean) mc.get(MessageContext.MESSAGE_OUTBOUND_PROPERTY);
                String sensMessage = "";

                if (isRequest) {
                    sensMessage = "requête";
                } else {
                    sensMessage = "réponse";
                }

                log.debug("----- Start details " + sensMessage + " " + type + " -----");
                SOAPMessage msg = ((SOAPMessageContext) mc)
                        .getMessage();

                // Print out the Mime Headers
                MimeHeaders mimeHeaders = msg.getMimeHeaders();
                Iterator mhIterator = mimeHeaders.getAllHeaders();
                MimeHeader mh;
                String header;
                log.debug("Mime Headers:");
                while (mhIterator.hasNext()) {
                    mh = (MimeHeader) mhIterator.next();
                    header = new StringBuffer("Name: ")
                            .append(mh.getName()).append("Value: ")
                            .append(mh.getValue()).toString();
                    log.debug(header);
                }

                log.debug("SOAP content: ");
                ByteArrayOutputStream baos = new ByteArrayOutputStream();
                msg.writeTo(baos);
                log.debug(baos.toString());
                log.debug("----- End details " + sensMessage + " " + type + " -----");
                baos.close();
            }

            return true;
        } catch (Exception e) {
            log.error("Error logging SOAP message", e);
            return false;
        }
    }

    public void close(MessageContext context) {
    }
}
