package SANTE;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.Dimension;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.springframework.test.annotation.Rollback;
import org.springframework.transaction.annotation.Transactional;

import java.io.FileInputStream;
import java.io.IOException;
import java.time.Duration;
import java.util.Properties;

import static org.junit.jupiter.api.Assertions.assertEquals;

@Transactional
public class PathologieSanteTest {


    private WebDriver driver;
    JavascriptExecutor js;

    @BeforeEach
    public void setUp() throws IOException {
        Properties prop = new Properties();
        prop.load(new FileInputStream("DriverProperties.txt"));
        String chromedriverpath = prop.getProperty("Path");
        System.setProperty("webdriver.chrome.driver", chromedriverpath);
        driver = new ChromeDriver();
        js = (JavascriptExecutor) driver;
    }

    @AfterEach
    public void tearDown() {
        driver.quit();
    }


    @Test
    @Rollback
    public void testPAthoCardiaqAjout() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".row:nth-child(3) > .col-md-6:nth-child(1) > .section-rouge")).click();
        driver.findElement(By.id("detail-cardio")).click();
        driver.findElement(By.id("detail-cardio")).sendKeys("maladie cardio");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPAthoCardiaqModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-cardio")).clear();
        driver.findElement(By.id("detail-cardio")).sendKeys("coranaire");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }
    @Test
    public void testPAthoCardiaqSupprim() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-cardio")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPathoRespiAjout() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-respi")).click();
        driver.findElement(By.id("detail-respi")).sendKeys("ashme");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testPAthoRespiModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-respi")).clear();
        driver.findElement(By.id("detail-respi")).sendKeys("BPCO");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }
    @Test
    public void testPAthoRespiSupprim() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-respi")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPathoMetaboAjou() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-metabo")).click();
        driver.findElement(By.id("detail-metabo")).sendKeys("maladie");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    public void testpatMetaModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-metabo")).clear();
        driver.findElement(By.id("detail-metabo")).sendKeys("bttt");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }



    @Test
    public void testPathoMetaboSup() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".col-md-6:nth-child(1) > .section-bleu .col-md-12")).click();
        driver.findElement(By.id("detail-metabo")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testPathoOstoAjou() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-osteo")).click();
        driver.findElement(By.id("detail-osteo")).sendKeys("osteopathie");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPathoOstoModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-osteo")).clear();
        driver.findElement(By.id("detail-osteo")).sendKeys("articulaire");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    public void testPathoOstoSupp() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-osteo")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }
    @Test
    @Rollback
    public void testPAthoNeuroAjout() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-neuro")).click();
        driver.findElement(By.id("detail-neuro")).sendKeys("alzheimer");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testPAthoNeuroModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-neuro")).clear();
        driver.findElement(By.id("detail-neuro")).sendKeys("AVC");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPAthoNeuroSupp() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-neuro")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testPAthoCanceroAjout() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-cancero")).click();
        driver.findElement(By.id("detail-cancero")).sendKeys("cancer du foi");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testPAthoCanceroModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-cancero")).clear();
        driver.findElement(By.id("detail-cancero")).sendKeys("tout cancer");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPAthoCanceroSupp() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-cancero")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testPAthoCirculAjout() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-circul")).click();
        driver.findElement(By.id("detail-circul")).sendKeys("maladie circulatoir");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testPAthoCirculModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-circul")).clear();
        driver.findElement(By.id("detail-circul")).sendKeys("disease");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPAthoCirculSupp() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-circul")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }


    @Test
    @Rollback
    public void testPAthoAutreAjout() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-autre")).click();
        driver.findElement(By.id("detail-autre")).sendKeys("autre maladie");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testPAthoAutreModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-autre")).clear();
        driver.findElement(By.id("detail-autre")).sendKeys("fièvre");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPAthoAutreSupp() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-autre")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }


    @Test
    @Rollback
    public void testPAthoPsychoAjout() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-psycho")).click();
        driver.findElement(By.id("detail-psycho")).sendKeys("autiste");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testPAthoPsychoModif() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-psycho")).clear();
        driver.findElement(By.id("detail-psycho")).sendKeys("depression");
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testPAthoPsychoSupp() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("detail-psycho")).clear();
        driver.findElement(By.id("modifier-pathologie")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }


















}
