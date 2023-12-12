package com.example.sapa_automation.Beneficiary;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.interactions.Actions;
import org.springframework.test.annotation.Rollback;
import org.springframework.transaction.annotation.Transactional;

import java.io.FileInputStream;
import java.io.IOException;
import java.time.Duration;
import java.util.Properties;

import static org.junit.jupiter.api.Assertions.*;

@Transactional
public class AddBeneficiaryTest {

    private WebDriver driver;
    JavascriptExecutor js;

    @BeforeEach
    public void setUp() throws IOException {
        Properties prop = new Properties();
        prop.load(new FileInputStream("DriverProperties.txt"));
        String chromedriverpath = prop.getProperty("Path");
        System.setProperty("webdriver.chrome.driver",chromedriverpath);
        driver =new ChromeDriver();
        js = (JavascriptExecutor) driver;
    }

    @AfterEach
    public void tearDown() {
        driver.quit();
    }

    @Test
    public void testRedirectFormAddBeneficary() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Ajout_Benef.php", driver.getCurrentUrl());
    }

    @Test
    public void testAddBenefeciaryEmptyForm() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        driver.findElement(By.name("enregistrer")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Ajout_Benef.php", driver.getCurrentUrl());
    }

    @Test
    public void addBeneficiaryAbortReturn() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1200, 747));
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        driver.findElement(By.cssSelector("legend > .btn")).click();
        driver.switchTo().alert().dismiss();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Ajout_Benef.php", driver.getCurrentUrl());
    }

    @Test
    public void addBeneficiaryReturn() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1200, 747));
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        driver.findElement(By.cssSelector("legend > .btn")).click();
        driver.switchTo().alert().accept();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Accueil_liste.php", driver.getCurrentUrl());
    }

    @Test
    @Rollback
    public void addBenefOk() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.id("pswd")).sendKeys(Keys.ENTER);
        driver.findElement(By.id("boutonAutre")).click();

        driver.findElement(By.id("da")).sendKeys("2022-03-01");
        driver.findElement(By.id("nom-patient")).sendKeys("PATIENT");
        driver.findElement(By.id("prenom-patient")).sendKeys("Titi");
        driver.findElement(By.id("dn")).sendKeys("01011978");
        driver.findElement(By.id("tel_f")).sendKeys("0555000000");
        driver.findElement(By.id("tel_p")).sendKeys("0666000000");
        driver.findElement(By.id("email-patient")).sendKeys("patient@titi.com");
        driver.findElement(By.id("adresse-patient")).sendKeys("12 rue titi");
        driver.findElement(By.id("complement-adresse-patient")).sendKeys("bat titi");
        driver.findElement(By.id("code-postal-patient")).click();
        driver.findElement(By.id("code-postal-patient")).sendKeys("86");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector("#code-postal-patientautocomplete-list > div:nth-child(1) > input")).click();
        driver.findElement(By.id("nom_urgence")).sendKeys("TOTO");
        driver.findElement(By.id("prenom_urgence")).sendKeys("Tutu");
        driver.findElement(By.id("id_lien")).click();
        {
            WebElement dropdown = driver.findElement(By.id("id_lien"));
            dropdown.findElement(By.xpath("//option[. = 'Voisin/Voisine']")).click();
        }
        driver.findElement(By.id("tel_urgence_f")).sendKeys("0555000001");
        driver.findElement(By.id("tel_urgence_p")).sendKeys("0666000001");
        driver.findElement(By.id("est-pris-en-charge")).click();
        driver.findElement(By.id("hauteur-prise-en-charge")).click();
        driver.findElement(By.id("hauteur-prise-en-charge")).sendKeys("60");
        driver.findElement(By.id("sit_part_prevention_chute")).click();
        driver.findElement(By.id("sit_part_education_therapeutique")).click();
        driver.findElement(By.id("sit_part_grossesse")).click();
        driver.findElement(By.id("sit_part_sedentarite")).click();
        driver.findElement(By.id("sit_part_autre")).sendKeys("RAS");
        driver.findElement(By.id("qpv")).click();
        driver.findElement(By.id("zrr")).click();
        driver.findElement(By.id("choix_prescrip")).sendKeys("COURTEMANCHE");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector("#choix_prescripautocomplete-list input")).click();
        driver.findElement(By.cssSelector("input:nth-child(4)")).click();
        driver.findElement(By.cssSelector("label:nth-child(3)")).click();
        driver.findElement(By.name("meme_med")).click();
        driver.findElement(By.id("choix_mutuelle")).click();
        driver.findElement(By.id("choix_mutuelle")).sendKeys("LA");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector("#choix_mutuelleautocomplete-list input")).click();
        driver.findElement(By.id("ville_cpam")).click();
        driver.findElement(By.id("ville_cpam")).sendKeys("POITIERS");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector("#ville_cpamautocomplete-list > div:nth-child(1) > input")).click();
        driver.findElement(By.name("enregistrer")).click();
        //assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/AccueilPatient.php?idPatient=3", driver.getCurrentUrl());
    }


    @Test
    public void testMandatoryFieldsAddBenef() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("nom-patient")).getAttribute("required"))));
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("prenom-patient")).getAttribute("required"))));
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("dn")).getAttribute("required"))));
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("adresse-patient")).getAttribute("required"))));
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("nom-patient")).getAttribute("required"))));
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("code-postal-patient")).getAttribute("required"))));
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("ville-patient")).getAttribute("required"))));
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("ville_cpam")).getAttribute("required"))));
    }

    @Test
    public void testReadOnlyFieldsAddBenef() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("ville-patient")).getAttribute("readonly"))));
        assertTrue(Boolean.parseBoolean((driver.findElement(By.id("cp_cpam")).getAttribute("required"))));
    }

    @Test
    @Rollback
    public void addBenefWithWrongEmail() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        driver.findElement(By.id("nom-patient")).sendKeys("PATIENT");
        driver.findElement(By.id("prenom-patient")).sendKeys("Titi");
        driver.findElement(By.id("dn")).sendKeys("1978-01-01");
        driver.findElement(By.id("email-patient")).sendKeys("toto");
        driver.findElement(By.id("adresse-patient")).sendKeys("12 rue titi ");
        driver.findElement(By.id("complement-adresse-patient")).sendKeys("bat titi ");
        driver.findElement(By.id("code-postal-patient")).sendKeys("86");
        driver.findElement(By.cssSelector("#code-postal-patientautocomplete-list > div:nth-child(1) > input")).click();
        driver.findElement(By.id("nom_urgence")).sendKeys("TOTO");
        driver.findElement(By.id("prenom_urgence")).sendKeys("Tutu");
        driver.findElement(By.id("tel_urgence_f")).sendKeys("05550000001");
        driver.findElement(By.id("tel_urgence_p")).sendKeys("06660000001");
        driver.findElement(By.id("choix_prescrip")).sendKeys("courtemanche");
        driver.findElement(By.cssSelector("#choix_prescripautocomplete-list input")).click();
        driver.findElement(By.id("choix_mutuelle")).click();
        driver.findElement(By.id("choix_mutuelle")).sendKeys("la");
        driver.findElement(By.cssSelector("#choix_mutuelleautocomplete-list input")).click();
        driver.findElement(By.id("ville_cpam")).click();
        driver.findElement(By.id("ville_cpam")).sendKeys("POITIERS");
        driver.findElement(By.cssSelector("#ville_cpamautocomplete-list > div:nth-child(1) > input")).click();
        driver.findElement(By.name("enregistrer")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Ajout_Benef.php", driver.getCurrentUrl());
    }

    @Test
    @Rollback
    public void addBenefWithWrongBenefPortable() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        driver.findElement(By.id("nom-patient")).sendKeys("PATIENT");
        driver.findElement(By.id("prenom-patient")).sendKeys("Titi");
        driver.findElement(By.id("dn")).sendKeys("1978-01-01");
        driver.findElement(By.id("tel_f")).sendKeys("dddddddddd");
        driver.findElement(By.id("email-patient")).sendKeys("patient@titi.com");
        driver.findElement(By.id("adresse-patient")).sendKeys("12 rue titi ");
        driver.findElement(By.id("complement-adresse-patient")).sendKeys("bat titi ");
        driver.findElement(By.id("code-postal-patient")).sendKeys("86");
        driver.findElement(By.cssSelector("#code-postal-patientautocomplete-list > div:nth-child(1) > input")).click();
        driver.findElement(By.id("nom_urgence")).sendKeys("TOTO");
        driver.findElement(By.id("prenom_urgence")).sendKeys("Tutu");
        driver.findElement(By.id("tel_urgence_f")).sendKeys("05550000001");
        driver.findElement(By.id("tel_urgence_p")).sendKeys("06660000001");
        driver.findElement(By.id("choix_prescrip")).sendKeys("courtemanche");
        driver.findElement(By.cssSelector("#choix_prescripautocomplete-list input")).click();
        driver.findElement(By.id("choix_mutuelle")).click();
        driver.findElement(By.id("choix_mutuelle")).sendKeys("la");
        driver.findElement(By.cssSelector("#choix_mutuelleautocomplete-list input")).click();
        driver.findElement(By.id("ville_cpam")).click();
        driver.findElement(By.id("ville_cpam")).sendKeys("POITIERS");
        driver.findElement(By.cssSelector("#ville_cpamautocomplete-list > div:nth-child(1) > input")).click();
        driver.findElement(By.name("enregistrer")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Ajout_Benef.php", driver.getCurrentUrl());
    }

    @Test
    @Rollback
    public void addBenefWithSamePhoneNumberBenef() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.id("boutonAutre")).click();
        driver.findElement(By.id("nom-patient")).sendKeys("PATIENT");
        driver.findElement(By.id("prenom-patient")).sendKeys("Titi");
        driver.findElement(By.id("dn")).sendKeys("1978-01-01");
        driver.findElement(By.id("tel_f")).sendKeys("0600000011");
        driver.findElement(By.id("tel_p")).sendKeys("0600000011");
        driver.findElement(By.id("email-patient")).sendKeys("patient@titi.com");
        driver.findElement(By.id("adresse-patient")).sendKeys("12 rue titi ");
        driver.findElement(By.id("complement-adresse-patient")).sendKeys("bat titi ");
        driver.findElement(By.id("code-postal-patient")).sendKeys("86");
        driver.findElement(By.cssSelector("#code-postal-patientautocomplete-list > div:nth-child(1) > input")).click();
        driver.findElement(By.id("nom_urgence")).sendKeys("TOTO");
        driver.findElement(By.id("prenom_urgence")).sendKeys("Tutu");
        driver.findElement(By.id("tel_urgence_f")).sendKeys("05550000001");
        driver.findElement(By.id("tel_urgence_p")).sendKeys("06660000001");
        driver.findElement(By.id("choix_prescrip")).sendKeys("courtemanche");
        driver.findElement(By.cssSelector("#choix_prescripautocomplete-list input")).click();
        driver.findElement(By.id("choix_mutuelle")).click();
        driver.findElement(By.id("choix_mutuelle")).sendKeys("la");
        driver.findElement(By.cssSelector("#choix_mutuelleautocomplete-list input")).click();
        driver.findElement(By.id("ville_cpam")).click();
        driver.findElement(By.id("ville_cpam")).sendKeys("POITIERS");
        driver.findElement(By.cssSelector("#ville_cpamautocomplete-list > div:nth-child(1) > input")).click();
        driver.findElement(By.name("enregistrer")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Ajout_Benef.php", driver.getCurrentUrl());
    }

}
