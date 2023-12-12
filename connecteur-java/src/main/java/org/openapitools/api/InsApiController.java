package org.openapitools.api;

import io.swagger.annotations.ApiParam;
import org.openapitools.model.Resultat;
import org.openapitools.model.TraitsDIdentite;
import org.sapa.lps.InsSoapClient;
import org.sapa.util.Converters;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.context.request.NativeWebRequest;

import javax.validation.Valid;
import java.util.Collections;
import java.util.Optional;

import static org.sapa.lps.InsSoapClient.*;
import static org.sapa.util.Converters.convertResultat;
import static org.sapa.util.Converters.objectToJsonString;

@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
@Controller
@RequestMapping("${openapi.connecteurINSSAPA.base-path:/v1}")
public class InsApiController implements InsApi {

    private final NativeWebRequest request;

    private static final Logger log = LoggerFactory.getLogger(InsApiController.class);

    @Autowired
    private InsSoapClient insSoapClient;

    @org.springframework.beans.factory.annotation.Autowired
    public InsApiController(NativeWebRequest request) {
        this.request = request;
    }

    @Override
    public Optional<NativeWebRequest> getRequest() {
        return Optional.ofNullable(request);
    }

    @Override
    public ResponseEntity<Resultat> insFindInsPost(@ApiParam(value = "" ,required=true )  @Valid @RequestBody TraitsDIdentite traitsDIdentite) {
        fr.cnamts.insirecsans.TraitsDIdentite convertedTraitsDIdentite = Converters.convertTraitsDIdentite(traitsDIdentite);

        // verification des données en entré
        if (!isTraitsDIdentiteValid(convertedTraitsDIdentite)) {
            log.error("traitsDIdentite invalide: " + convertedTraitsDIdentite.toString());
            return new ResponseEntity<>(HttpStatus.BAD_REQUEST);
        }

        // appel INS SOAP
        try {
            fr.cnamts.insiresultat.Resultat resultat = this.insSoapClient.findINS(convertedTraitsDIdentite);

            // s'il y a eu une erreur SOAP
            if (resultat == null) {
                log.error("Erreur SOAP resultat null");
                return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
            }

            String output = objectToJsonString(convertResultat(resultat));
            ApiUtil.setExampleResponse(request, "application/json", output);

            return new ResponseEntity<>(HttpStatus.OK);
        } catch (Exception e) {
            log.error("Exception: " + e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
