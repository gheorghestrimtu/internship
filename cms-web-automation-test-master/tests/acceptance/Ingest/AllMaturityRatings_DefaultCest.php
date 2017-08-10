<?php

class AllMaturityRatings_DefaultCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllMaturityRatings_DefaultCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllMaturityRatings_DefaultCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _findMaturityRatingOnSeriesPage(AcceptanceTester $I, $rating)
    {
        $url_rating = str_replace('-', '', $rating);
        $url_rating = strtolower($rating);

        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_AllMaturityRatings_Default_" . BuildNo::$build . " Default ". $rating);

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see($rating, ContentPage::$maturityRow);

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllMaturityRatings_DefaultCest::$url = $webdriver->getCurrentUrl();
        });

        $I->expect('URL is ' . AllMaturityRatings_DefaultCest::$url);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C13758
    */
    public function verifyMaturityTVG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-G Rating appears for a series. - C13758');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'TV-G');
    }

    /**
    * TESTRAIL TESTCASE ID: C13759
    */
    public function verifyMaturityTVY(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y Rating appears for a series. - C13759');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'TV-Y');
    }

    /**
    * TESTRAIL TESTCASE ID: C13760
    */
    public function verifyMaturityTVY7(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7 Rating appears for a series. - C13760');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'TV-Y7');
    }

    /**
    * TESTRAIL TESTCASE ID: C214866
    */
    public function verifyMaturityTVY7FV(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7-FV Rating appears for a series. - C214866');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'TV-Y7-FV');
    }

    /**
    * TESTRAIL TESTCASE ID: C13761
    */
    public function verifyMaturityTVPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-PG Rating appears for a series. - C13761');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'TV-PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C13762
    */
    public function verifyMaturityTV14(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-14 Rating appears for a series. - C13762');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'TV-14');
    }

    /**
    * TESTRAIL TESTCASE ID: C13763
    */
    public function verifyMaturityTVMA(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-MA Rating appears for a series. - C13763');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'TV-MA');
    }

    /**
     * TESTRAIL TESTCASE ID: C356456
     */
    public function verifyMaturityUnrated(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-MA Rating appears for a series. - C356456');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'Unrated');
    }

    /**
    * TESTRAIL TESTCASE ID: C16802
    */
    public function verifyMaturityG(AcceptanceTester $I)
    {
        $I->wantTo('Verify G Rating appears for a series. - C16802');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'G');
    }

    /**
    * TESTRAIL TESTCASE ID: C16803
    */
    public function verifyMaturityPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG Rating appears for a series. - C16802');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C16804
    */
    public function verifyMaturityPG13(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG-13 Rating appears for a series. - C16804');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'PG-13');
    }

    /**
    * TESTRAIL TESTCASE ID: C16805
    */
    public function verifyMaturityR(AcceptanceTester $I)
    {
        $I->wantTo('Verify R Rating appears for a series. - C16805');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'R');
    }

    /**
    * TESTRAIL TESTCASE ID: C16806
    */
    public function verifyMaturityNC17(AcceptanceTester $I)
    {
        $I->wantTo('Verify NC-17 Rating appears for a series. - C16806');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'NC-17');
    }

    /**
    * TESTRAIL TESTCASE ID: C16807
    */
    public function verifyMaturityNR(AcceptanceTester $I)
    {
        $I->wantTo('Verify NR Rating appears for a series. - C16807');
        AllMaturityRatings_DefaultCest::_findMaturityRatingOnSeriesPage($I, 'NR');
    }
}
