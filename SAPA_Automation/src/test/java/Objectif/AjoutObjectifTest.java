package Objectif;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.interactions.Actions;

import java.io.FileInputStream;
import java.io.IOException;
import java.time.Duration;
import java.util.Properties;

import static org.junit.jupiter.api.Assertions.assertEquals;

public class AjoutObjectifTest {
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
    public void accesFormulaireTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        driver.findElement(By.id("ajout-modal")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    public void abandonFormulaireTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(2)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        driver.findElement(By.id("ajout-modal")).click();
        driver.findElement(By.id("close")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    public void validerFormVideTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        driver.findElement(By.id("ajout-modal")).click();
        driver.findElement(By.id("enregistrer-modifier")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    public void saisieNomErroneTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        driver.findElement(By.id("ajout-modal")).click();
        driver.findElement(By.id("nom")).click();
        driver.findElement(By.id("nom")).sendKeys("11111111111111111111111");
        driver.findElement(By.id("description")).click();
        driver.findElement(By.id("description")).sendKeys("CV");
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).sendKeys("2022-04-28");
        driver.findElement(By.id("enregistrer-modifier")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    public void saisieDateTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(2)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        driver.findElement(By.id("ajout-modal")).click();
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("nom")).click();
        driver.findElement(By.id("nom")).sendKeys("DAME");
        driver.findElement(By.id("description")).click();
        driver.findElement(By.id("description")).sendKeys("dfg");
        driver.findElement(By.id("enregistrer-modifier")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    public void neRienEcrireTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1039, 720));
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        driver.findElement(By.id("ajout-modal")).click();
        driver.findElement(By.id("description")).click();
        driver.findElement(By.id("description")).sendKeys("dfgh");
        driver.findElement(By.id("enregistrer-modifier")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("nom")).sendKeys("drt");
        driver.findElement(By.id("enregistrer-modifier")).click();
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).sendKeys("2022-04-27");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("description")).click();
        driver.findElement(By.id("enregistrer-modifier")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    public void objectifAutonomTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        driver.findElement(By.id("ajout-modal")).click();
        driver.findElement(By.id("pratique")).click();
        {
            WebElement dropdown = driver.findElement(By.id("pratique"));
            dropdown.findElement(By.xpath("//option[. = 'Autonome']")).click();
        }
        {
            WebElement element = driver.findElement(By.id("modal"));
            Actions builder = new Actions(driver);
            builder.moveToElement(element).clickAndHold().perform();
        }
        {
            WebElement element = driver.findElement(By.id("modal"));
            Actions builder = new Actions(driver);
            builder.moveToElement(element).perform();
        }
        {
            WebElement element = driver.findElement(By.id("modal"));
            Actions builder = new Actions(driver);
            builder.moveToElement(element).release().perform();
        }
        driver.findElement(By.id("duree")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("duree")).sendKeys("22:04");
        driver.findElement(By.id("duree")).sendKeys("22:43");
        driver.findElement(By.cssSelector(".row:nth-child(3) .help-block")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("type-activite")).click();
        driver.findElement(By.id("type-activite")).sendKeys("GHJ");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("frequence")).click();
        driver.findElement(By.id("frequence")).sendKeys("HJKK");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("nom")).click();
        driver.findElement(By.id("nom")).sendKeys("HBG");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("description")).click();
        driver.findElement(By.id("description")).sendKeys("NJK");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).sendKeys("2022-04-27");
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=10", driver.getCurrentUrl());

    }


}
