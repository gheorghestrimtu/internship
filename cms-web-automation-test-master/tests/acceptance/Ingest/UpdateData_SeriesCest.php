<?php

class UpdateData_SeriesCest
{
	public static $url;
    public static $loginCookie = 'undefined';

    public static $series_url = '';

    public static $portraitPoster = '';
    public static $landscapePoster = '';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        UpdateData_SeriesCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, UpdateData_SeriesCest::$loginCookie);
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
    * TESTRAIL TESTCASE ID: C14138
    *
    * @group initial_upload
    */
    public function verifySeriesMinimumUpload(AcceptanceTester $I)
    {
    	$I->wantTo('Verify the series uploaded with miniumum data and get the url. - C14138');
    	$I->amOnPage(ContentPage::$URL_ingest);

        $I->amGoingTo('Navigate to series page.');
        ContentUtils::clickEditButtonForTitle($I, "CXCMS_Ingest_UpdateData_Series_" .  BuildNo::$build .  " Initial Title");

        $I->expect('We are taken to the series edit page.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          UpdateData_SeriesCest::$series_url = $webdriver->getCurrentUrl();
          UpdateData_SeriesCest::$series_url = explode('.com', UpdateData_SeriesCest::$series_url)[1];
        });
        $I->expect('Series URL is ' . UpdateData_SeriesCest::$series_url);

        $I->amGoingTo('Put the url in a separate file.');
        $urlFile = fopen("tests/acceptance/Utils/Url.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Url\n{\npublic static " . '$url = "' . UpdateData_SeriesCest::$series_url . "\";\n}\n?>";
        fwrite($urlFile, $text);
        fclose($urlFile);

        $I->amGoingTo('Take a screenshot.');
        $I->makeScreenshot('InitialUpload');

        $I->expect('Maturity rating, title, and warnings about no content appear.');
        $I->seeInField(ContentPage::$seriesTitleRow_editable, "CXCMS_Ingest_UpdateData_Series_" .  BuildNo::$build .  " Initial Title");
        $I->see('TV-G', ContentPage::$maturityRow);
        $I->dontSeeElement('span.tags-tagname');
        $I->see('There are no seasons attached to this media.');
        $I->see('There are no episodes attached to this media.');
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);
        $I->see('There are no videos attached to this media.');
    }

    //ADD DATA
    /**
    * TESTRAIL TESTCASE ID: C127354
    *
    * @group added_data
    */
    public function titleChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series title has changed. - C127354');
        $I->amOnPage(Url::$url);

        $I->expect('Title has been changed.');
        $I->seeInField(ContentPage::$seriesTitleRow_editable, "CXCMS_Ingest_UpdateData_Series_" .  BuildNo::$build .  " New Series Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C127346
    *
    * @group added_data
    */
    public function descriptionAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify series description has been added. - C127346');
        $I->amOnPage(Url::$url);

        $I->expect('A description is present.');
        $I->seeInField(ContentPage::$descriptionRow_editable,  "CXCMS_Ingest_UpdateData_Series_" .  BuildNo::$build .  " Series Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C127347
    *
    * @group added_data
    */
    public function categoriesAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify series categories have been added. - C127347');
        $I->amOnPage(Url::$url);

        $I->expect('Series Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Action/Drama', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127348
    *
    * @group added_data
    */
    public function tagsAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify series tags have been added. - C127348');
        $I->amOnPage(Url::$url);

        $I->expect('Series Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('series category', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127349
    *
    * @group added_data
    */
    public function publisherAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify series publisher has been added. - C127349');
        $I->amOnPage(Url::$url);

        $I->expect('Series Publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('Ellation Series QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127350
    *
    * @group added_data
    */
    public function maturityRatingAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify series maturity rating has been added. - C127350');
        $I->amOnPage(Url::$url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-Y7', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127351
    *
    * @group added_data
    */
    public function portraitPosterAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify series portrait poster has been added. - C127351');
        $I->amOnPage(Url::$url);
        
        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('AddedPortraitPoster');

        $I->amGoingTo('Grab the image filename.');
        UpdateData_SeriesCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127352
    *
    * @group added_data
    */
    public function landscapePosterAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify series landscape poster has been added. - C127352');
        $I->amOnPage(Url::$url);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('AddedLandscapePoster');

        $I->amGoingTo('Grab the image filename.');
        UpdateData_SeriesCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");

        $I->amGoingTo('Put image filenames in separate file.');
        $imageFile = fopen("tests/acceptance/Utils/Images.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Images\n{\npublic static " .
            '$landscapePoster = "' . UpdateData_SeriesCest::$landscapePoster . "\";\npublic static" .  '$portraitPoster = "' . 
            UpdateData_SeriesCest::$portraitPoster . "\";\n}\n?>";
        fwrite($imageFile, $text);
        fclose($imageFile);
    }

    /**
    * TESTRAIL TESTCASE ID: C127353
    *
    * @group added_data
    */
    public function seriesExtraAdded(AcceptanceTester $I)
    {
        $I->wantTo('Verify series extra has been added. - C127353');
        $I->amOnPage(Url::$url);

        $I->expect('Extra is visible.');
        $I->waitForElementVisible("//td/span[text()='CXCMS_Ingest_UpdateData_Series_" . BuildNo::$build . "_series_extra_clip_id']", 30);
        $I->dontSee('There are no videos attached to this media.');
    }

    //CHANGE DATA
    /**
    * TESTRAIL TESTCASE ID: C127363
    *
    * @group change_data
    *
    * Note: It is part of this group so that it is not left with a blank title after the test
    */
    public function titleCleared(AcceptanceTester $I)
    {
        $I->wantTo('Verify series title has been cleared. - C127363');
        $I->amOnPage(Url::$url);

        $I->expect('Title has been changed.');
        $I->dontSeeInField(ContentPage::$seriesTitleRow_editable, "CXCMS_Ingest_UpdateData_Series_" .  BuildNo::$build .  " New Series Title");
    }

    /**
    * TESTRAIL TESTCASE ID: C127355
    *
    * @group change_data
    */
    public function descriptionChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series description has been changed. - C127355');
        $I->amOnPage(Url::$url);

        $I->expect('A description is present.');
        $I->seeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_UpdateData_Series_" .  BuildNo::$build .  " New Series Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C127356
    *
    * @group change_data
    */
    public function categoriesChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series categories have been changed. - C127356');
        $I->amOnPage(Url::$url);

        $I->expect('Series Categories displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('New/Action/Drama', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127357
    *
    * @group change_data
    */
    public function tagsChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series tags have been changed. - C127357');
        $I->amOnPage(Url::$url);

        $I->expect('Series Tags displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('new category', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('new qa', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127358
    *
    * @group change_data
    */
    public function publisherChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series publisher has been changed. - C127358');
        $I->amOnPage(Url::$url);

        $I->expect('Series Publisher displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('New Ellation Series QA', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127359
    *
    * @group change_data
    */
    public function maturityRatingChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series maturity rating has been changed. - C127359');
        $I->amOnPage(Url::$url);

        $I->expect('Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-MA', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127360
    *
    * @group change_data
    */
    public function portraitPosterChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series portrait poster has been changed. - C127360');
        $I->amOnPage(Url::$url);

        $I->expect('There are no extra images and previous filename is not present.');
        $I->waitForElementVisible("//td[text()='Portrait Poster']", 30);
        $I->dontSee("(//td[text()='Portrait Poster'])[2]");
        $I->dontSee(Images::$portraitPoster);

        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('ChangedPortraitPoster');
        UpdateData_SeriesCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127361
    *
    * @group change_data
    */
    public function landscapePosterChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series landscape poster has been changed. - C127361');
        $I->amOnPage(Url::$url);

        $I->expect('There are no extra images and previous filename is not present.');
        $I->waitForElementVisible("//td[text()='Landscape Poster']", 30);
        $I->dontSee("(//td[text()='Landscape Poster'])[2]");
        $I->dontSee(Images::$landscapePoster);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('ChangedLandscapePoster');
        UpdateData_SeriesCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");

        $I->amGoingTo('Put image filenames in separate file.');
        $imageFile = fopen("tests/acceptance/Utils/Images.php", "w") or die("Unable to open file!");
        $text = "<?php\nclass Images\n{\npublic static " .
            '$landscapePoster = "' . UpdateData_SeriesCest::$landscapePoster . "\";\npublic static" .  '$portraitPoster = "' . 
            UpdateData_SeriesCest::$portraitPoster . "\";\n}\n?>";
        fwrite($imageFile, $text);
        fclose($imageFile);
    }

    /**
    * TESTRAIL TESTCASE ID: C127362
    *
    * @group change_data
    */
    public function seriesExtraChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify series extra has been changed. - C127362');
        $I->amOnPage(Url::$url);

        $I->expect('Extra is visible.');
        $I->waitForElementVisible("//td/span[text()='CXCMS_Ingest_UpdateData_Series_" . BuildNo::$build . "_series_changed_extra_clip_id']", 30);
        $I->dontSee('There are no videos attached to this media.');  
    }

    //REMOVE DATA
    /**
    * TESTRAIL TESTCASE ID: C127364
    *
    * @group remove_data
    */
    public function descriptionRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify series description has been removed. - C127364');
        $I->amOnPage(Url::$url);

        $I->expect('A description is not present.');
        $I->dontSeeInField(ContentPage::$descriptionRow_editable, "CXCMS_Ingest_UpdateData_Series_" .  BuildNo::$build .  " New Series Description");
    }

    /**
    * TESTRAIL TESTCASE ID: C127365
    *
    * @group remove_data
    */
    public function categoriesRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify series categories have been removed. - C127365');
        $I->amOnPage(Url::$url);

        $I->expect('Series Categories removed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('New/Action/Drama');
        $I->dontSeeElement("//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127366
    *
    * @group remove_data
    */
    public function tagsRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify series tags have been removed. - C127366');
        $I->amOnPage(Url::$url);

        $I->expect('Series Tags removed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('new category');
        $I->dontSee('new qa');
        $I->dontSeeElement("//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127367
    *
    * @group remove_data
    */
    public function publisherRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify series publisher has been removed. - C127367');
        $I->amOnPage(Url::$url);

        $I->expect('Series Publisher removed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->dontSee('New Ellation Series QA');
    }

    /**
    * TESTRAIL TESTCASE ID: C127368
    *
    * @group remove_data
    */
    public function maturityRatingRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify series maturity rating is back to the default for the manifest. - C127368');
        $I->amOnPage(Url::$url);

        $I->expect('Default Maturity Rating displayed.');
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);
        $I->see('TV-G', ContentPage::$maturityRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C127369
    *
    * @group remove_data
    */
    public function portraitPosterRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify series portrait poster remains after manifest is ingested without it. - C127369');
        $I->amOnPage(Url::$url);

        $I->expect('Previous images are still present.');
        $I->waitForText(Images::$portraitPoster, 30);

        $I->amGoingTo('Click the link for Portrait Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Portrait Poster']");
        $I->click("//td[text()='Portrait Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('RemovedPortraitPoster');
        UpdateData_SeriesCest::$portraitPoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127370
    *
    * @group remove_data
    */
    public function landscapePosterRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify series landscape poster remains after manifest is ingested without it. - C127370');
        $I->amOnPage(Url::$url);

        $I->expect('Previous images are still present.');
        $I->waitForText(Images::$landscapePoster, 30);

        $I->amGoingTo('Click the link for Landscape Poster and take a screenshot.');
        $I->scrollTo("//td[text()='Landscape Poster']");
        $I->click("//td[text()='Landscape Poster']");
        $I->wait(30); //Be sure image has fully loaded
        $I->makeScreenshot('RemovedLandscapePoster');
        UpdateData_SeriesCest::$landscapePoster = $I->grabTextFrom("//div[contains(@class, 'attributes')]/div[3]/span[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C127371
    *
    * @group remove_data
    */
    public function seriesExtraRemoved(AcceptanceTester $I)
    {
        $I->wantTo('Verify series extra has been removed. - C127371');
        $I->amOnPage(Url::$url);
        $I->waitForText('Ingest Testing', 30, ContentPage::$channelRow);

        $I->expect('Extra is not visible.');
        $I->waitForText('There are no videos attached to this media.', 30);
        $I->dontSeeElement("//td/span[text()='CXCMS_Ingest_UpdateData_Series_" . BuildNo::$build . "_series_changed_extra_clip_id']");
    }
}