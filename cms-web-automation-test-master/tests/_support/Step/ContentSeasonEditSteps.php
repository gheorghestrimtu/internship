<?php
namespace Step;

use ContentPage;
use Page\ContentSeasonEditPage;

class ContentSeasonEditSteps extends ContentEditSteps {

    public function amOnSeasonEditPage() {
        $I = $this;
        $I->amOnContentEditPage(ContentSeasonEditPage::getEditGuid());
    }

}