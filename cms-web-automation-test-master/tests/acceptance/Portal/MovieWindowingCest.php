<?php

class MovieWindowingCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (MovieWindowingCest::$environment == 'undefined')
        {
            MovieWindowingCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        MovieWindowingCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, MovieWindowingCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    /**
    * TESTRAIL TESTCASE ID: C19526
    *
    * @group test_priority_2
    */
    public function togglePremium(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium window can be toggled. - C19526');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C19527
    *
    * @group test_priority_2
    */
    public function toggleFree(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free window can be toggled. - C19527');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15831
    *
    * @group test_priority_2
    */
    public function noUsersCanWatch(AcceptanceTester $I)
    {
        $I->wantTo('Verify the "No users can watch this content" message appears. - C15831');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15833
    *
    * @group test_priority_2
    */
    public function freeUsersCannotWatch(AcceptanceTester $I)
    {
        $I->wantTo('Verify the "Free members cannot watch this content" message appears. - C15833');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$windowing_premiumCheckbox, 30);

        $I->amGoingTo('Uncheck Free');
        $I->moveMouseOver(ContentPage::$windowing_freeCheckbox);
        $I->click(ContentPage::$windowing_freeCheckbox);

        $I->expect('"Free members cannot watch this content" message is visible.');
        $I->waitForText('Free members will be unable to watch this media.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15832
    *
    * @group test_priority_2
    */
    public function premiumUsersCannotWatch(AcceptanceTester $I)
    {
        $I->wantTo('Verify the "Premium members cannot watch this content" message appears. - C15832');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);
        $I->waitForElementVisible(ContentPage::$windowing_premiumCheckbox, 30);

        $I->amGoingTo('Uncheck Premium');
        $I->click(ContentPage::$windowing_premiumCheckbox);

        $I->expect('"Premium members cannot watch this content" message is visible.');
        $I->waitForText('Premium members will be unable to watch this media.', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15834
    *
    * @group test_priority_2
    */
    public function geoLocationFieldUneditable(AcceptanceTester $I)
    {
        $I->wantTo('Verify Geo Location field is not editable. - C15834');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
        }
        $I->amOnPage(ContentPage::$contentUrl . $guid);

        $I->expect('Geo location row is visible, but there is no input.');
        $I->waitForElementVisible(ContentPage::$geoLocationRow, 30);
        $I->dontSeeElement(ContentPage::$geoLocationRow_input);
    }

    /**
    * TESTRAIL TESTCASE ID: C15836
    *
    * @group test_priority_2
    */
    public function setListingBegin(AcceptanceTester $I)
    {
        $I->wantTo('Verify Listing Begin can be set and saved on Movie page. - C15836');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15837
    *
    * @group test_priority_2
    */
    public function clearListingBegin(AcceptanceTester $I)
    {
        $I->wantTo('Verify Listing Begin can be cleared and saved on Movie page. - C15837');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15839
    *
    * @group test_priority_2
    */
    public function setPremiumWatchStart(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium Watch Start can be set and saved on Movie page. - C15839');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15840
    *
    * @group test_priority_2
    */
    public function clearPremiumWatchStart(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium Watch Start can be cleared and saved on Movie page. - C15840');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15843
    *
    * @group test_priority_2
    */
    public function setPremiumWatchEnd(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium Watch End can be set and saved on Movie page. - C15843');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15844
    *
    * @group test_priority_2
    */
    public function clearPremiumWatchEnd(AcceptanceTester $I)
    {
        $I->wantTo('Verify Premium Watch End can be cleared and saved on Movie page. - C15844');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15848
    *
    * @group test_priority_2
    */
    public function setFreeWatchStart(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free Watch Start can be set and saved on Movie page. - C15848');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15849
    *
    * @group test_priority_2
    */
    public function clearFreeWatchStart(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free Watch Start can be cleared and saved on Movie page. - C15849');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15852
    *
    * @group test_priority_2
    */
    public function setFreeWatchEnd(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free Watch End can be set and saved on Movie page. - C15852');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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
    * TESTRAIL TESTCASE ID: C15853
    *
    * @group test_priority_2
    */
    public function clearFreeWatchEnd(AcceptanceTester $I)
    {
        $I->wantTo('Verify Free Watch End can be cleared and saved on Movie page. - C15853');
        if(MovieWindowingCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieEditData_proto0;
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