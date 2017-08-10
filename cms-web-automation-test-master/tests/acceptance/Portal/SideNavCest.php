<?php

class SideNavCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (SideNavCest::$environment == 'undefined')
        {
            SideNavCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        SideNavCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, SideNavCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //Tests
    /**
    * TESTRAIL TESTCASE ID: C9172
    *
    * @group test_priority_2
    */
    public function clickContent(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking Content link in the side nav takes us to the Content page. - C9172');
        $I->amOnPage('/');
        $I->click(SideNavPage::$contentLink);

        $I->expect('We are on the Content page.');
        $I->waitForText('CONTENT', 30, 'ul.breadcrumbs');
        $I->waitForElementVisible('table', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C9179
    *
    * @group test_priority_2
    */
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

    /**
    * TESTRAIL TESTCASE ID: C19528
    *
    * @group test_priority_2
    */
    public function clickChannels(AcceptanceTester $I)
    {
        $I->wantTo('Verify that clicking the Channels link in the side nav takes us to the Channels page. - C19528');
        $I->amOnPage('/');
        $I->click(SideNavPage::$channelsLink);
        $I->expect('We are on the Channel page.');
        $I->waitForText('CHANNELS', 30, 'div');
        $I->waitForElementVisible('div.channels', 30);
    }
}