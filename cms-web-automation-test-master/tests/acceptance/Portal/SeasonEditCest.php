<?php

use Codeception\Example;
use Page\ContentEditPage;
use Step\ImageEditSteps;
use Step\ContentSeasonEditSteps;

class SeasonEditCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (SeasonEditCest::$environment == 'undefined')
        {
            SeasonEditCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        SeasonEditCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, SeasonEditCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    /**
    * TESTRAIL TESTCASE ID: C22273
    *
    * @group test_priority_2
    */
    public function publishSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can publish a season. - C22273');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season is unpublished.');
        $I->waitForText('All episodes will be hidden.', 30);

        $I->amGoingTo('Publish the season.');
        $I->click(ContentPage::$publishCheckbox);
        $I->waitForText('Season will be published. Episodes within this Season will remain unchanged.', 30);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season is still published.');
        $I->waitForText('Season will be published. Episodes within this Season will remain unchanged.', 30);
        $I->seeElement(ContentPage::$publishCheckboxChecked);
    }

    /**
    * TESTRAIL TESTCASE ID: C57540
    *
    * @depends publishSeason
    * @group test_priority_2
    */
    public function unpublishSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can unpublish a season. - C57540');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season is published.');
        $I->waitForText('Season will be published. Episodes within this Season will remain unchanged.', 30);

        $I->amGoingTo('Unpublish the season.');
        $I->click(ContentPage::$publishCheckbox);
        $I->waitForText('All episodes will be hidden.', 30);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season is still unpublished.');
        $I->waitForText('All episodes will be hidden.', 30);
        $I->dontSeeElement(ContentPage::$publishCheckboxChecked);
    }

    /**
    * TESTRAIL TESTCASE ID: C15578
    *
    * @group test_priority_1
    */
    public function channelNameDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify channel name is displayed on the Edit Season page. - C15578');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Channel name is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15579
    *
    * @group test_priority_1
    */
    public function seriesTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Title is displayed on the Edit Season page. - C15579');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series Title is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->see('Series View Filled Data For Automation', ContentPage::$seriesTitleRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15580
    *
    * @group test_priority_1
    */
    public function seasonTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Title is displayed on the Edit Season page. - C15580');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season Title is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonTitleRow_editable, 'Season View Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C214857
    *
    * @group test_priority_1
    */
    public function seasonNumberDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Number is displayed on the Edit Season page. - C214857');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season Number is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C15582
    *
    * @group test_priority_1
    */
    public function seasonLongDescriptionDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Description is displayed on the Edit Season page. - C15582');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season Description displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'This is the season automation uses to view all filled out data. Do not edit.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15583
    *
    * @group test_priority_1
    */
    public function seasonPublisherDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Publisher is displayed on the Edit Season page. - C15583');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season Publisher displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->see('Automation Tests', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15590
    *
    * @group test_priority_1
    */
    public function seasonTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Title can be edited. - C15590');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Season Title');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$seasonTitleRow_editable, 'Testing All Season Datas');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonTitleRow_editable, 'Testing All Season Datas');

        $I->amGoingTo('Change the title back.');
        $I->fillField(ContentPage::$seasonTitleRow_editable, 'All Data Season Title');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonTitleRow_editable, 'All Data Season Title');
    }

    /**
    * TESTRAIL TESTCASE ID: C214852
    *
    * @group test_priority_1
    */
    public function seasonNumberEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Number can be edited. - C214852');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Season Number');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$seasonNumberRow_editable, '3');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '3');

        $I->amGoingTo('Change the number back.');
        $I->fillField(ContentPage::$seasonNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C214853
    *
    * @group test_priority_2
    */
    public function arrowKeysOnSeasonNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify arrow keys increment season number. - C214853');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set Season Number to 1');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$seasonNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '1');

        $I->amGoingTo('Press Up');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->pressKey(ContentPage::$seasonNumberRow_editable, \Facebook\Webdriver\WebDriverKeys::UP);
        
        $I->expect('Number is now 2');
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '2');

        $I->amGoingTo('Press Down');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->pressKey(ContentPage::$seasonNumberRow_editable, \Facebook\Webdriver\WebDriverKeys::DOWN);
        
        $I->expect('Number is now 1');
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C214854
    *
    * @group test_priority_2
    */
    public function negativeSeasonNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify we cannot save a negative season number. - C214854');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set Season Number to 1');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$seasonNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '1');

        $I->amGoingTo('Set a negative season number');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->pressKey(ContentPage::$seasonNumberRow_editable, '2', \Facebook\Webdriver\WebDriverKeys::LEFT, '-');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are not saved. There is no negative in season number');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '1');
        $I->dontSeeInField(ContentPage::$seasonNumberRow_editable, '-21');
    }

    /**
    * TESTRAIL TESTCASE ID: C214855
    *
    * @group test_priority_2
    */
    public function blankSeasonNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can save a blank season number. - C214855');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set Season Number to 1');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$seasonNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '1');

        $I->amGoingTo('Set a blank season number');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->pressKey(ContentPage::$seasonNumberRow_editable, \Facebook\WebDriver\WebDriverKeys::DELETE);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved. Input field is blank');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '0');
        $I->dontSeeInField(ContentPage::$seasonNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C214856
    *
    * @group test_priority_2
    */
    public function zeroSeasonNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can save 0 as a season number. - C214856');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set Season Number to 1');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$seasonNumberRow_editable, '1');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '1');

        $I->amGoingTo('Set a blank season number');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$seasonNumberRow_editable, '0');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved. Input field is blank upon reload');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seasonNumberRow_editable, '0');
        $I->dontSeeInField(ContentPage::$seasonNumberRow_editable, '1');
    }

    /**
    * TESTRAIL TESTCASE ID: C15591
    *
    * @group test_priority_1
    */
    public function seasonDescriptionEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season Description can be edited. - C15591');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Season Description');
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
        $I->fillField(ContentPage::$descriptionRow_editable, 'This is edited via automation.');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'This is edited via automation.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15596
    *
    * @group test_priority_1
    */
    public function episodeListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode List is displayed on the Edit Season page. - C15596');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('EPISODES');
        $I->see('Episode View Filled Data For Automation', ContentPage::$episodesTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15597
    *
    * @group test_priority_2
    */
    public function episodeListSortedNumerically(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode List is sorted by #. - C15597');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('EPISODES');
        $I->see('1', "//h1[text()='Episodes']/..//table/tbody/tr/td[1]");
        $I->see('Episode 1', "//h1[text()='Episodes']/..//table/tbody/tr/td[2]");

        $I->see('2', "//h1[text()='Episodes']/..//table/tbody/tr[2]/td[1]");
        $I->see('Episode 2', "//h1[text()='Episodes']/..//table/tbody/tr[2]/td[2]");

        $I->see('3', "//h1[text()='Episodes']/..//table/tbody/tr[3]/td[1]");
        $I->see('Episode 3', "//h1[text()='Episodes']/..//table/tbody/tr[3]/td[2]");

        $I->see('4', "//h1[text()='Episodes']/..//table/tbody/tr[4]/td[1]");
        $I->see('Episode 4', "//h1[text()='Episodes']/..//table/tbody/tr[4]/td[2]");

        $I->see('5', "//h1[text()='Episodes']/..//table/tbody/tr[5]/td[1]");
        $I->see('Episode 5', "//h1[text()='Episodes']/..//table/tbody/tr[5]/td[2]");

        $I->see('6', "//h1[text()='Episodes']/..//table/tbody/tr[6]/td[1]");
        $I->see('Episode 6', "//h1[text()='Episodes']/..//table/tbody/tr[6]/td[2]");

        $I->see('7', "//h1[text()='Episodes']/..//table/tbody/tr[7]/td[1]");
        $I->see('Episode 7', "//h1[text()='Episodes']/..//table/tbody/tr[7]/td[2]");

        $I->see('8', "//h1[text()='Episodes']/..//table/tbody/tr[8]/td[1]");
        $I->see('Episode 8', "//h1[text()='Episodes']/..//table/tbody/tr[8]/td[2]");

        $I->see('9', "//h1[text()='Episodes']/..//table/tbody/tr[9]/td[1]");
        $I->see('Episode 9', "//h1[text()='Episodes']/..//table/tbody/tr[9]/td[2]");

        $I->see('10', "//h1[text()='Episodes']/..//table/tbody/tr[10]/td[1]");
        $I->see('Episode 10', "//h1[text()='Episodes']/..//table/tbody/tr[10]/td[2]");
    }
    /**
    * TESTRAIL TESTCASE ID: C15598
    *
    * @group test_priority_3
    */
    public function episodeListPaginatedAtTen(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode List is paginated at 10. - C15598');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = 'GRWE0XV3R';
        }
        else //proto0
        {
            $guid = 'GR8VD5Z4R';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('1 - 10 of ', "(//div[contains(@class, 'panel')])[1]");
        $I->dontSeeElement("(//table)[1]/tr[11]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15599
    *
    * @group test_priority_3
    */
    public function episodeListPaginationCannotBeChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode List pagination cannot be changed. - C15599');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = 'GRWE0XV3R';
        }
        else //proto0
        {
            $guid = 'GR8VD5Z4R';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->dontSeeElement("(//table)[1]//select");
    }

    /**
    * TESTRAIL TESTCASE ID: C15600
    *
    * @group test_priority_3
    */
    public function episodeListNoViewAll(AcceptanceTester $I)
    {
        $I->wantTo('Verify there is no View All for the Episode table. - C15600');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = 'GRWE0XV3R';
        }
        else //proto0
        {
            $guid = 'GR8VD5Z4R';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->dontSee('All', "(//div[contains(@class, 'panel')])[1]");
    }

    /**
    * TESTRAIL TESTCASE ID: C11008
    *
    * @group test_priority_1
    */
    public function clickEpisode(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a episode listing from the season page. - C11008');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->click("(//table)[1]//span[text()='Episode View Filled Data For Automation']");

        $I->expect('We are taken to the page for episode content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->seeInField(ContentPage::$episodeTitleRow_editable, 'Episode View Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C15601
    *
    * @group test_priority_3
    */
    public function noEpisodesMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Episodes message appears on a series without episodes. - C15601');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('There are no episodes attached to this media.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15602
    *
    * @group test_priority_2
    */
    public function videoListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List is displayed on the Edit Season page. - C15602');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('series_view_filled_data_automation_1_season_clip_media_id', ContentPage::$videoTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15603
    *
    * @group test_priority_3
    */
    public function videoListUnsortable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List is unsortable. - C15603');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('series_view_filled_data_automation_1_season_clip_media_id', ContentPage::$videoTable);
        $I->dontSee('.sortable');
    }

    /**
    * TESTRAIL TESTCASE ID: C15604
    *
    * @group test_priority_2
    */
    public function videoListFilenameColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Filename Column is displayed on the Edit Season page. - C15604');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List Title Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('Title', ContentPage::$videoTable_titleHeader);
        $I->see('series_view_filled_data_automation_1_season_clip_media_id', ContentPage::$videoTable_firstTitle);
    }

    /**
    * TESTRAIL TESTCASE ID: C15605
    *
    * @group test_priority_2
    */
    public function videoListDurationColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Duration Column is displayed on the Edit Season page. - C15605');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List Duration Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('Duration', ContentPage::$videoTable_durationHeader);
        $I->see('00:24:00', ContentPage::$videoTable_firstDuration);
    }

    /**
    * TESTRAIL TESTCASE ID: C15606
    *
    * @group test_priority_2
    */
    public function videoListGuidColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List GUID Column is displayed on the Edit Season page. - C15606');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List GUID Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('GUID', ContentPage::$videoTable_guidHeader);
        if(SeasonEditCest::$environment == 'staging')
        {
            $I->see('G6E53PGPY', ContentPage::$videoTable_firstGuid);
        }
        else //proto0
        {
            $I->see('G65VEDMD6', ContentPage::$videoTable_firstGuid);
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C57547
    *
    * @group test_priority_2
    */
    public function clickVideo(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a video listing from the season page. - C57547');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//*[text()='series_view_filled_data_automation_1_season_clip_media_id']");
        $I->click("//*[text()='series_view_filled_data_automation_1_season_clip_media_id']");

        $I->expect('We are taken to the page for the video.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->seeInField("//label[text()=\"Video Title\"]/following-sibling::input", 'Season Clip Video Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C15607
    *
    * @group test_priority_3
    */
    public function noVideosMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Videos message appears on a season without videos. - C15607');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('There are no videos attached to this media.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15608
    *
    * @group test_priority_2
    */
    public function imagesListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Images List is displayed on the Edit Season page. - C15608');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Images List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('4bb2dd5fb5bc6fc44fd51ec17ecad2a4.png', ContentPage::$imagesTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15609  
    *
    * @group test_priority_3
    */
    public function imagesListUnsortable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Images List is unsortable. - C15609');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Images List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('4bb2dd5fb5bc6fc44fd51ec17ecad2a4.png', ContentPage::$imagesTable);
        $I->dontSee('.sortable');
    }

    /**
    * TESTRAIL TESTCASE ID: C15610
    *
    * @group test_priority_2
    */
    public function imageListFilenameColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Filename Column is displayed on the Edit Season page. - C15610');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Image List Title Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('Title', ContentPage::$imagesTable_titleHeader);
        $I->see('4bb2dd5fb5bc6fc44fd51ec17ecad2a4.png', ContentPage::$imagesTable_firstTitle);
    }

    /**
    * TESTRAIL TESTCASE ID: C15611
    *
    * @group test_priority_2
    */
    public function imageListTypeColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Image List Type Column is displayed on the Edit Season page. - C15611');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Image List Type Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('Type', ContentPage::$imagesTable_typeHeader);
        $I->see('Portrait Poster', ContentPage::$imagesTable_firstType);
    }

    /**
    * TESTRAIL TESTCASE ID: C15613
    *
    * @group test_priority_3
    */
    public function noImagesMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Images message appears on a season without images. - C15613');
        if(SeasonEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);
    }

    /**
     * TESTRAIL TESTCASE ID: C50838, C50839
     *
     * @group test_priority_2
     *
     * @example {"poster": "Portrait Poster", "test_case_id": "C50838"}
     * @example {"poster": "Landscape Poster", "test_case_id": "C50839"}
     */
    public function clickPoster(Example $example, ContentSeasonEditSteps $I, ImageEditSteps $imagePage) {
        $I->wantTo("Checking is clicking on the image opens the page with images preview - " . $example['test_case_id']);
        $I->amOnSeasonEditPage();
        $I->accessPosterPage($example['poster']);
        $imagePage->shouldSeeImage();
        $imagePage->shouldSeeSmallSizePreviews();
        $imagePage->shouldSeeImageAttributes();
    }

    /**
     * TESTRAIL TESTCASE ID: C1788155
     *
     * @group test_priority_2
     *
     * @example {"linkTo": "Series", "test_case_id": "C1788155"}
     * @example {"linkTo": "Season", "test_case_id": "C1788155"}
     * @example {"linkTo": "Episode", "test_case_id": "C1788155"}
     * @example {"linkTo": "Movie", "test_case_id": "C1788155"}
     */
    public function contentCanBeLinkedAndUnlinked(Example $example, ContentSeasonEditSteps $I) {
        $I->wantTo('Check if user is able to add and remove linked content to Season - ' . $example['test_case_id']);
        $I->amOnSeasonEditPage();
        $I->linkContentTo(ContentEditPage::getEditGuidByContentType($example['linkTo']));
        $I->pressSaveChangesButton();
        $I->reloadPage();
        $I->shouldSeeContentWasLinked();
        $I->removeLinkedContent();
        $I->pressSaveChangesButton();
    }

}
