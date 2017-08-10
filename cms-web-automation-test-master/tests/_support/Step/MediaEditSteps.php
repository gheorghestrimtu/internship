<?php
namespace Step;

use Page\VideoEditPage;
use Page\ContentEditPage;

class MediaEditSteps extends \AcceptanceTester {

    public function amOnMediaEditPage($guid) {
        $I = $this;
        $I->amOnPage(str_replace('{{guid}}', $guid, VideoEditPage::$URL));
        $I->wait(2);
    }

    public function scrollToBottom($step, $callback = null) {
        $I = $this;
        $I->scrollBy(0, 1);
        parent::scrollToBottom($step, $callback);
    }

    public function shouldSeeSaveChangesButtonIsVisible() {
        $I = $this;
        $I->seeElement(ContentEditPage::$save_bar['xpath']);
        $saveChanges = $I->findElement(ContentEditPage::$save_bar['xpath']);
        $I->assertTrue($I->isElementInViewport($saveChanges));
    }

}