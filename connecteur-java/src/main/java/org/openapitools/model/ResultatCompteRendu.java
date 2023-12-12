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
 * ResultatCompteRendu
 */
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
public class ResultatCompteRendu   {
  @JsonProperty("codeCR")
  private String codeCR;

  @JsonProperty("libelleCR")
  private String libelleCR;

  public ResultatCompteRendu codeCR(String codeCR) {
    this.codeCR = codeCR;
    return this;
  }

  /**
   * Get codeCR
   * @return codeCR
  */
  @ApiModelProperty(example = "00", required = true, value = "")
  @NotNull


  public String getCodeCR() {
    return codeCR;
  }

  public void setCodeCR(String codeCR) {
    this.codeCR = codeCR;
  }

  public ResultatCompteRendu libelleCR(String libelleCR) {
    this.libelleCR = libelleCR;
    return this;
  }

  /**
   * Get libelleCR
   * @return libelleCR
  */
  @ApiModelProperty(example = "OK", required = true, value = "")
  @NotNull


  public String getLibelleCR() {
    return libelleCR;
  }

  public void setLibelleCR(String libelleCR) {
    this.libelleCR = libelleCR;
  }


  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || getClass() != o.getClass()) {
      return false;
    }
    ResultatCompteRendu resultatCompteRendu = (ResultatCompteRendu) o;
    return Objects.equals(this.codeCR, resultatCompteRendu.codeCR) &&
        Objects.equals(this.libelleCR, resultatCompteRendu.libelleCR);
  }

  @Override
  public int hashCode() {
    return Objects.hash(codeCR, libelleCR);
  }

  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class ResultatCompteRendu {\n");
    
    sb.append("    codeCR: ").append(toIndentedString(codeCR)).append("\n");
    sb.append("    libelleCR: ").append(toIndentedString(libelleCR)).append("\n");
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

