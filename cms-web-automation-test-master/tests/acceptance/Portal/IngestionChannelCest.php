<?php
use  \Step\IngestionChannelSteps;

class IngestionChannelCest {

    public function _before(\Step\LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: C362387
     *
     * @group test_priority_3
     *
     */
    public function verifyAutoIngestColumn(IngestionChannelSteps $I) {
        $I->wantTo('Verify if "Auto Ingest" column is displayed - C362387');
        $I->amOnChannelPage();
        $I->seeAutoIngestColumnIsDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C362388
     *
     * @group test_priority_3
     *
     */
    public function verifyAutoIngestButton(IngestionChannelSteps $I) {
        $I->wantTo('Verify if "Auto Ingest" button ("AUTO" or "MANUAL") is displayed - C362388');
        $I->amOnChannelPage();
        $I->seeAutoIngestButtonIsDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C362389
     *
     * @group test_priority_3
     *
     */
    public function verifyAutoIngestCheckbox(IngestionChannelSteps $I) {
        $I->wantTo('Verify if "Auto Ingest" checkbox is displayed - C362389');
        $I->amOnChannelEditPage();
        $I->seeAutoIngestCheckboxIsDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C602050
     *
     * @group test_priority_3
     *
     */
    public function verifyAutoIngestCheckboxToggles(IngestionChannelSteps $I) {
        $I->wantTo('Verify if "Auto Ingest" checkbox toggles - C602050');
        $I->amOnChannelEditPage();
        $I->seeAutoIngestCheckboxToggles();
    }
  
}