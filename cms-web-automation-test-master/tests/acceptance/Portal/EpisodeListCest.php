<?php

class EpisodeListCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (EpisodeListCest::$environment == 'undefined')
        {
            EpisodeListCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        EpisodeListCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, EpisodeListCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    /**
    * TESTRAIL TESTCASE ID: C225129
    *
    * @group test_priority_2
    */
    public function displayPerPageDropdown(AcceptanceTester $I)
    {
        $I->wantTo('Verify Display Per Page dropdown works correctly. - C225129');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
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
    * TESTRAIL TESTCASE ID: C225131
    *
    * @group test_priority_2
    */
    public function episodeNumbers(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode numbers are displayed on episode list page. - C225131');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('1', "//tr[1]/td[" . ContentPage::$numberCol_episode . "]");
        $I->see('2', "//tr[2]/td[" . ContentPage::$numberCol_episode . "]");
        $I->see('3', "//tr[3]/td[" . ContentPage::$numberCol_episode . "]");
        $I->see('4', "//tr[4]/td[" . ContentPage::$numberCol_episode . "]");
        $I->see('5', "//tr[5]/td[" . ContentPage::$numberCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C166969
    *
    * @group test_priority_2
    */
    public function episodesNumericalOnLoad(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode are sorted numerically on page load. - C166969');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('1', "//tr[1]/td[" . ContentPage::$numberCol_episode . "]");
        $I->see('2', "//tr[2]/td[" . ContentPage::$numberCol_episode . "]");
        $I->see('3', "//tr[3]/td[" . ContentPage::$numberCol_episode . "]");
        $I->see('4', "//tr[4]/td[" . ContentPage::$numberCol_episode . "]");
        $I->see('5', "//tr[5]/td[" . ContentPage::$numberCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225137
    *
    * @group test_priority_2
    */
    public function episodeTitles(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode titles are displayed on episode list page. - C225137');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('Episode 1', "//tr[1]/td[" . ContentPage::$titleCol_episode . "]");
        $I->see('Episode 2', "//tr[2]/td[" . ContentPage::$titleCol_episode . "]");
        $I->see('Episode 3', "//tr[3]/td[" . ContentPage::$titleCol_episode . "]");
        $I->see('Episode 4', "//tr[4]/td[" . ContentPage::$titleCol_episode . "]");
        $I->see('Episode 5', "//tr[5]/td[" . ContentPage::$titleCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225132
    *
    * @group test_priority_2
    */
    public function episodeTypes(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode types are displayed on episode list page. - C225132');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('Episode', "//tr[1]/td[" . ContentPage::$typeCol_episode . "]");
        $I->see('Episode', "//tr[2]/td[" . ContentPage::$typeCol_episode . "]");
        $I->see('Episode', "//tr[3]/td[" . ContentPage::$typeCol_episode . "]");
        $I->see('Episode', "//tr[4]/td[" . ContentPage::$typeCol_episode . "]");
        $I->see('Episode', "//tr[5]/td[" . ContentPage::$typeCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225133
    *
    * @group test_priority_2
    */
    public function episodeGuids(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode GUIDs are displayed on episode list page. - C225133');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        if(EpisodeListCest::$environment == 'staging')
        {
            $I->see('G68V8EWD6', "//tr[1]/td[" . ContentPage::$guidCol_episode . "]");
            $I->see('GYDQZP9D6', "//tr[2]/td[" . ContentPage::$guidCol_episode . "]");
            $I->see('GR5V8W0ER', "//tr[3]/td[" . ContentPage::$guidCol_episode . "]");
            $I->see('G6GGDQ126', "//tr[4]/td[" . ContentPage::$guidCol_episode . "]");
            $I->see('G6E532V8Y', "//tr[5]/td[" . ContentPage::$guidCol_episode . "]");
        }
        else //proto0
        {
            $I->see('GRNQ1GJ8R', "//tr[1]/td[" . ContentPage::$guidCol_episode . "]");
            $I->see('GYMG1W83Y', "//tr[2]/td[" . ContentPage::$guidCol_episode . "]");
            $I->see('GY3VGNWZR', "//tr[3]/td[" . ContentPage::$guidCol_episode . "]");
            $I->see('G62PWJ596', "//tr[4]/td[" . ContentPage::$guidCol_episode . "]");
            $I->see('G6ZXQV4MR', "//tr[5]/td[" . ContentPage::$guidCol_episode . "]");
        }
    }

    /**
    * TESTRAIL TESTCASE ID: C225134
    *
    * @group test_priority_2
    */
    public function episodePublishStatus(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode publish statuses are displayed on episode list page. - C225134');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('Yes', "//tr[1]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->see('Yes', "//tr[2]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->see('No', "//tr[3]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->see('Yes', "//tr[4]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->see('No', "//tr[5]/td[" . ContentPage::$publishedPercentCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C36898
    *
    * @group test_priority_2
    */
    public function episodePublishStatusIsYesNo(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode publish statuses are displayed as Yes or No. - C36898');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('Yes', "//tr[1]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->see('Yes', "//tr[2]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->see('No', "//tr[3]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->see('Yes', "//tr[4]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->see('No', "//tr[5]/td[" . ContentPage::$publishedPercentCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214847
    *
    * @group test_priority_2
    */
    public function episodeTranscodeStatus(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode transcode statuses are displayed on episode list page. - C214847');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('Yes', "//tr[1]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->see('Yes', "//tr[2]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->see('No', "//tr[3]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->see('No', "//tr[4]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->see('No', "//tr[5]/td[" . ContentPage::$transcodePercentCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214849
    *
    * @group test_priority_2
    */
    public function episodeTranscodeStatusIsYesNo(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode transcode statuses are displayed on as Yes or N. - C214849');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('Yes', "//tr[1]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->see('Yes', "//tr[2]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->see('No', "//tr[3]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->see('No', "//tr[4]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->see('No', "//tr[5]/td[" . ContentPage::$transcodePercentCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214848
    *
    * @group test_priority_2
    */
    public function episodeTranscodeStatusIgnoresExtras(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode transcode status is not affected by Extras. - C214848');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonTranscodeExtrasTest_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonTranscodeExtrasTest_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr", 30);
        $I->see('Yes', "//tr[1]/td[" . ContentPage::$transcodePercentCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225138
    *
    * @group test_priority_2
    */
    public function sortContentByEpisodeNumber(AcceptanceTester $I)
    {
        $I->wantTo('Verify episodes can be sorted by episode number. - C225138');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$numberCol_episode . "]");

        $I->waitForText('1', 30, "//tr[1]/td[" . ContentPage::$numberCol_episode . "]");
        $I->waitForText('2', 30, "//tr[2]/td[" . ContentPage::$numberCol_episode . "]");
        $I->waitForText('3', 30, "//tr[3]/td[" . ContentPage::$numberCol_episode . "]");
        $I->waitForText('4', 30, "//tr[4]/td[" . ContentPage::$numberCol_episode . "]");
        $I->waitForText('5', 30, "//tr[5]/td[" . ContentPage::$numberCol_episode . "]");

        $I->click("//tr/th[" . ContentPage::$numberCol_episode . "]");

        $I->waitForText('103', 30, "//tr[1]/td[" . ContentPage::$numberCol_episode . "]");
        $I->waitForText('102', 30, "//tr[2]/td[" . ContentPage::$numberCol_episode . "]");
        $I->waitForText('101', 30, "//tr[3]/td[" . ContentPage::$numberCol_episode . "]");
        $I->waitForText('100', 30, "//tr[4]/td[" . ContentPage::$numberCol_episode . "]");
        $I->waitForText('99', 30, "//tr[5]/td[" . ContentPage::$numberCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C225139
    *
    * @group test_priority_2
    */
    public function sortContentByPublishedStatus(AcceptanceTester $I)
    {
        $I->wantTo('Verify episodes can be sorted by publish status. - C225139');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$publishedPercentCol_episode . "]");

        $I->waitForText('No', 30, "//tr[1]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[2]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[3]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[4]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->waitForText('Yes', 30, "//tr[5]/td[" . ContentPage::$publishedPercentCol_episode . "]");

        $I->click("//tr/th[" . ContentPage::$publishedPercentCol_episode . "]");

        $I->waitForText('Yes', 30, "//tr[1]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->waitForText('Yes', 30, "//tr[2]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->waitForText('Yes', 30, "//tr[3]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->waitForText('Yes', 30, "//tr[4]/td[" . ContentPage::$publishedPercentCol_episode . "]");
        $I->waitForText('Yes', 30, "//tr[5]/td[" . ContentPage::$publishedPercentCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214850
    *
    * @group test_priority_2
    */
    public function sortContentByTranscodeStatus(AcceptanceTester $I)
    {
        $I->wantTo('Verify episodes can be sorted by transcode status. - C214850');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$transcodePercentCol_episode . "]");

        $I->waitForText('No', 30, "//tr[1]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[2]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[3]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[4]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[5]/td[" . ContentPage::$transcodePercentCol_episode . "]");

        $I->click("//tr/th[" . ContentPage::$transcodePercentCol_episode . "]");

        $I->waitForText('Yes', 30, "//tr[1]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->waitForText('Yes', 30, "//tr[2]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[3]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[4]/td[" . ContentPage::$transcodePercentCol_episode . "]");
        $I->waitForText('No', 30, "//tr[5]/td[" . ContentPage::$transcodePercentCol_episode . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C22279
    *
    * @group test_priority_2
    */
    public function clickEpisodeRow(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking an episode row. - C22279');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//*[contains(text(), 'Episode 2')]", 30);
        $I->click("//*[contains(text(), 'Episode 2')]");

        $I->expect('We are taken to the page for episode content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForText('IMAGES', 30);
        $I->waitForText('VIDEOS', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C259659
    *
    * @group test_priority_2
    */
    public function clickEditOnEpisode(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking the edit icon on an episode takes us to the edit series page. - C259659');
        if(EpisodeListCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonManySeasonAndEpisode_proto0;
        }
        $I->amOnPage(ContentPage::$contentListUrl . $guid);
        $I->wait(3);
        $I->waitForElementVisible("//table[contains(@class, 'sortable')]/tbody/tr", 30);

        $I->moveMouseOver("//tr[2]");
        $I->waitForElementVisible("//tr[2]//i[contains(@class, 'edit')]", 30);
        $I->click("//tr[2]//i[contains(@class, 'edit')]");

        $I->expect('We are taken to the page for episode content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForText('IMAGES', 30);
        $I->waitForText('VIDEOS', 30);
    }
}