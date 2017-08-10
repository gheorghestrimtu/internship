<?php

class UpdateData_SeasonCest
{
	public static $url;
    public static $loginCookie = 'undefined';

    public static $series_url = '';
    public static $season_url = '';

    public static $portraitPoster = '';
    public static $landscapePoster = '';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        UpdateData_SeasonCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, UpdateData_SeasonCest::$loginCookie);
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
    * TESTRAIL TESTCASE ID: C14139
    *
    * @group initial_upload
    */
    public function verifySeasonMinimumUpload(AcceptanceTester $I)
    {
    	$I->wantTo('Verify the season uploaded with miniumum data and get the url of the series and season. - C14139');
    	$I->amOnPage(ContentPage::$URL_ingest);

        $I->amGoingTo('Navigate to series page.');
        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " Series Title");

        $I->expect('We are taken to the season edit page.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForElementVisible("//td[text()='1']", 30); //season number
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          UpdateData_SeasonCest::$series_url = $webdriver->getCurrentUrl();
          UpdateData_SeasonCest::$series_url = explode('.com', UpdateData_SeasonCest::$series_url)[1];
        });
        $I->expect('Series URL is ' . UpdateData_SeasonCest::$series_url);

        $I->expect('Get the season URL.');
        $I->scrollTo("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " Season Title')]");
        $I->waitForElementVisible("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " Season Title')]", 60);
        $I->click("//*[contains(text(), 'CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " Season Title')]");
        $I->waitForElementVisible(ContentPage::$attributesList, 30);

        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          UpdateData_SeasonCest::$season_url = $webdriver->getCurrentUrl();
          UpdateData_SeasonCest::$season_url = explode('.com', UpdateData_SeasonCest::$season_url)[1];
        });
        $I->expect('Season URL is ' . UpdateData_SeasonCest::$season_url);

        $I->amGoingTo('Put the urls in a separate file.');
        $urlFile = fopen("tests/acceptance/Utils/Url.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Url\n{\npublic static " . '$series_url = "' . UpdateData_SeasonCest::$series_url . "\";\n" .
                'public static $season_url = "' . UpdateData_SeasonCest::$season_url . "\";\n}\n?>";
        fwrite($urlFile, $text);
        fclose($urlFile);

        $I->amGoingTo('Take a screenshot.');
        $I->makeScreenshot('InitialUpload');

        $I->expect('Maturity rating, title, and warnings about no content appear.');
        $I->seeInField(ContentPage::$seasonTitleRow_editable, "CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " Season Title");
        $I->see('TV-G', ContentPage::$maturityRow);
        $I->see('There are no episodes attached to this media.');
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);
        $I->see('There are no videos attached to this media.');
    }

    //ADD DATA
    /**
    * TESTRAIL TESTCASE ID: C139124
    *
    * @group added_data
    */
    public function titleChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify season title has changed. - C139124');
        $I->amOnPage(Url::$season_url);

        $I->expect('Title has been changed.');
        $I->seeInField(ContentPage::$seasonTitleRow_editable, "CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " New Season Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C139113
    *
    * @group added_data
    */
    public function descriptionAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify season description has been added. - C139113');
        $I->amOnPage(Url::$season_url);

        $I->expect('A description is present.');
        $I->seeInField(ContentPage::$descriptionRow_editable,  "CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " Season Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C139116
    *
    * @group added_data
    */
    public function publisherAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify season publisher has been added. - C139116');
        $I->amOnPage(Url::$season_url);

        $I->expect('Season Publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Ellation Season QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C139118
    *
    * @group added_data
    */
    public function portraitPosterAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify season portrait poster has been added. - C139118');
        $I->amOnPage(Url::$season_url);
        
        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('AddedPortraitPoster');

        $I->amGoingTo('Grab the image filename.');
        UpdateData_SeasonCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C139118
    *
    * @group added_data
    */
    public function landscapePosterAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify season landscape poster has been added. - C139119');
        $I->amOnPage(Url::$season_url);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('AddedLandscapePoster');

        $I->amGoingTo('Grab the image filename.');
        UpdateData_SeasonCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");

        $I->amGoingTo('Put image filenames in separate file.');
        $imageFile = fopen("tests/acceptance/Utils/Images.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Images\n{\npublic static " .
            '$landscapePoster = "' . UpdateData_SeasonCest::$landscapePoster . "\";\npublic static" .  '$portraitPoster = "' . 
            UpdateData_SeasonCest::$portraitPoster . "\";\n}\n?>";
        fwrite($imageFile, $text);
        fclose($imageFile);
    }

    /**
    * TESTRAIL TESTCASE ID: C139122
    *
    * @group added_data
    */
    public function seasonExtraAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify season extra has been added. - C139122');
        $I->amOnPage(Url::$season_url);

        $I->expect('Extra is visible.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('There are no videos attached to this media.');
        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Season_" . BuildNo::$build . "_season_extra_clip_id']");
    }

    //CHANGE DATA
    /**
    * TESTRAIL TESTCASE ID: C139123
    *
    * @group change_data
    */ 
    public function seasonSortkeyChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify season sortkey has changed. - C139123');
        $I->amOnPage(URL::$series_url);

        $I->waitForElementVisible("//td[text()='5']", 30); //season number
    }

    /**
    * TESTRAIL TESTCASE ID: C139135
    *
    * @group change_data
    *
    * Note: It is part of this group so that it is not left with a blank title after the test
    */
    public function titleCleared(AcceptanceTester $I)
    {
        $I->wantTo('Verify season title has been cleared. - C139135');
        $I->amOnPage(Url::$season_url);

        $I->expect('Title has been changed.');
        $I->dontSeeInField(ContentPage::$seasonTitleRow_editable, "CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " New Season Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C139125
    *
    * @group change_data
    */
    public function descriptionChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify season description has been changed. - C139125');
        $I->amOnPage(Url::$season_url);

        $I->expect('A description is present.');
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " New Season Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C139128
    *
    * @group change_data
    */
    public function publisherChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify season publisher has been changed. - C139128');
        $I->amOnPage(Url::$season_url);

        $I->expect('Season Publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('New Ellation Season QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C139130
    *
    * @group change_data
    */
    public function portraitPosterChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify season portrait poster has been changed. - C139130');
        $I->amOnPage(Url::$season_url);

        $I->expect('There are no extra images and previous filename is not present.');
        $I->waitForElementVisible("//td[text()='Portrait Poster']", 30);
        $I->dontSee("(//td[text()='Portrait Poster'])[2]");
        $I->dontSee(Images::$portraitPoster);

        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('ChangedPortraitPoster');
        UpdateData_SeasonCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C139131
    *
    * @group change_data
    */
    public function landscapePosterChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify season landscape poster has been changed. - C139131');
        $I->amOnPage(Url::$season_url);

        $I->expect('There are no extra images and previous filename is not present.');
        $I->waitForElementVisible("//td[text()='Landscape Poster']", 30);
        $I->dontSee("(//td[text()='Landscape Poster'])[2]");
        $I->dontSee(Images::$landscapePoster);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('ChangedLandscapePoster');
        UpdateData_SeasonCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");

        $I->amGoingTo('Put image filenames in separate file.');
        $imageFile = fopen("tests/acceptance/Utils/Images.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Images\n{\npublic static " .
            '$landscapePoster = "' . UpdateData_SeasonCest::$landscapePoster . "\";\npublic static" .  '$portraitPoster = "' . 
            UpdateData_SeasonCest::$portraitPoster . "\";\n}\n?>";
        fwrite($imageFile, $text);
        fclose($imageFile);
    }

    /**
    * TESTRAIL TESTCASE ID: C139134
    *
    * @group change_data
    */
    public function seasonExtraChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify season extra has been changed. - C139134');
        $I->amOnPage(Url::$season_url);

        $I->expect('Extra is visible.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('There are no videos attached to this media.');
        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Season_" . BuildNo::$build . "_season_changed_extra_clip_id']");
    }

    //REMOVE DATA
    /**
    * TESTRAIL TESTCASE ID: C139136v
    *
    * @group remove_data
    */
    public function descriptionRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify season description has been removed. - C139136');
        $I->amOnPage(Url::$season_url);

        $I->expect('A description is not present.');
        $I->dontSeeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_UpdateData_Season_" .  BuildNo::$build .  " New Season Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C139139 
    *
    * @group remove_data
    */
    public function publisherRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify season publisher has been removed. - C139139');
        $I->amOnPage(Url::$season_url);

        $I->expect('Season Publisher removed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('New Ellation Season QA');
    }

    /**
    * TESTRAIL TESTCASE ID: C139141
    *
    * @group remove_data
    */
    public function portraitPosterRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify season portrait poster remains after manifest is ingested without it. - C139141');
        $I->amOnPage(Url::$season_url);

        $I->expect('Previous images are still present.');
        $I->waitForText(Images::$portraitPoster, 30);

        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('RemovedPortraitPoster');
        UpdateData_SeasonCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C139142
    *
    * @group remove_data
    */
    public function landscapePosterRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify season landscape poster remains after manifest is ingested without it. - C139142');
        $I->amOnPage(Url::$season_url);

        $I->expect('Previous images are still present.');
        $I->waitForText(Images::$landscapePoster, 30);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->moveMouseOver("//td[text()='Landscape Poster']");
        $I->clickWithLeftButton("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('RemovedLandscapePoster');
        UpdateData_SeasonCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C139145
    *
    * @group remove_data
    */
    public function seasonExtraRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify season extra has been removed. - C139145');
        $I->amOnPage(Url::$season_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);

        $I->expect('Extra is not visible.');
        $I->waitForText('There are no videos attached to this media.', 30);
        $I->dontSeeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Season_" . BuildNo::$build . "_season_changed_extra_clip_id']");
    }
}