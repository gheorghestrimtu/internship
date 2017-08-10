<?php

class MulitpleSeriesDataUploadCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        MulitpleSeriesDataUploadCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, MulitpleSeriesDataUploadCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C9145
    */
    public function verifyMultipleSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify both series were uploaded from the same manifest. - C9145');
        $I->amOnPage(ContentPage::$URL_ingest);

        $I->expect('Series 1 has a season and episode');
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_MultipleSeriesUpload_" . BuildNo::$build . " Series 1 Title");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_MultipleSeriesUpload_" . BuildNo::$build . " Series 1 Season 1 Title");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_MultipleSeriesUpload_" . BuildNo::$build . " Series 1 S1E1 Title");

        $I->amGoingTo('Go to the second series.');
        $I->amOnPage(ContentPage::$URL_ingest);
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_MultipleSeriesUpload_" . BuildNo::$build . " Series 2 Title");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_MultipleSeriesUpload_" . BuildNo::$build . " Series 2 Season 1 Title");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_MultipleSeriesUpload_" . BuildNo::$build . " Series 2 S1E1 Title");
    }
}
