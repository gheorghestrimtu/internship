<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\StaleElementReferenceException;

class Acceptance extends \Codeception\Module {

    /**
     * @return \Codeception\Module|\Codeception\Module\WebDriver
     */
    private function getWebDriverModule() {
        return $this->getModule('WebDriver');
    }

    /**
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    private function getWebDriver() {
        return $this->getWebDriverModule()->webDriver;
    }

    public function findElements($method, $selector = null) {
        $locator = $selector ? [$method => $selector] : $method;
        return $this->getWebDriverModule()->_findElements($locator);
    }

    public function findRandomElement($locator) {
        $elements = $this->findElements($locator);
        return $elements[array_rand($elements)];
    }

    public function findElement($selector, $page = null) {
        return $this->getWebDriverModule()->_findClickable($page ? $page : $this->getWebDriver(), $selector);
    }

    public function findElementInElement($element, $selector) {
        /* @var $element \RemoteWebElement */
        return $element->findElement(\WebDriverBy::xpath('.' . $selector));
    }

    public function isDisplayed($locator) {
        return $this->findElement($locator)->isDisplayed();
    }

    public function waitElementToBeClickable($selector) {
        $condition = WebDriverExpectedCondition::elementToBeClickable(\WebDriverBy::xpath($selector));
        $this->getWebDriver()->wait(10)->until($condition);
    }

    public function waitForRegExp($pattern, $timeout = 10, $selector = null) {
        $webDriver = $this->getWebDriver();
        $selector = !$selector ? '//body' : $selector;
        $webDriver->wait($timeout)->until(function() use ($webDriver, $pattern, $selector) {
            try {
                return (bool) preg_match($pattern, $webDriver->findElement(\WebDriverBy::xpath($selector))->getText());
            } catch (StaleElementReferenceException $e) {
                return null;
            }
        });
    }

    public function clickWithLeftButton($selector, $offsetX = null, $offsetY = null) {
        $this->getWebDriverModule()->scrollTo($selector, $offsetX, $offsetY);
        $this->getWebDriverModule()->moveMouseOver($selector, $offsetX, $offsetY);
        $this->getWebDriver()->getMouse()->click();
    }

    public function getCurrentUrl() {
        return $this->getWebDriverModule()->_getUrl();
    }

    public function getCurrentUri() {
        return $this->getWebDriverModule()->_getCurrentUri();
    }

    public function getComputedStyle($element, $pseudoElement = null) {
        $style = $this->getWebDriver()->executeScript('return JSON.stringify(window.getComputedStyle(arguments[0], arguments[1]))', func_get_args());
        return json_decode($style);
    }

    public function scrollToBottom($step, $callback = null) {
        $offset = 0;
        $oldOffset = -1;
        while ($offset != $oldOffset) {
            $oldOffset = $offset;
            if ($callback) call_user_func($callback);
            $this->scrollBy(0, $step);
            $offset = $this->getWebDriverModule()->executeJS('return window.pageYOffset');
        }
    }

    public function waitForElementToLoad($method, $element, $seconds=10) {
        $I = $this;
        for ($i=0; $i<$seconds; $i++) {
            $total = count($I->findElements($method, $element));
            if ($total) {
                return $total;
            }
            sleep(1);
        }
        return false;
    }

    public function scrollBy($x = 0, $y = 0) {
        $this->getWebDriverModule()->executeJS("window.scrollBy($x, $y)");
    }

    public function isElementInViewport($element) {
        $result = $this->getWebDriver()->executeScript('
            var rect = arguments[0].getBoundingClientRect();
            var html = document.documentElement;
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || html.clientHeight) + rect.height/2 &&
                rect.right <= (window.innerWidth || html.clientWidth)
            );
        ', func_get_args());

        return $result;
    }

    public function amOnPage($page, $timeout = 300) {
        $this->getWebDriverModule()->amOnPage($page);
        $this->injectXMLHttpRequestCounter();
        $this->waitPageLoad($timeout);
    }

    public function reloadPage($timeout = 300) {
        $this->getWebDriverModule()->reloadPage();
        $this->injectXMLHttpRequestCounter();
        $this->waitPageLoad($timeout);
    }

    public function waitPageLoad($timeout = 10) {
        $this->getWebDriverModule()->waitForJs('return document.readyState == "complete"', $timeout);
        $this->waitAjaxLoad($timeout);
    }

    public function waitAjaxLoad($timeout = 10) {
        $this->getWebDriverModule()->waitForJS('return XMLHttpRequest.requests == 0;', $timeout);
        $this->getWebDriverModule()->wait(1);
    }

    public function click($link, $context = null) {
        try {
            $this->getWebDriverModule()->click($link, $context);
        } catch (\Exception $e) {
            if (is_string($link)) {
                $this->getWebDriverModule()->click("//*[text()='$link']", $context);
            } else {
                throw $e;
            }
        }
    }

    private function injectXMLHttpRequestCounter() {
        $this->getWebDriverModule()->executeJS('
            (function() {
                var send = XMLHttpRequest.prototype.send;
                XMLHttpRequest.requests = 0
                XMLHttpRequest.prototype.send = function() {
                    send.apply(this, arguments);
                    XMLHttpRequest.requests++;
                    this.addEventListener("readystatechange", function(e) {
                        if (this.readyState == 4 ) {
                            XMLHttpRequest.requests--;
                        }
                    });
                }
            })();
        ');
    }

}
