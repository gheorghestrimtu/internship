<?php
namespace Step;

use ContentPage;
use TestContentGuids;

class SeasonEditSteps extends \AcceptanceTester {

    public function amOnSeasonEditPage() {
        if ($this->getScenario()->current('env') == 'proto0') {
            $guid = TestContentGuids::$season_guid_proto0;
        } else {
            $guid = TestContentGuids::$season_guid_staging;
        }

        $I = $this;
        $I->amOnPage(ContentPage::$contentUrl . $guid);
    }

}