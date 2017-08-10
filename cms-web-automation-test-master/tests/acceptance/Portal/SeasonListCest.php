<?php

class SeasonListCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (SeasonListCest::$environment == 'undefined')
        {
            SeasonListCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        SeasonListCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, SeasonListCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    /**
    * TESTRAIL TESTCASE ID: C225117
    *
    * @group test_priority_2
    */
    public function displayPerPageDropdown(AcceptanceTester $I)
    {
        $I->wantTo('Verify Display Per Page dropdown works correctly. - C225117');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->amGoingTo('Select 10 on dropdown.');
        $I->selectOption("//table//select", '10');
        
        $I->expect('Only 10 elements are shown in the table.');
        $I->waitForElementNotVisible("//table//tr[11]", 30);
        $I->waitForElementVisible("//table//tr[10]", 30);

        $I->amGoingTo('Select 20 on dropdown.');
        $I->selectOption("//table//select", '20');
        
        $I->expect('Only 20 elements are shown in the table.');
        $I->waitForElementNotVisible("//table//tr[21]", 30);
        $I->waitForElementVisible("//table//tr[20]", 30);

        $I->amGoingTo('Select 50 on dropdown.');
        $I->selectOption("//table//select", '50');
        
        $I->expect('Only 50 elements are shown in the table.');
        $I->waitForElementNotVisible("//table//tr[51]", 30);
        $I->waitForElementVisible("//table//tr[50]", 30);

        $I->amGoingTo('Select 100 on dropdown.');
        $I->selectOption("//table//select", '100');
        
        $I->expect('Only 100 elements are shown in the table.');
        $I->waitForElementNotVisible("//table//tr[101]", 30);
        $I->waitForElementVisible("//table//tr[100]", 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C225130
    *
    * @group test_priority_2
    */
    public function seasonNumbers(AcceptanceTester $I)
    {
        $I->wantTo('Verify season numbers are displayed on season list page. - C225130');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('1', "//tr[1]/td[" . ContentPage::$numberCol_season . "]");
        $I->see('2', "//tr[2]/td[" . ContentPage::$numberCol_season . "]");
        $I->see('3', "//tr[3]/td[" . ContentPage::$numberCol_season . "]");
        $I->see('4', "//tr[4]/td[" . ContentPage::$numberCol_season . "]");
        $I->see('5', "//tr[5]/td[" . ContentPage::$numberCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C166968
    *
    * @group test_priority_2
    */
    public function seasonNumbersNumericalOnLoad(AcceptanceTester $I)
    {
        $I->wantTo('Verify seasons are sorted numerically upon page load. - C166968');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('1', "//tr[1]/td[" . ContentPage::$numberCol_season . "]");
        $I->see('2', "//tr[2]/td[" . ContentPage::$numberCol_season . "]");
        $I->see('3', "//tr[3]/td[" . ContentPage::$numberCol_season . "]");
        $I->see('4', "//tr[4]/td[" . ContentPage::$numberCol_season . "]");
        $I->see('5', "//tr[5]/td[" . ContentPage::$numberCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225118
    *
    * @group test_priority_2
    */
    public function seasonTitles(AcceptanceTester $I)
    {
        $I->wantTo('Verify season titles are displayed on season list page. - C225118');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('First', "//tr[1]/td[" . ContentPage::$titleCol_season . "]");
        $I->see('Second', "//tr[2]/td[" . ContentPage::$titleCol_season . "]");
        $I->see('Third', "//tr[3]/td[" . ContentPage::$titleCol_season . "]");
        $I->see('Fourth', "//tr[4]/td[" . ContentPage::$titleCol_season . "]");
        $I->see('Fifth', "//tr[5]/td[" . ContentPage::$titleCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225119
    *
    * @group test_priority_2
    */
    public function seasonTypes(AcceptanceTester $I)
    {
        $I->wantTo('Verify season types are displayed on season list page. - C225119');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('Season', "//tr[1]/td[" . ContentPage::$typeCol_season . "]");
        $I->see('Season', "//tr[2]/td[" . ContentPage::$typeCol_season . "]");
        $I->see('Season', "//tr[3]/td[" . ContentPage::$typeCol_season . "]");
        $I->see('Season', "//tr[4]/td[" . ContentPage::$typeCol_season . "]");
        $I->see('Season', "//tr[5]/td[" . ContentPage::$typeCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225120
    *
    * @group test_priority_2
    */
    public function seasonGuids(AcceptanceTester $I)
    {
        $I->wantTo('Verify season GUIDs are displayed on season list page. - C225120');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        if(SeasonListCest::$environment == 'staging')
        {
            $I->see('GY2PZ8XPY', "//tr[1]/td[" . ContentPage::$guidCol_season . "]");
            $I->see('GR8V8EVDR', "//tr[2]/td[" . ContentPage::$guidCol_season . "]");
            $I->see('G6ZXP8X4R', "//tr[3]/td[" . ContentPage::$guidCol_season . "]");
            $I->see('G6DQZPQDR', "//tr[4]/td[" . ContentPage::$guidCol_season . "]");
            $I->see('GYQ4X14Q6', "//tr[5]/td[" . ContentPage::$guidCol_season . "]");
        }
        else //proto0
        {
            $I->see('GYJQ2PK26', "//tr[1]/td[" . ContentPage::$guidCol_season . "]");
            $I->see('GYMG1W02Y', "//tr[2]/td[" . ContentPage::$guidCol_season . "]");
            $I->see('GR8VJP80R', "//tr[3]/td[" . ContentPage::$guidCol_season . "]");
            $I->see('GYQ4M7X16', "//tr[4]/td[" . ContentPage::$guidCol_season . "]");
            $I->see('GRE5PDZX6', "//tr[5]/td[" . ContentPage::$guidCol_season . "]");
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C225121
    *
    * @group test_priority_2
    */
    public function seasonEpisodes(AcceptanceTester $I)
    {
        $I->wantTo('Verify season episodes are displayed on season list page. - C225121');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('2', "//tr[2]/td[" . ContentPage::$episodesCol_season . "]");
        $I->see('1', "//tr[3]/td[" . ContentPage::$episodesCol_season . "]");
        $I->see('2', "//tr[4]/td[" . ContentPage::$episodesCol_season . "]");
        $I->see('0', "//tr[5]/td[" . ContentPage::$episodesCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225122
    *
    * @group test_priority_2
    */
    public function seasonPublishedStatus(AcceptanceTester $I)
    {
        $I->wantTo('Verify season publish statuses are displayed on season list page. - C225122');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('96%', "//tr[1]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->see('100%', "//tr[2]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->see('0%', "//tr[3]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->see('50%', "//tr[4]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->see('0%', "//tr[5]/td[" . ContentPage::$publishedPercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225124
    *
    * @group test_priority_2
    */
    public function publishStatusIndividualSeasons(AcceptanceTester $I)
    {
        $I->wantTo('Verify that each season shows its own publish percentage. - C225124');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('96%', "//tr[1]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->see('100%', "//tr[2]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->see('0%', "//tr[3]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->see('50%', "//tr[4]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->see('0%', "//tr[5]/td[" . ContentPage::$publishedPercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214843
    *
    * @group test_priority_2
    */
    public function seriesTranscodeStatus(AcceptanceTester $I)
    {
        $I->wantTo('Verify season transcode statuses are displayed on season list page. - C214843');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('1%', "//tr[1]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->see('50%', "//tr[2]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->see('100%', "//tr[3]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->see('100%', "//tr[4]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->see('N/A', "//tr[5]/td[" . ContentPage::$transcodePercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225140
    *
    * @group test_priority_2
    */
    public function transcodeStatusIndividualSeasons(AcceptanceTester $I)
    {
        $I->wantTo('Verify that each season shows its own transcode percentage. - C225140');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('1%', "//tr[1]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->see('50%', "//tr[2]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->see('100%', "//tr[3]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->see('100%', "//tr[4]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->see('N/A', "//tr[5]/td[" . ContentPage::$transcodePercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225126
    *
    * @group test_priority_2
    */
    public function sortContentBySeasonNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify seasons can be sorted by season number. - C225126');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$numberCol_season . "]");

        $I->waitForText('1', 30, "//tr[1]/td[" . ContentPage::$numberCol_season . "]");
        $I->waitForText('2', 30, "//tr[2]/td[" . ContentPage::$numberCol_season . "]");
        $I->waitForText('3', 30, "//tr[3]/td[" . ContentPage::$numberCol_season . "]");
        $I->waitForText('4', 30, "//tr[4]/td[" . ContentPage::$numberCol_season . "]");
        $I->waitForText('5', 30, "//tr[5]/td[" . ContentPage::$numberCol_season . "]");

        $I->click("//tr/th[" . ContentPage::$numberCol_season . "]");

        $I->waitForText('101', 30, "//tr[1]/td[" . ContentPage::$numberCol_season . "]");
        $I->waitForText('100', 30, "//tr[2]/td[" . ContentPage::$numberCol_season . "]");
        $I->waitForText('99', 30, "//tr[3]/td[" . ContentPage::$numberCol_season . "]");
        $I->waitForText('98', 30, "//tr[4]/td[" . ContentPage::$numberCol_season . "]");
        $I->waitForText('97', 30, "//tr[5]/td[" . ContentPage::$numberCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225125
    *
    * @group test_priority_2
    */
    public function sortContentByPublishedPercent(AcceptanceTester $I)
    {
        $I->wantTo('Verify seasons can be sorted by Published Percent. - C225125');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$publishedPercentCol_season . "]");

        $I->waitForText('0%', 30, "//tr[1]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->waitForText('0%', 30, "//tr[2]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->waitForText('0%', 30, "//tr[3]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->waitForText('0%', 30, "//tr[4]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->waitForText('0%', 30, "//tr[5]/td[" . ContentPage::$publishedPercentCol_season . "]");

        $I->click("//tr/th[" . ContentPage::$publishedPercentCol_season . "]");

        $I->waitForText('100%', 30, "//tr[1]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->waitForText('96%', 30, "//tr[2]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->waitForText('50%', 30, "//tr[3]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->waitForText('0%', 30, "//tr[4]/td[" . ContentPage::$publishedPercentCol_season . "]");
        $I->waitForText('0%', 30, "//tr[5]/td[" . ContentPage::$publishedPercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214846
    *
    * @group test_priority_2
    */
    public function sortContentByTranscodePercent(AcceptanceTester $I)
    {
        $I->wantTo('Verify seasons can be sorted by Transcode Percent. - C214846');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$transcodePercentCol_season . "]");

        $I->waitForText('1%', 30, "//tr[1]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->waitForText('50%', 30, "//tr[2]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->waitForText('100%', 30, "//tr[3]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->waitForText('100%', 30, "//tr[4]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->waitForText('N/A', 30, "//tr[5]/td[" . ContentPage::$transcodePercentCol_season . "]");

        $I->click("//tr/th[" . ContentPage::$transcodePercentCol_season . "]");

        $I->waitForText('N/A', 30, "//tr[1]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->waitForText('N/A', 30, "//tr[2]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->waitForText('N/A', 30, "//tr[3]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->waitForText('N/A', 30, "//tr[4]/td[" . ContentPage::$transcodePercentCol_season . "]");
        $I->waitForText('N/A', 30, "//tr[5]/td[" . ContentPage::$transcodePercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C36893
    *
    * @group test_priority_2
    */
    public function publishedPercentRoundsDown(AcceptanceTester $I)
    {
        $I->wantTo('Verify Published Percent rounds down. - C36893');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesPublishPercentTest_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesPublishPercentTest_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->expect('Since 2 of the 3 eps are published, 66.6% rounds down to 66%');
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('66%', "//tr[1]/td[" . ContentPage::$publishedPercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214845
    *
    * @group test_priority_2
    */
    public function transcodePercentRoundsDown(AcceptanceTester $I)
    {
        $I->wantTo('Verify Transcode Percent rounds down. - C214845');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesTranscodePercentTest_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesTranscodePercentTest_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->expect('Since 2 of the 3 eps are transcoded, 66.6% rounds down to 66%');
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('66%', "//tr[1]/td[" . ContentPage::$transcodePercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214844
    *
    * @group test_priority_2
    */
    public function transcodeStatusIgnoresExtras(AcceptanceTester $I)
    {
        $I->wantTo('Verify Transcode Percent is not affected by Extras. - C214844');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesTranscodeExtrasTest_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesTranscodeExtrasTest_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);

        $I->expect('The episode is transcoded by the extra is not. Therefore transcode status is still 100%.');
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('100%', "//tr[1]/td[" . ContentPage::$transcodePercentCol_season . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C259660
    *
    * @group test_priority_2
    */
    public function clickSeasonRow(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a season row. - C259660');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->waitForElementVisible("//*[contains(text(), 'First')]", 30);
        $I->click("//*[contains(text(), 'First')]");

        $I->expect('We are taken to the page for season list.');
        $I->waitForElementVisible(ContentPage::$scrollableTable, 30);
        $I->wait(1);

        $I->see('Episode 1', "//tr[1]/td[" . ContentPage::$titleCol_episode . "]");
        $I->see('Episode', "//tr[1]/td[" . ContentPage::$typeCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C22278
    *
    * @group test_priority_2
    */
    public function clickEditOnSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking the edit icon on a season takes us to the edit series page. - C22278');
        if(SeasonListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->waitForElementVisible("//table[contains(@class, 'sortable')]/tbody/tr", 30);

        $I->moveMouseOver("//tr[2]");
        $I->waitForElementVisible("//tr[2]//i[contains(@class, 'edit')]", 30);
        $I->click("//tr[2]//i[contains(@class, 'edit')]");

        $I->expect('We are taken to the page for season content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForText('EPISODES', 30);
        $I->waitForText('IMAGES', 30);
        $I->waitForText('VIDEOS', 30);
    }
}
