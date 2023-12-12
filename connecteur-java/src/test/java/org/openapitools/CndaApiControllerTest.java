package org.openapitools;

import org.junit.Test;
import org.junit.runner.RunWith;
import org.openapitools.api.CndaApiController;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.web.servlet.WebMvcTest;
import org.springframework.http.MediaType;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.test.web.servlet.MockMvc;
import org.springframework.test.web.servlet.request.MockMvcRequestBuilders;
import org.springframework.test.web.servlet.result.MockMvcResultMatchers;

import static org.hamcrest.Matchers.is;
import static org.springframework.test.web.servlet.result.MockMvcResultHandlers.print;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.status;

@RunWith(SpringRunner.class)
@WebMvcTest(controllers = CndaApiController.class)
public class CndaApiControllerTest {

    @Autowired
    private MockMvc mockMvc;

    @Test
    public void cndaInjectPostTestOk() throws Exception {
        // fichier REP_CR01
        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/cnda/inject?fileName=REP_CR01")
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isOk())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu").exists())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.codeCR", is("01")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.libelleCR", is("Aucune identite trouvee")));

        // fichier TEST_2.04_cas2
        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/cnda/inject?fileName=TEST_2.04_cas2")
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isOk())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu").exists())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.codeCR", is("00")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.libelleCR", is("OK")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.individu.insActif.matricule.numIdentifiant", is("1090763220834")));

        // fichier TEST_2.05
        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/cnda/inject?fileName=TEST_2.05")
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isOk())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu").exists())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.codeCR", is("00")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.libelleCR", is("OK")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.individu.insActif.matricule.numIdentifiant", is("1090763220888")));

        // fichier TEST_2.08_cas1
        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/cnda/inject?fileName=TEST_2.08_cas1")
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isOk())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu").exists())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.codeCR", is("00")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.libelleCR", is("OK")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.individu.insActif.matricule.numIdentifiant", is("180032B020401")));

        // fichier TEST_2.08_cas2
        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/cnda/inject?fileName=TEST_2.08_cas2")
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isOk())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu").exists())
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.codeCR", is("00")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.compteRendu.libelleCR", is("OK")))
                .andExpect(MockMvcResultMatchers.jsonPath("$.individu.insActif.matricule.numIdentifiant", is("1810363220456")));
    }

    @Test
    public void cndaInjectPostTestNotOk() throws Exception {
        // fileName missing
        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/cnda/inject")
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isBadRequest());

        // fileName invalid
        mockMvc.perform(MockMvcRequestBuilders
                        .post("/v1/cnda/inject?fileName=sdfdfs")
                        .accept(MediaType.APPLICATION_JSON))
                .andDo(print())
                .andExpect(status().isBadRequest());
    }
}
