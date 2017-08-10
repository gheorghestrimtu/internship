<?php

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //Tests
    /**
    * TESTRAIL TESTCASE ID: C9168
    *
    * @group test_priority_1
    */
    public function validLogin(AcceptanceTester $I)
    {
        $I->wantTo('Verify we can log in. - C9168');
        $I->amOnPage('/');
        $I->wait(5);
        $I->fillField(LoginPage::$username_input, LoginInfo::$username);
        $I->fillField(LoginPage::$password_input, LoginInfo::$password);
        $I->wait(1); //Failsafe to make sure text is entered properly
        $I->click('Log In');

        $I->expect('We are logged in.');
        $I->waitForText('Log Out', 30);

        $I->expect('We are taken to the Feeds page.');
        $I->waitForText('FEEDS', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C9169
    *
    * @group test_priority_2
    */
    public function loginInvalidEmail(AcceptanceTester $I)
    {
        $I->wantTo('Verify user cannot log in with an invalid email. - C9169');
        $I->amOnPage('/');
        $I->fillField(LoginPage::$username_input, 'thisemailisfake@fakeemail.com');
        $I->fillField(LoginPage::$password_input, 'password');
        $I->click('Log In');

        $I->expect('We are shown an error and not logged in.');
        $I->waitForText('Invalid account credentials!', 30, LoginPage::$loginFailedAlert);
    }

    /**
    * TESTRAIL TESTCASE ID: C9170
    *
    * @group test_priority_2
    */
    public function loginInvalidPassword(AcceptanceTester $I)
    {
        $I->wantTo('Verify user cannot log in with an invalid password. - C9170');
        $I->amOnPage('/');
        $I->fillField(LoginPage::$username_input, LoginInfo::$username);
        $I->fillField(LoginPage::$password_input, 'thispasswordiswrong');
        $I->click('Log In');

        $I->expect('We are shown an error and not logged in.');
        $I->waitForText('Invalid account credentials!', 30, LoginPage::$loginFailedAlert);
        $I->seeElement(LoginPage::$username_input);
        $I->seeElement(LoginPage::$password_input);
    }

    /**
    * TESTRAIL TESTCASE ID: C9590
    *
    * @group test_priority_1
    */
    public function logout(AcceptanceTester $I)
    {
        $I->wantTo('Verify user can log out. - C9590');
        $I->amOnPage('/');
        AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, 'undefined');
        $I->click('Log Out');

        $I->expect('We are taken back to the login form.');
        $I->seeElement(LoginPage::$username_input);
        $I->seeElement(LoginPage::$password_input);
    }
}
