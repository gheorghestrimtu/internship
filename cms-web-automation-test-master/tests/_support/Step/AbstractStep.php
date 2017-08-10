<?php

namespace Step;

use Codeception\Util\Locator;
use Codeception\Util\Fixtures;
use Page\AbstractPage as Page;

class AbstractStep extends \AcceptanceTester {

    // Top Nav Methods

    public function chooseChannel($channel_name) {
        $I = $this;
        $I->waitForElementVisible(Page::$channel_dropdown);
        $I->selectOption(Page::$channel_dropdown, $channel_name);
    }

    public function chooseRandomChannel() {
        $I = $this;
        $options = array_map('trim', (array)$I->grabMultiple(Page::$channel_dropdown_options));
        $randomChanel = $options[array_rand($options)];

        Fixtures::add('current_channel', $randomChanel);
        $I->chooseChannel($randomChanel);
    }

    public function shouldSeeSelectedChannelPersist() {
        $I = $this;
        $I->waitForElementVisible(Page::$channel_dropdown);
        $I->see(Fixtures::get('current_channel', Page::$channel_dropdown));
    }
  
    public function shouldSeeAllPartnersInChannelDropdown() {
        $I = $this;
        $I->waitForElementVisible(Page::$channel_dropdown);
        $options = array_map('trim', (array)$I->grabMultiple(Page::$channel_dropdown_options));
        foreach (Page::$channels_array as $channel_name) {
            $I->assertContains($channel_name, $options);
        }
    }

    // Side Nav Methods

    public function accessFeed() {
        $I = $this;
        $I->click(Page::$feed_link);
    }

    public function accessContent() {
        $I = $this;
        $I->click(Page::$content_link);
    }

    public function accessChannels() {
        $I = $this;
        $I->click(Page::$channels_link);
    }

    public function accessFTPAccounts() {
        $I = $this;
        $I->click(Page::$ftp_accounts_link);
    }

    public function accessRandomSideNavLink() {
        $I = $this;
        $links = $I->findElements('xpath', Page::$side_nav_links['xpath']);
        $I->click(Locator::elementAt(Page::$side_nav_links['xpath'], rand(1, count($links))));
    }
}