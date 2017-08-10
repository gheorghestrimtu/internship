<?php

class AllMaturityRatings_MovieCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllMaturityRatings_MovieCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllMaturityRatings_MovieCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _findMaturityRatingOnMoviePage(AcceptanceTester $I, $rating)
    {
        $url_rating = str_replace('-', '', $rating);
        $url_rating = strtolower($rating);

        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllMaturityRatings_Movie_" . BuildNo::$build . " Movie ". $rating);

        $I->waitForText('Ingest Testing', 30, "//form[contains(@class, 'attributes')]/div/span");
        $I->see($rating, ContentPage::$maturityRow);

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllMaturityRatings_MovieCest::$url = $webdriver->getCurrentUrl();
        });

        $I->expect('URL is ' . AllMaturityRatings_MovieCest::$url);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C13791
    */
    public function verifyMaturityTVG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-G Rating appears for a Movie. - C13791');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'TV-G');
    }

    /**
    * TESTRAIL TESTCASE ID: C13792
    */
    public function verifyMaturityTVY(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y Rating appears for a Movie. - C13792');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'TV-Y');
    }

    /**
    * TESTRAIL TESTCASE ID: C13793
    */
    public function verifyMaturityTVY7(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7 Rating appears for a Movie. - C13793');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'TV-Y7');
    }

    /**
    * TESTRAIL TESTCASE ID: C214869
    */
    public function verifyMaturityTVY7FV(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7-FV Rating appears for a Movie. - C214869');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'TV-Y7-FV');
    }

    /**
    * TESTRAIL TESTCASE ID: C13794
    */
    public function verifyMaturityTVPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-PG Rating appears for a Movie. - C13794');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'TV-PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C13795
    */
    public function verifyMaturityTV14(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-14 Rating appears for a Movie. - C13795');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'TV-14');
    }

    /**
    * TESTRAIL TESTCASE ID: C13796
    */
    public function verifyMaturityTVMA(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-MA Rating appears for a Movie. - C13796');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'TV-MA');
    }

    /**
     * TESTRAIL TESTCASE ID: C356460
     */
    public function verifyMaturityUnrated(AcceptanceTester $I)
    {
        $I->wantTo('Verify Unrated Rating appears for a Movie. - C356460');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'Unrated');
    }

    /**
    * TESTRAIL TESTCASE ID: C16820
    */
    public function verifyMaturityG(AcceptanceTester $I)
    {
        $I->wantTo('Verify G Rating appears for a Movie. - C16820');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'G');
    }

    /**
    * TESTRAIL TESTCASE ID: C16821
    */
    public function verifyMaturityPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG Rating appears for a Movie. - C16821');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C16822
    */
    public function verifyMaturityPG13(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG-13 Rating appears for a Movie. - C16822');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'PG-13');
    }

    /**
    * TESTRAIL TESTCASE ID: C16823
    */
    public function verifyMaturityR(AcceptanceTester $I)
    {
        $I->wantTo('Verify R Rating appears for a Movie. - C16823');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'R');
    }

    /**
    * TESTRAIL TESTCASE ID: C16824
    */
    public function verifyMaturityNC17(AcceptanceTester $I)
    {
        $I->wantTo('Verify NC-17 Rating appears for a Movie. - C16824');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'NC-17');
    }

    /**
    * TESTRAIL TESTCASE ID: C16825
    */
    public function verifyMaturityNR(AcceptanceTester $I)
    {
        $I->wantTo('Verify NR Rating appears for a Movie. - C16825');
        AllMaturityRatings_MovieCest::_findMaturityRatingOnMoviePage($I, 'NR');
    }
}
