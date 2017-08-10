<?php

class UpdateData_MovieCest
{
	public static $url;
    public static $loginCookie = 'undefined';

    public static $movie_url = '';

    public static $portraitPoster = '';
    public static $landscapePoster = '';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        UpdateData_MovieCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, UpdateData_MovieCest::$loginCookie);
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
    * TESTRAIL TESTCASE ID: C14141
    *
    * @group initial_upload
    */
    public function verifyMovieMinimumUpload(AcceptanceTester $I)
    {
    	$I->wantTo('Verify the movie uploaded with miniumum data and get the url of the movie. - C14141');
    	$I->amOnPage(ContentPage::$URL_ingest);

        $I->amGoingTo("Navigate to Movie page");
        ContentUtils::clickTableRowOfTitle($I, "CXCMS_Ingest_UpdateData_Movie_" .  BuildNo::$build .  " Movie Title");

        $I->expect('We are taken to the movie edit page.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          UpdateData_MovieCest::$movie_url = $webdriver->getCurrentUrl();
          UpdateData_MovieCest::$movie_url = explode('.com', UpdateData_MovieCest::$movie_url)[1];
        });
        $I->expect('Movie URL is ' . UpdateData_MovieCest::$movie_url);

        $I->amGoingTo('Put the url in a separate file.');
        $urlFile = fopen("tests/acceptance/Utils/Url.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Url\n{\npublic static " . '$movie_url = "' . UpdateData_MovieCest::$movie_url . "\";\n}\n?>";
        fwrite($urlFile, $text);
        fclose($urlFile);

        $I->amGoingTo('Take a screenshot.');
        $I->makeScreenshot('InitialUpload');

        $I->expect('Maturity rating, title, and unset windows appear.');
        $I->seeInField(ContentPage::$movieTitleRow_editable, "CXCMS_Ingest_UpdateData_Movie_" .  BuildNo::$build .  " Movie Title");
        $I->see('TV-G', ContentPage::$maturityRow);
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);

        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Movie_" . BuildNo::$build . "_movie_media_id']");

        $I->seeInField(ContentPage::$windowing_listingBegin_input, "Now");
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, "Now");
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, "Never");
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, "Now");
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, "Never");

        //Release year
        $I->see('0', ContentPage::$releaseYearRow);
    }

    //ADD DATA
    /**
    * TESTRAIL TESTCASE ID: C153574
    *
    * @group added_data
    */
    public function contentWindowAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify content window is added. - C153574');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Content Window has been added.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, "Oct 4, 2015 11:00 EDT");
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, "Nov 4, 2015 10:00 EST");
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, "Dec 4, 2015 10:00 EST");
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, "Nov 4, 2015 10:00 EST");
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, "Dec 4, 2015 10:00 EST");
    }

    /**
    * TESTRAIL TESTCASE ID: C153588
    *
    * @group added_data
    */
    public function titleChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie title has changed. - C153588');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Title has been changed.');
        $I->seeInField(ContentPage::$movieTitleRow_editable, "CXCMS_Ingest_UpdateData_Movie_" .  BuildNo::$build .  " New Movie Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C153575
    *
    * @group added_data
    */
    public function descriptionAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie description has been added. - C153575');
        $I->amOnPage(Url::$movie_url);

        $I->expect('A description is present.');
        $I->seeInField(ContentPage::$descriptionRow_editable,  "CXCMS_Ingest_UpdateData_Movie_" .  BuildNo::$build .  " Movie Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C153576
    *
    * @group added_data
    */
    public function categoriesAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie categories have been added. - C153576');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Movie Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Action/Drama', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C153577
    *
    * @group added_data
    */
    public function tagsAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie tags have been added. - C153577');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Movie Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('movie category', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C153578
    *
    * @group added_data
    */
    public function publisherAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie publisher has been added. - C153578');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Ellation QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153579
    *
    * @group added_data
    */
    public function maturityRatingAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie maturity rating has been added. - C153579');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-Y7', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153580
    *
    * @group added_data
    */
    public function releaseYearAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie release year is added. - C153580');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Release year displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see("2010", ContentPage::$releaseYearRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153581
    *
    * @group added_data
    */
    public function portraitPosterAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie portrait poster has been added. - C153581');
        $I->amOnPage(Url::$movie_url);
        
        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('AddedPortraitPoster');

        $I->amGoingTo('Grab the image filename.');
        UpdateData_MovieCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C153582
    *
    * @group added_data
    */
    public function landscapePosterAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie landscape poster has been added. - C153582');
        $I->amOnPage(Url::$movie_url);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('AddedLandscapePoster');

        $I->amGoingTo('Grab the image filename.');
        UpdateData_MovieCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");

        $I->amGoingTo('Put image filenames in separate file.');
        $imageFile = fopen("tests/acceptance/Utils/Images.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Images\n{\npublic static " .
            '$landscapePoster = "' . UpdateData_MovieCest::$landscapePoster . "\";\npublic static" .  '$portraitPoster = "' . 
            UpdateData_MovieCest::$portraitPoster . "\";\n}\n?>";
        fwrite($imageFile, $text);
        fclose($imageFile);
    }

    /**
    * TESTRAIL TESTCASE ID: C153585
    *
    * @group added_data
    */
    public function movieExtraAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie extra has been added. - C153585');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Extra is visible.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('There are no videos attached to this media.');
        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Movie_" . BuildNo::$build . "_movie_extra_clip_id']");
    }

    //CHANGE DATA
    /**
    * TESTRAIL TESTCASE ID: C153587
    *
    * @group change_data
    */
    public function contentWindowChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify content window has changed. - C153587');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Content Window has been changed.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, "Oct 4, 2010 11:00 EDT");
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, "Nov 4, 2010 11:00 EDT");
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, "Dec 4, 2010 10:00 EST");
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, "Nov 4, 2010 11:00 EDT");
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, "Dec 4, 2010 10:00 EST");
    }

    /**
    * TESTRAIL TESTCASE ID: C153601
    *
    * @group change_data
    *
    * Note: It is part of this group so that it is not left with a blank title after the test
    */
    public function titleCleared(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie title has been cleared. - C153601');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Title has been changed.');
        $I->dontSeeInField(ContentPage::$movieTitleRow_editable, "CXCMS_Ingest_UpdateData_Movie_" .  BuildNo::$build .  " New Movie Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C153589
    *
    * @group change_data
    */
    public function descriptionChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie description has been changed. - C153589');
        $I->amOnPage(Url::$movie_url);

        $I->expect('A description is present.');
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_UpdateData_Movie_" .  BuildNo::$build .  " New Movie Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C153590
    *
    * @group change_data
    */
    public function categoriesChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie categories have been changed. - C153590');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Movie Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('New Action/Drama', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C153591
    *
    * @group change_data
    */
    public function tagsChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie tags have been changed. - C153591');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Movie Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('new movie category', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('new qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C153592
    *
    * @group change_data
    */
    public function publisherChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie publisher has been changed. - C153592');
        $I->amOnPage(Url::$movie_url);

        $I->expect('New publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('New Ellation QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153593
    *
    * @group change_data
    */
    public function maturityRatingChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie maturity rating has been changed. - C153593');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-MA', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153594
    *
    * @group change_data
    */
    public function releaseYearChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie release year is changed. - C153594');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Release year displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see("2016", ContentPage::$releaseYearRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153595
    *
    * @group change_data
    */
    public function portraitPosterChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie portrait poster has been changed. - C153595');
        $I->amOnPage(Url::$movie_url);

        $I->expect('There are no extra images and previous filename is not present.');
        $I->waitForElementVisible("//td[text()='Portrait Poster']", 30);
        $I->dontSee("(//td[text()='Portrait Poster'])[2]");
        $I->dontSee(Images::$portraitPoster);

        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('ChangedPortraitPoster');
        UpdateData_MovieCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C153596
    *
    * @group change_data
    */
    public function landscapePosterChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie landscape poster has been changed. - C153596');
        $I->amOnPage(Url::$movie_url);

        $I->expect('There are no extra images and previous filename is not present.');
        $I->waitForElementVisible("//td[text()='Landscape Poster']", 30);
        $I->dontSee("(//td[text()='Landscape Poster'])[2]");
        $I->dontSee(Images::$landscapePoster);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('ChangedLandscapePoster');
        UpdateData_MovieCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");

        $I->amGoingTo('Put image filenames in separate file.');
        $imageFile = fopen("tests/acceptance/Utils/Images.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Images\n{\npublic static " .
            '$landscapePoster = "' . UpdateData_MovieCest::$landscapePoster . "\";\npublic static" .  '$portraitPoster = "' . 
            UpdateData_MovieCest::$portraitPoster . "\";\n}\n?>";
        fwrite($imageFile, $text);
        fclose($imageFile);
    }

    /**
    * TESTRAIL TESTCASE ID: C153599
    *
    * @group change_data
    */
    public function movieExtraChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie extra has been changed. - C153599');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Extra is visible.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('There are no videos attached to this media.');
        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Movie_" . BuildNo::$build . "_movie_changed_extra_clip_id']");
    }

    /**
    * TESTRAIL TESTCASE ID: C153613
    *
    * @group change_data
    */
    public function movieMediaIdChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie media id has been changed. - C153613');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Extra is visible.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('There are no videos attached to this media.');
        $I->seeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Movie_" . BuildNo::$build . "_changed_movie_media_id']");
    }

    //REMOVE DATA
    /**
    * TESTRAIL TESTCASE ID: C153600
    *
    * @group remove_data
    */
    public function contentWindowRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify content window is removed. - C153600');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Content Window has been removed.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, "Now");
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, "Now");
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, "Never");
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, "Now");
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, "Never");
    }

    /**
    * TESTRAIL TESTCASE ID: C153602
    *
    * @group remove_data
    */
    public function descriptionRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie description has been removed. - C153602');
        $I->amOnPage(Url::$movie_url);

        $I->expect('A description is not present.');
        $I->dontSeeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_UpdateData_Movie_" .  BuildNo::$build .  " New Movie Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C153603
    *
    * @group remove_data
    */
    public function categoriesRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie categories have been removed. - C153603');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Movie Categories removed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSeeElement('span.tags-tagname');
        $I->dontSee('Action/Drama');
    }

    /**
    * TESTRAIL TESTCASE ID: C153604
    *
    * @group remove_data
    */
    public function tagsRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie tags have been removed. - C153604');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Movie Tags removed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSeeElement('span.tags-tagname');
        $I->dontSee('movie cateogry');
    }

    /**
    * TESTRAIL TESTCASE ID: C153605
    *
    * @group remove_data
    */
    public function publisherRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie publisher has been removed. - C153605');
        $I->amOnPage(Url::$movie_url);

        $I->expect('New publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('New Ellation QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153606
    *
    * @group remove_data
    */
    public function maturityRatingRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie maturity rating has been removed. - C153606');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Default Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-G', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153607
    *
    * @group remove_data
    */
    public function releaseYearRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie release year is removed. - C153607');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Release year displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see("0", ContentPage::$releaseYearRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C153608
    *
    * @group remove_data
    */
    public function portraitPosterRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie portrait poster remains after manifest is ingested without it. - C153608');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Previous images are still present.');
        $I->waitForText(Images::$portraitPoster, 30);

        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('RemovedPortraitPoster');
        UpdateData_MovieCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C153609
    *
    * @group remove_data
    */
    public function landscapePosterRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie landscape poster remains after manifest is ingested without it. - C153609');
        $I->amOnPage(Url::$movie_url);

        $I->expect('Previous images are still present.');
        $I->waitForText(Images::$landscapePoster, 30);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('RemovedLandscapePoster');
        UpdateData_MovieCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C153612
    *
    * @group remove_data
    */
    public function movieExtraRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie extra has been removed. - C153612');
        $I->amOnPage(Url::$movie_url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);

        $I->expect('Extra is not visible.');
        $I->dontSeeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Movie_" . BuildNo::$build . "_movie_changed_extra_clip_id']");
    }
}