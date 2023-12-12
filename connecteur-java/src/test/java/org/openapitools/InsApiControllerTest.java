package org.openapitools;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.openapitools.api.InsApiController;
import org.openapitools.model.TraitsDIdentite;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.web.servlet.WebMvcTest;
import org.springframework.http.MediaType;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.test.web.servlet.MockMvc;
import org.springframework.test.web.servlet.request.MockMvcRequestBuilders;
import org.springframework.test.web.servlet.result.MockMvcResultMatchers;

import static org.hamcrest.Matchers.is;
import static org.sapa.util.Converters.objectToJsonString;
import static org.springframework.test.web.servlet.result.MockMvcResultHandlers.print;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;

@RunWith(SpringRunner.class)
@WebMvcTest(controllers = InsApiController.class)
public class InsApiControllerTest {

    @Autowired
    private MockMvc mockMvc;

    @Test
    public void insV1FindInsPostTest_2_03_Cas1() throws Exception {
        TraitsDIdentite t = new TraitsDIdentite();
        t.setNomNaissance("D'ARTAGNAN DE L'HERAULT");
        t.setSexe("M");
        t.setDateNaissance("2001-06-17");
        t.setPrenom("PIERRE-ALAIN");

        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/ins/find_ins")
                        .content(objectToJsonString(t))
                        .contentType(MediaType.APPLICATION_JSON)
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isOk())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu").exists())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.codeCR",  is("00")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.libelleCR",  is("OK")));
    }

    @Test
    public void insV1FindInsPostTest_2_03_Cas2() throws Exception {
        TraitsDIdentite t = new TraitsDIdentite();
        t.setNomNaissance("ADRTROIS");
        t.setSexe("M");
        t.setDateNaissance("1960-01-01");
        t.setPrenom("TOUSSAINT");
        t.setLieuNaissance("2B020");

        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/ins/find_ins")
                        .content(objectToJsonString(t))
                        .contentType(MediaType.APPLICATION_JSON)
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isOk())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu").exists())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.codeCR",  is("00")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.libelleCR",  is("OK")));
    }

    @Test
    public void insV1FindInsPostTest_2_03_Cas3() throws Exception {
        TraitsDIdentite t = new TraitsDIdentite();
        t.setNomNaissance("D’ÆION"); // Æ invalide
        t.setSexe("M");
        t.setDateNaissance("1987-01-01");
        t.setPrenom("CŒUR"); // Œ invalide

        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/ins/find_ins")
                        .content(objectToJsonString(t))
                        .contentType(MediaType.APPLICATION_JSON)
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isBadRequest()); // pas d'appel INS
    }

    @Test
    public void insV1FindInsPostTest_2_04_Cas1() throws Exception {
        TraitsDIdentite t = new TraitsDIdentite();
        t.setNomNaissance("ECETINSI");
        t.setSexe("M");
        t.setDateNaissance("2009-07-14");
        t.setPrenom("PIERRE-ALAIN");

        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/ins/find_ins")
                        .content(objectToJsonString(t))
                        .contentType(MediaType.APPLICATION_JSON)
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isOk())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu").exists())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.codeCR",  is("00")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.libelleCR",  is("OK")));
    }
}
