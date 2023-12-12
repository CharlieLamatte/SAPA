package org.openapitools.api;

import io.swagger.annotations.ApiParam;
import org.openapitools.model.Resultat;
import org.sapa.lps.InsSoapClient;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.env.Environment;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.context.request.NativeWebRequest;

import javax.validation.Valid;
import javax.validation.constraints.NotNull;
import java.util.Arrays;
import java.util.List;
import java.util.Optional;

import static org.sapa.lps.InsSoapClient.*;
import static org.sapa.util.Converters.convertResultat;
import static org.sapa.util.Converters.objectToJsonString;
import static org.sapa.util.Utilities.loadSoapResponse;

@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
@Controller
@RequestMapping("${openapi.connecteurINSSAPA.base-path:/v1}")
public class CndaApiController implements CndaApi {

    private final NativeWebRequest request;

    private static final Logger log = LoggerFactory.getLogger(InsApiController.class);

    @Autowired
    public CndaApiController(NativeWebRequest request) {
        this.request = request;
    }

    @Override
    public Optional<NativeWebRequest> getRequest() {
        return Optional.ofNullable(request);
    }

    @Override
    public ResponseEntity<Resultat> cndaInjectPost(@NotNull @ApiParam(value = "", required = true) @Valid @RequestParam(value = "fileName", required = true) String fileName) {
        // verification des données en entré
        List<String> allowedFilenames = Arrays.asList("REP_CR01", "TEST_2.04_cas2", "TEST_2.05", "TEST_2.08_cas1", "TEST_2.08_cas2");
        if (!allowedFilenames.contains(fileName)) {
            log.error("fileName invalide: " + fileName);
            return new ResponseEntity<>(HttpStatus.BAD_REQUEST);
        }

        // appel INS SOAP
        try {
            fr.cnamts.insiresultat.Resultat resultat = loadSoapResponse("example_data/" + fileName+ ".xml");

            String output = objectToJsonString(convertResultat(resultat));
            ApiUtil.setExampleResponse(request, "application/json", output);

            return new ResponseEntity<>(HttpStatus.OK);
        } catch (Exception e) {
            log.error("Exception: " + e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }

    }
}
