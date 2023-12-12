package SANTE;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
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
public class ConsentementSanteTest {


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
    public void testInformNOppPasConsentment() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("accord-oui")).click();
        driver.findElement(By.cssSelector(".col-md-12 > .btn-sm")).click();
        assertEquals(driver.findElement(By.cssSelector(".col-md-12 > .btn-sm")).getText(), ("Enregistrer"));
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testInformOppConsentement() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("accord-non")).click();
        driver.findElement(By.cssSelector(".col-md-12 > .btn-sm")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testDmarcheConsentement() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("accord-attente")).click();
        driver.findElement(By.cssSelector(".col-md-12 > .btn-sm")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testVoirPlusInfo() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(2)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("voir-plus")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testVoirMoinsInfo() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("voir-plus")).click();
        driver.findElement(By.id("voir-plus")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }













}
