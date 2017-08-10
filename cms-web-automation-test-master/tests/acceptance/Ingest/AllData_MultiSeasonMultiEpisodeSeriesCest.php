<?php

class AllData_MultiSeasonMultiEpisodeSeriesCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public static $series_url = '';
    public static $season_1_url = '';
    public static $episode_1_url = '';
    public static $video_url = '';


    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllData_MultiSeasonMultiEpisodeSeriesCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllData_MultiSeasonMultiEpisodeSeriesCest::$loginCookie);
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
    * TESTRAIL TESTCASE ID: C9140
    */
    public function seriesInParterPortal(AcceptanceTester $I)
    {
        $I->wantTo('Verify new series shows up in the portal and get the url. - C9140');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Series Title");

        $I->expect('We are taken to the series edit page.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url = $webdriver->getCurrentUrl();
          AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url = explode('.com', AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url)[1];
        });
        $I->expect('Series URL is ' . AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);
    }

    public function getSeasonOneUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the season in the partner portal.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Season 1 Title')]");
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Season 1 Title')]");

        $I->expect('We are taken to the page for season content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url = $webdriver->getCurrentUrl();
          AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url = explode('.com', AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url)[1];
        });
        $I->expect('Season URL is ' . AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);
    }

    public function getEpisodeOneUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the episode in the partner portal.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " S1E1 Title')]");
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " S1E1 Title')]");

        $I->expect('We are taken to the page for episode content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url = $webdriver->getCurrentUrl();
          AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url = explode('.com', AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url)[1];
        });
        $I->expect('Episode URL is ' . AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);
    }

    public function getVideoOneUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the video of the episode in the partner portal.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->moveMouseOver("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  "_ep1_media_id')]");
        $I->clickWithLeftButton("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  "_ep1_media_id')]");
        $I->expect('We are taken to the page for episode content.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url = $webdriver->getCurrentUrl();
          AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url = explode('.com', AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url)[1];
        });
        $I->expect('Video URL is ' . AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url);
    }

    /**
    * TESTRAIL TESTCASE ID: C9151
    */
    public function seasonsInParterPortal(AcceptanceTester $I)
    {
        $I->wantTo('Verify both seasons are listed on the series page. - C9151');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->waitForElementVisible("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Season 1 Title')]", 30);
        $I->waitForElementVisible("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Season 2 Title')]", 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C9141
    */
    public function episodesInParterPortal(AcceptanceTester $I)
    {
        $I->wantTo('Verify both episodes are listed on the series page. - C9141');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->waitForElementVisible("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " S1E1 Title')]", 30);
        $I->waitForElementVisible("//*[contains(text(), 'CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " S2E1 Title')]", 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C50202
    */
    public function seriesIsInitiallyUnpublished(AcceptanceTester $I)
    {
        $I->wantTo('Verify series is initially unpublished. - C50202');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->dontSeeElement('label.checkbox.checked');
        $I->dontSee('All seasons and episodes will be published.');
    }

    /**
    * TESTRAIL TESTCASE ID: C58876
    */
    public function seriesTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify series title is displayed. - C58876');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seriesTitleRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Series Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C58877
    */
    public function seriesDescriptionDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify series description is displayed. - C58877');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Series Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C36883
    */
    public function seriesCategoriesDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Categories are displayed. - C36883');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);

        $I->expect('Series Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Action/Drama', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C36884
    */
    public function seriesTagsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Tags is displayed. - C36884');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);

        $I->expect('Series Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('series category', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C58900
    */
    public function seriesPublisherDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Publisher is displayed. - C58900');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);

        $I->expect('Series Publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Ellation Series QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C36880
    */
    public function seriesMaturityRatingDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Maturity Rating is displayed. - C36880');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-G', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127372
    */
    public function imagesAttachedToSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify that a Portrait Poster and Lanscape Poster are attached to the series. - C127372');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->dontSee('There are no image files attached to this media.');
        $I->see('Landscape Poster');
        $I->see('Portrait Poster');
    }

    /**
    * TESTRAIL TESTCASE ID: C14148
    */
    public function seriesTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Title is can be edited. - C14148');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);

        $I->amGoingTo('Edit Series Title');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField("//form[contains(@class, 'attributes')]/div[2]/div/input", "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Series Title");
        $I->fillField("//form[contains(@class, 'attributes')]/div[2]/div/input", 'Multi Season Series Build ' . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seriesTitleRow_editable, 'Multi Season Series Build ' . BuildNo::$build);
    }

    /**
    * TESTRAIL TESTCASE ID: C14150
    */
    public function seriesDescriptionEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Description can be edited. - C14150');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);

        $I->amGoingTo('Edit Series Description');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField("//form[contains(@class, 'attributes')]/div[2]/div[2]/textarea", "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Series Description");
        $I->fillField("//form[contains(@class, 'attributes')]/div[2]/div[2]/textarea", BuildNo::$build . " New Description");
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$series_url);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, BuildNo::$build . " New Description");
    }

    //SEASON PAGE
    /**
    * TESTRAIL TESTCASE ID: C58901
    */
    public function seasonTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Title is displayed. - C58901');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);

        $I->expect('Season Title is displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonTitleRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Season 1 Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C58902
    */
    public function seasonLongDescriptionDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Description is displayed. - C58902');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);

        $I->expect('Season Description displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Season 1 Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C58903
    */
    public function seasonPublisherDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Publisher is displayed. - C58903');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);

        $I->expect('Season Publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Ellation Season QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C36881
    */
    public function seasonMaturityRatingDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Maturity Rating is displayed. - C36881');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-MA', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127373
    */
    public function imagesAttachedToSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify that a Portrait Poster and Lanscape Poster are attached to the season. - C127373');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->dontSee('There are no image files attached to this media.');
        $I->see('Landscape Poster');
        $I->see('Portrait Poster');
    }

    /**
    * TESTRAIL TESTCASE ID: C14157
    */
    public function seasonTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Title can be edited. - C14157');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);

        $I->amGoingTo('Edit Season Title');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonTitleRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Season 1 Title");
        $I->fillField(ContentPage::$seasonTitleRow_editable, "Edited Season Title " . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonTitleRow_editable, "Edited Season Title " . BuildNo::$build);
    }

    /**
    * TESTRAIL TESTCASE ID: C14159
    */
    public function seasonDescriptionEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Description can be edited. - C14159');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);

        $I->amGoingTo('Edit Season Description');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " Season 1 Description");
        $I->fillField(ContentPage::$descriptionRow_editable, "Edited Season Description for Build " . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$season_1_url);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, "Edited Season Description for Build " . BuildNo::$build);
    }

    //EPISODE PAGE
    /**
    * TESTRAIL TESTCASE ID: C59944
    */
    public function episodeTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Title is displayed on the Edit Episode page. - C59944');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->expect('Episode Title is displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeTitleRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " S1E1 Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C59945
    */
    public function episodeLongDescriptionDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Description is displayed on the Edit Episode page. - C59945');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->expect('Episode Description displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " S1E1 Desc");
    }

    /**
    * TESTRAIL TESTCASE ID: C36885
    */
    public function episodeCategoriesDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Categories is displayed on the Edit Episode page. - C36885');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->expect('Episode Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Action/Comedy', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C36886
    */
    public function episodeTagsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Tags is displayed on the Edit Episode page. - C36886');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->expect('Episode Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('episode test', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C36882
    */
    public function episodeMaturityRatingDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Maturity Rating is displayed on the Edit Episode page. - C36882');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-Y7', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127374
    */
    public function imagesAttachedToEpisode(AcceptanceTester $I)
    {
        $I->wantTo('Verify that a Portrait Poster and Lanscape Poster are attached to the season. - C127374');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->dontSee('There are no image files attached to this media.');
        $I->see('Landscape Poster');
        $I->see('Portrait Poster');
    }

    /**
    * TESTRAIL TESTCASE ID: C14160
    */
    public function episodeTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Title can be edited. - C14160');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->amGoingTo('Edit Episode Title');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeTitleRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " S1E1 Title");
        $I->fillField(ContentPage::$episodeTitleRow_editable, 'Edited Episode Title Build ' . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeTitleRow_editable, 'Edited Episode Title Build ' . BuildNo::$build);
    }

    /**
    * TESTRAIL TESTCASE ID: C14162
    */
    public function episodeDescriptionEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Description can be edited. - C14162');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->amGoingTo('Edit Episode Description');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  " S1E1 Desc");
        $I->fillField(ContentPage::$descriptionRow_editable, 'Edited Description Build ' . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$episode_1_url);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'Edited Description Build ' . BuildNo::$build);
    }

    //VIDEO PAGE
    /**
    * TESTRAIL TESTCASE ID: C127375
    */
    public function episodeThumbnailAttached(AcceptanceTester $I)
    {
        $I->wantTo('Verify a thumbnail has shown up. - C127375');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url);
        $I->waitForElementVisible("//a/img", 30);
        $I->dontSee('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C59948
    */
    public function episodeVideoTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title is displayed. - C59948');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" . BuildNo::$build .  "_ep1_media_title");
    }

    /**
    * TESTRAIL TESTCASE ID: C59947
    */
    public function episodeVideoAdsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the ad break is displayed. - C59947');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url);

        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C14748
    */
    public function episodeVideoTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title can be edited. - C14748');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_MultiSeasonMultiEpisodeSeries_" .  BuildNo::$build .  "_ep1_media_title");
        $I->fillField(ContentPage::$videoTitleRow_editable, "Ingest All Series Data " . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MultiSeasonMultiEpisodeSeriesCest::$video_url);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Ingest All Series Data " . BuildNo::$build);
    }
}
