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
public class ObservationSanteTest {


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
    public void testAddRASObervation() {
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
        driver.findElement(By.id("observation")).click();
        driver.findElement(By.id("observation")).sendKeys("RAS");
        driver.findElement(By.id("ajouterobservation")).click();
        driver.findElement(By.id("obs")).click();
        //assertEquals(driver.findElement(By.id("obs")).getText(), ("  Chassin Thomas 16/03/2022: RAS\\\\n  Chassin Thomas 16/03/2022: RAS\\\\n  Chassin Thomas 16/03/2022: RAS\\\\n  Chassin Thomas 16/03/2022: RAS\\\\n  Chassin Thomas 15/03/2022: RAS\\\\n  Chassin Thomas 13/03/2022: RAS\\\\n  Chassin Thomas 13/03/2022: RAS"));
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testAjouterSansTextObervation() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("ajouterobservation")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

    @Test
    @Rollback
    public void testAjoutEspaceObservation() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".odd > .text-left:nth-child(3)")).click();
        driver.findElement(By.linkText("Santé")).click();
        driver.findElement(By.id("observation")).click();
        driver.findElement(By.id("observation")).sendKeys(" ");
        driver.findElement(By.id("ajouterobservation")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Sante.php?idPatient=10", driver.getCurrentUrl());

    }

}
