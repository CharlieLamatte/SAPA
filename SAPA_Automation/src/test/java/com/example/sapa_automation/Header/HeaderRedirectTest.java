package com.example.sapa_automation.Header;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;

import java.io.FileInputStream;
import java.io.IOException;
import java.time.Duration;
import java.util.Properties;

import static org.junit.jupiter.api.Assertions.assertEquals;

public class HeaderRedirectTest {
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
    public void testRedirectBeneficiary() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Bénéficiaire")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/AccueilPatient.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectPrescription() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Prescription")).click();
        assertEquals( "https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Prescription.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectSante() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectActivitePhysique() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectEvaluations() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Évaluations")).click();
        assertEquals( "https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Evaluation.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectQuestionnaires() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Questionnaires")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Questionnaires.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectObjectifs() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectOrientation() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Orientation")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Orientation.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectProgramme() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Programme")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Programme.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirectSynthese() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Synthèse")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Synthese.php?idPatient=2", driver.getCurrentUrl());
    }

    @Test
    public void testRedirecProgression() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(3));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Progression")).click();
        assertEquals( "https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Progression.php?idPatient=2", driver.getCurrentUrl());
    }

}
