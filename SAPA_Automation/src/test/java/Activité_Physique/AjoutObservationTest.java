package Activité_Physique;

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
public class AjoutObservationTest {
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
    public void testAjoutObserAntrieur() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.name("observation")).click();
        driver.findElement(By.name("observation")).sendKeys("RAS");
        driver.findElement(By.name("ajout_obs_ant")).click();
        driver.findElement(By.id("activite_anterieure_textarea")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    @Rollback
    public void testAjoutObserAutonome() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#activite_physique_autonome input")).click();
        driver.findElement(By.cssSelector("#activite_physique_autonome input")).sendKeys("Ras");
        driver.findElement(By.name("ajout_obs_auto")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testAjoutObserEncadre() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#activite_physique_encadree input")).click();
        driver.findElement(By.cssSelector("#activite_physique_encadree input")).sendKeys("Ras");
        driver.findElement(By.name("ajout_obs_encadree")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testAjoutObserDispo() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#disponibilite input")).click();
        driver.findElement(By.cssSelector("#disponibilite input")).sendKeys("Ras");
        driver.findElement(By.name("ajout_obs_dispo")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testAjoutObserEnvisagee() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(5));
        //driver.findElement(By.cssSelector("#activite_physique_envisagee input")).click();
        driver.findElement(By.cssSelector("#activite_physique_envisagee input")).sendKeys("Ras");
        driver.findElement(By.name("ajout_obs_envisage")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testAjoutObserFreinActivite() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#frein_activite input")).click();
        driver.findElement(By.cssSelector("#frein_activite input")).sendKeys("Ras");
        driver.findElement(By.name("ajout_obs_frein")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testAjoutObserPointFort() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#point_fort_levier input")).click();
        driver.findElement(By.cssSelector("#point_fort_levier input")).sendKeys("Ras");
        driver.findElement(By.name("ajout_obs_ptn")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testEspaceObserAntrieur() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.name("observation")).click();
        driver.findElement(By.name("observation")).sendKeys(" ");
        driver.findElement(By.name("ajout_obs_ant")).click();
        driver.findElement(By.id("activite_anterieure_textarea")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testEspaceObserAutonome() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#activite_physique_autonome input")).click();
        driver.findElement(By.cssSelector("#activite_physique_autonome input")).sendKeys(" ");
        driver.findElement(By.name("ajout_obs_auto")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testEspaceObserEncadre() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#activite_physique_encadree input")).click();
        driver.findElement(By.cssSelector("#activite_physique_encadree input")).sendKeys(" ");
        driver.findElement(By.name("ajout_obs_encadree")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testEspaceObserDispo() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#disponibilite input")).click();
        driver.findElement(By.cssSelector("#disponibilite input")).sendKeys(" ");
        driver.findElement(By.name("ajout_obs_dispo")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testEspaceObserEnvisagee() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(5));
       // driver.findElement(By.cssSelector("#activite_physique_envisagee input")).click();
        driver.findElement(By.cssSelector("#activite_physique_envisagee input")).sendKeys(" ");
        driver.findElement(By.name("ajout_obs_envisage")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testEspaceObserFreinActivite() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#frein_activite input")).click();
        driver.findElement(By.cssSelector("#frein_activite input")).sendKeys(" ");
        driver.findElement(By.name("ajout_obs_frein")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }
    @Test
    @Rollback
    public void testEspaceObserPointFort() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Activité Physique")).click();
        driver.findElement(By.cssSelector("#point_fort_levier input")).click();
        driver.findElement(By.cssSelector("#point_fort_levier input")).sendKeys(" ");
        driver.findElement(By.name("ajout_obs_ptn")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Ap.php?idPatient=10", driver.getCurrentUrl());


    }












































}
