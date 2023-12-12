package com.example.sapa_automation.Header;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.Dimension;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;

import static org.junit.jupiter.api.Assertions.assertEquals;

import java.io.FileInputStream;
import java.io.IOException;
import java.util.Properties;

public class DeconnectionTest {

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
    public void testDeconnectionOk() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.cssSelector(".glyphicon-off")).click();
        assertEquals(("Etes-vous sûr de vouloir vous déconnecter ?"), driver.switchTo().alert().getText());
        driver.switchTo().alert().accept();
        assertEquals(driver.getCurrentUrl(), "https://suivibeneficiairesauto.sportsante86.fr/index.php");

    }

    @Test
    public void testDeconnectionAbort() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.cssSelector(".glyphicon-off")).click();
        assertEquals(driver.switchTo().alert().getText(),("Etes-vous sûr de vouloir vous déconnecter ?"));
        driver.switchTo().alert().dismiss();
        assertEquals(driver.getCurrentUrl(), "https://suivibeneficiairesauto.sportsante86.fr/PHP/Accueil_liste.php");

    }

}
