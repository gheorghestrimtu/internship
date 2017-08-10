<?php

class AllMaturityRatings_SeasonCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllMaturityRatings_SeasonCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllMaturityRatings_SeasonCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _findMaturityRatingOnEpisodePage(AcceptanceTester $I, $rating)
    {
        $url_rating = str_replace('-', '', $rating);
        $url_rating = strtolower($rating);

        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllMaturityRatings_Season_" . BuildNo::$build . " Season ". $rating);
        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_AllMaturityRatings_Season_" . BuildNo::$build . " Season ". $rating . " Season");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see($rating, ContentPage::$maturityRow);

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllMaturityRatings_SeasonCest::$url = $webdriver->getCurrentUrl();
        });

        $I->expect('URL is ' . AllMaturityRatings_SeasonCest::$url);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C221790
    */
    public function verifyMaturityTVG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-G Rating appears for a Season. - C221790');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'TV-G');
    }

    /**
    * TESTRAIL TESTCASE ID: C221791
    */
    public function verifyMaturityTVY(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y Rating appears for a Season. - C221791');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'TV-Y');
    }

    /**
    * TESTRAIL TESTCASE ID: C221792
    */
    public function verifyMaturityTVY7(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7 Rating appears for a Season. - C221792');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'TV-Y7');
    }

    /**
    * TESTRAIL TESTCASE ID: C221793
    */
    public function verifyMaturityTVY7FV(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7-FV Rating appears for a Season. - C221793');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'TV-Y7-FV');
    }

    /**
    * TESTRAIL TESTCASE ID: C221794
    */
    public function verifyMaturityTVPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-PG Rating appears for a Season. - C221794');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'TV-PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C221795
    */
    public function verifyMaturityTV14(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-14 Rating appears for a Season. - C221795');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'TV-14');
    }

    /**
    * TESTRAIL TESTCASE ID: C221796
    */
    public function verifyMaturityTVMA(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-MA Rating appears for a Season. - C221796');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'TV-MA');
    }

    /**
     * TESTRAIL TESTCASE ID: C356458
     */
    public function verifyMaturityUnrated(AcceptanceTester $I)
    {
        $I->wantTo('Verify Unrated Rating appears for a Season. - C356458');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'Unrated');
    }

    /**
    * TESTRAIL TESTCASE ID: C221802
    */
    public function verifyMaturityG(AcceptanceTester $I)
    {
        $I->wantTo('Verify G Rating appears for a Season. - C221802');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'G');
    }

    /**
    * TESTRAIL TESTCASE ID: C221803
    */
    public function verifyMaturityPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG Rating appears for a Season. - C221803');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C221804
    */
    public function verifyMaturityPG13(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG-13 Rating appears for a Season. - C221804');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'PG-13');
    }

    /**
    * TESTRAIL TESTCASE ID: C221805
    */
    public function verifyMaturityR(AcceptanceTester $I)
    {
        $I->wantTo('Verify R Rating appears for a Season. - C221805');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'R');
    }

    /**
    * TESTRAIL TESTCASE ID: C221806
    */
    public function verifyMaturityNC17(AcceptanceTester $I)
    {
        $I->wantTo('Verify NC-17 Rating appears for a Season. - C221806');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'NC-17');
    }

    /**
    * TESTRAIL TESTCASE ID: C221807
    */
    public function verifyMaturityNR(AcceptanceTester $I)
    {
        $I->wantTo('Verify NR Rating appears for a Season. - C221807');
        AllMaturityRatings_SeasonCest::_findMaturityRatingOnEpisodePage($I, 'NR');
    }
}
