<?php
namespace Step;
use Page\ChannelsPage;
use Page\ChannelEditPage;

class IngestionChannelSteps extends \AcceptanceTester {

    public function amOnChannelPage() {
        $I = $this;
        $I->amOnPage(ChannelsPage::$URL);
    }

    public function amOnChannelEditPage() {
        $I = $this;
        $I->amOnPage(ChannelEditPage::$URL);
    }

    public function seeAutoIngestColumnIsDisplayed() {
        $I = $this;
        $I->seeElement(ChannelsPage::$auto_ingest_column);
    }

    public function seeAutoIngestButtonIsDisplayed() {
        $I = $this;
        $total = 0;
        for ($i=0, $n=count(ChannelsPage::$auto_ingest_button_text); $i<$n; $i++) {
            $total += count($I->findElements('xpath', str_replace(
                '{{text}}',
                ChannelsPage::$auto_ingest_button_text[$i],
                ChannelsPage::$auto_ingest_button['xpath']
            )));
        }
        $I->assertGreaterThan(0, $total);
    }

    public function seeAutoIngestCheckboxIsDisplayed() {
        $I = $this;
        $I->seeElement(ChannelEditPage::$auto_ingest_checkbox);
    }

    public function seeAutoIngestCheckboxToggles() {
        $I = $this;
        $this->seeAutoIngestCheckboxIsDisplayed();
        $I->checkOption(ChannelEditPage::$auto_ingest_checkbox);
        $I->seeCheckboxIsChecked(ChannelEditPage::$auto_ingest_checkbox);
        $I->uncheckOption(ChannelEditPage::$auto_ingest_checkbox);
        $I->dontSeeCheckboxIsChecked(ChannelEditPage::$auto_ingest_checkbox);
    }
  
}