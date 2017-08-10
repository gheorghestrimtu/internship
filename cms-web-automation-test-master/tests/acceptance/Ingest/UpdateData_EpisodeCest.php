<?php

class UpdateData_EpisodeCest
{
	public static $url;
    public static $loginCookie = 'undefined';

    public static $series_url = '';
    public static $season_url = '';
    public static $episode_url = '';

    public static $portraitPoster = '';
    public static $landscapePoster = '';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
       UpdateData_EpisodeCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, UpdateData_EpisodeCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    /**
    * @group initial_upload
    * @group added_data
    * @group change_data
    * @group remove_data
    */
    public function wait(AcceptanceTester $I)
    {
        $I->wantTo('Wait 2 min for everything to upload.');
        $I->wait(120);
    }

    /**
    * TESTRAIL TESTCASE ID: C14140
    *
    * @group initial_upload
    */
    public function verifyEpisodeMinimumUpload(AcceptanceTester $I)
    {
    	$I->wantTo('Verify the episode uploaded with miniumum data and get the url of the series and season. - C14140');
    	$I->amOnPage(ContentPage::$URL_ingest);

        $I->amGoingTo('Navigate to Series Page');
        $I->wait(20);
        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Series Title");

        $I->expect('We are taken to the series edit page.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          UpdateData_EpisodeCest::$series_url = $webdriver->getCurrentUrl();
          UpdateData_EpisodeCest::$series_url = explode('.com', UpdateData_EpisodeCest::$series_url)[1];
        });
        $I->expect('Series URL is ' . UpdateData_EpisodeCest::$series_url);

        $I->expect('Get the season URL.');
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Season Title')]");
        $I->waitForElementVisible("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Season Title')]", 60);
        $I->click("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Season Title')]");
        $I->waitForElementVisible(ContentPage::$attributesList, 30);

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          UpdateData_EpisodeCest::$season_url = $webdriver->getCurrentUrl();
          UpdateData_EpisodeCest::$season_url = explode('.com', UpdateData_EpisodeCest::$season_url)[1];
        });
        $I->expect('Season URL is ' . UpdateData_EpisodeCest::$season_url);

        $I->amGoingTo('Get the episode URL');
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Episode Title')]");
        $I->waitForElementVisible("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Episode Title')]", 60);
        $I->click("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Episode Title')]");
        $I->waitForElementVisible(ContentPage::$attributesList, 30);

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          UpdateData_EpisodeCest::$episode_url = $webdriver->getCurrentUrl();
          UpdateData_EpisodeCest::$episode_url = explode('.com', UpdateData_EpisodeCest::$episode_url)[1];
        });
        $I->expect('Episode URL is ' . UpdateData_EpisodeCest::$episode_url);

        $I->amGoingTo('Put the urls in a separate file.');
        $urlFile = fopen("tests/acceptance/Utils/Url.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Url\n{\npublic static " . '$series_url = "' . UpdateData_EpisodeCest::$series_url . "\";\n" .
                'public static $season_url = "' . UpdateData_EpisodeCest::$season_url . "\";\n" . 
                'public static $episode_url = "' . UpdateData_EpisodeCest::$episode_url . "\";" .
                "\n}\n?>";
        fwrite($urlFile, $text);
        fclose($urlFile);

        $I->amGoingTo('Take a screenshot.');
        $I->makeScreenshot('InitialUpload');

        $I->expect('Maturity rating, title, and unset windows appear.');
        $I->seeInField(ContentPage::$episodeTitleRow_editable, "CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Episode Title");
        $I->see('TV-G', ContentPage::$maturityRow);
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);

        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Episode_" . BuildNo::$build . "_episode_media_id']");

        $I->seeInField(ContentPage::$windowing_listingBegin_input, "Now");
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, "Now");
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, "Never");
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, "Now");
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, "Never");

        $I->seeInField(ContentPage::$airDateRow_editable, "Select an Air Date");
    }

    //ADD DATA
    /**
    * TESTRAIL TESTCASE ID: C141287
    *
    * @group added_data
    */
    public function contentWindowAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify content window is added. - C141287');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Content Window has been added.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, "Oct 4, 2015 11:00 EDT");
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, "Nov 4, 2015 10:00 EST");
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, "Dec 4, 2015 10:00 EST");
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, "Nov 4, 2015 10:00 EST");
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, "Dec 4, 2015 10:00 EST");
    }

    /**
    * TESTRAIL TESTCASE ID: C141301
    *
    * @group added_data
    */
    public function titleChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode title has changed. - C141301');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Title has been changed.');
        $I->seeInField(ContentPage::$episodeTitleRow_editable, "CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " New Episode Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C141288
    *
    * @group added_data
    */
    public function descriptionAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode description has been added. - C141288');
        $I->amOnPage(Url::$episode_url);

        $I->expect('A description is present.');
        $I->seeInField(ContentPage::$descriptionRow_editable,  "CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " Episode Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C141289
    *
    * @group added_data
    */
    public function categoriesAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode categories have been added. - C141288');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Movie Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Action/Drama', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C141290
    *
    * @group added_data
    */
    public function tagsAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode tags have been added. - C141289');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Episode Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('episode category', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C141292
    *
    * @group added_data
    */
    public function maturityRatingAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode maturity rating has been added. - C141292');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-Y7', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C141293
    *
    * @group added_data
    */
    public function airDateAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode air date is added. - C141293');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Air date displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$airDateRow_editable, "Oct 4, 2015 11:00 EDT");
    }

    /**
    * TESTRAIL TESTCASE ID: C141294
    *
    * @group added_data
    */
    public function portraitPosterAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode portrait poster has been added. - C141294');
        $I->amOnPage(Url::$episode_url);
        
        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('AddedPortraitPoster');

        $I->amGoingTo('Grab the image filename.');
        UpdateData_EpisodeCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C141295
    *
    * @group added_data
    */
    public function landscapePosterAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode landscape poster has been added. - C141295');
        $I->amOnPage(Url::$episode_url);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('AddedLandscapePoster');

        $I->amGoingTo('Grab the image filename.');
        UpdateData_EpisodeCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");

        $I->amGoingTo('Put image filenames in separate file.');
        $imageFile = fopen("tests/acceptance/Utils/Images.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Images\n{\npublic static " .
            '$landscapePoster = "' . UpdateData_EpisodeCest::$landscapePoster . "\";\npublic static" .  '$portraitPoster = "' . 
            UpdateData_EpisodeCest::$portraitPoster . "\";\n}\n?>";
        fwrite($imageFile, $text);
        fclose($imageFile);
    }

    /**
    * TESTRAIL TESTCASE ID: C141298
    *
    * @group added_data
    */
    public function episodeExtraAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode extra has been added. - C141298');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Extra is visible.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('There are no videos attached to this media.');
        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Episode_" . BuildNo::$build . "_episode_extra_clip_id']");
    }

    //CHANGE DATA
    /**
    * TESTRAIL TESTCASE ID: C141300
    *
    * @group change_data
    */
    public function contentWindowChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify content window has changed. - C141300');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Content Window has been changed.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, "Oct 4, 2010 11:00 EDT");
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, "Nov 4, 2010 11:00 EDT");
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, "Dec 4, 2010 10:00 EST");
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, "Nov 4, 2010 11:00 EDT");
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, "Dec 4, 2010 10:00 EST");
    }

    /**
    * TESTRAIL TESTCASE ID: C141299
    *
    * @group change_data
    */ 
    public function episodeNumberChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode number has changed. - C141299');
        $I->amOnPage(URL::$season_url);

        $I->waitForElementVisible("//td[text()='5']", 30); //episode number
    }

    /**
    * TESTRAIL TESTCASE ID: C141314
    *
    * @group change_data
    *
    * Note: It is part of this group so that it is not left with a blank title after the test
    */
    public function titleCleared(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode title has been cleared. - C141314');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Title has been changed.');
        $I->dontSeeInField(ContentPage::$episodeTitleRow_editable, "CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " New Episode Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C141302
    *
    * @group change_data
    */
    public function descriptionChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode description has been changed. - C141302');
        $I->amOnPage(Url::$episode_url);

        $I->expect('A description is present.');
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " New Episode Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C141303
    *
    * @group change_data
    */
    public function categoriesChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode categories have been changed. - C141303');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Movie Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('New Action/Drama', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C141304
    *
    * @group change_data
    */
    public function tagsChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode tags have been changed. - C141304');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Movie Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('new episode category', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('new qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C141306
    *
    * @group change_data
    */
    public function maturityRatingChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode maturity rating has been changed. - C141306');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-MA', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C141307
    *
    * @group change_data
    */
    public function airDateChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode air date is changed. - C141307');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Air date displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$airDateRow_editable, "Oct 4, 2010 11:00 EDT");
    }

    /**
    * TESTRAIL TESTCASE ID: C141308
    *
    * @group change_data
    */
    public function portraitPosterChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode portrait poster has been changed. - C141308');
        $I->amOnPage(Url::$episode_url);

        $I->expect('There are no extra images and previous filename is not present.');
        $I->waitForElementVisible("//td[text()='Portrait Poster']", 30);
        $I->dontSee("(//td[text()='Portrait Poster'])[2]");
        $I->dontSee(Images::$portraitPoster);

        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('ChangedPortraitPoster');
        UpdateData_EpisodeCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C141309
    *
    * @group change_data
    */
    public function landscapePosterChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode landscape poster has been changed. - C141309');
        $I->amOnPage(Url::$episode_url);

        $I->expect('There are no extra images and previous filename is not present.');
        $I->waitForElementVisible("//td[text()='Landscape Poster']", 30);
        $I->dontSee("(//td[text()='Landscape Poster'])[2]");
        $I->dontSee(Images::$landscapePoster);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('ChangedLandscapePoster');
        UpdateData_EpisodeCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");

        $I->amGoingTo('Put image filenames in separate file.');
        $imageFile = fopen("tests/acceptance/Utils/Images.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Images\n{\npublic static " .
            '$landscapePoster = "' . UpdateData_EpisodeCest::$landscapePoster . "\";\npublic static" .  '$portraitPoster = "' . 
            UpdateData_EpisodeCest::$portraitPoster . "\";\n}\n?>";
        fwrite($imageFile, $text);
        fclose($imageFile);
    }

    /**
    * TESTRAIL TESTCASE ID: C141312
    *
    * @group change_data
    */
    public function episodeExtraChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode extra has been changed. - C141312');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Extra is visible.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('There are no videos attached to this media.');
        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Episode_" . BuildNo::$build . "_episode_changed_extra_clip_id']");
    }

    /**
    * TESTRAIL TESTCASE ID: C141326
    *
    * @group change_data
    */
    public function episodeMediaIdChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode media id has been changed. - C141326');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Extra is visible.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('There are no videos attached to this media.');
        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Episode_" . BuildNo::$build . "_changed_episode_media_id']");
    }

    //REMOVE DATA
    /**
    * TESTRAIL TESTCASE ID: C141313
    *
    * @group remove_data
    */
    public function contentWindowRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify content window is removed. - C141313');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Content Window has been removed.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, "Now");
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, "Now");
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, "Never");
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, "Now");
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, "Never");
    }

    /**
    * TESTRAIL TESTCASE ID: C141315
    *
    * @group remove_data
    */
    public function descriptionRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode description has been removed. - C141315');
        $I->amOnPage(Url::$episode_url);

        $I->expect('A description is not present.');
        $I->dontSeeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_UpdateData_Episode_" .  BuildNo::$build .  " New Episode Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C141316
    *
    * @group remove_data
    */
    public function categoriesRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode categories have been removed. - C141316');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Movie Categories removed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSeeElement('span.tags-tagname');
        $I->dontSee('Action/Drama');
    }

    /**
    * TESTRAIL TESTCASE ID: C141317
    *
    * @group remove_data
    */
    public function tagsRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode tags have been removed. - C141317');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Episode Tags removed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSeeElement('span.tags-tagname');
        $I->dontSee('episode cateogry');
    }

    /**
    * TESTRAIL TESTCASE ID: C141319
    *
    * @group remove_data
    */
    public function maturityRatingRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode maturity rating has been removed. - C141319');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Default Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-G', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C141320
    *
    * @group remove_data
    */
    public function airDateRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode air date is removed. - C141320');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Air date displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$airDateRow_editable, "Select an Air Date");
    }

    /**
    * TESTRAIL TESTCASE ID: C141321
    *
    * @group remove_data
    */
    public function portraitPosterRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode portrait poster remains after manifest is ingested without it. - C141321');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Previous images are still present.');
        $I->waitForText(Images::$portraitPoster, 30);

        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('RemovedPortraitPoster');
        UpdateData_EpisodeCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C141322
    *
    * @group remove_data
    */
    public function landscapePosterRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode landscape poster remains after manifest is ingested without it. - C141322');
        $I->amOnPage(Url::$episode_url);

        $I->expect('Previous images are still present.');
        $I->waitForText(Images::$landscapePoster, 30);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('RemovedLandscapePoster');
        UpdateData_EpisodeCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C141325
    *
    * @group remove_data
    */
    public function episodeExtraRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode extra has been removed. - C141325');
        $I->amOnPage(Url::$episode_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);

        $I->expect('Extra is not visible.');
        $I->dontSeeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Episode_" . BuildNo::$build . "_episode_changed_extra_clip_id']");
    }
}