<?php

/**
* This class holds utility functions related to editing content.
*/
class ContentUtils
{
    public static $currentUrl;

    /*-----------LIST PAGES---------------------*/

    /*
    * Finds a row in a content list (Main content page, season list, episode list)  by title
    * and verifies it is visible.
    */
    public function findContentItemByTitle(AcceptanceTester $I, $title)
    {
        $I->amGoingTo('Select All on table dropdown.');
        $I->waitForElementVisible(ContentPage::$scrollableTable, 30);
        $I->selectOption(ContentPage::$pageSelectDropdown, 'All');

        $I->amGoingTo('Wait for ' . $title . ' to be visible.');
        $I->waitForElement(ContentPage::tableRowByTitle($title), 60);
    }

    /*
    * Finds a row in a content list (Main content page, season list, episode list)  by title
    * and clicks it
    */
    public function clickTableRowOfTitle(AcceptanceTester $I, $title)
    {
        $I->amGoingTo('Select All on table dropdown.');
        $I->waitForElementVisible(ContentPage::$scrollableTable, 30);
        $I->selectOption(ContentPage::$pageSelectDropdown, 'All');

        $I->amGoingTo('Wait for ' . $title . ' to be visible and click it.');
        $I->waitForElement(ContentPage::tableRowByTitle($title), 60);
        $I->click(ContentPage::tableRowByTitle($title)); 
    }

    /*
    * Finds a row in a content list (Main content page, season list, episode list)  by title,
    * moves mouse over it for Edit button to appear, then clicks Edit button
    */
    public function clickEditButtonForTitle(AcceptanceTester $I, $title)
    {
        $I->amGoingTo('Select All on table dropdown.');
        $I->waitForElementVisible(ContentPage::$scrollableTable, 30);
        $I->selectOption(ContentPage::$pageSelectDropdown, 'All');

        $I->amGoingTo('Wait for ' . $title . ' to be visible and mouse over it.');

        $I->waitForElement(ContentPage::tableRowByTitle($title), 60);
        $I->moveMouseOver(ContentPage::tableRowByTitle($title));

        $I->amGoingTo('Wait for edit button to appear and click it.');
        $I->waitForElementVisible(ContentPage::tableRowEditBtnByTitle($title), 60);
        $I->click(ContentPage::tableRowEditBtnByTitle($title));

    }


    /*--------------EDIT PAGES-------------------*/

    /**
    * Saves changes and reloads current url
    */
    public function saveAndReload(AcceptanceTester $I)
    {
        $I->amGoingTo('Save Changes');
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Get current URL so we can reload the page.');
        $I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver)
        {
          ContentUtils::$currentUrl = $webdriver->getCurrentUrl();
          ContentUtils::$currentUrl = explode('.com', ContentUtils::$currentUrl)[1];
        });
        $I->amOnPage(ContentUtils::$currentUrl);
    }

    /**
    * $inputToSet - The web element for the input being set. Ie, Listing Begin
    * $monthYear - The month and year as it appears atop the calendar widget
    * $dayOfMonth - The day of the month we are setting the date to
    * $formattedDate - The date as it appears in the input once date is set
    * $pastOrFuture - 'past' = this date is in the past. 'future' = this date is in the future
    *
    * This function opens the calendar, sets the date, then verifies the formatted date is showing up. It does not save the date.
    */
    public function setDate(AcceptanceTester $I, $inputToSet, $monthYear, $dayOfMonth, $formattedDate, $pastOrFuture) {
        $I->amGoingTo('Open calendar');
        $I->wait(5);
        $I->scrollTo($inputToSet);
        $I->click($inputToSet);
        $I->waitForElementVisible(ContentPage::$calendar_main, 30);

        if (ContentUtils::isFuture($dayOfMonth . ' ' . $monthYear, $I->grabValueFrom($inputToSet))) {
            $button = ContentPage::$calendar_nextBtn;
        } else {
            $button = ContentPage::$calendar_prevBtn;
        }

        $I->amGoingTo('Set the date for ' . $dayOfMonth . 'th of ' . $monthYear);
        $calendar = $I->findElement(ContentPage::$calendar_main_xpath);
        $caption = $I->findElementInElement($calendar, ContentPage::$calendar_caption_xpath);
        for ($u=0; $u < 24; $u++) {
            $I->see($caption->getText());

            if(!AcceptanceUtils::checkIfElementVisible($I, "//div[contains(text(), '" . $monthYear . "')]")) {
                $I->scrollTo($button);
                $I->click($button);
                $I->wait(3);
            } else {
                $I->wait(10); //Avoid stale elements
                break;
            }
        }
        $I->click("//div[contains(@class, 'DayPicker-Body')]//div[text()='" . $dayOfMonth . "']");

        $I->expect('Correct date shows up in field.');
        $I->wait(5);
        $I->seeInField($inputToSet, $formattedDate);
        $I->wait(1);

        $I->amGoingTo('Click OK on the calendar.');
        $I->click(ContentPage::$calendar_confirm);
    }

    function isFuture($time, $now = 'today') {
        $now = strtotime($now);
        $now = $now ? $now : strtotime('today');
        return strtotime($time) > $now;
    }
}
?>
