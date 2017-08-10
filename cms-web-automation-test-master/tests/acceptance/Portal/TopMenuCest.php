<?php

use Step\LoginSteps;
use Step\FeedsAndCollectionsSteps;

class TopMenuCest {

    public function _before(LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: C57536
     *
     * @group test_priority_2
     */
    public function verifyChannelDropdown(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify If all partner channels are listed in the drop-down list of channels. - C57536');
        $I->amOnFeedsPage();
        $I->shouldSeeAllPartnersInChannelDropdown();
    }

    /**
     * TESTRAIL TESTCASE ID: C57537
     *
     * @group test_priority_2
     */
    public function channelSelectionPersist(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify if channel selection persist. - C57537');
        $I->amOnFeedsPage();
        $I->chooseRandomChannel();
        $I->accessRandomSideNavLink();
        $I->shouldSeeSelectedChannelPersist();
    }

}