<?php
namespace Step;

use Page\LoginPage;

class LoginSteps extends \AcceptanceTester {

//    public static $loginCookie = false;

//    public function login() {
//        $I = $this;
//        $I->amOnPage(LoginPage::$URL);
//        if (!self::$loginCookie) {
//            $I->waitForElementVisible(LoginPage::$username_input, 30);
//            $I->fillField(LoginPage::$username_input, USERNAME);
//            $I->fillField(LoginPage::$password_input, PASSWORD);
//            $I->wait(1); //Failsafe to make sure text is entered properly
//            $I->click('Log In');
//            $I->wait(2);
//            $I->waitForText('Log Out', 40);
//            self::$loginCookie = $I->grabCookie('VCMS');
//        }    else {
//             $I->resetCookie('VCMS');
//            $I->setCookie('VCMS', self::$loginCookie);
//            $I->amOnPage('/');
//        }
//        $I->expect('We are logged in.');
//        $I->waitForText('Log Out', 30);
//    }

    public function login() {
        $I = $this;
        if ($I->loadSessionSnapshot('login')) {
            return;
        }
        $I->amOnPage(LoginPage::$URL);
        $I->fillField(LoginPage::$username_input, USERNAME);
        $I->fillField(LoginPage::$password_input, PASSWORD);
        $I->click('Log In');
        $I->expect('We are logged in.');
        $I->waitForText('Log Out', 30);
        $I->saveSessionSnapshot('login');
    }

}