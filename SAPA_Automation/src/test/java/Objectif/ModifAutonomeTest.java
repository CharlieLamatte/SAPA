package Objectif;

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

public class ModifAutonomeTest {

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
    public void modifNomDateDescriptTest() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).click();
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).click();
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.cssSelector(".text-left:nth-child(2)")).click();
        driver.findElement(By.linkText("Objectifs")).click();
        driver.findElement(By.cssSelector("#buttons-1 > .btn-warning")).click();
        driver.findElement(By.id("nom")).click();
        driver.findElement(By.id("nom")).sendKeys("TOTO");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("description")).click();
        driver.findElement(By.id("description")).sendKeys("MALADE");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("date-debut")).click();
        driver.findElement(By.id("date-debut")).sendKeys("2022-04-06");
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(2));
        driver.findElement(By.id("enregistrer-modifier")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/PHP/Patients/Objectifs.php?idPatient=10", driver.getCurrentUrl());

    }

}
