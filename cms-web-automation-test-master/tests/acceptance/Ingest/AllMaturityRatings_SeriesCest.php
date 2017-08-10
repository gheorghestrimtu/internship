<?php

class AllMaturityRatings_SeriesCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllMaturityRatings_SeriesCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllMaturityRatings_SeriesCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _findMaturityRatingOnSeriesPage(AcceptanceTester $I, $rating)
    {
        $url_rating = str_replace('-', '', $rating);
        $url_rating = strtolower($rating);

        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_AllMaturityRatings_Series_" . BuildNo::$build . " Series ". $rating);

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see($rating, ContentPage::$maturityRow);

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllMaturityRatings_SeriesCest::$url = $webdriver->getCurrentUrl();
        });

        $I->expect('URL is ' . AllMaturityRatings_SeriesCest::$url);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C13769
    */
    public function verifyMaturityTVG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-G Rating appears for a series. - C13769');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'TV-G');
    }

    /**
    * TESTRAIL TESTCASE ID: C13770
    */
    public function verifyMaturityTVY(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y Rating appears for a series. - C13770');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'TV-Y');
    }

    /**
    * TESTRAIL TESTCASE ID: C13771
    */
    public function verifyMaturityTVY7(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7 Rating appears for a series. - C13771');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'TV-Y7');
    }

    /**
    * TESTRAIL TESTCASE ID: C214867
    */
    public function verifyMaturityTVY7FV(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7-FV Rating appears for a series. - C214867');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'TV-Y7-FV');
    }

    /**
    * TESTRAIL TESTCASE ID: C13772
    */
    public function verifyMaturityTVPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-PG Rating appears for a series. - C13772');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'TV-PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C13773
    */
    public function verifyMaturityTV14(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-14 Rating appears for a series. - C13773');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'TV-14');
    }

    /**
    * TESTRAIL TESTCASE ID: C13774
    */
    public function verifyMaturityTVMA(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-MA Rating appears for a series. - C13774');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'TV-MA');
    }

    /**
     * TESTRAIL TESTCASE ID: C356457
     */
    public function verifyMaturityUnrated(AcceptanceTester $I)
    {
        $I->wantTo('Verify Unrated Rating appears for a series. - C356457');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'Unrated');
    }

    /**
    * TESTRAIL TESTCASE ID: C16808
    */
    public function verifyMaturityG(AcceptanceTester $I)
    {
        $I->wantTo('Verify G Rating appears for a series. - C16808');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'G');
    }

    /**
    * TESTRAIL TESTCASE ID: C16809
    */
    public function verifyMaturityPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG Rating appears for a series. - C16809');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C16810
    */
    public function verifyMaturityPG13(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG-13 Rating appears for a series. - C16810');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'PG-13');
    }

    /**
    * TESTRAIL TESTCASE ID: C16811
    */
    public function verifyMaturityR(AcceptanceTester $I)
    {
        $I->wantTo('Verify R Rating appears for a series. - C16811');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'R');
    }

    /**
    * TESTRAIL TESTCASE ID: C16812
    */
    public function verifyMaturityNC17(AcceptanceTester $I)
    {
        $I->wantTo('Verify NC-17 Rating appears for a series. - C16812');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'NC-17');
    }

    /**
    * TESTRAIL TESTCASE ID: C16813
    */
    public function verifyMaturityNR(AcceptanceTester $I)
    {
        $I->wantTo('Verify NR Rating appears for a series. - C16813');
        AllMaturityRatings_SeriesCest::_findMaturityRatingOnSeriesPage($I, 'NR');
    }
}
