<?php

use Page\ContentPage;
use Step\ContentSteps;
use Step\ContentEditSteps;
use Step\LoginSteps;
use Codeception\Example;

class ContentCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(LoginSteps $I) {
        $I->login();
    }

    //CONTENT SCREEN

    /**
    * TESTRAIL TESTCASE ID: C15511
    *
    * @group test_priority_2
    */
    /*
    public function displayPerPageDropdown(AcceptanceTester $I)
    {
        $I->wantTo('Verify Display Per Page dropdown works correctly. - C15511');
        $I->amOnPage(::$URL);

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
    */
    /**
     * * TESTRAIL TESTCASE ID: C15511
     *
     * @group test_priority_2
     *
     * @example { "numberOfElements": "10" }
     * @example { "numberOfElements": "20" }
     * @example { "numberOfElements": "All" }
     */
    public function displayPerPageDropdown(ContentSteps $I,Example $example)
    {

        $I->wantTo('Verify Display Per Page dropdown works correctly. - C15511');
        $I->amOnContentPage();
        $I->selectNumberOfItemsPerPage($example['numberOfElements']);
        $I->shouldSeePageDropdownElements($example['numberOfElements']);
    }


    /**
    * TESTRAIL TESTCASE ID: C9174
    *
    * @group test_priority_1
    */
    /*
    public function contentTitles(AcceptanceTester $I)
    {
        $I->wantTo('Verify content titles show up correctly. - C9174');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr", 30);

        $I->see('A CAPITAL SERIES', "//tr[1]/td[" . ContentPage::$titleCol . "]");
        $I->see('a lowercase movie', "//tr[2]/td[" . ContentPage::$titleCol . "]");
        $I->see('AA', "//tr[3]/td[" . ContentPage::$titleCol . "]");
        $I->see('Ab', "//tr[4]/td[" . ContentPage::$titleCol . "]");
        $I->see('AC', "//tr[5]/td[" . ContentPage::$titleCol . "]");
    }
    */

    /**
     * TESTRAIL TESTCASE ID: C9174
     *
     * @group test_priority_1
     */

    public function contentTitles(ContentSteps $I){
        $I->wantTo('Verify content titles show up correctly. - C9174');
        $I->amOnContentPage();
        $guid=$I->chooseGuidOfItemByTypeAndPosition('Movie',1);
        $I->shouldSeeTitleIsValid($guid);
    }

    /**
    * TESTRAIL TESTCASE ID: C166967
    *
    * @group test_priority_2
    */
    /*
    public function contentTitlesAlphabeticalOnLoad(AcceptanceTester $I)
    {
        $I->wantTo('Verify content titles are alphabetical upon loading. - C166967');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr", 30);

        $I->see('A CAPITAL SERIES', "//tr[1]/td[" . ContentPage::$titleCol . "]");
        $I->see('a lowercase movie', "//tr[2]/td[" . ContentPage::$titleCol . "]");
        $I->see('AA', "//tr[3]/td[" . ContentPage::$titleCol . "]");
        $I->see('Ab', "//tr[4]/td[" . ContentPage::$titleCol . "]");
        $I->see('AC', "//tr[5]/td[" . ContentPage::$titleCol . "]");
    }
    */

    /**
     * TESTRAIL TESTCASE ID: C166967
     *
     * @group test_priority_2
     */
    public function contentTitlesAlphabeticalOnLoad(ContentSteps $I){
        $I->wantTo('Verify content titles are alphabetical upon loading. - C166967');
        $I->amOnContentPage();
        $I->selectNumberOfItemsPerPage("All");
        $I->shouldSeeTableSortedByTitle();
    }


        /**
    * TESTRAIL TESTCASE ID: C166970
    *
    * @group test_priority_2
    */
    public function alphabeticalSortNotCaseSensitive(AcceptanceTester $I)
    {
        $I->wantTo('Verify alphabetical sorting on titles is not case sensitive. - C166970');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr", 30);

        $I->see('A CAPITAL SERIES', "//tr[1]/td[" . ContentPage::$titleCol . "]");
        $I->see('a lowercase movie', "//tr[2]/td[" . ContentPage::$titleCol . "]");
        $I->see('AA', "//tr[3]/td[" . ContentPage::$titleCol . "]");
        $I->see('Ab', "//tr[4]/td[" . ContentPage::$titleCol . "]");
        $I->see('AC', "//tr[5]/td[" . ContentPage::$titleCol . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C9175
    *
    * @group test_priority_2
    */
    /*
    public function contentTypes(AcceptanceTester $I)
    {
        $I->wantTo('Verify content types show up correctly. - C9175');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr");

        $I->see('Series', "//tr[1]/td[" . ContentPage::$typeCol . "]");
        $I->see('Movie', "//tr[2]/td[" . ContentPage::$typeCol . "]");
        $I->see('Series', "//tr[3]/td[" . ContentPage::$typeCol . "]");
        $I->see('Movie', "//tr[4]/td[" . ContentPage::$typeCol . "]");
        $I->see('Series', "//tr[5]/td[" . ContentPage::$typeCol . "]");
    }
    */

    /**
     * TESTRAIL TESTCASE ID: C9175
     *
     * @group test_priority_2
     */
    public function contentTypes(ContentSteps $I)
    {
        $I->wantTo('Verify content types show up correctly. - C9175');
        $I->amOnContentPage();
        $I->waitForElementVisible(ContentPage::$all_types['xpath']);
        $I->shouldSeeOnlyMoviesAndSeries();
    }

    /**
    * TESTRAIL TESTCASE ID: C9176
    *
    * @group test_priority_2
    */
    /*
    public function contentIds(AcceptanceTester $I)
    {
        $I->wantTo('Verify content IDs show up correctly. - C9176');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr");

        if(ContentCest::$environment == 'staging')
        {
            $I->see('G6X0Z4X2Y', "//tr[1]/td[" . ContentPage::$guidCol . "]");
            $I->see('GRZXPQN3Y', "//tr[2]/td[" . ContentPage::$guidCol . "]");
            $I->see('GR4980Z36', "//tr[3]/td[" . ContentPage::$guidCol . "]");
            $I->see('G6Q4XMV4R', "//tr[4]/td[" . ContentPage::$guidCol . "]");
            $I->see('GY1985MZR', "//tr[5]/td[" . ContentPage::$guidCol . "]");
        }
        else //proto0
        {
            $I->see('GRX04WW06', "//tr[1]/td[" . ContentPage::$guidCol . "]");
            $I->see('GYZXQ0MZ6', "//tr[2]/td[" . ContentPage::$guidCol . "]");
            $I->see('G6195DDQY', "//tr[3]/td[" . ContentPage::$guidCol . "]");
            $I->see('GRQ4MNEEY', "//tr[4]/td[" . ContentPage::$guidCol . "]");
            $I->see('GYJQ2EEV6', "//tr[5]/td[" . ContentPage::$guidCol . "]");
        }
    }
    */

    /**
     * TESTRAIL TESTCASE ID: C9176
     *
     * @group test_priority_2
     */
    public function contentIds(ContentSteps $I)
    {
        $I->wantTo('Verify content IDs show up correctly. - C9176');
        $I->amOnContentPage();
        $I->waitForElementVisible(ContentPage::$all_guids['xpath']);
        $I->shouldSeeGuidsAreListed();
    }


    /**
    * TESTRAIL TESTCASE ID: C9177
    *
    * @group test_priority_2
    */
    /*
    public function contentSeasons(AcceptanceTester $I)
    {
        $I->wantTo('Verify content Seasons show up correctly. - C9177');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr");

        $I->see('4', "//tr[1]/td[" . ContentPage::$seasonsCol . "]");
        $I->dontSee('0', "//tr[2]/td[" . ContentPage::$seasonsCol . "]");
        $I->see('0', "//tr[3]/td[" . ContentPage::$seasonsCol . "]");
        $I->dontSee('0', "//tr[4]/td[" . ContentPage::$seasonsCol . "]");
        $I->see('0', "//tr[5]/td[" . ContentPage::$seasonsCol . "]");
    }*/

    /**
     * TESTRAIL TESTCASE ID: C9177
     *
     * @group test_priority_2
     */
    public function contentSeasons(ContentSteps $I)
    {
        $I->wantTo('Verify content Seasons show up correctly. - C9177');
        $I->amOnContentPage();
        $I->selectNumberOfItemsPerPage("All");
        $I->seeCorrectNumberOfSeasons();
    }
    /**
    * TESTRAIL TESTCASE ID: C9178
    *
    * @group test_priority_2
    */
    /*
    public function contentEpisodes(AcceptanceTester $I)
    {
        $I->wantTo('Verify content Episodes show up correctly. - C9178');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr");

        $I->see('2', "//tr[1]/td[" . ContentPage::$episodesCol . "]");
        $I->dontSee('0', "//tr[2]/td[" . ContentPage::$episodesCol . "]");
        $I->see('0', "//tr[3]/td[" . ContentPage::$episodesCol . "]");
        $I->dontSee('0', "//tr[4]/td[" . ContentPage::$episodesCol . "]");
        $I->see('0', "//tr[5]/td[" . ContentPage::$episodesCol . "]");
    }
    */

    /**
     * TESTRAIL TESTCASE ID: C9178
     *
     * @group test_priority_2
     */
    public function contentEpisodes(ContentSteps $I)
    {
        $I->wantTo('Verify content Episodes show up correctly. - C9178');
        $I->amOnContentPage();
        $I->selectNumberOfItemsPerPage("All");
        $I->clickRandomSeriesWithEpisodes();
        $I->seeCorrectNumberOfEpisodes();

    }


    /**
    * TESTRAIL TESTCASE ID: C225123
    *
    * @group test_priority_2
    */
    /*
    public function publishedStatus(AcceptanceTester $I)
    {
        $I->wantTo('Verify content Published Status show up correctly. - C225123');
        $I->amOnPage(ContentPage::$URL);
        $I->wait(3);
        $I->waitForElementVisible("//tbody/tr");

        $I->see('100%', "//tr[1]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->see('100%', "//tr[2]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->see('0%', "//tr[3]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->see('0%', "//tr[4]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->see('0%', "//tr[5]/td[" . ContentPage::$publishedPercentCol . "]");
    }
    */

    /**
     * TESTRAIL TESTCASE ID: C225123
     *
     * @group test_priority_2
     */
    public function publishedStatus(ContentSteps $I)
    {
        $I->wantTo('Verify content Published Status show up correctly. - C225123');
        $I->amOnContentPage();
        $I->see('Published');
        $I->seePublishedPercentage();
    }


    /**
    * TESTRAIL TESTCASE ID: C214839
    *
    * @group test_priority_2
    */
    /*
    public function transcodeStatus(AcceptanceTester $I)
    {
        $I->wantTo('Verify content Transcode Status show up correctly. - C214839');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr");

        $I->see('50%', "//tr[1]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->see('100%', "//tr[2]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->see('N/A', "//tr[3]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->see('100%', "//tr[4]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->see('N/A', "//tr[5]/td[" . ContentPage::$transcodePercentCol . "]");
    }
    */

    /**
     * TESTRAIL TESTCASE ID: C214839
     *
     * @group test_priority_2
     */
    public function transcodeStatus(ContentSteps $I)
    {
        $I->wantTo('Verify content Transcode Status show up correctly. - C214839');
        $I->amOnContentPage();
        $I->see('Transcoded');
        $I->seeTranscodedPercentage();
    }

    /**
     * TESTRAIL TESTCASE ID: C9173
    *
    * @group test_priority_2
    */
    /*
    public function sortContentByTitle(AcceptanceTester $I)
    {
        $I->wantTo('Verify content can be sorted by title. - C9173');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$titleCol . "]");

        $I->waitForText('A CAPITAL SERIES', 30, "//tr[1]/td[" . ContentPage::$titleCol . "]");
        $I->waitForText('a lowercase movie', 30, "//tr[2]/td[" . ContentPage::$titleCol . "]");
        $I->waitForText('AA', 30, "//tr[3]/td[" . ContentPage::$titleCol . "]");
        $I->waitForText('Ab', 30, "//tr[4]/td[" . ContentPage::$titleCol . "]");
        $I->waitForText('AC', 30, "//tr[5]/td[" . ContentPage::$titleCol . "]");

        $I->click("//tr/th[" . ContentPage::$titleCol . "]");

        $I->waitForText('ZZ', 30, "//tr[1]/td[" . ContentPage::$titleCol . "]");
        $I->waitForText('Zy', 30, "//tr[2]/td[" . ContentPage::$titleCol . "]");
        $I->waitForText('ZX', 30, "//tr[3]/td[" . ContentPage::$titleCol . "]");
        $I->waitForText('Y Movie', 30, "//tr[4]/td[" . ContentPage::$titleCol . "]");
        $I->waitForText('X Movie', 30, "//tr[5]/td[" . ContentPage::$titleCol . "]");
    }
    */

    /**
     * TESTRAIL TESTCASE ID: C9173
     *
     * @group test_priority_2
     */
    public function sortContentByTitle(ContentSteps $I)
    {
        $I->wantTo('Verify content can be sorted by title. - C9173');
        $I->amOnContentPage();
        $I->waitForElementVisible(ContentPage::$table_header);
        $I->click(ContentPage::$table_header_title);
        $I->shouldSeeTableSortedByTitle();
        $I->click(ContentPage::$table_header_title);
        $I->shouldSeeTableReverseSortedByTitle();
    }

        /**
    * TESTRAIL TESTCASE ID: C225127
    *
    * @group test_priority_2
    */
    public function sortContentByPublishedPercent(AcceptanceTester $I)
    {
        $I->wantTo('Verify content can be sorted by Published Percent. - C225127');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$publishedPercentCol . "]");

        $I->waitForText('0%', 30, "//tr[1]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->waitForText('0%', 30, "//tr[2]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->waitForText('0%', 30, "//tr[3]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->waitForText('0%', 30, "//tr[4]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->waitForText('0%', 30, "//tr[5]/td[" . ContentPage::$publishedPercentCol . "]");

        $I->click("//tr/th[" . ContentPage::$publishedPercentCol . "]");

        $I->waitForText('100%', 30, "//tr[1]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->waitForText('100%', 30, "//tr[2]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->waitForText('100%', 30, "//tr[3]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->waitForText('100%', 30, "//tr[4]/td[" . ContentPage::$publishedPercentCol . "]");
        $I->waitForText('100%', 30, "//tr[5]/td[" . ContentPage::$publishedPercentCol . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214842
    *
    * @group test_priority_2
    */
    public function sortContentByTranscodePercent(AcceptanceTester $I)
    {
        $I->wantTo('Verify content can be sorted by Transcode Percent. - C214842');
        $I->amOnPage(ContentPage::$URL);

        $I->waitForElementVisible("//tbody/tr");

        $I->click("//tr/th[" . ContentPage::$transcodePercentCol . "]");

        $I->waitForText('0%', 30, "//tr[1]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('0%', 30, "//tr[2]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('0%', 30, "//tr[3]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('0%', 30, "//tr[4]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('0%', 30, "//tr[5]/td[" . ContentPage::$transcodePercentCol . "]");

        $I->click("//tr/th[" . ContentPage::$transcodePercentCol . "]");

        $I->waitForText('N/A', 30, "//tr[1]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('N/A', 30, "//tr[2]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('N/A', 30, "//tr[3]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('N/A', 30, "//tr[4]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('N/A', 30, "//tr[5]/td[" . ContentPage::$transcodePercentCol . "]");
        $I->waitForText('N/A', 30, "//tr[6]/td[" . ContentPage::$transcodePercentCol . "]");
    }

    /**
    * TESTRAIL TESTCASE ID: C36891
    *
    * @group test_priority_2
    */
    public function publishedPercentRoundsDown(AcceptanceTester $I)
    {
        $I->wantTo('Verify Published Percent rounds down. - C36891');
        $I->amOnPage(ContentPage::$URL);

        ContentUtils::findContentItemByTitle($I, 'Test Series Publish Percentages');

        $I->expect('Since 2 of the 3 eps are published, 66.6% rounds down to 66%');
        $I->see('66%', "//span[contains(text(), 'Test Series Publish Percentages')]/../../td[". ContentPage::$publishedPercentCol ."]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214841
    *
    * @group test_priority_2
    */
    public function transcodePercentRoundsDown(AcceptanceTester $I)
    {
        $I->wantTo('Verify Transcode Percent rounds down. - C214841');
        $I->amOnPage(ContentPage::$URL);

        ContentUtils::findContentItemByTitle($I, 'Test Series Transcode Percentages');

        $I->expect('Since 2 of the 3 eps are transcoded, 66.6% rounds down to 66%');
        $I->see('66%', "//span[contains(text(), 'Test Series Transcode Percentages')]/../../td[". ContentPage::$transcodePercentCol ."]");
    }

    /**
    * TESTRAIL TESTCASE ID: C214840
    *
    * @group test_priority_2
    */
    public function transcodeStatusIgnoresExtras(AcceptanceTester $I)
    {
        $I->wantTo('Verify Transcode Percent is not affected by Extras. - C214840');
        $I->amOnPage(ContentPage::$URL);

        ContentUtils::findContentItemByTitle($I, 'Series Transcoding Extras');

        $I->expect('The episode is transcoded by the extra is not. Therefore transcode status is still 100%.');
        $I->see('100%', "//span[contains(text(), 'Series Transcoding Extras')]/../../td[". ContentPage::$transcodePercentCol ."]");
    }

    /**
    * TESTRAIL TESTCASE ID: C15525
    *
    * @group test_priority_2
    */
    public function filterByMediaTypeSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can filter by Media Type Series - C15525');
        $I->amOnPage(ContentPage::$URL);

        $I->amGoingTo('Make sure all content is displayed.');
        ContentUtils::findContentItemByTitle($I, 'ZZ');

        $I->amGoingTo('Open the filter dropdown and select Series.');
        $I->moveMouseOver(ContentPage::$addFilterDropdown);
        $I->waitForElementVisible(ContentPage::$addFilterDropdown_series);
        $I->click(ContentPage::$addFilterDropdown_series);

        $I->expect('Only series appear now.');
        $I->dontSeeElement("//td[text()='Movie']");
    }

    /**
    * TESTRAIL TESTCASE ID: C15526
    *
    * @group test_priority_2
    */
    public function filterByMediaTypeMovie(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can filter by Media Type Movie - C15526');
        $I->amOnPage(ContentPage::$URL);

        $I->amGoingTo('Make sure all content is displayed.');
        ContentUtils::findContentItemByTitle($I, 'ZZ');

        $I->amGoingTo('Open the filter dropdown and select Movie.');
        $I->moveMouseOver(ContentPage::$addFilterDropdown);
        $I->waitForElementVisible(ContentPage::$addFilterDropdown_movie);
        $I->click(ContentPage::$addFilterDropdown_movie);

        $I->expect('Only movies appear now.');
        $I->dontSeeElement("//td[text()='Series']");
    }

    /**
    * TESTRAIL TESTCASE ID: C15527
    *
    * @group test_priority_2
    */
    public function filterByMediaTypeRemoveFilter(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can remove a set Media Type filter - C15527');
        $I->amOnPage(ContentPage::$URL);

        $I->amGoingTo('Make sure all content is displayed.');
        ContentUtils::findContentItemByTitle($I, 'ZZ');

        $I->amGoingTo('Open the filter dropdown and select Series.');
        $I->moveMouseOver(ContentPage::$addFilterDropdown);
        $I->waitForElementVisible(ContentPage::$addFilterDropdown_series);
        $I->click(ContentPage::$addFilterDropdown_series);

        $I->expect('Only series appear now.');
        $I->dontSeeElement("//td[text()='Movie']");

        $I->amGoingTo('Remove the filter.');
        $I->moveMouseOver(ContentPage::$addFilterDropdown);
        $I->waitForElementVisible(ContentPage::$addFilterDropdown_remove);
        $I->click(ContentPage::$addFilterDropdown_remove);

        $I->expect('Movies reappear.');
        $I->seeElement("//td[text()='Movie']");
    }

    /**
    * TESTRAIL TESTCASE ID: C11005
    *
    * @group test_priority_2
    */
    public function clickMovieRow(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a movie row. - C11005');
        $I->amOnPage(ContentPage::$URL);

        ContentUtils::clickTableRowOfTitle($I, 'a lowercase movie');

        $I->expect('We are taken to the page for movie content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->see('VIDEOS');
        $I->dontSee('EPISODES');
        $I->dontSee('SEASONS');
    }

    /**
    * TESTRAIL TESTCASE ID: C11004
    *
    * @group test_priority_2
    */
    public function clickSeriesRow(AcceptanceTester $I)
    {
        $I->wantTo('Verify we are taken to the right page when clicking a series row. - C11004');
        $I->amOnPage(ContentPage::$URL);

        ContentUtils::clickTableRowOfTitle($I, 'Many Season And Episode');

        $I->expect('We are taken to the page for season list.');
        ContentUtils::findContentItemByTitle($I, 'First');
        ContentUtils::findContentItemByTitle($I, 'Second');
        ContentUtils::findContentItemByTitle($I, 'Season 6');
    }

    /**
    * TESTRAIL TESTCASE ID: C22281
    *
    * @group test_priority_1
    */
    public function clickEditOnMovie(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking the edit icon on a movie takes us to the edit movie page. - C22281');
        $I->amOnPage(ContentPage::$URL);

        ContentUtils::clickEditButtonForTitle($I, 'a lowercase movie');

        $I->expect('We are taken to the page for movie content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->see('VIDEOS');
        $I->see('IMAGES');
        $I->dontSee('EPISODES');
        $I->dontSee('SEASONS');
    }

    /**
    * TESTRAIL TESTCASE ID: C22280
    *
    * @group test_priority_1
    */
    public function clickEditOnSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking the edit icon on a seires takes us to the edit series page. - C22280');
        $I->amOnPage(ContentPage::$URL);
        
        ContentUtils::clickEditButtonForTitle($I, 'Many Season And Episode');

        $I->expect('We are taken to the page for series content.');
        $I->waitForElementVisible(ContentPage::$attributesList, 30);
        $I->waitForText('EPISODES', 30);
        $I->waitForText('SEASONS', 30);
        $I->waitForText('IMAGES', 30);
        $I->waitForText('VIDEOS', 30);
    }

    /**
     * TESTRAIL TESTCASE ID: C225135
     *
     * @group test_priority_2
     */
    public function seeSeriesArt(ContentSteps $I, ContentEditSteps $contentEditSteps) {
        $I->wantTo('Verify if landscape posters appear in the column to the right of the check boxes. - C225135');

        $I->amOnContentPage();
        $I->navigateToContentEditPageWithLandscapePoster();
        $contentEditSteps->shouldSeeLandscapePoster();

        $I->amOnContentPage();
        $I->navigateToContentEditPageWithoutLandscapePoster();
        $contentEditSteps->shouldNotSeeLandscapePoster();
    }

    /**
     * TESTRAIL TESTCASE ID: C15512
     *
     * @group test_priority_2
     */
    public function publishContentMovie(ContentSteps $I, ContentEditSteps $contentEditSteps) {
        $I->wantTo('Verify if user can publish movie from content page - C15512');
        $I->amOnContentPage();
        $guid = $I->selectRandomMovie();
        $I->publishSelectedContent();

        $I->amOnContentPage();
        $I->shouldSeeContentIsPublished($guid);

        $contentEditSteps->unpublishContent($guid);
    }

}
