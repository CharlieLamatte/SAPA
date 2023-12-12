package com.example.sapa_automation;

import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.*;
import org.openqa.selenium.chrome.ChromeDriver;

import java.io.FileInputStream;
import java.io.IOException;
import java.util.Properties;

import static org.hamcrest.CoreMatchers.is;
import static org.junit.jupiter.api.Assertions.assertEquals;

public class ConnectionTest {

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
    void testLoginSuccess() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals("Bonjour Thomas Chassin du département : Vienne", driver.findElement(By.cssSelector("b")).getText());
    }

    @Test
    void testLoginWithOitherDepartment() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo64@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals("Bonjour Matin Martin du département : Pyrénées-Atlantiques", driver.findElement(By.cssSelector("b")).getText());
    }

    @Test
    void testLoginWithWrongPassWord() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("123456azerty");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals("Mot de passe ou email invalide.", driver.findElement(By.cssSelector(".text-center:nth-child(3)")).getText());

    }

    @Test
    void testLoginWithWrongUsername() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("toto@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals( "Mot de passe ou email invalide.", driver.findElement(By.cssSelector(".text-center:nth-child(3)")).getText());
    }

    @Test
    void testLoginWithWrongUserNameWithoutAt() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("totogmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals( "Mot de passe ou email invalide.", driver.findElement(By.cssSelector(".text-center:nth-child(3)")).getText());
    }


    @Test
    void testLoginWithWrongUserNameWithoutDot() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("toto@gmailcom");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals( "Mot de passe ou email invalide.", driver.findElement(By.cssSelector(".text-center:nth-child(3)")).getText());
    }

    @Test
    void testLoginWithWrongUserNameWithBlank() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("toto @gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("5f43b1e9040ea");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals( "Mot de passe ou email invalide.", driver.findElement(By.cssSelector(".text-center:nth-child(3)")).getText());
    }

    @Test
    void testLoginWithoutUsername() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("");
        driver.findElement(By.id("pswd")).sendKeys("5f43b1e9040ea");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/", driver.getCurrentUrl());
        //Verify that you can see an error message
    }

    @Test
    void testLoginWithoutPassword() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("thomas.chassin@sportsante86.fr");
        driver.findElement(By.id("pswd")).sendKeys("");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals("https://suivibeneficiairesauto.sportsante86.fr/", driver.getCurrentUrl());
        //Verify that you can see an error message

    }

    @Test
    void testLoginTwoTimesWrong() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("toto");
        driver.findElement(By.id("pswd")).sendKeys("toto");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals( "Mot de passe ou email invalide.", driver.findElement(By.cssSelector(".text-center:nth-child(3)")).getText());
        driver.findElement(By.id("identifiant")).sendKeys("toto");
        driver.findElement(By.id("pswd")).sendKeys("toto");
        driver.findElement(By.cssSelector(".btn")).click();
        assertEquals( "Mot de passe ou email invalide.", driver.findElement(By.cssSelector(".text-center:nth-child(3)")).getText());
    }

    @Test
    public void testHeaderHomeButton() {
        driver.get("https://suivibeneficiairesauto.sportsante86.fr/");
        driver.findElement(By.id("identifiant")).sendKeys("coordo86@gmail.com");
        driver.findElement(By.id("pswd")).sendKeys("Azerty123@");
        driver.findElement(By.cssSelector(".btn")).click();
        driver.findElement(By.cssSelector(".glyphicon-home")).click();
        assertEquals( "https://suivibeneficiairesauto.sportsante86.fr/PHP/Accueil_liste.php", driver.getCurrentUrl());

    }
}
