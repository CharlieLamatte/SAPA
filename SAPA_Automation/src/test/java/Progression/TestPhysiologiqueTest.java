package Progression;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;

import java.io.FileInputStream;
import java.io.IOException;
import java.time.Duration;
import java.util.Properties;

import static org.junit.jupiter.api.Assertions.assertEquals;

public class TestPhysiologiqueTest {

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
    public void deplierTestPhysioEtCocherPoidsTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Progression")).click();
        driver.findElement(By.linkText("Test physiologique")).click();
        driver.findElement(By.linkText("Test physiologique")).click();
        driver.findElement(By.id("poids-checkbox")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Progression.php?idPatient=10", driver.getCurrentUrl());

    }
    @Test
    public void CocherDecochePlierToutTestPhysioTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Progression")).click();
        driver.findElement(By.id("poids-checkbox")).click();
        driver.findElement(By.id("poids-checkbox")).click();
        driver.findElement(By.id("poids-checkbox")).click();
        driver.findElement(By.id("tour_taille-checkbox")).click();
        driver.findElement(By.id("IMC-checkbox")).click();
        driver.findElement(By.id("fc_repos-checkbox")).click();
        driver.findElement(By.id("fc_max_mesuree-checkbox")).click();
        driver.findElement(By.id("saturation_repos-checkbox")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(40));
        driver.findElement(By.id("poids-checkbox")).click();
        driver.findElement(By.id("tour_taille-checkbox")).click();
        driver.findElement(By.id("IMC-checkbox")).click();
        driver.findElement(By.id("fc_repos-checkbox")).click();
        driver.findElement(By.id("fc_max_mesuree-checkbox")).click();
        driver.findElement(By.id("saturation_repos-checkbox")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(10));
        driver.findElement(By.linkText("Test physiologique")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Progression.php?idPatient=10", driver.getCurrentUrl());

    }



}
