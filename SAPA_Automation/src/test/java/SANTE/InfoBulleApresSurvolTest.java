package SANTE;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.springframework.transaction.annotation.Transactional;

import java.io.FileInputStream;
import java.io.IOException;
import java.time.Duration;
import java.util.Properties;

import static org.junit.jupiter.api.Assertions.assertEquals;

@Transactional
public class InfoBulleApresSurvolTest {


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
    public void TestSurvoleObser() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".form-horizontal")).click();
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".section-noir:nth-child(4) .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());



    }
    @Test
    public void TestSurvoleAffection() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".form-horizontal")).click();
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(10));
        driver.findElement(By.cssSelector(".can-be-hidden-2 > .section-noir .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    public void TestSurvolePathologie() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".form-horizontal")).click();
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".section-bleu:nth-child(2) > .section-titre-bleu > .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }

    @Test
    public void testSurvolCardiaq() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".row:nth-child(3) > .col-md-6:nth-child(1) .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    public void TestSurvoleRespiratoire() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".form-horizontal")).click();
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".row:nth-child(3) > .col-md-6:nth-child(2) .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }
    @Test
    public void TestSurvoleMetaboliq() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".form-horizontal")).click();
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".col-md-6:nth-child(1) > .section-bleu .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }
    @Test
    public void TestSurvoleOsteo() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".form-horizontal")).click();
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".col-md-6:nth-child(2) > .section-bleu .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }
    @Test
    public void TestSurvoleNeuro() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".form-horizontal")).click();
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".col-md-6:nth-child(1) > .section-vert .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }
    @Test
    public void TestSurvolePsycho() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".form-horizontal")).click();
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".col-md-6:nth-child(2) > .section-vert .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());
    }
    @Test
    public void testSurvolCancereuse() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".row:nth-child(6) > .col-md-6:nth-child(1) .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    public void testSurvolCirculatoire() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".row:nth-child(6) > .col-md-6:nth-child(2) .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    public void testSurvolAutres() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.cssSelector(".col-md-12 .infobulle")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }










































}
