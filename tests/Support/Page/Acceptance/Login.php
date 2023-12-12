<?php

namespace Tests\Support\Page\Acceptance;

use Tests\Support\AcceptanceTester;

class Login
{
    // include url of current page
    public static $URL = '/';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public $emailField = 'input[name=identifiant]';
    public $passwordField = 'input[name=pswd]';
    public $loginButton = 'button[type=submit]';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    protected AcceptanceTester $acceptanceTester;

    public function __construct(AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function login($email, $password)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL);
        $I->fillField($this->emailField, $email);
        $I->fillField($this->passwordField, $password);
        $I->click($this->loginButton);
        $I->waitPageLoad();
    }
}
