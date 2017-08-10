<?php

class AllExtraTypes_EpisodeCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllExtraTypes_EpisodeCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllExtraTypes_EpisodeCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _navigateToExtra(AcceptanceTester $I, $extra)
    {
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllExtraTypes_Episode_" . BuildNo::$build . " " . $extra . " Series Title");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllExtraTypes_Episode_" . BuildNo::$build . " " . $extra . " Season Title");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllExtraTypes_Episode_" . BuildNo::$build . " " . $extra . " Episode Title");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllExtraTypes_EpisodeCest::$url = $webdriver->getCurrentUrl();
        });
        $I->expect('URL is ' . AllExtraTypes_EpisodeCest::$url);

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Episode_" . BuildNo::$build . "_" . str_replace(' ', '', strtolower($extra)) . "_clip']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Episode_" . BuildNo::$build . "_" .  str_replace(' ', '', strtolower($extra)) . "_clip']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_AllExtraTypes_Episode_" . BuildNo::$build . "_" . str_replace(' ', '', strtolower($extra)) . "_clip']");
        $I->waitForText(str_replace(' ', '_', (strtolower($extra))), 30, ContentPage::$videoTypeRow);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C14129
    */
    public function verifyExtraPreview(AcceptanceTester $I)
    {
        $I->wantTo('Verify Preview attached to Season. - C14129');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Preview');
    }

    /**
    * TESTRAIL TESTCASE ID: C14130
    */
    public function verifyExtraTrailer(AcceptanceTester $I)
    {
        $I->wantTo('Verify Trailer attached to Season. - C14130');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Trailer');
    }

    /**
    * TESTRAIL TESTCASE ID: C14131
    */
    public function verifyExtraGagReel(AcceptanceTester $I)
    {
        $I->wantTo('Verify Gag Reel attached to Season. - C14131');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Gag Reel');
    }

    /**
    * TESTRAIL TESTCASE ID: C14132
    */
    public function verifyExtraRecap(AcceptanceTester $I)
    {
        $I->wantTo('Verify Recap attached to Season. - C14132');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Recap');
    }

    /**
    * TESTRAIL TESTCASE ID: C14133
    */
    public function verifyExtraMakingOf(AcceptanceTester $I)
    {
        $I->wantTo('Verify Making Of attached to Season. - C14133');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Making Of');
    }

    /**
    * TESTRAIL TESTCASE ID: C14134
    */
    public function verifyExtraInterview(AcceptanceTester $I)
    {
        $I->wantTo('Verify Interview attached to Season. - C14134');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Interview');
    }

    /**
    * TESTRAIL TESTCASE ID: C14135
    */
    public function verifyExtraPromo(AcceptanceTester $I)
    {
        $I->wantTo('Verify Promo attached to Season. - C14135');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Promo');
    }

    /**
    * TESTRAIL TESTCASE ID: C14136
    */
    public function verifyExtraExtra(AcceptanceTester $I)
    {
        $I->wantTo('Verify Extra attached to Season. - C14136');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Extra');
    }

    /**
    * TESTRAIL TESTCASE ID: C19518
    */
    public function verifyExtraClip(AcceptanceTester $I)
    {
        $I->wantTo('Verify Clip attached to Season. - C19518');
        AllExtraTypes_EpisodeCest::_navigateToExtra($I, 'Clip');
    }
}
