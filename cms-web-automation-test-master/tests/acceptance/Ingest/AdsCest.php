<?php

class AdsCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AdsCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AdsCest::$loginCookie);
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
    * TESTRAIL TESTCASE ID: C71675
    */
    public function episodeDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify Defined Ads show up on episode. - C71675');
        $I->amOnPage(ContentPage::$URL_ingest);
        
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Defined");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Defined Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Defined Episode");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_defined_episode_media_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_defined_episode_media_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_defined_episode_media_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C59949
    */
    public function episodeNoDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify no Defined Ads show up on episode. - C59949');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode No Defined");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode No Defined Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode No Defined Episode");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_nodefined_episode_media_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_nodefined_episode_media_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_nodefined_episode_media_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->dontSeeElement('//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C71676  
    */
    public function movieDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify Defined Ads show up on movie. - C71676');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Movie Defined");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_defined_media_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_defined_media_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_defined_media_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C59952
    */
    public function movieNoDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify no Defined Ads show up on movie. - C59952');
        $I->amOnPage(ContentPage::$URL_ingest);
        
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Movie No Defined");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_nodefined_media_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_nodefined_media_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_nodefined_media_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->dontSeeElement('//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C71677  
    */
    public function seriesExtraDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify Defined Ads show up on series extra. - C71677');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Series Extra Defined");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_series_extra_defined_clip_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_series_extra_defined_clip_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_series_extra_defined_clip_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C59955
    */
    public function seriesExtraNoDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify no Defined Ads show up on series extra. - C59955');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Series Extra No Defined");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_series_extra_nodefined_clip_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_series_extra_nodefined_clip_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_series_extra_nodefined_clip_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->dontSeeElement('//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C71678
    */
    public function seasonExtraDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify Defined Ads show up on season extra. - C71678');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Season Extra Defined");
        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Season Extra Defined Season");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_season_extra_defined_clip_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_season_extra_defined_clip_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_season_extra_defined_clip_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C59958
    */
    public function seasonExtraNoDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify no Defined Ads show up on season extra. - C59958');
        $I->amOnPage(ContentPage::$URL_ingest);
        
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Season Extra No Defined");
        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Season Extra No Defined Season");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_season_extra_nodefined_clip_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_season_extra_nodefined_clip_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_season_extra_nodefined_clip_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->dontSeeElement('//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C71679
    */
    public function episodeExtraDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify Defined Ads show up on episode extra. - C71679');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Extra Defined");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Extra Defined Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Extra Defined Episode");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_extra_defined_clip_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_extra_defined_clip_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_extra_defined_clip_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C59961
    */
    public function episodeExtraNoDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify no Defined Ads show up on episode extra. - C59961');
        $I->amOnPage(ContentPage::$URL_ingest);
        
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Extra No Defined");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Extra No Defined Season");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Episode Extra No Defined Episode");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_extra_nodefined_clip_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_extra_nodefined_clip_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_episode_extra_nodefined_clip_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->dontSeeElement('//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C71680  
    */
    public function movieExtraDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify Defined Ads show up on movie extra. - C71680');
        $I->amOnPage(ContentPage::$URL_ingest);
        
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Movie Extra Defined");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_extra_defined_clip_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_extra_defined_clip_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_extra_defined_clip_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C59964
    */
    public function movieExtraNoDefinedAds(AcceptanceTester $I)
    {
        $I->wantTo('Verify no Defined Ads show up on movie extra. - C59964');
        $I->amOnPage(ContentPage::$URL_ingest);
        
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_Ads_" . BuildNo::$build . " Movie Extra No Defined");

        $I->scrollTo("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_extra_nodefined_clip_id']");
        $I->waitForElementVisible("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_extra_nodefined_clip_id']", 30);
        $I->click("//tr/td/span[text()='CXCMS_Ingest_Ads_" . BuildNo::$build . "_movie_extra_nodefined_clip_id']");

        $I->waitForText('VIDEO PREVIEW', 30);
        $I->dontSeeElement('//div[@class="adbreaks-input"]/ul/li/span');
    }
}
