package org.openapitools.model;

import java.util.Objects;
import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.annotation.JsonCreator;
import io.swagger.annotations.ApiModel;
import io.swagger.annotations.ApiModelProperty;
import java.time.LocalDate;
import org.openapitools.model.IdentifiantNationalSanteMatricule;
import org.openapitools.jackson.nullable.JsonNullable;
import javax.validation.Valid;
import javax.validation.constraints.*;

/**
 * IdentifiantNationalSante
 */
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.SpringCodegen", date = "2023-07-17T18:08:41.546000800+02:00[Europe/Paris]")
public class IdentifiantNationalSante   {
  @JsonProperty("matricule")
  private IdentifiantNationalSanteMatricule matricule;

  @JsonProperty("oid")
  private String oid;

  @JsonProperty("dateDeb")
  @org.springframework.format.annotation.DateTimeFormat(iso = org.springframework.format.annotation.DateTimeFormat.ISO.DATE)
  private LocalDate dateDeb;

  @JsonProperty("dateFin")
  @org.springframework.format.annotation.DateTimeFormat(iso = org.springframework.format.annotation.DateTimeFormat.ISO.DATE)
  private LocalDate dateFin;

  public IdentifiantNationalSante matricule(IdentifiantNationalSanteMatricule matricule) {
    this.matricule = matricule;
    return this;
  }

  /**
   * Get matricule
   * @return matricule
  */
  @ApiModelProperty(required = true, value = "")
  @NotNull

  @Valid

  public IdentifiantNationalSanteMatricule getMatricule() {
    return matricule;
  }

  public void setMatricule(IdentifiantNationalSanteMatricule matricule) {
    this.matricule = matricule;
  }

  public IdentifiantNationalSante oid(String oid) {
    this.oid = oid;
    return this;
  }

  /**
   * Get oid
   * @return oid
  */
  @ApiModelProperty(example = "1.2.250.1.213.1.4.8", required = true, value = "")
  @NotNull


  public String getOid() {
    return oid;
  }

  public void setOid(String oid) {
    this.oid = oid;
  }

  public IdentifiantNationalSante dateDeb(LocalDate dateDeb) {
    this.dateDeb = dateDeb;
    return this;
  }

  /**
   * date au format XMLGregorianCalendar, TODO vérifier conversion
   * @return dateDeb
  */
  @ApiModelProperty(value = "date au format XMLGregorianCalendar, TODO vérifier conversion")

  @Valid

  public LocalDate getDateDeb() {
    return dateDeb;
  }

  public void setDateDeb(LocalDate dateDeb) {
    this.dateDeb = dateDeb;
  }

  public IdentifiantNationalSante dateFin(LocalDate dateFin) {
    this.dateFin = dateFin;
    return this;
  }

  /**
   * date au format XMLGregorianCalendar, TODO vérifier conversion
   * @return dateFin
  */
  @ApiModelProperty(value = "date au format XMLGregorianCalendar, TODO vérifier conversion")

  @Valid

  public LocalDate getDateFin() {
    return dateFin;
  }

  public void setDateFin(LocalDate dateFin) {
    this.dateFin = dateFin;
  }


  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || getClass() != o.getClass()) {
      return false;
    }
    IdentifiantNationalSante identifiantNationalSante = (IdentifiantNationalSante) o;
    return Objects.equals(this.matricule, identifiantNationalSante.matricule) &&
        Objects.equals(this.oid, identifiantNationalSante.oid) &&
        Objects.equals(this.dateDeb, identifiantNationalSante.dateDeb) &&
        Objects.equals(this.dateFin, identifiantNationalSante.dateFin);
  }

  @Override
  public int hashCode() {
    return Objects.hash(matricule, oid, dateDeb, dateFin);
  }

  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class IdentifiantNationalSante {\n");
    
    sb.append("    matricule: ").append(toIndentedString(matricule)).append("\n");
    sb.append("    oid: ").append(toIndentedString(oid)).append("\n");
    sb.append("    dateDeb: ").append(toIndentedString(dateDeb)).append("\n");
    sb.append("    dateFin: ").append(toIndentedString(dateFin)).append("\n");
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

