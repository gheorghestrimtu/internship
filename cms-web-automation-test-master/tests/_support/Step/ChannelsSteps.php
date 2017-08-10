<?php
namespace Step;

use Page\ChannelsPage;

class ChannelsSteps extends \AcceptanceTester {

    public function amOnChannelsPage() {
        $I = $this;
        $I->amOnPage(ChannelsPage::$URL);
    }

    public function shouldSeeListOfChannels() {
        $I = $this;
        foreach (ChannelsPage::$channels as $channel) {
            $channel_row = str_replace('{{channel}}', $channel, ChannelsPage::$channel_row['xpath']);
            $I->waitForElementVisible($channel_row, 30);
        }
        $I->assertGreaterThan(count($I->findElements('xpath', '//table/tbody//tr')), 30);
    }

    public function clickOnAddChannelButton() {
        $I = $this;
        $I->click(ChannelsPage::$add_channel_button);
    }

    public function shouldSeeAddChannelModal() {
        $I = $this;
        $I->waitForElementVisible(ChannelsPage::$new_channel_modal, 30);
    }

    public function clickOnChannelRow() {
        $I = $this;
        $I->waitForElementVisible(ChannelsPage::$partner_channel_row);
        $I->click(ChannelsPage::$partner_channel_row);
    }

    public function clickOnEditChannelButton() {
        $I = $this;
        $I->waitForElementVisible(ChannelsPage::$partner_channel_row);
        $I->moveMouseOver(ChannelsPage::$partner_channel_row);
        $I->waitForElementVisible(ChannelsPage::$partner_channel_edit_button);
        $I->click(ChannelsPage::$partner_channel_edit_button);
    }
}