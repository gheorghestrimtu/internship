<?php
namespace Step;

use ContentPage;
use TestContentGuids;

class ContentMovieEditSteps extends ContentEditSteps {

    public function amOnMovieEditPage() {
        if ($this->getScenario()->current('env') == 'proto0') {
            $guid = TestContentGuids::$movieViewData_proto0;
        } else {
            $guid = TestContentGuids::$movieViewData_staging;
        }

        $I = $this;
        $I->amOnPage(ContentPage::$contentUrl . $guid);
    }

}