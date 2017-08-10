<?php
use \Codeception\Util\Locator;
use Page\FeedsAndCollectionsPage;
use Step\FeedsAndCollectionsSteps;

class FeedCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (FeedCest::$environment == 'undefined')
        {
            FeedCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        FeedCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, FeedCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //Tests
    /**
    * TESTRAIL TESTCASE ID: C10883
    *
    * @group test_priority_2
    */
    public function clickCollectionsFromFeed(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can switch between Feed and Collections tabs. - C10883');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Click the Collections link in the topnav.');
        $I->click('Collections');

        $I->expect('Header is updated.');
        $I->waitForText('COLLECTIONS', 30, 'div');
    }

    /**
    * TESTRAIL TESTCASE ID: C29287
    *
    * @group test_priority_1
    */
    public function feedsAddNewFeed(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can add another Feed. - C29287');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);
        
        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesForFeed_proto0;
        }

        $I->amGoingTo('Get the page content.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$page_content);

        $I->amGoingTo('Add a new feed.');
        $I->click('Create New Feed');
        $I->waitForText('You are creating a new feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, 'Auto Test Feed');
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->expect('We are notified that collection has been created.');
        $I->waitForText('Feed successfully created', 30);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('New feed is saved.');
        $I->see('Auto Test Feed', Locator::lastElement('//div[contains(@class, \'title\')]'));
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Series In Feed For Automation', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Series in feed.', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('series', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Delete Feed')]"));
        $I->seeInPopup('Delete feed - are you sure? There is no undo.');
        $I->acceptPopup();
        $I->waitForText('Feed deleted', 30);
        //Scroll window
        $I->executeJS('window.scrollTo(0,0);');

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The feed list is now in the same state it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$page_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C11057
    *
    * @group test_priority_2
    */
    public function feedsDeleteFeed(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can delete a feed. - C11057');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesForFeed_proto0;
        }

        $I->amGoingTo('Get the content for the Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add a new feed.');
        $I->click('Create New Feed');
        $I->waitForText('You are creating a new feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, 'Auto Test Feed');
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->expect('We are notified that collection has been created.');
        $I->waitForText('Feed successfully created', 30);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('New feed is saved.');
        $I->see('Auto Test Feed', Locator::lastElement('//div[contains(@class, \'title\')]'));
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Series In Feed For Automation', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Series in feed.', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('series', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Delete Feed')]"));
        $I->seeInPopup('Delete feed - are you sure? There is no undo.');
        $I->acceptPopup();
        $I->waitForText('Feed deleted', 30);
        //Scroll window
        $I->executeJS('window.scrollTo(0,0);');

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The feed list is now in the same state it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C29288
    *
    * @group test_priority_3
    */
    public function feedsAddNewFeedEmptyTitle(AcceptanceTester $I)
    {
        $I->wantTo('Verify that Feed cannot be created with an empty title. - C29288');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesForFeed_proto0;
        }

        $I->amGoingTo('Get the content for the Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Try to add a new feed.');
        $I->click('Create New Feed');
        $I->waitForText('You are creating a new feed', 30);
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->expect('We get a popup telling us we need a title.');
        $I->seeInPopup('Please specify a title for the feed to easily identify it.');
        $I->acceptPopup();
        $I->click('i.fa-times');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The feed list is still in the same state it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C29289
    *
    * @group test_priority_3
    */
    public function feedsAddNewFeedNoItems(AcceptanceTester $I)
    {
        $I->wantTo('Verify that Feed cannot be created without any items. - C29289');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Get the content for the Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Try to add a new feed.');
        $I->click('Create New Feed');
        $I->waitForText('You are creating a new feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, 'Auto Test Feed');
        $I->click('Save Changes');
        $I->wait(2);

        $I->expect('We get a popup telling us we need items.');
        $I->seeInPopup('You must add one item to the feed.');
        $I->acceptPopup();
        $I->click('i.fa-times');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The feed list is still in the same state it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C29290
    *
    * @group test_priority_2
    */
    public function feedsAddNewFeedDiscardChanges(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can discard the changes of a feed they are adding. - C29290');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesForFeed_proto0;
        }

        $I->amGoingTo('Get the content for the Feed.');
        $I->wait(2);
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Start to add a new feed.');
        $I->click('Create New Feed');
        $I->waitForText('You are creating a new feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, 'Auto Test Feed');
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('i.fa-times');

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The feed list is now in the same state it was originally.');
        $I->wait(2);
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C29293
    *
    * @group test_priority_3
    */
    public function feedsCancelDelete(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can cancel the deletion of a feed. - C29293');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Get the content for the Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Attempt to delete the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Delete Feed')]"));
        $I->seeInPopup('Delete feed - are you sure? There is no undo.');
        $I->cancelPopup();
        $I->wait(3);
        $I->dontSee('Feed deleted');
        //Scroll window
        $I->executeJS('window.scrollTo(0,0);');

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The feed list is still in the same state it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C29284
    *
    * @group test_priority_2
    */
    public function feedsAddSecondFeed(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can delete a feed. - C29284');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesForFeed_proto0;
        }

        $I->amGoingTo('Get the content for the Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('See there is an additonal feed already present.');
        $I->waitForElementVisible(FeedsAndListsPage::$feed_firstTitle, 30);

        $I->amGoingTo('Add a new feed.');
        $I->click('Create New Feed');
        $I->waitForText('You are creating a new feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, 'Auto Test Feed');
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->expect('We are notified that collection has been created.');
        $I->waitForText('Feed successfully created', 30);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('New feed is saved.');
        $I->see('Auto Test Feed', Locator::lastElement('//div[contains(@class, \'title\')]'));
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Series In Feed for Automation', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Series in feed.', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('series', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Delete Feed')]"));
        $I->seeInPopup('Delete feed - are you sure? There is no undo.');
        $I->acceptPopup();
        $I->waitForText('Feed deleted', 30);
        //Scroll window
        $I->executeJS('window.scrollTo(0,0);');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The feed list is now in the same state it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C29291
    *
    * @group test_priority_2
    */
    public function feedMenuOnPublishedFeed(AcceptanceTester $I)
    {
        $I->wantTo('Verify only the Edit option appears on the published feed. Delete and Publish/Unpublish do not show up. - C29291');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Mouse over the gear icon on the published feed to view the menu.');
        $I->moveMouseOver('i.fa-gear');
        $I->waitForText('Edit Feed', 30, 'div.panel-options');
        $I->see('Customize Feed');
        $I->dontSee('Delete', 'div.panel-options');
        $I->dontSee('Publish', 'div.panel-options');
        $I->dontSee('Unpublish', 'div.panel-options');
    }

    /**
    * TESTRAIL TESTCASE ID: C29292
    *
    * @group test_priority_2
    */
    public function feedMenuOnUnpublishedFeed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Edit, Publish, and Delete appear for Unpublished Feeds. - C29292');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Mouse over the gear icon on the published feed to view the menu.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[2]");
        $I->waitForText('Edit Feed', 30, "(//div[contains(@class, 'panel-options')])[2]");
        $I->see('Customize Feed');
        $I->see('Publish this Feed', "(//div[contains(@class, 'panel-options')])[2]");
        $I->see('Delete Feed', "(//div[contains(@class, 'panel-options')])[2]");
    }

    /**
    * TESTRAIL TESTCASE ID: C9181
    *
    * @group test_priority_1
    */
    public function feedUpdateTitle(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can update the title of a Feed. - C9181');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Change the title of a Feed.');
        $I->moveMouseOver('i.fa-gear');
        $I->waitForText('Edit Feed', 30);
        $I->click('Edit Feed');
        $I->waitForText('You are editing a feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, 'AutomationTitle');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Title has been updated.');
        $I->see('AutomationTitle', FeedsAndListsPage::$feed_firstTitle);

        $I->amGoingTo('Change the title again.');
        $I->moveMouseOver('i.fa-gear');
        $I->waitForText('Edit Feed', 30);
        $I->click('Edit Feed');
        $I->waitForText('You are editing a feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, 'Curated Feed Title');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Title has been updated.');
        $I->see('Curated Feed Title', FeedsAndListsPage::$feed_firstTitle);
    }

    /**
    * TESTRAIL TESTCASE ID: C29294
    *
    * @group test_priority_2
    */
    public function feedEdit(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can bring up the editing modal - C29294');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the edit modal.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->seeElement(FeedsAndListsPage::$feed_titleInput);
    }

    /**
    * TESTRAIL TESTCASE ID: C10987
    *
    * @group test_priority_1
    */
    public function feedDeleteContent(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can delete content from a Feed. - C10987');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesForFeed_proto0;
        }

        $I->amGoingTo('Get the title for the last item in Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add a Series to the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click('div.fa-plus');
        $I->click(Locator::lastElement('//input[contains(@class, \'content-id\')]'));
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Added series shows up correctly at the bottom of the list.');
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Series In Feed For Automation', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Series in feed', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('Series', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the Series.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click(Locator::lastElement('//i[contains(@class, \'fa-times\')]'));
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The last item in the feed is now the same as it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C9185
    *
    * @group test_priority_1
    */
    public function feedAddNewContentSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can add a new Series to a Feed. - C9185');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesForFeed_proto0;
        }

        $I->amGoingTo('Get the title for the last item in Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add a Series to the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click('div.fa-plus');
        $I->click(Locator::lastElement('//input[contains(@class, \'content-id\')]'));
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Added series shows up correctly at the bottom of the list.');
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Series In Feed For Automation', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Series in feed.', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('Series', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the Series.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click(Locator::lastElement('//i[contains(@class, \'fa-times\')]'));
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The last item in the feed is now the same as it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C9600
    *
    * @group test_priority_2
    */
    public function feedAddNewContentSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can add a new Season to a Feed. - C9600');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seasonForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seasonForFeed_proto0;
        }

        $I->amGoingTo('Get the title for the last item in Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add a Season to the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click('div.fa-plus');
        $I->click(Locator::lastElement('//input[contains(@class, \'content-id\')]'));
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Added season shows up correctly at the bottom of the list.');
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Season In Feed For Automation', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Season in feed.', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('Season', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the Season.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click(Locator::lastElement('//i[contains(@class, \'fa-times\')]'));
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The last item in the feed is now the same as it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C9186
    *
    * @group test_priority_2
    */
    public function feedAddNewContentEpisode(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can add a new Episode to a Feed. - C9186');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeForFeed_proto0;
        }

        $I->amGoingTo('Get the title for the last item in Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add an Episode to the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click('div.fa-plus');
        $I->click(Locator::lastElement('//input[contains(@class, \'content-id\')]'));
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Added episode shows up correctly at the bottom of the list.');
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Episode In Feed For Automation', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Episode in feed.', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('Episode', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the Episode.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click(Locator::lastElement('//i[contains(@class, \'fa-times\')]'));
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The last item in the feed is now the same as it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C9187
    *
    * @group test_priority_2
    */
    public function feedAddNewContentMovie(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can add a new Movie to a Feed. - C9187');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieForFeed_proto0;
        }

        $I->amGoingTo('Get the title for the last item in Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add a Movie to the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click('div.fa-plus');
        $I->click(Locator::lastElement('//input[contains(@class, \'content-id\')]'));
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Added movie shows up correctly at the bottom of the list.');
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Movie In Feed For Automation', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Movie in feed.', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('Movie', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the Movie.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click(Locator::lastElement('//i[contains(@class, \'fa-times\')]'));
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The last item in the feed is now the same as it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C15797
    *
    * @group test_priority_2
    */
    public function feedAddNewContentChannelAsAdmin(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can add a new Channel to a Feed. - C15797');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$channelForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$channelForFeed_proto0;
        }

        $I->amGoingTo('Get the title for the last item in Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add a Channel to the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click('div.fa-plus');
        $I->click(Locator::lastElement('//input[contains(@class, \'content-id\')]'));
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Added channel shows up correctly at the bottom of the list.');
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Crunchyroll', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('Crunchyroll is a leading global', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('Channel', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the Channel.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click(Locator::lastElement('//i[contains(@class, \'fa-times\')]'));
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The last item in the feed is now the same as it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C9188
    *
    * @group test_priority_2
    */
    public function feedAddNewCollection(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can add a new Curated Feed to a Feed. - C9188');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$collectionForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$collectionForFeed_proto0;
        }

        $I->amGoingTo('Get the title for the last item in Feed.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add a Collection to the feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click('div.fa-plus');
        $I->click(Locator::lastElement('//input[contains(@class, \'content-id\')]'));
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Added collection shows up correctly at the bottom of the list.');
        $I->seeInField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->see('Automation Collection', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]'));
        $I->see('To test collections in feeds. Do not edit.', Locator::lastElement('//h3[contains(@class, \'entry-comment\')]'));
        $I->see('Collection', Locator::lastElement('//li[contains(@class, \'feed-list-entry\')]/div/span'));

        $I->amGoingTo('Delete the Collection.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->click(Locator::lastElement('//i[contains(@class, \'fa-times\')]'));
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The last item in the feed is now the same as it was originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C11058
    *
    * @group test_priority_3
    */
    public function feedClearTitle(AcceptanceTester $I)
    {
        $I->wantTo('Verify that the Feed does not save a blank title. - C11058');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Grab the text of the title.');
        $originalTitle = $I->grabAttributeFrom(Locator::lastElement("//div[contains(@class, 'title')]"), 'value');

        $I->amGoingTo('Clear the title of the Feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, '');
        $I->click('Save Changes');
        $I->wait(2);

        $I->expect('A popup tells us we cannot have a blank title.');
        $I->seeInPopup('Please specify a title for the feed to easily identify it.');
        $I->acceptPopup();
        $I->click('i.fa-times');

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The old title is still present.');
        $I->see($originalTitle, Locator::lastElement("//div[contains(@class, 'title')]"));
    }

    /**
    * TESTRAIL TESTCASE ID: C29295
    *
    * @group test_priority_3
    */
    public function feedClearAllItems(AcceptanceTester $I)
    {
        $I->wantTo('Verify that the Feed does not save after clearing out all items. - C29295');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Grab the text of the title.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Clear the items of the Feed.');
        $I->moveMouseOver('(//i[contains(@class, \'fa-gear\')])[2]');
        $I->waitForElementVisible("(//a[contains(text(), 'Edit Feed')])[2]", 30);
        $I->click("(//a[contains(text(), 'Edit Feed')])[2]");
        $I->waitForText('You are editing a feed', 30);
        $I->click("(//i[contains(@class, 'fa-times')])[2]");
        $I->click('Save Changes');
        $I->wait(2);

        $I->expect('A popup tells us we need items.');
        $I->seeInPopup('You must add one item to the feed.');
        $I->acceptPopup();
        $I->click('i.fa-times');

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The old feed is still present.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    /**
    * TESTRAIL TESTCASE ID: C29296
    *
    * @group test_priority_2
    */
    public function feedEditDiscardChanges(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can discard changes to a feed when editing. - C29296');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        if(FeedCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesForFeed_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesForFeed_proto0;
        }

        $I->amGoingTo('Get the state of the feeds.');
        $originalState = $I->grabTextFrom(FeedsAndListsPage::$feed_content);

        $I->amGoingTo('Add an item and change title of feed.');
        $I->moveMouseOver(Locator::lastElement('//i[contains(@class, \'fa-gear\')]'));
        $I->waitForElementVisible(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"), 30);
        $I->click(Locator::lastElement("//a[contains(text(), 'Edit Feed')]"));
        $I->waitForText('You are editing a feed', 30);
        $I->fillField(FeedsAndListsPage::$feed_titleInput, 'This wont save');
        $I->click('div.fa-plus');
        $I->click(Locator::lastElement('//input[contains(@class, \'content-id\')]'));
        $I->fillField(Locator::lastElement('//input[contains(@class, \'content-id\')]'), $guid);
        $I->click('i.fa-times');
        $I->wait(3);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('The feeds are in the same state they were originally.');
        $I->assertEquals($originalState, $I->grabTextFrom(FeedsAndListsPage::$feed_content));
    }

    //CUSTOMIZATION
    /**
    * TESTRAIL TESTCASE ID: C50154
    *
    * @group test_priority_1
    */
    public function customizeFeedDisplay(AcceptanceTester $I)
    {
        $I->wantTo('Verify clicking Customize Feed opens the relevant modal. - C50154');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->expect('Customize modal is displayed.');
        $I->waitForText('You are customizing the feed:', 30);
        $I->seeElement('div.entry-details');

        $I->expect('Since we opened this directly, there is no option to return to the edit modal.');
        $I->dontSee("Don't Customize");
    }

    /**
    * TESTRAIL TESTCASE ID: C50155
    *
    * @group test_priority_2
    */
    public function customizeFeedDiscardChanges(AcceptanceTester $I)
    {
        $I->wantTo('Verify clicking Discard Changes closes the customize modal. - C50155');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->expect('Customize modal is displayed.');
        $I->waitForText('You are customizing the feed:', 30);

        $I->amGoingTo('Close the modal.');
        $I->click('i.fa-times');
        $I->wait(3);

        $I->expect('Modal is now gone.');
        $I->dontSee('You are customizing the feed:');
    }

    /**
    * TESTRAIL TESTCASE ID: C50156
    *
    * @group test_priority_2
    */
    public function customizeFeedFromEditModal(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can get to the Customize Feed modal from the Edit modal. - C50156');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Edit modal.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Edit Feed', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Edit Feed')])[3]");

        $I->expect('Edit modal is displayed.');
        $I->waitForText('You are editing a feed', 30);

        $I->amGoingTo('Switch to the Customize Feed modal.');
        $I->click('Customize Feed Display');

        $I->expect('Customize modal is displayed.');
        $I->waitForText('You are customizing the feed:', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C50157
    *
    * @group test_priority_2
    */
    public function customizeFeedDontCustomizeUpperLeft(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can click the Dont Customize option in the upper left and be returned to the Edit modal. - C50157');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Edit modal.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Edit Feed', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Edit Feed')])[3]");

        $I->expect('Edit modal is displayed.');
        $I->waitForText('You are editing a feed', 30);

        $I->amGoingTo('Switch to the Customize Feed modal.');
        $I->click('Customize Feed Display');

        $I->expect('Customize modal is displayed.');
        $I->waitForText('You are customizing the feed:', 30);

        $I->amGoingTo('Click the Dont Customize link in the upper left.');
        $I->click("Don't Customize");

        $I->expect('Edit modal is displayed.');
        $I->waitForText('You are editing a feed', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C50158
    *
    * @group test_priority_2
    */
    public function customizeFeedDontCustomizeBottom(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can click the Dont Customize option on the bottom and be returned to the Edit modal. - C50158');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Edit modal.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Edit Feed', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Edit Feed')])[3]");

        $I->expect('Edit modal is displayed.');
        $I->waitForText('You are editing a feed', 30);

        $I->amGoingTo('Switch to the Customize Feed modal.');
        $I->click('Customize Feed Display');

        $I->expect('Customize modal is displayed.');
        $I->waitForText('You are customizing the feed:', 30);

        $I->amGoingTo('Click the Dont Customize link on the bottom.');
        $I->click("//a[contains(text(), \"Don't Customize\")]");

        $I->expect('Edit modal is displayed.');
        $I->waitForText('You are editing a feed', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C50159
    *
    * @group test_priority_1
    */
    public function customizeFeedTitleAndDescription(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can customize the title and description of a feed item. - C50159');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//input", 'Automation title');
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Automation description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//input", 'Automation title');
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Automation description');

        $I->amGoingTo('Edit again');
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//input", 'Custom auto title');
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Custom auto description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//input", 'Custom auto title');
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Custom auto description');
    }

    /**
    * TESTRAIL TESTCASE ID: C50160
    *
    * @group test_priority_2
    * @group disabled
    */
    public function customizeFeedTitleOnly(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can set only a custom title. - C50160');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//input", 'Automation title');
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//textarea", " ");
        $I->pressKey("//div[@class='modal show']//div[@class='entry-details']//textarea", \Facebook\WebDriver\WebDriverKeys::BACKSPACE);
        $I->wait(5);
        $I->click('Save Changes');


        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//input", 'Automation title');
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//textarea", "");
    }

    /**
    * TESTRAIL TESTCASE ID: C50161
    *
    * @group test_priority_2
    */
    public function customizeFeedDescriptionOnly(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can set only a custom description. - C50161');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//input", '');
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Automation description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//input", '');
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Automation description');
    }

    /**
    * TESTRAIL TESTCASE ID: C50175
    *
    * @group test_priority_2
    * @group disabled
    */
    public function customizeFeedClearTitle(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can clear the custom title of an item. - C50175');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//input", 'Automation title');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//input", 'Automation title');

        $I->amGoingTo('Edit again');
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//input", ' ');
        $I->pressKey("//div[@class='modal show']//div[@class='entry-details']//textarea", \Facebook\WebDriver\WebDriverKeys::BACKSPACE);
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->dontSeeInField("//div[@class='modal show']//div[@class='entry-details']//input", 'Automation title');
    }

    /**
    * TESTRAIL TESTCASE ID: C50176
    *
    * @group test_priority_2
    * @group disabled
    */
    public function customizeFeedClearDescription(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can clear the custom description of an item. - C50176');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Automation description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Automation description');

        $I->amGoingTo('Edit again');
        $I->fillField("//div[@class='modal show']//div[@class='entry-details']//textarea", ' ');
        $I->pressKey("//div[@class='modal show']//div[@class='entry-details']//textarea", \Facebook\WebDriver\WebDriverKeys::BACKSPACE);
        $I->wait(5);
        $I->click('div.modal.show');
        $I->wait(5);
        $I->click('Save Changes');
        $I->wait(5);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->dontSeeInField("//div[@class='modal show']//div[@class='entry-details']//textarea", 'Automation description');
    }

    /**
    * TESTRAIL TESTCASE ID: C50162
    *
    * @group test_priority_2
    */
    public function customizeFeedSeriesDisplay(AcceptanceTester $I)
    {
        $I->wantTo('Verify series data displays correctly on Customize Feed modal. - C50162');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->see('SERIES', "//div[@class='modal show']//li[1]");
        $I->see('Series In Feed For Automation', "//div[@class='modal show']//li[1]");
        $I->see('Series in feed.', "//div[@class='modal show']//li[1]");
        $I->seeElement("//div[@class='modal show']//li[1]//input");
        $I->seeElement("//div[@class='modal show']//li[1]//textarea");
    }

    /**
    * TESTRAIL TESTCASE ID: C50163
    *
    * @group test_priority_2
    */
    public function customizeFeedSeasonDisplay(AcceptanceTester $I)
    {
        $I->wantTo('Verify season data displays correctly on Customize Feed modal. - C50163');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->see('SEASON', "//div[@class='modal show']//li[2]");
        $I->see('Season In Feed For Automation', "//div[@class='modal show']//li[2]");
        $I->see('Season in feed.', "//div[@class='modal show']//li[2]");
        $I->seeElement("//div[@class='modal show']//li[2]//input");
        $I->seeElement("//div[@class='modal show']//li[2]//textarea");
    }

    /**
    * TESTRAIL TESTCASE ID: C50164
    *
    * @group test_priority_2
    */
    public function customizeFeedEpisodeDisplay(AcceptanceTester $I)
    {
        $I->wantTo('Verify episode data displays correctly on Customize Feed modal. - C50164');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->see('EPISODE S1 E1', "//div[@class='modal show']//li[3]");
        $I->see('Episode In Feed For Automation', "//div[@class='modal show']//li[3]");
        $I->see('Episode in feed.', "//div[@class='modal show']//li[3]");
        $I->see('SERIES', "//div[@class='modal show']//li[3]");
        $I->see('Series In Feed For Automation', "//div[@class='modal show']//li[3]");
        $I->see('Series in feed.', "//div[@class='modal show']//li[3]");
        $I->seeElement("//div[@class='modal show']//li[3]//input");
        $I->seeElement("//div[@class='modal show']//li[3]//textarea");
    }

    /**
    * TESTRAIL TESTCASE ID: C50165
    *
    * @group test_priority_2
    */
    public function customizeFeedMovieDisplay(AcceptanceTester $I)
    {
        $I->wantTo('Verify movie data displays correctly on Customize Feed modal. - C50165');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->see('MOVIE', "//div[@class='modal show']//li[4]");
        $I->see('Movie In Feed For Automation', "//div[@class='modal show']//li[4]");
        $I->see('Movie in feed.', "//div[@class='modal show']//li[4]");
        $I->seeElement("//div[@class='modal show']//li[4]//input");
        $I->seeElement("//div[@class='modal show']//li[4]//textarea");
    }

    /**
    * TESTRAIL TESTCASE ID: C50166
    *
    * @group test_priority_2
    */
    public function customizeFeedChannelDisplay(AcceptanceTester $I)
    {
        $I->wantTo('Verify channel data displays correctly on Customize Feed modal. - C50166');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->see('CHANNEL', "//div[@class='modal show']//li[5]");
        $I->see('Crunchyroll', "//div[@class='modal show']//li[5]");
        $I->see('Crunchyroll is a leading global destination', "//div[@class='modal show']//li[5]");
        $I->seeElement("//div[@class='modal show']//li[5]//input");
        $I->seeElement("//div[@class='modal show']//li[5]//textarea");
    }

    /**
    * TESTRAIL TESTCASE ID: C50167
    *
    * @group test_priority_2
    */
    public function customizeFeedCollectionDisplay(AcceptanceTester $I)
    {
        $I->wantTo('Verify collection data displays correctly on Customize Feed modal. - C50167');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->see('COLLECTION', "//div[@class='modal show']//li[6]");
        $I->see('Automation Collection', "//div[@class='modal show']//li[6]");
        $I->see('To test collections in feeds. Do not edit.', "//div[@class='modal show']//li[6]");
        $I->dontSeeElement("//div[@class='modal show']//li[6]//input");
        $I->dontSeeElement("//div[@class='modal show']//li[6]//textarea");
        $I->see('No optional title and description for collection.');
    }

    /**
    * TESTRAIL TESTCASE ID: C50168
    *
    * @group test_priority_2
    */
    public function customizeFeedSeries(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can customize the title and description of a series feed item. - C50168');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//li[1]//input", 'Automation series title');
        $I->fillField("//div[@class='modal show']//li[1]//textarea", 'Automation series description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[1]//input", 'Automation series title');
        $I->seeInField("//div[@class='modal show']//li[1]//textarea", 'Automation series description');

        $I->amGoingTo('Edit again');
        $I->fillField("//div[@class='modal show']//li[1]//input", 'Custom series auto title');
        $I->fillField("//div[@class='modal show']//li[1]//textarea", 'Custom series auto description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[1]//input", 'Custom series auto title');
        $I->seeInField("//div[@class='modal show']//li[1]//textarea", 'Custom series auto description');
    }

    /**
    * TESTRAIL TESTCASE ID: C50169
    *
    * @group test_priority_2
    */
    public function customizeFeedSeason(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can customize the title and description of a season feed item. - C50169');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//li[2]//input", 'Automation season title');
        $I->fillField("//div[@class='modal show']//li[2]//textarea", 'Automation season description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[2]//input", 'Automation season title');
        $I->seeInField("//div[@class='modal show']//li[2]//textarea", 'Automation season description');

        $I->amGoingTo('Edit again');
        $I->fillField("//div[@class='modal show']//li[2]//input", 'Custom season auto title');
        $I->fillField("//div[@class='modal show']//li[2]//textarea", 'Custom season auto description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[2]//input", 'Custom season auto title');
        $I->seeInField("//div[@class='modal show']//li[2]//textarea", 'Custom season auto description');
    }

    /**
    * TESTRAIL TESTCASE ID: C50170
    *
    * @group test_priority_2
    */
    public function customizeFeedEpisode(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can customize the title and description of a episode feed item. - C50170');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//li[3]//input", 'Automation episode title');
        $I->fillField("//div[@class='modal show']//li[3]//textarea", 'Automation episode description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[3]//input", 'Automation episode title');
        $I->seeInField("//div[@class='modal show']//li[3]//textarea", 'Automation episode description');

        $I->amGoingTo('Edit again');
        $I->fillField("//div[@class='modal show']//li[3]//input", 'Custom episode auto title');
        $I->fillField("//div[@class='modal show']//li[3]//textarea", 'Custom episode auto description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[3]//input", 'Custom episode auto title');
        $I->seeInField("//div[@class='modal show']//li[3]//textarea", 'Custom episode auto description');
    }

    /**
    * TESTRAIL TESTCASE ID: C50171
    *
    * @group test_priority_2
    */
    public function customizeFeedMovie(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can customize the title and description of a movie feed item. - C50171');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//li[4]//input", 'Automation movie title');
        $I->fillField("//div[@class='modal show']//li[4]//textarea", 'Automation movie description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[4]//input", 'Automation movie title');
        $I->seeInField("//div[@class='modal show']//li[4]//textarea", 'Automation movie description');

        $I->amGoingTo('Edit again');
        $I->fillField("//div[@class='modal show']//li[4]//input", 'Custom movie auto title');
        $I->fillField("//div[@class='modal show']//li[4]//textarea", 'Custom movie auto description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[4]//input", 'Custom movie auto title');
        $I->seeInField("//div[@class='modal show']//li[4]//textarea", 'Custom movie auto description');
    }

    /**
    * TESTRAIL TESTCASE ID: C50172
    *
    * @group test_priority_2
    */
    public function customizeFeedChannel(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can customize the title and description of a channel feed item. - C50172');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->amGoingTo('Open the Customize modal and change title/description.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");

        $I->waitForText('You are customizing the feed:', 30);
        $I->fillField("//div[@class='modal show']//li[5]//input", 'Automation channel title');
        $I->fillField("//div[@class='modal show']//li[5]//textarea", 'Automation channel description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[5]//input", 'Automation channel title');
        $I->seeInField("//div[@class='modal show']//li[5]//textarea", 'Automation channel description');

        $I->amGoingTo('Edit again');
        $I->fillField("//div[@class='modal show']//li[5]//input", 'Custom channel auto title');
        $I->fillField("//div[@class='modal show']//li[5]//textarea", 'Custom channel auto description');
        $I->click('Save Changes');
        $I->wait(3);

        $I->amGoingTo('Reload page.');
        $I->amOnPage(FeedsAndListsPage::$URL);
        $I->waitForElement(FeedsAndListsPage::$firstFeed_container, 30);

        $I->expect('Changes have been saved.');
        $I->moveMouseOver("(//i[contains(@class, 'fa-gear')])[3]");
        $I->waitForText('Customize Feed Display', 30, "(//div[contains(@class, 'panel-options')])[3]");
        $I->click("(//a[contains(text(), 'Customize Feed Display')])[3]");
        $I->seeInField("//div[@class='modal show']//li[5]//input", 'Custom channel auto title');
        $I->seeInField("//div[@class='modal show']//li[5]//textarea", 'Custom channel auto description');
    }

    /**
     * TESTRAIL TESTCASE ID: C15802
     *
     * @group test_priority_2
     */
    public function changePromoTitle(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify if user can change Promo Title - C15802');
        $I->amOnFeedsPage();
        $I->openEditModal();
        $I->editFirstFeedPromoTitle();
        $I->clickOnSaveChangesButton();
        $I->amOnFeedsPage();
        $I->shouldSeeNewPromoTitle();
    }

    /**
     * TESTRAIL TESTCASE ID: C29285
     *
     * @group test_priority_2
     */
    public function clearPromoTitle(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify if user can clear Promo Title - C29285');
        $I->amOnFeedsPage();
        $I->openEditModal();
        $I->clearFirstFeedPromoTitle();
        $I->clickOnSaveChangesButton();
        $I->amOnFeedsPage();
        $I->shouldSeePromoTitleWasCleared();
    }

}