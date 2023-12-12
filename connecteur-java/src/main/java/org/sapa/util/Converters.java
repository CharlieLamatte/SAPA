package org.sapa.util;


import com.fasterxml.jackson.databind.ObjectMapper;

import java.util.ArrayList;
import java.util.Arrays;

public class Converters {
    /**
     *
     * @param input
     * @return the input converted to fr.cnamts.insirecsans.TraitsDIdentite
     */
    public static fr.cnamts.insirecsans.TraitsDIdentite convertTraitsDIdentite(org.openapitools.model.TraitsDIdentite input) {
        if (input == null) {
            return null;
        }

        fr.cnamts.insirecsans.TraitsDIdentite output = new fr.cnamts.insirecsans.TraitsDIdentite();

        output.setSexe(input.getSexe());
        output.setDateNaissance(input.getDateNaissance());
        output.setLieuNaissance(input.getLieuNaissance());
        output.setNomNaissance(input.getNomNaissance());

        if (input.getListePrenom() != null) {
            for (String prenom : input.getListePrenom()) {
                output.getPrenom().add(prenom);
            }
        } else {
            output.getPrenom().add(input.getPrenom());
        }

        return output;
    }

    /**
     *
     * @param input
     * @return the input converted to org.openapitools.model.Resultat
     */
    public static org.openapitools.model.Resultat convertResultat(fr.cnamts.insiresultat.Resultat input) {
        if (input == null) {
            return null;
        }

        org.openapitools.model.Resultat output = new org.openapitools.model.Resultat();

        if (input.getCR() != null) {
            org.openapitools.model.ResultatCompteRendu compteRendu = new org.openapitools.model.ResultatCompteRendu();
            compteRendu.setCodeCR(input.getCR().getCodeCR());
            compteRendu.setLibelleCR(input.getCR().getLibelleCR());

            output.setCompteRendu(compteRendu);
        }

        if (input.getINDIVIDU() != null) {
            org.openapitools.model.ResultatIndividu individu = new org.openapitools.model.ResultatIndividu();

            if (input.getINDIVIDU().getINSACTIF() != null) {
                individu.setInsActif(convertIdentifiantNationalSante(input.getINDIVIDU().getINSACTIF()));
            }

            if (input.getINDIVIDU().getINSHISTO() != null && input.getINDIVIDU().getINSHISTO().size() > 0) {
                ArrayList<org.openapitools.model.IdentifiantNationalSante> histo = new ArrayList<>();
                for (fr.cnamts.insiresultat.IdentifiantNationalSante ins: input.getINDIVIDU().getINSHISTO()) {
                    histo.add(convertIdentifiantNationalSante(ins));
                }

                individu.setInsHistorique(histo);
            }

            if (input.getINDIVIDU().getTIQ() != null) {
                org.openapitools.model.TraitsDIdentite tiq = new org.openapitools.model.TraitsDIdentite();
                tiq.setDateNaissance(input.getINDIVIDU().getTIQ().getDateNaissance());
                tiq.setSexe(input.getINDIVIDU().getTIQ().getSexe());
                tiq.setLieuNaissance(input.getINDIVIDU().getTIQ().getLieuNaissance());
                tiq.setPrenom(input.getINDIVIDU().getTIQ().getPrenom());
                tiq.setNomNaissance(input.getINDIVIDU().getTIQ().getNomNaissance());

                if (input.getINDIVIDU().getTIQ().getListePrenom() != null) {
                    String[] prenoms = input.getINDIVIDU().getTIQ().getListePrenom().split(" ");
                    tiq.setListePrenom(Arrays.asList(prenoms));
                }

                if (input.getINDIVIDU().getTIQ().getPrenom() == null && (tiq.getListePrenom() != null && tiq.getListePrenom().size() > 0) ) {
                    tiq.setPrenom(tiq.getListePrenom().get(0));
                }

                individu.setTraitsIdentite(tiq);
            }

            output.setIndividu(individu);
        }

        return output;
    }

    /**
     *
     * @param input
     * @return the input converted to org.openapitools.model.IdentifiantNationalSante
     */
    public static org.openapitools.model.IdentifiantNationalSante convertIdentifiantNationalSante(fr.cnamts.insiresultat.IdentifiantNationalSante input) {
        if (input == null) {
            return null;
        }

        org.openapitools.model.IdentifiantNationalSante output = new org.openapitools.model.IdentifiantNationalSante();
        output.setOid(input.getOID());

        if (input.getIdIndividu() != null) {
            org.openapitools.model.IdentifiantNationalSanteMatricule matricule = new org.openapitools.model.IdentifiantNationalSanteMatricule();
            matricule.setCle(input.getIdIndividu().getCle());
            matricule.setNumIdentifiant(input.getIdIndividu().getNumIdentifiant());
            matricule.setTypeMatricule(input.getIdIndividu().getTypeMatricule());

            output.setMatricule(matricule);
        }

        return output;
    }

    /**
     * @param obj an object
     * @return the object converted to a JSON formatted string
     */
    public static String objectToJsonString(final Object obj) {
        try {
            return new ObjectMapper().writerWithDefaultPrettyPrinter().writeValueAsString(obj);
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }
}
