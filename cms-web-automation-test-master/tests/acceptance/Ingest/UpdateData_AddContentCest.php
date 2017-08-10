<?php

class UpdateData_AddContentCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        UpdateData_AddContentCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, UpdateData_AddContentCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    /**
    * @group initial_upload
    * @group second_upload
    */
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * @group initial_upload
    */
    public function verifyFirstNewSeasonAddedToExistingSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify a new season was added to Constantly Updating Series.');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "Constantly Updating Series");

        $I->expect('Initially added season is visible.');
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Updates_" . BuildNo::$build . " Added Season 1");
    }

    /**
    * @group initial_upload
    */
    public function verifyFirstNewEpisodeAddedToExistingSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify a second new season was added to Constantly Updating Series. - C14211');
        $I->amOnPage(ContentPage::$URL_ingest);
        ContentUtils::clickTableRowOfTitle($I, "Constantly Updating Series");
        ContentUtils::clickTableRowOfTitle($I, "Constantly Updating Season");

        $I->expect('Initially added episode is visible.');
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Updates_" . BuildNo::$build . " Added Episode 1");
    }

    /**
    * @group second_upload
    *
    * TESTRAIL TESTCASE ID: C14211
    */
    public function verifySecondNewSeasonAddedToExistingSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify a new season was added to Constantly Updating Series.');
        $I->amOnPage(ContentPage::$URL_ingest);
        ContentUtils::clickTableRowOfTitle($I, "Constantly Updating Series");

        $I->expect('Second added season is visible.');
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Updates_" . BuildNo::$build . " Added Season 2");
    }

    /**
    * @group second_upload
    *
    * TESTRAIL TESTCASE ID: C14212
    */
    public function verifySecondNewEpisodeAddedToExistingSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify a second new episode was added to Constantly Updating Series. - C14212');
        $I->amOnPage(ContentPage::$URL_ingest);
        ContentUtils::clickTableRowOfTitle($I, "Constantly Updating Series");
        ContentUtils::clickTableRowOfTitle($I, "Constantly Updating Season");

        $I->expect('Second added episode is visible.');
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Updates_" . BuildNo::$build . " Added Episode 2");
    }
}
