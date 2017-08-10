<?php

class AllMaturityRatings_EpisodesCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllMaturityRatings_EpisodesCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllMaturityRatings_EpisodesCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function _findMaturityRatingOnEpisodePage(AcceptanceTester $I, $rating)
    {
        $url_rating = str_replace('-', '', $rating);
        $url_rating = strtolower($rating);

        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllMaturityRatings_Episodes_" . BuildNo::$build . " Episode " . $rating);
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllMaturityRatings_Episodes_" . BuildNo::$build . " Episode " . $rating . " Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllMaturityRatings_Episodes_" . BuildNo::$build . " Episode " . $rating . " Episode");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see($rating, ContentPage::$maturityRow);

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllMaturityRatings_EpisodesCest::$url = $webdriver->getCurrentUrl();
        });

        $I->expect('URL is ' . AllMaturityRatings_EpisodesCest::$url);
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C13780
    */
    public function verifyMaturityTVG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-G Rating appears for a Episode. - C13780');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'TV-G');
    }

    /**
    * TESTRAIL TESTCASE ID: C13781
    */
    public function verifyMaturityTVY(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y Rating appears for a Episode. - C13781');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'TV-Y');
    }

    /**
    * TESTRAIL TESTCASE ID: C13782
    */
    public function verifyMaturityTVY7(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7 Rating appears for a Episode. - C13782');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'TV-Y7');
    }

    /**
    * TESTRAIL TESTCASE ID: C214868
    */
    public function verifyMaturityTVY7FV(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-Y7-FV Rating appears for a Episode. - C214868');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'TV-Y7-FV');
    }

    /**
    * TESTRAIL TESTCASE ID: C13783
    */
    public function verifyMaturityTVPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-PG Rating appears for a Episode. - C13783');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'TV-PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C13784
    */
    public function verifyMaturityTV14(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-14 Rating appears for a Episode. - C13784');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'TV-14');
    }

    /**
    * TESTRAIL TESTCASE ID: C13785
    */
    public function verifyMaturityTVMA(AcceptanceTester $I)
    {
        $I->wantTo('Verify TV-MA Rating appears for a Episode. - C13785');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'TV-MA');
    }

    /**
     * TESTRAIL TESTCASE ID: C356459
     */
    public function verifyMaturityUnrated(AcceptanceTester $I)
    {
        $I->wantTo('Verify Unrated Rating appears for a Episode. - C356459');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'Unrated');
    }

    /**
    * TESTRAIL TESTCASE ID: C16814
    */
    public function verifyMaturityG(AcceptanceTester $I)
    {
        $I->wantTo('Verify G Rating appears for a Episode. - C16814');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'G');
    }

    /**
    * TESTRAIL TESTCASE ID: C16815
    */
    public function verifyMaturityPG(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG Rating appears for a Episode. - C16815');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'PG');
    }

    /**
    * TESTRAIL TESTCASE ID: C16816
    */
    public function verifyMaturityPG13(AcceptanceTester $I)
    {
        $I->wantTo('Verify PG-13 Rating appears for a Episode. - C16816');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'PG-13');
    }

    /**
    * TESTRAIL TESTCASE ID: C16817
    */
    public function verifyMaturityR(AcceptanceTester $I)
    {
        $I->wantTo('Verify R Rating appears for a Episode. - C16817');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'R');
    }

    /**
    * TESTRAIL TESTCASE ID: C16818
    */
    public function verifyMaturityNC17(AcceptanceTester $I)
    {
        $I->wantTo('Verify NC-17 Rating appears for a Episode. - C16818');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'NC-17');
    }

    /**
    * TESTRAIL TESTCASE ID: C16819
    */
    public function verifyMaturityNR(AcceptanceTester $I)
    {
        $I->wantTo('Verify NR Rating appears for a Episode. - C16819');
        AllMaturityRatings_EpisodesCest::_findMaturityRatingOnEpisodePage($I, 'NR');
    }
}
