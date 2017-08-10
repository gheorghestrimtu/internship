<?php

use Codeception\Example;
use Page\ContentEditPage;
use Step\ImageEditSteps;
use Step\ContentMovieEditSteps;

class MovieEditCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (MovieEditCest::$environment == 'undefined')
        {
            MovieEditCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        MovieEditCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, MovieEditCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    /**
    * TESTRAIL TESTCASE ID: C22275
    *
    * @group test_priority_2
    */
    public function publishMovie(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can publish a movie. - C22275');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Movie is unpublished.');
        $I->waitForText('Media is currently hidden from all users.', 30);

        $I->amGoingTo('Publish the movie.');
        $I->click(ContentPage::$publishCheckbox);
        $I->waitForText('Users who match window settings can view and/or watch content as defined.', 30);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Movie is still published.');
        $I->waitForText('Users who match window settings can view and/or watch content as defined.', 30);
        $I->seeElement(ContentPage::$publishCheckboxChecked);
    }

    /**
    * TESTRAIL TESTCASE ID: C57542
    *
    * @depends publishMovie
    * @group test_priority_2
    */
    public function unpublishMovie(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can unpublish a movie. - C57542');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Movie is published.');
        $I->waitForText('Users who match window settings can view and/or watch content as defined.', 30);

        $I->amGoingTo('Unpublish the movie.');
        $I->click(ContentPage::$publishCheckbox);
        $I->waitForText('Media is currently hidden from all users.', 30);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Movie is still unpublished.');
        $I->waitForText('Media is currently hidden from all users.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15685
    *
    * @group test_priority_1
    */
    public function channelNameDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify channel name is displayed on the Edit Movie page. - C15685');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Channel name is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15686
    *
    * @group test_priority_1
    */
    public function movieTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Title is displayed on the Edit Movie page. - C15686');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Movie Title is displayed.');
        $I->waitForText('Portal & Content Testing', 30);
        $I->seeInField(ContentPage::$movieTitleRow_editable, 'Movie View Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C15687
    *
    * @group test_priority_1
    */
    public function movieLongDescriptionDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Description is displayed on the Edit Movie page. - C15687');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Movie Description displayed.');
        $I->waitForText('Portal & Content Testing');
        $I->seeInField(ContentPage::$descriptionRow_editable, 'This is the movie automation uses to view all filled out data. Do not edit.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15688
    *
    * @group test_priority_1
    */
    public function movieCategoriesDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Categories is displayed on the Edit Movie page. - C15688');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Movie Categories displayed.');
        $I->waitForText('Portal & Content Testing', 30);
        $I->see('Categories', ContentPage::$categoriesRow);
        $I->see('Action/Comedy', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15689
    *
    * @group test_priority_1
    */
    public function movieTagsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Tags is displayed on the Edit Movie page. - C15689');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Movie Tags displayed.');
        $I->waitForText('Portal & Content Testing', 30);
        $I->see('Tags', ContentPage::$tagsRow);
        $I->see('automation', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('view data', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15692
    *
    * @group test_priority_1
    */
    public function moviePublisherDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Publisher is displayed on the Edit Movie page. - C15692');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Publisher displayed.');
        $I->waitForText('Portal & Content Testing', 30);
        $I->see('Automation Tests', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15694
    *
    * @group test_priority_1
    */
    public function movieReleaseYearDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Release Year is displayed on the Edit Movie page. - C15694');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Release Year displayed.');
        $I->waitForText('Portal & Content Testing', 30);
        $I->see('2016', ContentPage::$releaseYearRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15698
    *
    * @group test_priority_1
    */
    public function movieTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Title is can be edited. - C15698');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Movie Title');
        $I->waitForText('Portal & Content Testing', 30);
        $I->fillField(ContentPage::$movieTitleRow_editable, 'Edited Test Movie');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30);
        $I->seeInField(ContentPage::$movieTitleRow_editable, 'Edited Test Movie');

        $I->amGoingTo('Change the title back.');
        $I->fillField(ContentPage::$movieTitleRow_editable, 'Test Movie');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$movieTitleRow_editable, 'Test Movie');
    }

    /**
    * TESTRAIL TESTCASE ID: C15699
    *
    * @group test_priority_1
    */
    public function movieDescriptionEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Movie Description can be edited. - C15699');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Movie Description');
        $I->waitForText('Portal & Content Testing', 30);
        $I->fillField(ContentPage::$descriptionRow_editable, 'Edited this via automation.');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'Edited this via automation.');

        $I->amGoingTo('Change the description back.');
        $I->fillField(ContentPage::$descriptionRow_editable, 'This is edited via automation.');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'This is edited via automation.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15702
    *
    * @group test_priority_2
    */
    public function videoListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List is displayed on the Edit Movie page. - C15702');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('movie_view_filled_data_automation_1_media_id', ContentPage::$videoTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15703
    *
    * @group test_priority_3
    */
    public function videoListUnsortable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List is unsortable. - C15703');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('movie_view_filled_data_automation_1_media_id', ContentPage::$videoTable);
        $I->dontSee('.sortable');
    }

    /**
    * TESTRAIL TESTCASE ID: C15704
    *
    * @group test_priority_2
    */
    public function videoListFilenameColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Filename Column is displayed on the Edit Movie page. - C15704');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List Title Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('Title', ContentPage::$videoTable_titleHeader);
        $I->see('movie_view_filled_data_automation_1_media_id', ContentPage::$videoTable_firstTitle);
    }

    /**
    * TESTRAIL TESTCASE ID: C15705
    *
    * @group test_priority_2
    */
    public function videoListDurationColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Duration Column is displayed on the Edit Movie page. - C15705');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List Duration Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('Duration', ContentPage::$videoTable_durationHeader);
        $I->see('00:24:00', ContentPage::$videoTable_firstDuration);
    }

    /**
    * TESTRAIL TESTCASE ID: C15706
    *
    * @group test_priority_2
    */
    public function videoListGuidColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List GUID Column is displayed on the Edit Movie page. - C15706');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List GUID Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('GUID', ContentPage::$videoTable_guidHeader);
        if(MovieEditCest::$environment == 'staging')
        {
            $I->see('GYGGDPM4Y', ContentPage::$videoTable_firstGuid);  
        }
        else
        {
            $I->see('G6DQ433GR', ContentPage::$videoTable_firstGuid);
        }  
    }

    /**
    * TESTRAIL TESTCASE ID: C57549
    *
    * @group test_priority_2
    */
    public function clickVideo(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a video listing from the season page. - C57549');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->moveMouseOver("//*[text()='movie_extra_view_filled_data_automation_1_media_id']");
        $I->click("//*[text()='movie_extra_view_filled_data_automation_1_media_id']");

        $I->expect('We are taken to the page for the video.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->seeInField("//label[text()=\"Video Title\"]/following-sibling::input", 'Movie Clip Video View Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C15708  
    *
    * @group test_priority_2
    */
    public function imagesListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Images List is displayed on the Edit Movie page. - C15708');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Images List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('523b4ac5e570f8d8753610569c0fbcfa.png', ContentPage::$imagesTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15709
    *
    * @group test_priority_3
    */
    public function imagesListUnsortable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Images List is unsortable. - C15709');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Images List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('523b4ac5e570f8d8753610569c0fbcfa.png', ContentPage::$imagesTable);
        $I->dontSee('.sortable');
    }

    /**
    * TESTRAIL TESTCASE ID: C15710
    *
    * @group test_priority_2
    */
    public function imageListFilenameColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Image List Filename Column is displayed on the Edit Movie page. - C15710');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Image List Title Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('Title', ContentPage::$imagesTable_titleHeader);
        $I->see('523b4ac5e570f8d8753610569c0fbcfa.png', ContentPage::$imagesTable_firstTitle);
    }

    /**
    * TESTRAIL TESTCASE ID: C15711
    *
    * @group test_priority_2
    */
    public function imageListTypeColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Image List Type Column is displayed on the Edit Movie page. - C15711');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Image List Type Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('Type', ContentPage::$imagesTable_typeHeader);
        $I->see('Landscape Poster', ContentPage::$imagesTable_firstType);
    }

    /**
    * TESTRAIL TESTCASE ID: C15713
    *
    * @group test_priority_3
    */
    public function noImagesMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Images message appears on a movie without images. - C15713');
        if(MovieEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);
    }

    /**
     * TESTRAIL TESTCASE ID: C50842, C50843
     *
     * @group test_priority_2
     *
     * @example {"poster": "Portrait Poster", "test_case_id": "C50842"}
     * @example {"poster": "Landscape Poster", "test_case_id": "C50843"}
     */
    public function clickPoster(Example $example, ContentMovieEditSteps $I, ImageEditSteps $imagePage) {
        $I->wantTo("Checking is clicking on the image opens the page with images preview - " . $example['test_case_id']);
        $I->amOnMovieEditPage();
        $I->accessPosterPage($example['poster']);
        $imagePage->shouldSeeImage();
        $imagePage->shouldSeeSmallSizePreviews();
        $imagePage->shouldSeeImageAttributes();
    }

    /**
     * TESTRAIL TESTCASE ID: C1788153
     *
     * @group test_priority_2
     *
     * @example {"linkTo": "Series", "test_case_id": "C1788153"}
     * @example {"linkTo": "Season", "test_case_id": "C1788153"}
     * @example {"linkTo": "Episode", "test_case_id": "C1788153"}
     * @example {"linkTo": "Movie", "test_case_id": "C1788153"}
     */
    public function contentCanBeLinkedAndUnlinked(Example $example, ContentMovieEditSteps $I) {
        $I->wantTo('Check if user is able to add and remove linked content to Movie - ' . $example['test_case_id']);
        $I->amOnMovieEditPage();
        $I->linkContentTo(ContentEditPage::getEditGuidByContentType($example['linkTo']));
        $I->pressSaveChangesButton();
        $I->reloadPage();
        $I->shouldSeeContentWasLinked();
        $I->removeLinkedContent();
        $I->pressSaveChangesButton();
    }

}
