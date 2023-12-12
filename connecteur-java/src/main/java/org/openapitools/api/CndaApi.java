/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech) (5.0.0).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */
package org.openapitools.api;

import org.openapitools.model.Resultat;
import io.swagger.annotations.*;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.validation.annotation.Validated;
import org.springframework.data.domain.Pageable;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.context.request.NativeWebRequest;
import org.springframework.web.multipart.MultipartFile;
import springfox.documentation.annotations.ApiIgnore;

import javax.validation.Valid;
import javax.validation.constraints.*;
import java.util.List;
import java.util.Map;
import java.util.Optional;
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
@Validated
@Api(value = "cnda", description = "the cnda API")
public interface CndaApi {

    default Optional<NativeWebRequest> getRequest() {
        return Optional.empty();
    }

    /**
     * POST /cnda/inject
     *
     * @param fileName  (required)
     * @return A Resultat object. (status code 200)
     */
    @ApiOperation(value = "", nickname = "cndaInjectPost", notes = "", response = Resultat.class, tags={  })
    @ApiResponses(value = { 
        @ApiResponse(code = 200, message = "A Resultat object.", response = Resultat.class) })
    @PostMapping(
        value = "/cnda/inject",
        produces = { "application/json" }
    )
    default ResponseEntity<Resultat> cndaInjectPost(@NotNull @ApiParam(value = "", required = true) @Valid @RequestParam(value = "fileName", required = true) String fileName) {
        getRequest().ifPresent(request -> {
            for (MediaType mediaType: MediaType.parseMediaTypes(request.getHeader("Accept"))) {
                if (mediaType.isCompatibleWith(MediaType.valueOf("application/json"))) {
                    String exampleString = "{ \"individu\" : { \"traitsIdentite\" : { \"listePrenom\" : [ \"listePrenom\", \"listePrenom\" ], \"lieuNaissance\" : \"63220\", \"nomNaissance\" : \"ADRDEUX\", \"dateNaissance\" : \"1981-01-01\", \"sexe\" : \"M\", \"prenom\" : \"LAURENT\" }, \"insActif\" : { \"matricule\" : { \"numIdentifiant\" : \"1810163220751\", \"cle\" : \"40\", \"typeMatricule\" : \"typeMatricule\" }, \"dateDeb\" : \"2000-01-23\", \"oid\" : \"1.2.250.1.213.1.4.8\", \"dateFin\" : \"2000-01-23\" }, \"insHistorique\" : [ { \"matricule\" : { \"numIdentifiant\" : \"1810163220751\", \"cle\" : \"40\", \"typeMatricule\" : \"typeMatricule\" }, \"dateDeb\" : \"2000-01-23\", \"oid\" : \"1.2.250.1.213.1.4.8\", \"dateFin\" : \"2000-01-23\" }, { \"matricule\" : { \"numIdentifiant\" : \"1810163220751\", \"cle\" : \"40\", \"typeMatricule\" : \"typeMatricule\" }, \"dateDeb\" : \"2000-01-23\", \"oid\" : \"1.2.250.1.213.1.4.8\", \"dateFin\" : \"2000-01-23\" } ] }, \"compteRendu\" : { \"codeCR\" : \"00\", \"libelleCR\" : \"OK\" } }";
                    ApiUtil.setExampleResponse(request, "application/json", exampleString);
                    break;
                }
            }
        });
        return new ResponseEntity<>(HttpStatus.NOT_IMPLEMENTED);

    }

}
