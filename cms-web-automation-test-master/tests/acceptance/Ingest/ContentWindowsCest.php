<?php

class ContentWindowsCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        ContentWindowsCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, ContentWindowsCest::$loginCookie);
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
    * TESTRAIL TESTCASE ID: C14100
    */
    public function episodeUnpaidContentWindow(AcceptanceTester $I)
    {
        $I->wantTo('Verify unpaid content window is toggled properly on episode. - C14100');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Title");

        $I->waitForText('Premium members will be unable to watch this media.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C14101
    */
    public function episodePaidContentWindow(AcceptanceTester $I)
    {
        $I->wantTo('Verify paid content window is toggled properly on episode. - C14101');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Title");

        $I->waitForText('Free members will be unable to watch this media.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C225096
    */
    public function episodeFreeVisibleWindowBeforePremiumVisibleWindow(AcceptanceTester $I)
    {
        $I->wantTo('Verify that the earliest window is selected when the Free window is earlier than the Premium window. - C225096');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Before Paid");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Before Paid Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Before Paid Title");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Oct 4, 2010 11:00 EDT');
    }

    /**
    * TESTRAIL TESTCASE ID: C225097
    */
    public function episodePremiumVisibleWindowBeforeFreeVisibleWindow(AcceptanceTester $I)
    {
        $I->wantTo('Verify that the earliest window is selected when the Premium window is earlier than the Free window. - C225097');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Before Unpaid");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Before Unpaid Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Before Unpaid Title");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Oct 4, 2010 11:00 EDT');
    }

    /**
    * TESTRAIL TESTCASE ID: C225100
    */
    public function episodeFreeVisibleInDistantFuture(AcceptanceTester $I)
    {
        $I->wantTo('Verify that "Never" is displayed in the portal when Free visible date is in the distant future. - C225100');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Distant Future");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Distant Future Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Distant Future Title");

        //CXCMS-1738 - This is bugged and will always fail
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C225103
    */
    public function episodePremiumVisibleInDistantFuture(AcceptanceTester $I)
    {
        $I->wantTo('Verify that "Never" is displayed in the portal when Premium visible date is in the distant future. - C225103');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Distant Future");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Distant Future Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Distant Future Title");

        //CXCMS-1738 - This is bugged and will always fail
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C225101
    */
    public function episodeFreeWatchableInDistantFuture(AcceptanceTester $I)
    {
        $I->wantTo('Verify that "Never" is displayed in the portal when Free watchable date is in the distant future. - C225101');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Distant Future");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Distant Future Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Unpaid Distant Future Title");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C225102
    */
    public function episodePremiumWatchableInDistantFuture(AcceptanceTester $I)
    {
        $I->wantTo('Verify that "Never" is displayed in the portal when Premium watchable date is in the distant future. - C225102');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Distant Future");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Distant Future Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Episode Paid Distant Future Title");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C14103
    */
    public function movieUnpaidContentWindow(AcceptanceTester $I)
    {
        $I->wantTo('Verify unpaid content window is toggled properly on movie. - C14103');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Movie Unpaid");

        $I->waitForText('Premium members will be unable to watch this media.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C14104
    */
    public function moviePaidContentWindow(AcceptanceTester $I)
    {
        $I->wantTo('Verify paid content window is toggled properly on movie. - C14104');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Movie Paid");
        
        $I->waitForText('Free members will be unable to watch this media.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C225098
    */
    public function movieFreeVisibleWindowBeforePremiumVisibleWindow(AcceptanceTester $I)
    {
        $I->wantTo('Verify that the earliest window is selected when the Free window is earlier than the Premium window. - C225098');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Movie Unpaid Before Paid");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Oct 4, 2010 11:00 EDT');
    }

    /**
    * TESTRAIL TESTCASE ID: C225099
    */
    public function moviePremiumVisibleWindowBeforeFreeVisibleWindow(AcceptanceTester $I)
    {
        $I->wantTo('Verify that the earliest window is selected when the Premium window is earlier than the Free window. - C225099');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Movie Paid Before Unpaid");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Oct 4, 2010 11:00 EDT');
    }

    /**
    * TESTRAIL TESTCASE ID: C225104
    */
    public function movieFreeVisibleInDistantFuture(AcceptanceTester $I)
    {
        $I->wantTo('Verify that "Never" is displayed in the portal when Free visible date is in the distant future. - C225104');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Movie Unpaid Distant Future");

        //CXCMS-1738 - This is bugged. Will always fail.
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C225105
    */
    public function moviePremiumVisibleInDistantFuture(AcceptanceTester $I)
    {
        $I->wantTo('Verify that "Never" is displayed in the portal when Premium visible date is in the distant future. - C225105');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Movie Paid Distant Future");

        //CXCMS-1738 - This should say Never. Change when fixed.
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C225106
    */
    public function movieFreeWatchableInDistantFuture(AcceptanceTester $I)
    {
        $I->wantTo('Verify that "Never" is displayed in the portal when Free watchable date is in the distant future. - C225106');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Movie Unpaid Distant Future");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C225107
    */
    public function moviePremiumWatchableInDistantFuture(AcceptanceTester $I)
    {
        $I->wantTo('Verify that "Never" is displayed in the portal when Premium watchable date is in the distant future. - C225107');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_ContentWindows_" . BuildNo::$build . " Movie Paid Distant Future");

        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, 'Never');
    }
}
