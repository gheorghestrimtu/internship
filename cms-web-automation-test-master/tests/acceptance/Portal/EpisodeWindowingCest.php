<?php

class EpisodeWindowingCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (EpisodeWindowingCest::$environment == 'undefined')
        {
            EpisodeWindowingCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        EpisodeWindowingCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, EpisodeWindowingCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
    * TESTRAIL TESTCASE ID: C15856
    *
    * @group test_priority_2
    */
    public function openCalendar(AcceptanceTester $I)
    {
        $I->wantTo('Verify calendar can be opened. - C15856');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Click an input to open the calendar.');
        $I->waitForElementVisible(ContentPage::$windowing_listingBegin_input, 30);
        $I->click(ContentPage::$windowing_listingBegin_input);

        $I->expect('Calendar appears.');
        $I->waitForElementVisible(ContentPage::$calendar_main, 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15859
    *
    * @group test_priority_2
    */
    public function clickOkayOnCalendar(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can set a date by clicking Okay on calendar. - C15859');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        ContentUtils::setDate($I, ContentPage::$windowing_listingBegin_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');

        $I->expect('Date is populated into field.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Oct 15, 2016 00:00 EDT');
    }

    /**
    * TESTRAIL TESTCASE ID: C15860
    *
    * @group test_priority_2
    */
    public function clickCancelOnCalendar(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can hit Cancel on calendar and prevent new date from appearing. - C15860');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Open calendar');
        $I->click(ContentPage::$windowing_listingBegin_input);
        $I->waitForElementVisible(ContentPage::$calendar_main, 30);

        $I->amGoingTo('Go back a month and click a day.');
        $I->click(ContentPage::$calendar_prevBtn);
        $I->click("//*[text()='14']");

        $I->amGoingTo('Hit Cancel');
        $I->click(ContentPage::$calendar_cancel);

        $I->expect('Calendar is closed and date is not set.');
        $I->waitForElementNotVisible(ContentPage::$calendar_main, 30);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Now');
    }

    /**
    * TESTRAIL TESTCASE ID: C15861
    *
    * @group test_priority_2
    */
    public function flipCalendarMonths(AcceptanceTester $I)
    {
        $I->wantTo('Verify calendar months can be flipped - C15861');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->amGoingTo('Set a date in the future');
        ContentUtils::setDate($I, ContentPage::$windowing_freeStartOfWindow_input, 'October 2017', '15', 'Oct 15, 2017 00:00 EDT', 'future');

        $I->amGoingTo('Set a date in the past');
        ContentUtils::setDate($I, ContentPage::$windowing_freeStartOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
    }

    /**
    * TESTRAIL TESTCASE ID: C19524
    *
    * @group test_priority_1
    */
    public function togglePremium(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium window can be toggled. - C19524');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$windowing_premiumCheckbox, 30);

        $I->amGoingTo('Click Premium box');
        $I->click(ContentPage::$windowing_premiumCheckbox);

        $I->expect('Premium checkbox is unchecked.');
        $I->waitForElementNotVisible(ContentPage::$windowing_premiumCheckboxChecked, 30);

        $I->amGoingTo('Click Premium box');
        $I->click(ContentPage::$windowing_premiumCheckbox);

        $I->expect('Premium checkbox is checked.');
        $I->waitForElementVisible(ContentPage::$windowing_premiumCheckboxChecked, 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C19525
    *
    * @group test_priority_1
    */
    public function toggleFree(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free window can be toggled. - C19525');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$windowing_premiumCheckbox, 30);

        $I->amGoingTo('Click Free box');
        $I->moveMouseOver(ContentPage::$windowing_freeCheckbox);
        $I->click(ContentPage::$windowing_freeCheckbox);

        $I->expect('Free checkbox is unchecked.');
        $I->waitForElementNotVisible(ContentPage::$windowing_freeCheckboxChecked, 30);

        $I->amGoingTo('Click Free box');
        $I->moveMouseOver(ContentPage::$windowing_freeCheckbox);
        $I->click(ContentPage::$windowing_freeCheckbox);

        $I->expect('Free checkbox is checked.');
        $I->waitForElementVisible(ContentPage::$windowing_freeCheckboxChecked, 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15805
    *
    * @group test_priority_1
    */
    public function noUsersCanWatch(AcceptanceTester $I)
    {
        $I->wantTo('Verify the "No users can watch this content" message appears. - C15805');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$windowing_premiumCheckbox, 30);

        $I->amGoingTo('Uncheck Free and Premium');
        $I->click(ContentPage::$windowing_premiumCheckbox);
        $I->click(ContentPage::$windowing_freeCheckbox);

        $I->expect('"No users can watch this content" message is visible. Other messages are not shown.');
        $I->waitForText('No users can watch this content.', 30);
        $I->dontSee('Free members will be unable to watch this media.');
        $I->dontSee('Premium members will be unable to watch this media.');
    }

    /**
    * TESTRAIL TESTCASE ID: C15807
    *
    * @group test_priority_1
    */
    public function freeUsersCannotWatch(AcceptanceTester $I)
    {
        $I->wantTo('Verify the "Free members cannot watch this content" message appears. - C15807');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$windowing_premiumCheckbox, 30);

        $I->amGoingTo('Uncheck Free');
        $I->scrollTo(ContentPage::$windowing_freeCheckbox);
        $I->click(ContentPage::$windowing_freeCheckbox);

        $I->expect('"Free members cannot watch this content" message is visible.');
        $I->waitForText('Free members will be unable to watch this media.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15806
    *
    * @group test_priority_1
    */
    public function premiumUsersCannotWatch(AcceptanceTester $I)
    {
        $I->wantTo('Verify the "Premium members cannot watch this content" message appears. - C15806');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$windowing_premiumCheckbox, 30);

        $I->amGoingTo('Uncheck Free');
        $I->click(ContentPage::$windowing_premiumCheckbox);

        $I->expect('"Premium members cannot watch this content" message is visible.');
        $I->waitForText('Premium members will be unable to watch this media.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15808
    *
    * @group test_priority_2
    */
    public function geoLocationFieldUneditable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Geo Location field is not editable. - C15808');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Geo location row is visible, but there is no input.');
        $I->waitForElementVisible(ContentPage::$geoLocationRow, 30);
        $I->dontSeeElement(ContentPage::$geoLocationRow_input);
    }

    /**
    * TESTRAIL TESTCASE ID: C15810
    *
    * @group test_priority_1
    */
    public function setListingBegin(AcceptanceTester $I)
    {
        $I->wantTo('Verify Listing Begin can be set and saved on Episode page. - C15810');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        ContentUtils::setDate($I, ContentPage::$windowing_listingBegin_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Listing Begins date.');
        $I->click(ContentPage::$windowing_listingBegin_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Now');

        $I->amGoingTo('Save Changes');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Now');
    }

    /**
    * TESTRAIL TESTCASE ID: C15811
    *
    * @group test_priority_1
    */
    public function clearListingBegin(AcceptanceTester $I)
    {
        $I->wantTo('Verify Listing Begin can be cleared and saved on Episode page. - C15811');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_listingBegin_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Listing Begins date.');
        $I->click(ContentPage::$windowing_listingBegin_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Now');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_listingBegin_input, 'Now');
    }

    /**
    * TESTRAIL TESTCASE ID: C15813
    *
    * @group test_priority_1
    */
    public function setPremiumWatchStart(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium Watch Start can be set and saved on Episode page. - C15813');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_premiumStartOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Premium Watch Start date.');
        $I->click(ContentPage::$windowing_premiumStartOfWindow_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, 'Now');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, 'Now');
    }

    /**
    * TESTRAIL TESTCASE ID: C15814
    *
    * @group test_priority_1
    */
    public function clearPremiumWatchStart(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium Watch Start can be cleared and saved on Episode page. - C15814');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_premiumStartOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Premium Watch Start date.');
        $I->click(ContentPage::$windowing_premiumStartOfWindow_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, 'Now');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_premiumStartOfWindow_input, 'Now');
    }

    /**
    * TESTRAIL TESTCASE ID: C15817  
    *
    * @group test_priority_1
    */
    public function setPremiumWatchEnd(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium Watch End can be set and saved on Episode page. - C15817');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_premiumEndOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Premium Watch End date.');
        $I->click(ContentPage::$windowing_premiumEndOfWindow_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, 'Never');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C15818
    *
    * @group test_priority_1
    */
    public function clearPremiumWatchEnd(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium Watch End can be cleared and saved on Episode page. - C15818');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_premiumEndOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Premium Watch End date.');
        $I->click(ContentPage::$windowing_premiumEndOfWindow_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, 'Never');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_premiumEndOfWindow_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C15822
    *
    * @group test_priority_1
    */
    public function setFreeWatchStart(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free Watch Start can be set and saved on Episode page. - C15822');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_freeStartOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Free Watch Start date.');
        $I->click(ContentPage::$windowing_freeStartOfWindow_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, 'Now');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, 'Now');
    }

    /**
    * TESTRAIL TESTCASE ID: C15823
    *
    * @group test_priority_1
    */
    public function clearFreeWatchStart(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free Watch Start can be cleared and saved on Episode page. - C15823');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_freeStartOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Free Watch Start date.');
        $I->click(ContentPage::$windowing_freeStartOfWindow_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, 'Now');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_freeStartOfWindow_input, 'Now');
    }

    /**
    * TESTRAIL TESTCASE ID: C15826  
    *
    * @group test_priority_1
    */
    public function setFreeWatchEnd(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free Watch End can be set and saved on Episode page. - C15826');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_freeEndOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Free Watch End date.');
        $I->click(ContentPage::$windowing_freeEndOfWindow_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, 'Never');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, 'Never');
    }

    /**
    * TESTRAIL TESTCASE ID: C15827
    *
    * @group test_priority_1
    */
    public function clearFreeWatchEnd(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free Watch End can be cleared and saved on Episode page. - C15827');
        if(EpisodeWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        ContentUtils::setDate($I, ContentPage::$windowing_freeEndOfWindow_input, 'October 2016', '15', 'Oct 15, 2016 00:00 EDT', 'past');
        ContentUtils::saveAndReload($I);

        $I->expect('Date is saved.');
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, 'Oct 15, 2016 00:00 EDT');

        $I->amGoingTo('Clear the Free Watch End date.');
        $I->click(ContentPage::$windowing_freeEndOfWindow_clear);
        $I->wait(1);
        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, 'Never');

        ContentUtils::saveAndReload($I);

        $I->seeInField(ContentPage::$windowing_freeEndOfWindow_input, 'Never');
    }
}