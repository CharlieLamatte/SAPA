package org.openapitools.model;

import java.util.Objects;
import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.annotation.JsonCreator;
import io.swagger.annotations.ApiModel;
import io.swagger.annotations.ApiModelProperty;
import java.util.ArrayList;
import java.util.List;
import org.openapitools.jackson.nullable.JsonNullable;
import javax.validation.Valid;
import javax.validation.constraints.*;

/**
 * TraitsDIdentite
 */
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
public class TraitsDIdentite   {
  @JsonProperty("nomNaissance")
  private String nomNaissance;

  @JsonProperty("prenom")
  private String prenom;

  @JsonProperty("listePrenom")
  @Valid
  private List<String> listePrenom = null;

  @JsonProperty("sexe")
  private String sexe;

  @JsonProperty("dateNaissance")
  private String dateNaissance;

  @JsonProperty("lieuNaissance")
  private String lieuNaissance;

  public TraitsDIdentite nomNaissance(String nomNaissance) {
    this.nomNaissance = nomNaissance;
    return this;
  }

  /**
   * Get nomNaissance
   * @return nomNaissance
  */
  @ApiModelProperty(example = "ADRDEUX", value = "")


  public String getNomNaissance() {
    return nomNaissance;
  }

  public void setNomNaissance(String nomNaissance) {
    this.nomNaissance = nomNaissance;
  }

  public TraitsDIdentite prenom(String prenom) {
    this.prenom = prenom;
    return this;
  }

  /**
   * Permier prénom
   * @return prenom
  */
  @ApiModelProperty(example = "LAURENT", value = "Permier prénom")


  public String getPrenom() {
    return prenom;
  }

  public void setPrenom(String prenom) {
    this.prenom = prenom;
  }

  public TraitsDIdentite listePrenom(List<String> listePrenom) {
    this.listePrenom = listePrenom;
    return this;
  }

  public TraitsDIdentite addListePrenomItem(String listePrenomItem) {
    if (this.listePrenom == null) {
      this.listePrenom = new ArrayList<>();
    }
    this.listePrenom.add(listePrenomItem);
    return this;
  }

  /**
   * Get listePrenom
   * @return listePrenom
  */
  @ApiModelProperty(value = "")


  public List<String> getListePrenom() {
    return listePrenom;
  }

  public void setListePrenom(List<String> listePrenom) {
    this.listePrenom = listePrenom;
  }

  public TraitsDIdentite sexe(String sexe) {
    this.sexe = sexe;
    return this;
  }

  /**
   * M ou F
   * @return sexe
  */
  @ApiModelProperty(example = "M", value = "M ou F")


  public String getSexe() {
    return sexe;
  }

  public void setSexe(String sexe) {
    this.sexe = sexe;
  }

  public TraitsDIdentite dateNaissance(String dateNaissance) {
    this.dateNaissance = dateNaissance;
    return this;
  }

  /**
   * La date de naissance au format AAAA-MM-JJ
   * @return dateNaissance
  */
  @ApiModelProperty(example = "1981-01-01", value = "La date de naissance au format AAAA-MM-JJ")


  public String getDateNaissance() {
    return dateNaissance;
  }

  public void setDateNaissance(String dateNaissance) {
    this.dateNaissance = dateNaissance;
  }

  public TraitsDIdentite lieuNaissance(String lieuNaissance) {
    this.lieuNaissance = lieuNaissance;
    return this;
  }

  /**
   * Get lieuNaissance
   * @return lieuNaissance
  */
  @ApiModelProperty(example = "63220", value = "")


  public String getLieuNaissance() {
    return lieuNaissance;
  }

  public void setLieuNaissance(String lieuNaissance) {
    this.lieuNaissance = lieuNaissance;
  }


  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || getClass() != o.getClass()) {
      return false;
    }
    TraitsDIdentite traitsDIdentite = (TraitsDIdentite) o;
    return Objects.equals(this.nomNaissance, traitsDIdentite.nomNaissance) &&
        Objects.equals(this.prenom, traitsDIdentite.prenom) &&
        Objects.equals(this.listePrenom, traitsDIdentite.listePrenom) &&
        Objects.equals(this.sexe, traitsDIdentite.sexe) &&
        Objects.equals(this.dateNaissance, traitsDIdentite.dateNaissance) &&
        Objects.equals(this.lieuNaissance, traitsDIdentite.lieuNaissance);
  }

  @Override
  public int hashCode() {
    return Objects.hash(nomNaissance, prenom, listePrenom, sexe, dateNaissance, lieuNaissance);
  }

  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class TraitsDIdentite {\n");
    
    sb.append("    nomNaissance: ").append(toIndentedString(nomNaissance)).append("\n");
    sb.append("    prenom: ").append(toIndentedString(prenom)).append("\n");
    sb.append("    listePrenom: ").append(toIndentedString(listePrenom)).append("\n");
    sb.append("    sexe: ").append(toIndentedString(sexe)).append("\n");
    sb.append("    dateNaissance: ").append(toIndentedString(dateNaissance)).append("\n");
    sb.append("    lieuNaissance: ").append(toIndentedString(lieuNaissance)).append("\n");
    sb.append("}");
    return sb.toString();
  }

  /**
   * Convert the given object to string with each line indented by 4 spaces
   * (except the first line).
   */
  private String toIndentedString(Object o) {
    if (o == null) {
      return "null";
    }
    return o.toString().replace("\n", "\n    ");
  }
}

