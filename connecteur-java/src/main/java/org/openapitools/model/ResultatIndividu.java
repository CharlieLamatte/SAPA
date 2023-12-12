package org.openapitools.model;

import java.util.Objects;
import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.annotation.JsonCreator;
import io.swagger.annotations.ApiModel;
import io.swagger.annotations.ApiModelProperty;
import java.util.ArrayList;
import java.util.List;
import org.openapitools.model.IdentifiantNationalSante;
import org.openapitools.model.TraitsDIdentite;
import org.openapitools.jackson.nullable.JsonNullable;
import javax.validation.Valid;
import javax.validation.constraints.*;

/**
 * ResultatIndividu
 */
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
public class ResultatIndividu   {
  @JsonProperty("insActif")
  private IdentifiantNationalSante insActif;

  @JsonProperty("insHistorique")
  @Valid
  private List<IdentifiantNationalSante> insHistorique = null;

  @JsonProperty("traitsIdentite")
  private TraitsDIdentite traitsIdentite;

  public ResultatIndividu insActif(IdentifiantNationalSante insActif) {
    this.insActif = insActif;
    return this;
  }

  /**
   * Get insActif
   * @return insActif
  */
  @ApiModelProperty(required = true, value = "")
  @NotNull

  @Valid

  public IdentifiantNationalSante getInsActif() {
    return insActif;
  }

  public void setInsActif(IdentifiantNationalSante insActif) {
    this.insActif = insActif;
  }

  public ResultatIndividu insHistorique(List<IdentifiantNationalSante> insHistorique) {
    this.insHistorique = insHistorique;
    return this;
  }

  public ResultatIndividu addInsHistoriqueItem(IdentifiantNationalSante insHistoriqueItem) {
    if (this.insHistorique == null) {
      this.insHistorique = new ArrayList<>();
    }
    this.insHistorique.add(insHistoriqueItem);
    return this;
  }

  /**
   * Get insHistorique
   * @return insHistorique
  */
  @ApiModelProperty(value = "")

  @Valid

  public List<IdentifiantNationalSante> getInsHistorique() {
    return insHistorique;
  }

  public void setInsHistorique(List<IdentifiantNationalSante> insHistorique) {
    this.insHistorique = insHistorique;
  }

  public ResultatIndividu traitsIdentite(TraitsDIdentite traitsIdentite) {
    this.traitsIdentite = traitsIdentite;
    return this;
  }

  /**
   * Get traitsIdentite
   * @return traitsIdentite
  */
  @ApiModelProperty(required = true, value = "")
  @NotNull

  @Valid

  public TraitsDIdentite getTraitsIdentite() {
    return traitsIdentite;
  }

  public void setTraitsIdentite(TraitsDIdentite traitsIdentite) {
    this.traitsIdentite = traitsIdentite;
  }


  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || getClass() != o.getClass()) {
      return false;
    }
    ResultatIndividu resultatIndividu = (ResultatIndividu) o;
    return Objects.equals(this.insActif, resultatIndividu.insActif) &&
        Objects.equals(this.insHistorique, resultatIndividu.insHistorique) &&
        Objects.equals(this.traitsIdentite, resultatIndividu.traitsIdentite);
  }

  @Override
  public int hashCode() {
    return Objects.hash(insActif, insHistorique, traitsIdentite);
  }

  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class ResultatIndividu {\n");
    
    sb.append("    insActif: ").append(toIndentedString(insActif)).append("\n");
    sb.append("    insHistorique: ").append(toIndentedString(insHistorique)).append("\n");
    sb.append("    traitsIdentite: ").append(toIndentedString(traitsIdentite)).append("\n");
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

