package com.example.sapa_automation.Beneficiary;

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

public class CheckBeneficiaryTest {
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
    public void verifyCorrectInfoBeneficiray() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.manage().window().setSize(new Dimension(1200, 747));
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.manage().timeouts().implicitlyWait(Duration.ofSeconds(5));
        assertEquals("DURAND", driver.findElement(By.cssSelector(".text-left:nth-child(2)")).getText());
        assertEquals("Jacques", driver.findElement(By.cssSelector(".text-left:nth-child(3)")).getText());
        assertEquals("SPORT SANTE 86", driver.findElement(By.cssSelector(".text-left:nth-child(4)")).getText());
        assertEquals("01/03/2022", driver.findElement(By.cssSelector(".text-left:nth-child(5)")).getText());
        assertEquals("0666455221", driver.findElement(By.cssSelector(".text-left:nth-child(6)")).getText());
        assertEquals("durand.jacques@test.com", driver.findElement(By.cssSelector(".text-left:nth-child(7)")).getText());
        assertEquals("Arianne COURTEMANCHE", driver.findElement(By.cssSelector(".text-left:nth-child(8)")).getText());
        assertEquals("SPORT SANTE 86", driver.findElement(By.cssSelector(".text-left:nth-child(9)")).getText());
        assertEquals("Chassin Thomas (Coordinateur)", driver.findElement(By.cssSelector(".text-left:nth-child(10)")).getText());

    }
}
