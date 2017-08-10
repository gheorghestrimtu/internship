<?php

class AllExtraTypes_SeriesCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllExtraTypes_SeriesCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllExtraTypes_SeriesCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _navigateToExtra(AcceptanceTester $I, $extra)
    {
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_AllExtraTypes_Series_" . BuildNo::$build . " " . $extra . " Series Title");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllExtraTypes_SeriesCest::$url = $webdriver->getCurrentUrl();
        });
        $I->expect('URL is ' . AllExtraTypes_SeriesCest::$url);

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Series_" . BuildNo::$build . "_" . str_replace(' ', '', strtolower($extra)) . "_clip']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Series_" . BuildNo::$build . "_" .  str_replace(' ', '', strtolower($extra)) . "_clip']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Series_" . BuildNo::$build . "_" . str_replace(' ', '', strtolower($extra)) . "_clip']");
        $I->waitForText(str_replace(' ', '_', (strtolower($extra))), 30, ContentPage::$videoTypeRow);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C14113
    */
    public function verifyExtraPreview(AcceptanceTester $I)
    {
        $I->wantTo('Verify Preview attached to Series. - C14113');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Preview');
    }

    /**
    * TESTRAIL TESTCASE ID: C14114
    */
    public function verifyExtraTrailer(AcceptanceTester $I)
    {
        $I->wantTo('Verify Trailer attached to Series. - C14114');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Trailer');
    }

    /**
    * TESTRAIL TESTCASE ID: C14115
    */
    public function verifyExtraGagReel(AcceptanceTester $I)
    {
        $I->wantTo('Verify Gag Reel attached to Series. - C14115');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Gag Reel');
    }

    /**
    * TESTRAIL TESTCASE ID: C14116
    */
    public function verifyExtraRecap(AcceptanceTester $I)
    {
        $I->wantTo('Verify Recap attached to Series. - C14116');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Recap');
    }

    /**
    * TESTRAIL TESTCASE ID: C14117
    */
    public function verifyExtraMakingOf(AcceptanceTester $I)
    {
        $I->wantTo('Verify Making Of attached to Series. - C14117');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Making Of');
    }

    /**
    * TESTRAIL TESTCASE ID: C14118
    */
    public function verifyExtraInterview(AcceptanceTester $I)
    {
        $I->wantTo('Verify Interview attached to Series. - C14118');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Interview');
    }

    /**
    * TESTRAIL TESTCASE ID: C14119
    */
    public function verifyExtraPromo(AcceptanceTester $I)
    {
        $I->wantTo('Verify Promo attached to Series. - C14119');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Promo');
    }

    /**
    * TESTRAIL TESTCASE ID: C14120
    */
    public function verifyExtraExtra(AcceptanceTester $I)
    {
        $I->wantTo('Verify Extra attached to Series. - C14120');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Extra');
    }

    /**
    * TESTRAIL TESTCASE ID: C19516
    */
    public function verifyExtraClip(AcceptanceTester $I)
    {
        $I->wantTo('Verify Clip attached to Series. - C19516');
        AllExtraTypes_SeriesCest::_navigateToExtra($I, 'Clip');
    }
}
