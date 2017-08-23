<?php
/**
 * Created by PhpStorm.
 * User: gstrimtu
 * Date: 8/16/17
 * Time: 10:31 AM
 */

namespace Step;

use Page\AbstractPage;

class SideNavSteps extends \AcceptanceTester
{
    public function amOnPortalAndContentTestingPage(){
        $I=$this;
        $I->amOnPage(AbstractPage::$PortalAndContentTestingURL);
        $I->waitAjaxLoad();
    }

    public function waitForBreadcrumbs($text){
        $I=$this;
        $I->waitForText($text, 30, AbstractPage::$breadcrumbs);
    }
}