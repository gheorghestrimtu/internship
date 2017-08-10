<?php

class AllData_MovieCest
{
    public static $url;
    public static $loginCookie = 'undefined';

    public static $movie_url = '';
    public static $movieVideo_url = '';
    public static $extraVideo_url = '';


    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        AllData_MovieCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, AllData_MovieCest::$loginCookie);
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
    * TESTRAIL TESTCASE ID: C14752
    */
    public function movieInParterPortal(AcceptanceTester $I)
    {
        $I->wantTo('Verify new movie shows up in the portal and get the url. - C14752');
        $I->amOnPage(ContentPage::$URL_ingest);

        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  " Movie Title");
        
        $I->expect('We are taken to the movie edit page.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_MovieCest::$movie_url = $webdriver->getCurrentUrl();
          AllData_MovieCest::$movie_url = explode('.com', AllData_MovieCest::$movie_url)[1];
        });
        $I->expect('Movie URL is ' . AllData_MovieCest::$movie_url);
    }

    public function getMovieVideoUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the video of the movie in the partner portal.');
        $I->amOnPage(AllData_MovieCest::$movie_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  "_movie_media_id')]");
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  "_movie_media_id')]");

        $I->expect('We are taken to the page for movie content.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_MovieCest::$movieVideo_url = $webdriver->getCurrentUrl();
          AllData_MovieCest::$movieVideo_url = explode('.com', AllData_MovieCest::$movieVideo_url)[1];
        });
        $I->expect('Video URL is ' . AllData_MovieCest::$movieVideo_url);
    }

    public function getExtraVideoUrl(AcceptanceTester $I)
    {
        $I->wantTo('Get the url for the video of the extra in the partner portal.');
        $I->amOnPage(AllData_MovieCest::$movie_url);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  "_movie_clip_media_id')]");
        $I->click("//*[contains(text(), 'CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  "_movie_clip_media_id')]");

        $I->expect('We are taken to the page for extra content.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          AllData_MovieCest::$extraVideo_url = $webdriver->getCurrentUrl();
          AllData_MovieCest::$extraVideo_url = explode('.com', AllData_MovieCest::$extraVideo_url)[1];
        });
        $I->expect('Video URL is ' . AllData_MovieCest::$extraVideo_url);
    }

    /**
    * TESTRAIL TESTCASE ID: C50204
    */
    public function movieIsInitiallyUnpublished(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie is initially unpublished. - C50204');
        $I->amOnPage(AllData_MovieCest::$movie_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->dontSeeElement("//div[@class='form-item']//label[contains(@class, 'checked')]");
        $I->dontSee('Users who match window settings can view and/or watch content as defined.');
    }

    /**
    * TESTRAIL TESTCASE ID: C78751
    */
    public function movieTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie title is displayed. - C78751');
        $I->amOnPage(AllData_MovieCest::$movie_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$movieTitleRow_editable, "CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  " Movie Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C78752
    */
    public function movieDescriptionDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie description is displayed. - C78752');
        $I->amOnPage(AllData_MovieCest::$movie_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  " Movie Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C36889
    */
    public function movieCategoriesDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Categories are displayed. - C36889');
        $I->amOnPage(AllData_MovieCest::$movie_url);

        $I->expect('Movie Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Action/Comedy', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C36890  
    */
    public function movieTagsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Tags is displayed. - C36890    ');
        $I->amOnPage(AllData_MovieCest::$movie_url);

        $I->expect('Movie Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('movie test', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C78753
    */
    public function moviePublisherDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Publisher is displayed. - C78753');
        $I->amOnPage(AllData_MovieCest::$movie_url);

        $I->expect('Movie Publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Ellation QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C36888
    */
    public function movieMaturityRatingDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Maturity Rating is displayed. - C36888');
        $I->amOnPage(AllData_MovieCest::$movie_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-G', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127376
    */
    public function imagesAttachedToMovie(AcceptanceTester $I)
    {
        $I->wantTo('Verify that a Portrait Poster and Lanscape Poster are attached to the movie. - C127376');
        $I->amOnPage(AllData_MovieCest::$movie_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->dontSee('There are no image files attached to this media.');
        $I->see('Landscape Poster');
        $I->see('Portrait Poster');
    }

    /**
    * TESTRAIL TESTCASE ID: C14756
    */
    public function movieTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Title is can be edited. - C14756');
        $I->amOnPage(AllData_MovieCest::$movie_url);

        $I->amGoingTo('Edit Movie Title');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$movieTitleRow_editable, "CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  " Movie Title");
        $I->fillField(ContentPage::$movieTitleRow_editable, 'Test Movie Build ' . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MovieCest::$movie_url);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$movieTitleRow_editable, 'Test Movie Build ' . BuildNo::$build);
    }

    /**
    * TESTRAIL TESTCASE ID: C14758
    */
    public function movieDescriptionEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Description can be edited. - C14758');
        $I->amOnPage(AllData_MovieCest::$movie_url);

        $I->amGoingTo('Edit Movie Description');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->scrollTo(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  " Movie Description");
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  " Movie Description");
        $I->fillField(ContentPage::$descriptionRow_editable, BuildNo::$build . " New Description");
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MovieCest::$movie_url);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, BuildNo::$build . " New Description");
    }


    //VIDEO PAGE
    /**
    * TESTRAIL TESTCASE ID: C127377
    */
    public function movieThumbnailAttached(AcceptanceTester $I)
    {
        $I->wantTo('Verify a thumbnail has shown up. - C127377');
        $I->amOnPage(AllData_MovieCest::$movieVideo_url);
        $I->waitForElementVisible("//a/img", 30);
        $I->dontSee('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C59948
    */
    public function movieVideoTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title is displayed. - C59948');
        $I->amOnPage(AllData_MovieCest::$movieVideo_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_Movie_" . BuildNo::$build .  "_video_title");
    }

    /**
    * TESTRAIL TESTCASE ID: C59947
    */
    public function movieVideoAdsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the ad break is displayed. - C59947');
        $I->amOnPage(AllData_MovieCest::$movieVideo_url);

        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C14748
    */
    public function movieVideoTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title can be edited. - C14748');
        $I->amOnPage(AllData_MovieCest::$movieVideo_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  "_video_title");
        $I->fillField(ContentPage::$videoTitleRow_editable, "Ingest All Movie Data " . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MovieCest::$movieVideo_url);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Ingest All Movie Data " . BuildNo::$build);
    }

    /**
    * TESTRAIL TESTCASE ID: C129733
    */
    public function movieExtraThumbnailAttached(AcceptanceTester $I)
    {
        $I->wantTo('Verify a thumbnail has shown up. - C129733');
        $I->amOnPage(AllData_MovieCest::$extraVideo_url);
        $I->waitForElementVisible("//a/img", 30);
        $I->dontSee('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C59962
    */
    public function movieExtraVideoTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title is displayed. - C59962');
        $I->amOnPage(AllData_MovieCest::$extraVideo_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_Movie_" . BuildNo::$build .  " Movie Extra Clip Video Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C59963
    */
    public function movieExtraVideoAdsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify the ad break is displayed. - C59963');
        $I->amOnPage(AllData_MovieCest::$extraVideo_url);

        $I->see('00:00:05', '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C14204
    */
    public function movieExtraVideoTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify the video title can be edited. - C14204');
        $I->amOnPage(AllData_MovieCest::$extraVideo_url);

        $I->seeInField(ContentPage::$videoTitleRow_editable, "CXCMS_Ingest_AllData_Movie_" .  BuildNo::$build .  " Movie Extra Clip Video Title");
        $I->fillField(ContentPage::$videoTitleRow_editable, "Ingest All Data - Movie Build " . BuildNo::$build);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(AllData_MovieCest::$extraVideo_url);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Ingest All Data - Movie Build " . BuildNo::$build);
    }
}
