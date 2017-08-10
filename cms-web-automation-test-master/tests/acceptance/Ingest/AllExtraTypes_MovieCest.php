<?php

class AllExtraTypes_MovieCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllExtraTypes_MovieCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllExtraTypes_MovieCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _navigateToExtra(AcceptanceTester $I, $extra)
    {
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllExtraTypes_Movie_" . BuildNo::$build . " " . $extra . " Movie");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllExtraTypes_MovieCest::$url = $webdriver->getCurrentUrl();
        });
        $I->expect('URL is ' . AllExtraTypes_MovieCest::$url);

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Movie_" . BuildNo::$build . "_" . str_replace(' ', '', strtolower($extra)) . "_clip']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Movie_" . BuildNo::$build . "_" .  str_replace(' ', '', strtolower($extra)) . "_clip']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Movie_" . BuildNo::$build . "_" . str_replace(' ', '', strtolower($extra)) . "_clip']");
        $I->waitForText(str_replace(' ', '_', (strtolower($extra))), 30, ContentPage::$videoTypeRow);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C14105
    */
    public function verifyExtraPreview(AcceptanceTester $I)
    {
        $I->wantTo('Verify Preview attached to Series. - C14105');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Preview');
    }

    /**
    * TESTRAIL TESTCASE ID: C14106
    */
    public function verifyExtraTrailer(AcceptanceTester $I)
    {
        $I->wantTo('Verify Trailer attached to Series. - C14106');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Trailer');
    }

    /**
    * TESTRAIL TESTCASE ID: C14107
    */
    public function verifyExtraGagReel(AcceptanceTester $I)
    {
        $I->wantTo('Verify Gag Reel attached to Series. - C14107');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Gag Reel');
    }

    /**
    * TESTRAIL TESTCASE ID: C14108
    */
    public function verifyExtraRecap(AcceptanceTester $I)
    {
        $I->wantTo('Verify Recap attached to Series. - C14108');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Recap');
    }

    /**
    * TESTRAIL TESTCASE ID: C14109
    */
    public function verifyExtraMakingOf(AcceptanceTester $I)
    {
        $I->wantTo('Verify Making Of attached to Series. - C14109');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Making Of');
    }

    /**
    * TESTRAIL TESTCASE ID: C14110
    */
    public function verifyExtraInterview(AcceptanceTester $I)
    {
        $I->wantTo('Verify Interview attached to Series. - C14110');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Interview');
    }

    /**
    * TESTRAIL TESTCASE ID: C14111
    */
    public function verifyExtraPromo(AcceptanceTester $I)
    {
        $I->wantTo('Verify Promo attached to Series. - C14111');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Promo');
    }

    /**
    * TESTRAIL TESTCASE ID: C14112
    */
    public function verifyExtraExtra(AcceptanceTester $I)
    {
        $I->wantTo('Verify Extra attached to Series. - C14112');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Extra');
    }

    /**
    * TESTRAIL TESTCASE ID: C19515
    */
    public function verifyExtraClip(AcceptanceTester $I)
    {
        $I->wantTo('Verify Clip attached to Series. - C19515');
        AllExtraTypes_MovieCest::_navigateToExtra($I, 'Clip');
    }
}
