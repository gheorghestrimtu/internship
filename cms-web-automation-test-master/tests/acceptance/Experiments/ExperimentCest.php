<?php

use Codeception\Example;

/**
 * Created by PhpStorm.
 * User: gstrimtu
 * Date: 8/8/17
 * Time: 3:10 PM
 */

class ExperimentCest {

    /**
     * @example { "type": "Movie" }
     * @example { "type": "Series" }
     * @example { "type": "Video" }
     * @example { "type": "Seasons"}
     * @example { "type": "Episode"}
     */
    public function tescodtPage(Example $example, AcceptanceTester $I) {
        $I->amOnPage("/");
        $I->fillField(['css' => 'input[type=text]'], 'super.admin@ellation.com');
        $I->fillField(['css' => 'input[type=password]'], 'password');
        $I->click(['css' => 'button[type=submit]']);
        $I->selectOption('select[name=channel]', 'partnertest');
        $I->click('Content', 'nav');
        $I->waitAjaxLoad();

//        $I->waitForElement(['xpath'=> '//table']);

        $I->moveMouseOver(['xpath'=> '//table/tbody/*[contains(., "'.$example['type'].'")][1]']);
        $I->click(['css' => 'i.edit']);
        $I->wait(3);
        $I->see('Created');
        $I->see('Modified');
        $I->see('Modified By');
    }

}

//*[@id="workspace"]/section/main/div/div[4]/table/tbody/tr[1]/td[3]/i
#workspace > section > main > div > div.catalog-body > table > tbody > tr:nth-child(1) > td:nth-child(3) > i
