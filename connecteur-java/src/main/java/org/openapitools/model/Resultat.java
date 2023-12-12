package org.openapitools.model;

import java.util.Objects;
import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.annotation.JsonCreator;
import io.swagger.annotations.ApiModel;
import io.swagger.annotations.ApiModelProperty;
import org.openapitools.model.ResultatCompteRendu;
import org.openapitools.model.ResultatIndividu;
import org.openapitools.jackson.nullable.JsonNullable;
import javax.validation.Valid;
import javax.validation.constraints.*;

/**
 * Resultat
 */
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
public class Resultat   {
  @JsonProperty("compteRendu")
  private ResultatCompteRendu compteRendu;

  @JsonProperty("individu")
  private ResultatIndividu individu;

  public Resultat compteRendu(ResultatCompteRendu compteRendu) {
    this.compteRendu = compteRendu;
    return this;
  }

  /**
   * Get compteRendu
   * @return compteRendu
  */
  @ApiModelProperty(required = true, value = "")
  @NotNull

  @Valid

  public ResultatCompteRendu getCompteRendu() {
    return compteRendu;
  }

  public void setCompteRendu(ResultatCompteRendu compteRendu) {
    this.compteRendu = compteRendu;
  }

  public Resultat individu(ResultatIndividu individu) {
    this.individu = individu;
    return this;
  }

  /**
   * Get individu
   * @return individu
  */
  @ApiModelProperty(value = "")

  @Valid

  public ResultatIndividu getIndividu() {
    return individu;
  }

  public void setIndividu(ResultatIndividu individu) {
    this.individu = individu;
  }


  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || getClass() != o.getClass()) {
      return false;
    }
    Resultat resultat = (Resultat) o;
    return Objects.equals(this.compteRendu, resultat.compteRendu) &&
        Objects.equals(this.individu, resultat.individu);
  }

  @Override
  public int hashCode() {
    return Objects.hash(compteRendu, individu);
  }

  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class Resultat {\n");
    
    sb.append("    compteRendu: ").append(toIndentedString(compteRendu)).append("\n");
    sb.append("    individu: ").append(toIndentedString(individu)).append("\n");
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

