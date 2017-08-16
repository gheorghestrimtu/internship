<?php

use \Page\SideNavPage;
use \Step\SideNavSteps;
use \Step\LoginSteps;

class SideNavCest
{
    public function _before(LoginSteps $I)
    {
        $I->login();
    }

    //Tests
    /**
    * TESTRAIL TESTCASE ID: C9172
    *
    * @group test_priority_2
    */
    /*
    public function clickContent(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking Content link in the side nav takes us to the Content page. - C9172');
        $I->amOnPage('/');
        $I->click(SideNavPage::$contentLink);

        $I->expect('We are on the Content page.');
        $I->waitForText('CONTENT', 30, 'ul.breadcrumbs');
        $I->waitForElementVisible('table', 30);
    }*/

    /**
    * TESTRAIL TESTCASE ID: C9179
    *
    * @group test_priority_2
    */
    /*
    public function clickFeed(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking Feed link in the side nav takes us to the Feed page. - C9179');
        $I->amOnPage(ContentPage::$URL);
        $I->click(SideNavPage::$feedLink);
        $I->expect('We are on the Feeds & Lists page.');
        $I->waitForText('FEEDS', 30, 'div');
        $I->wait(2);
        $I->waitForElementVisible(FeedsAndListsPage::$firstFeed_container, 30);
    }
    */

    /**
    * TESTRAIL TESTCASE ID: C19528
    *
    * @group test_priority_2
    */
    /*
    public function clickChannels(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking the Channels link in the side nav takes us to the Channels page. - C19528');
        $I->amOnPage('/');
        $I->click(SideNavPage::$channelsLink);
        $I->expect('We are on the Channel page.');
        $I->waitForText('CHANNELS', 30, 'div');
        $I->waitForElementVisible('div.channels', 30);
    }*/

    /**
     * TESTRAIL TESTCASE ID: C9172, C9179, C19528
     *
     * @group test_priority_2
     *
     * @example{"item":"Content", "breadcrumbText":"CONTENT", "element":"table", "link":"contentLink", "test_id":"C9172"}
     * @example{"item":"Feed", "breadcrumbText":"FEED", "element":"firstFeedContainer", "link":"feedLink", "test_id":"C9179"}
     * @example{"item":"Channels", "breadcrumbText":"CHANNELS", "element":"channelsContainer", "link":"channelsLink", "test_id":"C19528"}
     *
     */
    public function clickContentFeedChannels(SideNavSteps $I, \Codeception\Example $example)
    {
        $I->wantTo('Verify that clicking '.$example["item"].' link in the side nav takes us to the '.$example["item"].' page. - '.$example["test_id"].' ');
        $I->amOnPortalAndContentTestingPage();
        $I->click(SideNavPage::${$example["link"]});
        $I->waitForBreadcrumbs($example["breadcrumbText"]);
        $I->waitForElementVisible(SideNavPage::${$example["element"]}, 30);
    }
}