<?php

use \Page\ChannelEditPage;
use \Step\ChannelsSteps;
use \Step\ChannelEditSteps;

class ChannelCest {

    public function _before(\Step\LoginSteps $I) {
        $I->login();
    }

    /**
    * TESTRAIL TESTCASE ID: C15492
    *
    * @group test_priority_1
    */
    public function verifyChannelList(ChannelsSteps $I) {
        $I->wantTo('Verify channel list shows up - C15492');
        $I->amOnChannelsPage();
        $I->shouldSeeListOfChannels();
    }

    /**
    * TESTRAIL TESTCASE ID: C95665
    *
    * @group test_priority_2
    */
    public function verifyAddChannelModal(ChannelsSteps $I) {
        $I->wantTo('Verify Add Channel modal shows up - C95665');
        $I->amOnChannelsPage();
        $I->clickOnAddChannelButton();
        $I->shouldSeeAddChannelModal();
    }

    /**
    * TESTRAIL TESTCASE ID: C50181
    *
    * @group test_priority_2
    */
    public function verifyClickChannelRow(ChannelsSteps $I, ChannelEditSteps $user) {
        $I->wantTo('Verify we can click channel row - C50181');
        $I->amOnChannelsPage();
        $I->clickOnChannelRow();
        $user->shouldBeOnChannelEditPage();
    }

    /**
    * TESTRAIL TESTCASE ID: C50182
    *
    * @group test_priority_2
    */
    public function verifyClickChannelEditButton(ChannelsSteps $I, ChannelEditSteps $user) {
        $I->wantTo('Verify we can click channel edit button - C50182');
        $I->amOnChannelsPage();
        $I->clickOnEditChannelButton();
        $user->shouldBeOnChannelEditPage();
    }

    /**
     * TESTRAIL TESTCASE ID: C15494, C15496, C15497
     *
     * @group test_priority_2
     *
     * @example {"input": "title_input","edited_text": "edited_title_text", "text":"title_text", "category": "title", "test_case_id": "C15494"}
     * @example {"input": "description_input","edited_text": "edited_description_text", "text":"description_text", "category": "description", "test_case_id": "C15496"}
     * @example {"input": "color_input","edited_text": "edited_color", "text":"color_text", "category": "color", "test_case_id": "C15497"}
     */
    public function verifyEditChannel(\Codeception\Example $example, ChannelEditSteps $I) {
        $I->wantTo('Verify we can edit the channel "' . $example['category'] . '" - ' . $example['test_case_id']);
        $I->amOnChannelEditPage();
        $I->editChannel(ChannelEditPage::${$example['input']}, ChannelEditPage::${$example['edited_text']});
        $I->amOnChannelEditPage();
        $I->changesShouldBeSaved(ChannelEditPage::${$example['input']}, ChannelEditPage::${$example['edited_text']});
        $I->editChannel(ChannelEditPage::${$example['input']}, ChannelEditPage::${$example['text']});
        $I->amOnChannelEditPage();
        $I->changesShouldBeSaved(ChannelEditPage::${$example['input']}, ChannelEditPage::${$example['text']});
    }

    /**
     * TESTRAIL TESTCASE ID: C383266
     *
     * @group test_priority_2
     */
    public function verifyStatus(ChannelEditSteps $I) {
        $I->wantTo('Verify on channel edit page if status is "LIVE" or "OFF" - C383266');
        $I->amOnChannelEditPage();
        $I->seeStatus();
    }

}