<?php

use Codeception\Example;
use Page\ContentEditPage;
use Step\ImageEditSteps;
use Step\ContentEpisodeEditSteps;

class EpisodeEditCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (EpisodeEditCest::$environment == 'undefined')
        {
            EpisodeEditCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        EpisodeEditCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, EpisodeEditCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    /**
    * TESTRAIL TESTCASE ID: C22274
    *
    * @group test_priority_2
    */
    public function publishEpisode(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can publish a episode. - C22274');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode is unpublished.');
        $I->waitForText('Media is currently hidden from all users.', 30);

        $I->amGoingTo('Publish the episode.');
        $I->click(ContentPage::$publishCheckbox);
        $I->waitForText('Users who match window settings can view and/or watch content as defined.', 30);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode is still published.');
        $I->waitForText('Users who match window settings can view and/or watch content as defined.', 30);
        $I->seeElement(ContentPage::$publishCheckboxChecked);
    }

    /**
    * TESTRAIL TESTCASE ID: C57541
    *
    * @depends publishEpisode
    * @group test_priority_2
    */
    public function unpublishEpisode(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can unpublish a episode. - C57541');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode is published.');
        $I->waitForText('Users who match window settings can view and/or watch content as defined.', 30);

        $I->amGoingTo('Unpublish the episode.');
        $I->click(ContentPage::$publishCheckbox);
        $I->waitForText('Media is currently hidden from all users.', 30);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode is still unpublished.');
        $I->waitForText('Media is currently hidden from all users.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15617
    *
    * @group test_priority_1
    */
    public function channelNameDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify channel name is displayed on the Edit Episode page. - C15617');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Channel name is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15618
    *
    * @group test_priority_1
    */
    public function seriesTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Title is displayed on the Edit Episode page. - C15618');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series Title is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->see('Series View Filled Data For Automation', ContentPage::$seriesTitleRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15619
    *
    * @group test_priority_1
    */
    public function seasonTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Title is displayed on the Edit Episode page. - C15619');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season Title is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->see('Season View Filled Data For Automation', ContentPage::$seasonTitleRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C214859
    *
    * @group test_priority_1
    */
    public function seasonNumberDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Number is displayed on the Edit Episode page. - C214859');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season Number is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->see('1', ContentPage::$seasonNumberRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15622
    *
    * @group test_priority_1
    */
    public function episodeTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Title is displayed on the Edit Episode page. - C15622');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode Title is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeTitleRow_editable, 'Episode View Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C214860
    *
    * @group test_priority_1
    */
    public function episodeNumberDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Number is displayed on the Edit Episode page. - C214860');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode Number is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C15623
    *
    * @group test_priority_1
    */
    public function episodeLongDescriptionDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Description is displayed on the Edit Episode page. - C15623');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode Description displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'This is the episode automation uses to view all filled out data. Do not edit.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15624
    *
    * @group test_priority_1
    */
    public function episodeCategoriesDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Categories is displayed on the Edit Episode page. - C15624');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode Categories displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeElement(ContentPage::$categoriesRow);
        $I->see('Action/Comedy', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15625
    *
    * @group test_priority_1
    */
    public function episodeTagsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Tags is displayed on the Edit Episode page. - C15625');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode Tags displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeElement(ContentPage::$tagsRow);
        $I->see('automation', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('view data', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15629
    *
    * @group test_priority_1
    */
    public function episodeAirDateDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Air Date is displayed on the Edit Episode page. - C15629');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Air Date displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$airDateRow_editable, 'Oct 4, 2015 11:00 EDT');
    }

    /**
    * TESTRAIL TESTCASE ID: C15633
    *
    * @group test_priority_1
    */
    public function episodeTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Title can be edited. - C15633');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Episode Title');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$episodeTitleRow_editable, 'Testing All Episode');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeTitleRow_editable, 'Testing All Episode');

        $I->amGoingTo('Change the title back.');
        $I->fillField(ContentPage::$episodeTitleRow_editable, 'The Episode Title');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeTitleRow_editable, 'The Episode Title');
    }

    /**
    * TESTRAIL TESTCASE ID: C214861
    *
    * @group test_priority_1
    */
    public function episodeNumberEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Number can be edited. - C214861');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Episode Number');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$episodeNumberRow_editable, '3');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '3');

        $I->amGoingTo('Change the number back.');
        $I->fillField(ContentPage::$episodeNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C214862
    *
    * @group test_priority_2
    */
    public function arrowKeysOnEpisodeNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify arrow keys increment episode number. - C214862');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set Episode Number to 1');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$episodeNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '1');

        $I->amGoingTo('Press Up');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->pressKey(ContentPage::$episodeNumberRow_editable, \Facebook\Webdriver\WebDriverKeys::UP);
        
        $I->expect('Number is now 2');
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '2');

        $I->amGoingTo('Press Down');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->pressKey(ContentPage::$episodeNumberRow_editable, \Facebook\Webdriver\WebDriverKeys::DOWN);
        
        $I->expect('Number is now 1');
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C214863
    *
    * @group test_priority_2
    */
    public function negativeEpisodeNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify we cannot save a negative episode number. - C214863');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set Episode Number to 1');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$episodeNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '1');

        $I->amGoingTo('Set a negative episode number');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->pressKey(ContentPage::$episodeNumberRow_editable, '2', \Facebook\Webdriver\WebDriverKeys::LEFT, '-');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are not saved. There is no negative in episode number');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '1');
        $I->dontSeeInField(ContentPage::$episodeNumberRow_editable, '-21');
    }

    /**
    * TESTRAIL TESTCASE ID: C214864
    *
    * @group test_priority_2
    */
    public function blankEpisodeNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can save a blank episode number. - C214864');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set Episode Number to 1');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$episodeNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '1');

        $I->amGoingTo('Set a blank episode number');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->moveMouseOver(ContentPage::$episodeNumberRow_editable);
        $I->pressKey(ContentPage::$episodeNumberRow_editable, WebDriverKeys::DELETE);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved. Input field is blank');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '0');
        $I->dontSeeInField(ContentPage::$episodeNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C214865
    *
    * @group test_priority_2
    */
    public function zeroEpisodeNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can save 0 as an episode number. - C214865');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set Episode Number to 1');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$episodeNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '1');

        $I->amGoingTo('Set a blank episode number');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$episodeNumberRow_editable, '0');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved. Input field is blank');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$episodeNumberRow_editable, '0');
        $I->dontSeeInField(ContentPage::$episodeNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C15634
    *
    * @group test_priority_1
    */
    public function episodeDescriptionEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode Description can be edited. - C15634');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Episode Description');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$descriptionRow_editable, 'Edited this via automation.');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'Edited this via automation.');

        $I->amGoingTo('Change the description back.');
        $I->fillField(ContentPage::$descriptionRow_editable, 'This is an episode.');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'This is an episode.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15637
    *
    * @group test_priority_1
    * @group disabled
    *
    * For some reason this returns a stale element exception. Further investigation required.
    */
    public function episodeAirDateEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Air Date can be edited. - C15637');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$airDateRow_editable, 'October 2016', '18', 'Oct 18, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$airDateRow_editable, 'Oct 18, 2016 00:00 EDT');

        ContentUtils::setDate($I, ContentPage::$airDateRow_editable, 'January 2018', '18', 'Jan 18, 2018 00:00 EST', 'future');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$airDateRow_editable, 'Jan 18, 2018 00:00 EST');
    }

    /**
    * TESTRAIL TESTCASE ID: C15640
    *
    * @group test_priority_2
    */
    public function videoListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List is displayed on the Edit Episode page. - C15640');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('series_view_filled_data_automation_1_episode_1_media_id', ContentPage::$videoTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15641
    *
    * @group test_priority_3
    */
    public function videoListUnsortable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List is unsortable. - C15641');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('series_view_filled_data_automation_1_episode_1_media_id', ContentPage::$videoTable);
        $I->dontSee('.sortable');
    }

    /**
    * TESTRAIL TESTCASE ID: C15642
    *
    * @group test_priority_2
    */
    public function videoListFilenameColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Filename Column is displayed on the Edit Episode page. - C15642');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List Title Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('Title', ContentPage::$videoTable_titleHeader);
        $I->see('series_view_filled_data_automation_1_episode_1_media_id', ContentPage::$videoTable_firstTitle);
    }

    /**
    * TESTRAIL TESTCASE ID: C15643
    *
    * @group test_priority_2
    */
    public function videoListDurationColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Duration Column is displayed on the Edit Episode page. - C15643');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List Duration Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('Duration', ContentPage::$videoTable_durationHeader);
        $I->see('00:24:00', ContentPage::$videoTable_firstDuration);
    }

    /**
    * TESTRAIL TESTCASE ID: C15644
    *
    * @group test_priority_2
    */
    public function videoListGuidColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List GUID Column is displayed on the Edit Episode page. - C15644');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List GUID Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('GUID', ContentPage::$videoTable_guidHeader);
        if(EpisodeEditCest::$environment == 'staging')
        {
            $I->see('GY9P8J10R', ContentPage::$videoTable_firstGuid);  
        }
        else
        {
            $I->see('GYGGPWMEY', ContentPage::$videoTable_firstGuid);
        }  
    }

    /**
    * TESTRAIL TESTCASE ID: C57548
    *
    * @group test_priority_2
    */
    public function clickVideo(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a video listing from the season page. - C57548');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->executeJS("window.scrollTo(0, document.body.scrollHeight)");
        $I->click("//*[text()='series_view_filled_data_automation_1_episode_clip_media_id']");

        $I->expect('We are taken to the page for the video.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->seeInField("//label[text()=\"Video Title\"]/following-sibling::input", 'Episode Clip Video Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C15646  
    *
    * @group test_priority_2
    */
    public function imagesListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Images List is displayed on the Edit Episode page. - C15646');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Images List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $I->see('e653f1094306790084dd8262c5a0e168.png', ContentPage::$imagesTable);
        }
        else
        {
            $I->see('45ad52a32ca5e4d374086aaa19c49e02.png', ContentPage::$imagesTable);
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C15647
    *
    * @group test_priority_3
    */
    public function imagesListUnsortable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Images List is unsortable. - C15647');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Images List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $I->see('e653f1094306790084dd8262c5a0e168.png', ContentPage::$imagesTable);
        }
        else
        {
            $I->see('45ad52a32ca5e4d374086aaa19c49e02.png', ContentPage::$imagesTable);
        }
        $I->dontSee('.sortable');
    }

    /**
    * TESTRAIL TESTCASE ID: C15648
    *
    * @group test_priority_2
    */
    public function imageListFilenameColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Image List Filename Column is displayed on the Edit Episode page. - C15648');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Image List Title Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('Title', ContentPage::$imagesTable_titleHeader);
        if(EpisodeEditCest::$environment == 'staging')
        {
            $I->see('e653f1094306790084dd8262c5a0e168.png', ContentPage::$imagesTable_firstTitle);
        }
        else //proto0
        {
            $I->see('45ad52a32ca5e4d374086aaa19c49e02.png', ContentPage::$imagesTable_firstTitle);
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C15649
    *
    * @group test_priority_2
    */
    public function imageListTypeColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Image List Type Column is displayed on the Edit Episode page. - C15649');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Image List Type Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('Type', ContentPage::$imagesTable_typeHeader);
        if(EpisodeEditCest::$environment == 'staging')
        {
            $I->see('Portrait Poster', ContentPage::$imagesTable_firstType);
        }
        else //proto0
        {
            $I->see('Landscape Poster', ContentPage::$imagesTable_firstType);
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C15651
    *
    * @group test_priority_3
    */
    public function noImagesMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Images message appears on a episode without images. - C15651');
        if(EpisodeEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);
    }

    /**
     * TESTRAIL TESTCASE ID: C50840, C50841
     *
     * @group test_priority_2
     *
     * @example {"poster": "Portrait Poster", "test_case_id": "C50840"}
     * @example {"poster": "Landscape Poster", "test_case_id": "C50841"}
     */
    public function clickPoster(Example $example, ContentEpisodeEditSteps $I, ImageEditSteps $imagePage) {
        $I->wantTo("Checking is clicking on the image opens the page with images preview - " . $example['test_case_id']);
        $I->amOnEpisodeEditPage();
        $I->accessPosterPage($example['poster']);
        $imagePage->shouldSeeImage();
        $imagePage->shouldSeeSmallSizePreviews();
        $imagePage->shouldSeeImageAttributes();
    }

    /**
     * TESTRAIL TESTCASE ID: C1788156
     *
     * @group test_priority_2
     *
     * @example {"linkTo": "Series", "test_case_id": "C1788156"}
     * @example {"linkTo": "Season", "test_case_id": "C1788156"}
     * @example {"linkTo": "Episode", "test_case_id": "C1788156"}
     * @example {"linkTo": "Movie", "test_case_id": "C1788156"}
     */
    public function contentCanBeLinkedAndUnlinked(Example $example, ContentEpisodeEditSteps $I) {
        $I->wantTo('Check if user is able to add and remove linked content to Episode - ' . $example['test_case_id']);
        $I->amOnEpisodeEditPage();
        $I->linkContentTo(ContentEditPage::getEditGuidByContentType($example['linkTo']));
        $I->pressSaveChangesButton();
        $I->reloadPage();
        $I->shouldSeeContentWasLinked();
        $I->removeLinkedContent();
        $I->pressSaveChangesButton();
    }

}
