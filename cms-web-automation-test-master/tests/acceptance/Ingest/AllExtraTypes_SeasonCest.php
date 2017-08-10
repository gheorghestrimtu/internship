<?php

class AllExtraTypes_SeasonCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllExtraTypes_SeasonCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllExtraTypes_SeasonCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _navigateToExtra(AcceptanceTester $I, $extra)
    {
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllExtraTypes_Season_" . BuildNo::$build . " " . $extra . " Series Title");
        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_AllExtraTypes_Season_" . BuildNo::$build . " " . $extra . " Season Title");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllExtraTypes_SeasonCest::$url = $webdriver->getCurrentUrl();
        });
        $I->expect('URL is ' . AllExtraTypes_SeasonCest::$url);

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Season_" . BuildNo::$build . "_" .  str_replace(' ', '', strtolower($extra)) . "_clip']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Season_" . BuildNo::$build . "_" .  str_replace(' ', '', strtolower($extra)) . "_clip']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Season_" . BuildNo::$build . "_" . str_replace(' ', '', strtolower($extra)) . "_clip']");
        $I->waitForText(str_replace(' ', '_', (strtolower($extra))), 30, ContentPage::$videoTypeRow);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C14121
    */
    public function verifyExtraPreview(AcceptanceTester $I)
    {
        $I->wantTo('Verify Preview attached to Season. - C14121');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Preview');
    }

    /**
    * TESTRAIL TESTCASE ID: C14122
    */
    public function verifyExtraTrailer(AcceptanceTester $I)
    {
        $I->wantTo('Verify Trailer attached to Season. - C14122');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Trailer');
    }

    /**
    * TESTRAIL TESTCASE ID: C14123
    */
    public function verifyExtraGagReel(AcceptanceTester $I)
    {
        $I->wantTo('Verify Gag Reel attached to Season. - C14123');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Gag Reel');
    }

    /**
    * TESTRAIL TESTCASE ID: C14124
    */
    public function verifyExtraRecap(AcceptanceTester $I)
    {
        $I->wantTo('Verify Recap attached to Season. - C14124');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Recap');
    }

    /**
    * TESTRAIL TESTCASE ID: C14125
    */
    public function verifyExtraMakingOf(AcceptanceTester $I)
    {
        $I->wantTo('Verify Making Of attached to Season. - C14125');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Making Of');
    }

    /**
    * TESTRAIL TESTCASE ID: C14126
    */
    public function verifyExtraInterview(AcceptanceTester $I)
    {
        $I->wantTo('Verify Interview attached to Season. - C14126');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Interview');
    }

    /**
    * TESTRAIL TESTCASE ID: C14127
    */
    public function verifyExtraPromo(AcceptanceTester $I)
    {
        $I->wantTo('Verify Promo attached to Season. - C14127');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Promo');
    }

    /**
    * TESTRAIL TESTCASE ID: C14128
    */
    public function verifyExtraExtra(AcceptanceTester $I)
    {
        $I->wantTo('Verify Extra attached to Season. - C14128');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Extra');
    }

    /**
    * TESTRAIL TESTCASE ID: C19517
    */
    public function verifyExtraClip(AcceptanceTester $I)
    {
        $I->wantTo('Verify Clip attached to Season. - C19517');
        AllExtraTypes_SeasonCest::_navigateToExtra($I, 'Clip');
    }
}
