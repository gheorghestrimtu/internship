<?php

/**
* This class holds the all-purpose functions that can be used any place in the test suites
*/
class AcceptanceUtils {

    public static $environment = 'undefined';

    public static $loginCookie = 'undefined';

    public static $url;

    public static $elementVisible;

    public static $elementToBeFound;

    public static function setEnvironment($I) {
        $I->amOnPage('/');
        if (self::$environment == 'undefined') {
            self::$environment = AcceptanceUtils::getEnvironment($I);
        }
        self::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, self::$loginCookie);
    }
    
    /**
    * User login
    */
    public static function login($I, $username, $password, $cookie)
    {
        if($cookie == 'undefined')
        {
            $I->waitForElementVisible(LoginPage::$username_input, 30);
            $I->fillField(LoginPage::$username_input, $username);
            $I->fillField(LoginPage::$password_input, $password);
            $I->wait(1); //Failsafe to make sure text is entered properly
            $I->click('Log In');
            $I->wait(2);
            $I->waitForText('Log Out', 40);
            $cookie = $I->grabCookie('VCMS');
        }
        else
        {
            $I->resetCookie('VCMS');
            $I->setCookie('VCMS', $cookie);
            $I->amOnPage('/');
        }

        $I->expect('We are logged in.');
        $I->waitForText('Log Out', 30);

        return $cookie;
    }

    /**
    * Determines what environment we're in by checking the url.
    */
    public static function getEnvironment(AcceptanceTester $I)
    {
        $environment;
        AcceptanceUtils::$url = '';
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AcceptanceUtils::$url = $webdriver->getCurrentUrl();
        });

        if (strpos(AcceptanceUtils::$url, 'staging'))
        {
            $environment = 'staging';
        }
        else
        {
            $environment = 'proto0';
        }

        return $environment;
    }

    /**
    * Checks if a given element is available on the page. Used for conditional testing, since Codeception does not have a way 
    * to do this that does not cause tests to fail unnecessarily. 
    */
    public static function checkIfElementVisible(AcceptanceTester $I, $element)
    {
        AcceptanceUtils::$elementVisible = false;
        AcceptanceUtils::$elementToBeFound = $element;

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
            $arrElements = $webdriver->findElements(\Facebook\WebDriver\WebDriverBy::xpath(AcceptanceUtils::$elementToBeFound));

            foreach ($arrElements as $singleElement) 
            {
                if($singleElement->isDisplayed())
                {
                    AcceptanceUtils::$elementVisible = true;
                    break;
                }
            }
        });

        return AcceptanceUtils::$elementVisible;
    }

    public static function accessGeneratedThumbnails($I, $change) {
        $guid = self::$environment == 'staging' ? TestContentGuids::$episodeVideoEditDataThumbnailSet_staging : TestContentGuids::$episodeVideoEditDataThumbnailSet_proto0;
        $I->amOnPage(ContentPage::$episodeThumbnails . $guid);
        $I->waitForElementVisible('//*[@class="thumbnails-available"]/div/div/img', 30);
        $src = $I->grabAttributeFrom('//*[@class="thumbnails-installed"]/div/div/img', 'src');
        $elements = self::findElements($I, 'xpath', '//*[@class="thumbnails-available"]/div/div/img');
        $index = rand(1, count($elements));
        $I->wait(30);
        $I->moveMouseOver('(//*[@class="thumbnails-available"]/div/div/img)[' . $index . ']');
        $I->click('(//*[@class="thumbnails-available"]/div/div/div/div/button)[' . $index . ']');
        $I->waitForElementVisible('//div[contains(@class,"alert-popup")]', 30);
        $I->click('//div[contains(@class,"alert-popup")]/button[@class="' . ($change ? 'yes' : 'cancel') . '"]');
        if ($change) {
            $I->waitForElementVisible('//div[contains(@class,"success show")]', 30);
            $I->wait(10);
        }
        $new_src = $I->grabAttributeFrom('//*[@class="thumbnails-installed"]/div/div/img', 'src');
        if ($change) {
            $I->assertNotEquals($src, $new_src);
        } else {
            $I->assertEquals($src, $new_src);
        }
    }

    public static function clickThumbnailSize($I, $index, $total) {
        $I->click('(//div[@class="thumbnails-preview"]/small)[' . $index . ']');
        $new_total = count(self::findElements($I, 'cssSelector', 'div[class="thumbnail"][style*="width: ' . ($index == 1 ? '33.3333' : ($index == 2 ? '50' : '100')) . '"]'));
        $I->assertEquals($total, $new_total);
        return $new_total;
    }

    public static function accessMaturityRating($I, $category, $edit) {
        if ($category == 'Episode') {
            self::accessMaturityRating($I, 'Season', false);
        } elseif ($category == 'Season') {
            self::accessMaturityRating($I, 'Series', false);
        } else {
            $I->amOnPage(ContentPage::$URL);
        }
        $I->waitForElementVisible('//td[text()="' . $category . '"]', 30);
        $index = self::maturityRatingGetRandomIndex($I, $category, '//td[text()="' . $category . '"]', 0);
        $pencil = '/ancestor::tr/td/i[contains(@class,"edit")]';
        $I->click('(//td[text()="' . $category . '"])[' . $index . ']' . ($edit ? $pencil : ''));
    }

    public static function selectMaturityRatingOption($I, $type, $save) {
        $I->waitForElementVisible('//input[@id="rating_type_' . $type . '"]');
        $I->scrollTo('//input[@id="rating_type_' . $type . '"]');
        $I->click('//input[@id="rating_type_' . $type . '"]');
        $index = rand(1, count(AcceptanceUtils::findElements($I, 'cssSelector', 'ul.maturity-rating-input > li[data-reactid*="' . $type . '"] > ul[data-reactid*="' . $type . '"] > li')));
        $I->click('ul.maturity-rating-input > li[data-reactid*="' . $type . '"] > ul[data-reactid*="' . $type . '"] > li:nth-child(' . $index . ')');
        if ($save) {
            $I->click('//div[@class="save-bar"]/button');
        }
    }

    public static function maturityRatingGetRandomIndex($I, $category, $xpath, $cycles) {
        if ($cycles == 100) {
            return false;
        }
        $cycles++;
        $index = rand(1, count(AcceptanceUtils::findElements($I, 'xpath', $xpath)));
        if ($category == 'Series' || $category == 'Season') {
            $total = $I->grabTextFrom('(' . $xpath . ')[' . $index . ']' . '/ancestor::tr/td[6]');
            if ($total == '0') {
                $index = self::maturityRatingGetRandomIndex($I, $category, $xpath, $cycles);
            }
            if ($category == 'Series') {
                $total = $I->grabTextFrom('(' . $xpath . ')[' . $index . ']' . '/ancestor::tr/td[7]');
                if ($total == '0') {
                    $index = self::maturityRatingGetRandomIndex($I, $category, $xpath, $cycles);
                }
            }
        }
        return $index;
    }

    public static function getCheckedInputBeforeAndAfterPageReload($I, $element, $visible) {
        $ids = [];
        $ids[] = $I->grabAttributeFrom($element, 'id');
        $current_url = $I->grabFromCurrentUrl();
        $I->amOnPage($current_url);
        $I->waitForElementVisible($element . (!$visible ? ' + label' : ''), 30);
        $ids[] = $I->grabAttributeFrom($element, 'id');
        return $ids;
    }

    public static function findElements(AcceptanceTester $I, $method, $selector) {
        return $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) use ($method, $selector) {
            return $webdriver->findElements(\Facebook\WebDriver\WebDriverBy::$method($selector));
        });
    }
}