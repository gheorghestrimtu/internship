<?php
namespace Step;

use ContentPage;
use TestContentGuids;

class ContentEpisodeEditSteps extends ContentEditSteps {

    public function amOnEpisodeEditPage() {
        if ($this->getScenario()->current('env') == 'proto0') {
            $guid = TestContentGuids::$episodeViewData_proto0;
        } else {
            $guid = TestContentGuids::$episodeViewData_staging;
        }

        $I = $this;
        $I->amOnPage(ContentPage::$contentUrl . $guid);
    }

}