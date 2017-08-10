<?php

class AllData_AllSeriesExtrasCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public static $series_url = '';
    public static $season_url = '';
    public static $episode_url = '';

    public static $seriesExtra_url = '';
    public static $seasonExtra_url = '';
    public static $episodeExtra_url = '';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllData_AllSeriesExtrasCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllData_AllSeriesExtrasCest::$loginCookie);
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

    public function getSeriesUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the series in the partner portal.');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  " Series Title");

        $I->expect('We are taken to the series edit page.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_AllSeriesExtrasCest::$series_url = $webdriver->getCurrentUrl();
          AllData_AllSeriesExtrasCest::$series_url = explode('.com', AllData_AllSeriesExtrasCest::$series_url)[1];
        });
        $I->expect('Series URL is ' . AllData_AllSeriesExtrasCest::$series_url);
    }

    public function getSeriesExtraUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the series extra in the partner portal.');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$series_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  "_series_extra_clip_id')]");
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  "_series_extra_clip_id')]");

        $I->expect('We are taken to the video edit page.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_AllSeriesExtrasCest::$seriesExtra_url = $webdriver->getCurrentUrl();
          AllData_AllSeriesExtrasCest::$seriesExtra_url = explode('.com', AllData_AllSeriesExtrasCest::$seriesExtra_url)[1];
        });
        $I->expect('Series Extra URL is ' . AllData_AllSeriesExtrasCest::$seriesExtra_url);
    }

    public function getSeasonUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the season in the partner portal.');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$series_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  " Extras Season 1')]");

        $I->expect('We are taken to the page for season content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_AllSeriesExtrasCest::$season_url = $webdriver->getCurrentUrl();
          AllData_AllSeriesExtrasCest::$season_url = explode('.com', AllData_AllSeriesExtrasCest::$season_url)[1];
        });
        $I->expect('Season URL is ' . AllData_AllSeriesExtrasCest::$season_url);
    }

    public function getSeasonExtraUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the season extra in the partner portal.');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$season_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  "_season_extra_clip_id')]");
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  "_season_extra_clip_id')]");

        $I->expect('We are taken to the video edit page.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_AllSeriesExtrasCest::$seasonExtra_url = $webdriver->getCurrentUrl();
          AllData_AllSeriesExtrasCest::$seasonExtra_url = explode('.com', AllData_AllSeriesExtrasCest::$seasonExtra_url)[1];
        });
        $I->expect('Season Extra URL is ' . AllData_AllSeriesExtrasCest::$seasonExtra_url);
    }

    public function getEpisodeUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the episode in the partner portal.');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$season_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  " Episode Title')]");

        $I->expect('We are taken to the page for episode content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_AllSeriesExtrasCest::$episode_url = $webdriver->getCurrentUrl();
          AllData_AllSeriesExtrasCest::$episode_url = explode('.com', AllData_AllSeriesExtrasCest::$episode_url)[1];
        });
        $I->expect('Episode URL is ' . AllData_AllSeriesExtrasCest::$episode_url);
    }

    public function getEpisodeExtraUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the episode extra in the partner portal.');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$episode_url);
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  "_episode_extra_clip_id')]");
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  "_episode_extra_clip_id')]");

        $I->expect('We are taken to the video edit page.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_AllSeriesExtrasCest::$episodeExtra_url = $webdriver->getCurrentUrl();
          AllData_AllSeriesExtrasCest::$episodeExtra_url = explode('.com', AllData_AllSeriesExtrasCest::$episodeExtra_url)[1];
        });
        $I->expect('Episode Extra URL is ' . AllData_AllSeriesExtrasCest::$episodeExtra_url);
    }

    /**
    * TESTRAIL TESTCASE ID: C129727
    */
    public function seriesExtraThumbnailAttached(AcceptanceTester $I)
    {
        $I->wantTo('Verify a thumbnail has shown up. - C129727');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seriesExtra_url);
        $I->waitForElementVisible("//a/img", 30);
        $I->dontSee('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C59953
    */
    public function seriesExtraVideoTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title is displayed. - C59953');

        $I->amOnPage(AllData_AllSeriesExtrasCest::$seriesExtra_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_AllSeriesExtras_" . BuildNo::$build .  " Series Extra Clip Video Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C59954
    */
    public function seriesExtraVideoAdsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the ad break is displayed. - C59954');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seriesExtra_url);

        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C14183
    */
    public function seriesExtraVideoTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title can be edited. - C14183');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seriesExtra_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  " Series Extra Clip Video Title");
        $I->fillField(ContentPage::$videoTitleRow_editable, "Ingest All Data - Series Extra Build " . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seriesExtra_url);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Ingest All Data - Series Extra Build " . BuildNo::$build);
    }

    /**
    * TESTRAIL TESTCASE ID: C129729
    */
    public function seasonExtraThumbnailAttached(AcceptanceTester $I)
    {
        $I->wantTo('Verify a thumbnail has shown up. - C129729');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seasonExtra_url);
        $I->waitForElementVisible("//a/img", 30);
        $I->dontSee('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C59956
    */
    public function seasonExtraVideoTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title is displayed. - C59956');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seasonExtra_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_AllSeriesExtras_" . BuildNo::$build .  " Season Extra Clip Video Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C59957
    */
    public function seasonExtraVideoAdsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the ad break is displayed. - C59957');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seasonExtra_url);

        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C14190
    */
    public function seasonExtraVideoTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title can be edited. - C14190');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seasonExtra_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  " Season Extra Clip Video Title");
        $I->fillField(ContentPage::$videoTitleRow_editable, "Ingest All Data - Season Extra Build " . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$seasonExtra_url);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Ingest All Data - Season Extra Build " . BuildNo::$build);
    }

    /**
    * TESTRAIL TESTCASE ID: C129731
    */
    public function episodeExtraThumbnailAttached(AcceptanceTester $I)
    {
        $I->wantTo('Verify a thumbnail has shown up. - C129731');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$episodeExtra_url);
        $I->waitForElementVisible("//a/img", 30);
        $I->dontSee('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C59959
    */
    public function episodeExtraVideoTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title is displayed. - C59959');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$episodeExtra_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_AllSeriesExtras_" . BuildNo::$build .  " Episode Extra Clip Video Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C59960
    */
    public function episodeExtraVideoAdsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the ad break is displayed. - C59960');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$episodeExtra_url);

        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C14197
    */
    public function episodeExtraVideoTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title can be edited. - C14197');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$episodeExtra_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_AllSeriesExtras_" .  BuildNo::$build .  " Episode Extra Clip Video Title");
        $I->fillField(ContentPage::$videoTitleRow_editable, "Ingest All Data - Episode Extra Build " . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_AllSeriesExtrasCest::$episodeExtra_url);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Ingest All Data - Episode Extra Build " . BuildNo::$build);
    }
}
