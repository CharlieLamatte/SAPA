<?php

namespace Tests\Support\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Exception\ModuleException;
use Codeception\TestInterface;
use Exception;

class Acceptance extends \Codeception\Module
{
    /**
     * Event hook before a test starts.
     *
     * @param TestInterface $test
     * @throws Exception
     */
    public function _before(TestInterface $test)
    {
        if (!$this->hasModule('WebDriver') && !$this->hasModule('Selenium2')) {
            throw new Exception('PageWait uses the WebDriver. Please be sure that this module is activated.');
        }
    }

    /**
     * Waiting for ajax download.
     *
     * @param $timeout
     * @throws ModuleException
     */
    public function waitAjaxLoad($timeout = 10)
    {
        $this->getModule('WebDriver')->waitForJS('return !!window.jQuery && window.jQuery.active == 0;', $timeout);
        $this->getModule('WebDriver')->wait(1);
        $this->dontSeeJsError();
    }

    /**
     * Waiting for the page to load.
     *
     * @param $timeout
     * @throws ModuleException
     */
    public function waitPageLoad($timeout = 10)
    {
        $this->getModule('WebDriver')->waitForJs('return document.readyState == "complete"', $timeout);
        $this->waitAjaxLoad($timeout);
        $this->dontSeeJsError();
    }

    /**
     * @param $identifier
     * @param $elementID
     * @param $excludeElements
     * @param $element
     * @throws ModuleException
     */
    public function dontSeeVisualChanges($identifier, $elementID = null, $excludeElements = null, $element = false)
    {
        if ($element !== false) {
            $this->getModule('WebDriver')->moveMouseOver($element);
        }
        $this->getModule('VisualCeption')->dontSeeVisualChanges($identifier, $elementID, $excludeElements);
        $this->dontSeeJsError();
    }

    /**
     * Clicks all elements
     * @param $locator
     * @return void
     * @throws ModuleException
     */
    public function clickAllElements($locator)
    {
        $elems =  $this->getModule('WebDriver')->_findElements($locator);
        foreach ($elems as $elem) {
            $elem->click();
        }
    }

    /**
     * Checking for errors in the console
     *
     * @throws ModuleException
     */
    public function dontSeeJsError()
    {
        // TODO sur les pages du site ne pas renvoyer erreur http 404 quand il n'y a pas de données dispo
//        $logs =  $this->getModule('WebDriver')->webDriver->manage()->getLog('browser');
//        foreach ($logs as $log) {
//            if ($log['level'] == 'SEVERE') {
//                throw new ModuleException($this, 'Some error in JavaScript: ' . json_encode($log));
//            }
//        }
    }
}
