<?php

use Codeception\Example;
use Page\ContentEditPage;
use Step\ContentEditSteps;
use Step\ImageEditSteps;
use Step\ContentSeriesEditSteps;

class SeriesEditCest
{
    public static $environment ='undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (SeriesEditCest::$environment == 'undefined')
        {
            SeriesEditCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        SeriesEditCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, SeriesEditCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    /**
    * TESTRAIL TESTCASE ID: C22272
    *
    * @group test_priority_2
    */
    public function publishSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can publish a series. - C22272');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series is unpublished.');
        $I->waitForText('All seasons and episodes will be hidden.', 30);

        $I->amGoingTo('Publish the season.');
        $I->click(ContentPage::$publishCheckbox);
        $I->waitForText('Series will be published. Seasons and Episodes within this Series will remain unchanged.', 30);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series is still published.');
        $I->waitForText('Series will be published. Seasons and Episodes within this Series will remain unchanged.', 30);
        $I->seeElement(ContentPage::$publishCheckboxChecked);
    }

    /**
    * TESTRAIL TESTCASE ID: C57539
    *
    * @depends publishSeries
    * @group test_priority_2
    */
    public function unpublishSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can unpublish a series. - C57539');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series is published.');
        $I->waitForText('Series will be published. Seasons and Episodes within this Series will remain unchanged.', 30);

        $I->amGoingTo('Unpublish the season.');
        $I->click(ContentPage::$publishCheckbox);
        $I->waitForText('All seasons and episodes will be hidden.', 30);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series is still unpublished.');
        $I->waitForText('All seasons and episodes will be hidden.', 30);
        $I->dontSeeElement(ContentPage::$publishCheckboxChecked);
    }

    /**
    * TESTRAIL TESTCASE ID: C15531
    *
    * @group test_priority_1
    */
    public function channelNameDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify channel name is displayed on the Edit Series page. - C15531');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Channel name is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15532
    *
    * @group test_priority_1
    */
    public function seriesTitleDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Title is displayed on the Edit Series page. - C15532');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series Title is displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seriesTitleRow_editable, 'Series View Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C15533
    *
    * @group test_priority_1
    */
    public function seriesDescriptionDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Description is displayed on the Edit Series page. - C15533');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series Description displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$descriptionRow_editable, 'This is the series automation uses to view all filled out data. Do not edit.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15534
    *
    * @group test_priority_1
    */
    public function seriesCategoriesDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Categories is displayed on the Edit Series page. - C15534');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series Categories displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->see('Categories', ContentPage::$categoriesRow);
        $I->see('Action/Drama', "//span[contains(@class, 'tags-tagname')]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15535
    *
    * @group test_priority_1
    */
    public function seriesTagsDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Tags is displayed on the Edit Series page. - C15535');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series Tags displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->see('Tags', ContentPage::$tagsRow);
        $I->see('automation', "(//span[contains(@class, 'tags-tagname')])[2]");
        $I->see('view data', "(//span[contains(@class, 'tags-tagname')])[3]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15536
    *
    * @group test_priority_1
    */
    public function seriesPublisherDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Publisher is displayed on the Edit Series page. - C15536');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Series Publisher displayed.');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->see('Automation Tests', ContentPage::$publisherRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15543
    *
    * @group test_priority_1
    */
    public function seriesTitleEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Title can be edited. - C15543');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Series Title');
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->fillField(ContentPage::$seriesTitleRow_editable, 'Testing All Series Datas');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seriesTitleRow_editable, 'Testing All Series Datas');

        $I->amGoingTo('Change the title back.');
        $I->fillField(ContentPage::$seriesTitleRow_editable, 'Test All Series Data');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Changes are saved.');
        $I->waitForElementVisible(ContentPage::$attributesSection, 30);
        $I->waitForText('Portal & Content Testing', 30, ContentPage::$channelRow);
        $I->seeInField(ContentPage::$seriesTitleRow_editable, 'Test All Series Data');
    }

    /**
    * TESTRAIL TESTCASE ID: C15544
    *
    * @group test_priority_1
    */
    public function seriesDescriptionEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify Series Description can be edited. - C15544');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Edit Series Description');
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
    * TESTRAIL TESTCASE ID: C15551
    *
    * @group test_priority_1
    */
    public function seasonListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season List is displayed on the Edit Series page. - C15551');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('SEASONS');
        $I->see('Season View Filled Data For Automation', ContentPage::$seasonsTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15552
    *
    * @group test_priority_2
    */
    public function seasonListSortedNumerically(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season List is sorted by #. - C15552');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Season List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('SEASONS');
        $I->see('1', "//h1[text()='Seasons']/..//table/tbody/tr/td[1]");
        $I->see('First', "//h1[text()='Seasons']/..//table/tbody/tr/td[2]");

        $I->see('2', "//h1[text()='Seasons']/..//table/tbody/tr[2]/td[1]");
        $I->see('Second', "//h1[text()='Seasons']/..//table/tbody/tr[2]/td[2]");

        $I->see('3', "//h1[text()='Seasons']/..//table/tbody/tr[3]/td[1]");
        $I->see('Third', "//h1[text()='Seasons']/..//table/tbody/tr[3]/td[2]");

        $I->see('4', "//h1[text()='Seasons']/..//table/tbody/tr[4]/td[1]");
        $I->see('Fourth', "//h1[text()='Seasons']/..//table/tbody/tr[4]/td[2]");

        $I->see('5', "//h1[text()='Seasons']/..//table/tbody/tr[5]/td[1]");
        $I->see('Fifth', "//h1[text()='Seasons']/..//table/tbody/tr[5]/td[2]");

        $I->see('6', "//h1[text()='Seasons']/..//table/tbody/tr[6]/td[1]");
        $I->see('Season 6', "//h1[text()='Seasons']/..//table/tbody/tr[6]/td[2]");

        $I->see('7', "//h1[text()='Seasons']/..//table/tbody/tr[7]/td[1]");
        $I->see('Season 7', "//h1[text()='Seasons']/..//table/tbody/tr[7]/td[2]");

        $I->see('8', "//h1[text()='Seasons']/..//table/tbody/tr[8]/td[1]");
        $I->see('Season 8', "//h1[text()='Seasons']/..//table/tbody/tr[8]/td[2]");

        $I->see('9', "//h1[text()='Seasons']/..//table/tbody/tr[9]/td[1]");
        $I->see('Season 9', "//h1[text()='Seasons']/..//table/tbody/tr[9]/td[2]");

        $I->see('10', "//h1[text()='Seasons']/..//table/tbody/tr[10]/td[1]");
        $I->see('Season 10', "//h1[text()='Seasons']/..//table/tbody/tr[10]/td[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15553
    *
    * @group test_priority_3
    */
    public function seasonListPaginatedAtTen(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season List is paginated at 10. - C15553');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = 'GR2P24E2R';
        }
        else //proto0
        {
            $guid = 'GY759V1K6';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('1 - 10 of ', "(//div[contains(@class, 'panel')])[1]");
        $I->dontSeeElement("(//table)[1]/tr[11]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15554
    *
    * @group test_priority_3
    */
    public function seasonListPaginationCannotBeChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify Season List pagination cannot be changed. - C15554');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = 'GR2P24E2R';
        }
        else //proto0
        {
            $guid = 'GY759V1K6';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->dontSeeElement("(//table)[1]//select");
    }

    /**
    * TESTRAIL TESTCASE ID: C15555
    *
    * @group test_priority_3
    */
    public function seasonListNoViewAll(AcceptanceTester $I)
    {
        $I->wantTo('Verify there is no View All for the Season table. - C15555');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = 'GR2P24E2R';
        }
        else //proto0
        {
            $guid = 'GY759V1K6';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->dontSee('All', "(//div[contains(@class, 'panel')])[1]");
    }

    /**
    * TESTRAIL TESTCASE ID: C11006
    *
    * @group test_priority_1
    */
    public function clickSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a season listing. - C11006');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//span[text()='Season View Filled Data For Automation']");
        $I->click("//span[text()='Season View Filled Data For Automation']");

        $I->expect('We are taken to the page for season content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->seeInField(ContentPage::$seasonTitleRow_editable, 'Season View Filled Data For Automation');
        $I->see('EPISODES');
    }

    /**
    * TESTRAIL TESTCASE ID: C15556
    *
    * @group test_priority_3
    */
    public function noSeasonsMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Seasons message appears on a series without seasons. - C15556');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('There are no seasons attached to this media.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15557
    *
    * @group test_priority_1
    */
    public function episodeListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode List is displayed on the Edit Series page. - C15557');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Episode List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('EPISODES');
        $I->see('Episode View Filled Data For Automation', ContentPage::$episodesTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15558
    *
    * @group test_priority_2
    */
    public function episodeListSortedNumerically(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode List is sorted by #. - C15558');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
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
    * TESTRAIL TESTCASE ID: C15559
    *
    * @group test_priority_3
    */
    public function episodeListPaginatedAtTen(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode List is paginated at 10. - C15559');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = 'GRWE0XV3R';
        }
        else //proto0
        {
            $guid = 'GY759V1K6';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('1 - 10 of ', "(//div[contains(@class, 'panel')])[1]");
        $I->dontSeeElement("(//table)[2]/tr[11]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15560
    *
    * @group test_priority_3
    */
    public function episodeListPaginationCannotBeChanged(AcceptanceTester $I)
    {
        $I->wantTo('Verify Episode List pagination cannot be changed. - C15560');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = 'GRWE0XV3R';
        }
        else //proto0
        {
            $guid = 'GY759V1K6';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->dontSeeElement("(//table)[2]//select");
    }

    /**
    * TESTRAIL TESTCASE ID: C15561
    *
    * @group test_priority_3
    */
    public function episodeListNoViewAll(AcceptanceTester $I)
    {
        $I->wantTo('Verify there is no View All for the Episode table. - C15561');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = 'GRWE0XV3R';
        }
        else //proto0
        {
            $guid = 'G62P4D2J6';
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->dontSee('All', "(//div[contains(@class, 'panel')])[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C11007
    *
    * @group test_priority_1
    */
    public function clickEpisode(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a episode listing from the series page. - C11007');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("(//table)[2]//span[text()='Episode View Filled Data For Automation']");
        $I->click("(//table)[2]//span[text()='Episode View Filled Data For Automation']");

        $I->expect('We are taken to the page for episode content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->seeInField(ContentPage::$episodeTitleRow_editable, 'Episode View Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C15562
    *
    * @group test_priority_3
    */
    public function noEpisodesMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Episodes message appears on a series without episodes. - C15562');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('There are no episodes attached to this media.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15563
    *
    * @group test_priority_2
    */
    public function videoListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List is displayed on the Edit Series page. - C15563');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('series_view_filled_data_automation_1_series_clip_media_id', ContentPage::$videoTable);
    }

    /**
    * TESTRAIL TESTCASE ID: C15564
    *
    * @group test_priority_3
    */
    public function videoListUnsortable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List is unsortable. - C15564');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('series_view_filled_data_automation_1_series_clip_media_id', ContentPage::$videoTable);
        $I->dontSee('.sortable');
    }

    /**
    * TESTRAIL TESTCASE ID: C15565
    *
    * @group test_priority_2
    */
    public function videoListFilenameColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Filename Column is displayed on the Edit Series page. - C15565');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List Title Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('Title', ContentPage::$videoTable_titleHeader);
        $I->see('series_view_filled_data_automation_1_series_clip_media_id', ContentPage::$videoTable_firstTitle);
    }

    /**
    * TESTRAIL TESTCASE ID: C15566
    *
    * @group test_priority_2
    */
    public function videoListDurationColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List Duration Column is displayed on the Edit Series page. - C15566');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List Duration Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('Duration', ContentPage::$videoTable_durationHeader);
        $I->see('00:24:00', ContentPage::$videoTable_firstDuration);
    }

    /**
    * TESTRAIL TESTCASE ID: C15567
    *
    * @group test_priority_2
    */
    public function videoListGuidColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video List GUID Column is displayed on the Edit Series page. - C15567');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Video List GUID Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('VIDEOS');
        $I->see('GUID', ContentPage::$videoTable_guidHeader);
        if(SeriesEditCest::$environment == 'staging')
        {
            $I->see('G6GGDPE46', ContentPage::$videoTable_firstGuid);
        }
        else
        {
            $I->see('GRDQ43JGY', ContentPage::$videoTable_firstGuid);
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C57545
    *
    * @group test_priority_2
    */
    public function clickVideo(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a video listing from the series page. - C57545');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->scrollTo("//*[text()='series_view_filled_data_automation_1_series_clip_media_id']");
        $I->click("//*[text()='series_view_filled_data_automation_1_series_clip_media_id']");

        $I->expect('We are taken to the page for the video.');
        $I->waitForText('VIDEO PREVIEW', 30);
        $I->seeInField("//label[text()=\"Video Title\"]/following-sibling::input", 'Series Clip Video Filled Data For Automation');
    }

    /**
    * TESTRAIL TESTCASE ID: C15568
    *
    * @group test_priority_3
    */
    public function noVideosMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Videos message appears on a series without videos. - C15568');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('There are no videos attached to this media.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15569
    *
    * @group test_priority_2
    */
    public function imagesListDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Images List is displayed on the Edit Series page. - C15569');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Images List is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        if(SeriesEditCest::$environment == 'staging')
        {
            $I->see('cb68f4d833a982b74ba7844d6176e706.png', ContentPage::$imagesTable);
        }
        else
        {
            $I->see('1bfabe3098cfb7d658594946d572704c.png', ContentPage::$imagesTable);
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C15570  
    *
    * @group test_priority_3
    */
    public function imagesListUnsortable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Images List is unsortable. - C15570');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Images List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        if(SeriesEditCest::$environment == 'staging')
        {
            $I->see('cb68f4d833a982b74ba7844d6176e706.png', ContentPage::$imagesTable);
        }
        else
        {
            $I->see('1bfabe3098cfb7d658594946d572704c.png', ContentPage::$imagesTable);
        }
        $I->dontSee('.sortable');
    }

    /**
    * TESTRAIL TESTCASE ID: C15571
    *
    * @group test_priority_2
    */
    public function imageListFilenameColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Image List Filename Column is displayed on the Edit Series page. - C15571');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Image List Title Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('Title', ContentPage::$imagesTable_titleHeader);
        if(SeriesEditCest::$environment == 'staging')
        {
            $I->see('cb68f4d833a982b74ba7844d6176e706.png', ContentPage::$imagesTable_firstTitle);
        }
        else
        {
            $I->see('1bfabe3098cfb7d658594946d572704c.png', ContentPage::$imagesTable_firstTitle);
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C15572
    *
    * @group test_priority_2
    */
    public function imageListTypeColumnDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Image List Type Column is displayed on the Edit Series page. - C15572');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Image List Type Column is displayed.');
        $I->waitForElementVisible(ContentPage::$clickableTable, 30);
        $I->see('IMAGES');
        $I->see('Type', ContentPage::$imagesTable_typeHeader);
        if(SeriesEditCest::$environment == 'staging')
        {
            $I->see('Landscape Poster', ContentPage::$imagesTable_firstType);
        }
        else
        {
            $I->see('Portrait Poster', ContentPage::$imagesTable_firstType);
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C15574
    *
    * @group test_priority_3
    */
    public function noImagesMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Images message appears on a series without images. - C15574');
        if(SeriesEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);
    }

    /**
     * TESTRAIL TESTCASE ID: C50836, C50837
     *
     * @group test_priority_2
     *
     * @example {"poster": "Portrait Poster", "test_case_id": "C50836"}
     * @example {"poster": "Landscape Poster", "test_case_id": "C50837"}
     */
    public function clickPoster(Example $example, ContentSeriesEditSteps $I, ImageEditSteps $imagePage) {
        $I->wantTo("Checking is clicking on the image opens the page with images preview - " . $example['test_case_id']);
        $I->amOnSeriesEditPage();
        $I->accessPosterPage($example['poster']);
        $imagePage->shouldSeeImage();
        $imagePage->shouldSeeSmallSizePreviews();
        $imagePage->shouldSeeImageAttributes();
    }

    /**
     * TESTRAIL TESTCASE ID: C1788154
     *
     * @group test_priority_2
     *
     * @example {"linkTo": "Series", "test_case_id": "C1788154"}
     * @example {"linkTo": "Season", "test_case_id": "C1788154"}
     * @example {"linkTo": "Episode", "test_case_id": "C1788154"}
     * @example {"linkTo": "Movie", "test_case_id": "C1788154"}
     */
    public function contentCanBeLinkedAndUnlinked(Example $example, ContentSeriesEditSteps $I) {
        $I->wantTo('Check if user is able to add and remove linked content to Series - ' . $example['test_case_id']);
        $I->amOnSeriesEditPage();
        $I->linkContentTo(ContentEditPage::getEditGuidByContentType($example['linkTo']));
        $I->pressSaveChangesButton();
        $I->reloadPage();
        $I->shouldSeeContentWasLinked();
        $I->removeLinkedContent();
        $I->pressSaveChangesButton();
    }

}
