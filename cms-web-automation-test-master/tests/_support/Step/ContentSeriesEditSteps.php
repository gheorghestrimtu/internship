<?php

namespace Step;

use ContentPage;
use Page\ContentSeriesEditPage;

class ContentSeriesEditSteps extends ContentEditSteps {

    public function amOnSeriesEditPage() {
        $I = $this;
        $I->amOnContentEditPage(ContentSeriesEditPage::getEditGuid());
    }

}