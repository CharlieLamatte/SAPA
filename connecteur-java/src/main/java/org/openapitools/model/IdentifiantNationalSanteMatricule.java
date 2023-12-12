package org.openapitools.model;

import java.util.Objects;
import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.annotation.JsonCreator;
import io.swagger.annotations.ApiModel;
import io.swagger.annotations.ApiModelProperty;
import org.openapitools.jackson.nullable.JsonNullable;
import javax.validation.Valid;
import javax.validation.constraints.*;

/**
 * IdentifiantNationalSanteMatricule
 */
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
public class IdentifiantNationalSanteMatricule   {
  @JsonProperty("numIdentifiant")
  private String numIdentifiant;

  @JsonProperty("cle")
  private String cle;

  @JsonProperty("typeMatricule")
  private String typeMatricule;

  public IdentifiantNationalSanteMatricule numIdentifiant(String numIdentifiant) {
    this.numIdentifiant = numIdentifiant;
    return this;
  }

  /**
   * Get numIdentifiant
   * @return numIdentifiant
  */
  @ApiModelProperty(example = "1810163220751", required = true, value = "")
  @NotNull


  public String getNumIdentifiant() {
    return numIdentifiant;
  }

  public void setNumIdentifiant(String numIdentifiant) {
    this.numIdentifiant = numIdentifiant;
  }

  public IdentifiantNationalSanteMatricule cle(String cle) {
    this.cle = cle;
    return this;
  }

  /**
   * Get cle
   * @return cle
  */
  @ApiModelProperty(example = "40", value = "")


  public String getCle() {
    return cle;
  }

  public void setCle(String cle) {
    this.cle = cle;
  }

  public IdentifiantNationalSanteMatricule typeMatricule(String typeMatricule) {
    this.typeMatricule = typeMatricule;
    return this;
  }

  /**
   * Get typeMatricule
   * @return typeMatricule
  */
  @ApiModelProperty(value = "")


  public String getTypeMatricule() {
    return typeMatricule;
  }

  public void setTypeMatricule(String typeMatricule) {
    this.typeMatricule = typeMatricule;
  }


  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || getClass() != o.getClass()) {
      return false;
    }
    IdentifiantNationalSanteMatricule identifiantNationalSanteMatricule = (IdentifiantNationalSanteMatricule) o;
    return Objects.equals(this.numIdentifiant, identifiantNationalSanteMatricule.numIdentifiant) &&
        Objects.equals(this.cle, identifiantNationalSanteMatricule.cle) &&
        Objects.equals(this.typeMatricule, identifiantNationalSanteMatricule.typeMatricule);
  }

  @Override
  public int hashCode() {
    return Objects.hash(numIdentifiant, cle, typeMatricule);
  }

  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class IdentifiantNationalSanteMatricule {\n");
    
    sb.append("    numIdentifiant: ").append(toIndentedString(numIdentifiant)).append("\n");
    sb.append("    cle: ").append(toIndentedString(cle)).append("\n");
    sb.append("    typeMatricule: ").append(toIndentedString(typeMatricule)).append("\n");
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

