<?php
namespace Step;

use Page\IngestionDashboardPage;

class IngestionDashboardSteps extends \AcceptanceTester {

    private $temp = [];

    public function seeIngestionTabIsDisplayedInLeftMenu() {
        $I = $this;
        $ingest_tab_name = $I->grabTextFrom(IngestionDashboardPage::$ingest_tab_after_feed);
        $I->assertEquals(IngestionDashboardPage::$ingest_tab_name, $ingest_tab_name);
    }

    public function amOnIngestDashboardPage() {
        $I = $this;
        $I->amOnPage(IngestionDashboardPage::$URL);
    }

    public function accessIngestDashboardPage() {
        $I = $this;
        $I->amOnPage('/');
        $I->click(IngestionDashboardPage::$ingest_tab_after_feed);
    }
  
    public function seeBreadcrumbNavigationIsDisplayed() {
        $I = $this;
        $I->seeElement(IngestionDashboardPage::$ingest_breadcrumb_navigation);
    }

    public function seeTabIsDisplayed($tab) {
        $I = $this;
        $I->waitForElementVisible(IngestionDashboardPage::${$tab}, 30);
        $I->seeElement(IngestionDashboardPage::${$tab});
    }
  
    public function filter($option) {
        $I = $this;
        $I->moveMouseOver(IngestionDashboardPage::$filter);
        $I->click(str_replace('{{text}}', $option, IngestionDashboardPage::$filter_option['xpath']));
        $this->temp['filter'] = $option;
    }
  
    public function accessManifestsSection() {
        $I = $this;
        $I->click(IngestionDashboardPage::$manifests_tab);
    }

    public function seeManifestsSectionRowsDetailsAreDisplayed() {
        $I = $this;
        $index = rand(1, count($I->findElements('xpath', IngestionDashboardPage::$manifests_rows['xpath'])));
        $manifests_row = str_replace('{{index}}', $index, IngestionDashboardPage::$manifests_row['xpath']);
        $I->scrollTo($manifests_row);
        $I->click($manifests_row);
        for ($i=0, $n=count(IngestionDashboardPage::$manifests_row_details_columns_text); $i<$n; $i++) {
            $I->see(IngestionDashboardPage::$manifests_row_details_columns_text[$i]);
        }
    }
  
    public function seeManifestsRowsAreFilteredByPending() {
        $I = $this;
        $not_allowed = $allowed = 0;
        $I->waitForElementVisible(IngestionDashboardPage::$manifests_rows, 30);
        $allowed += count($I->findElements('xpath', IngestionDashboardPage::$manifests_row_status_ready_for_ingest['xpath']));
        $allowed += count($I->findElements('xpath', IngestionDashboardPage::$manifests_row_status_missing_files['xpath']));
        $allowed += count($I->findElements('xpath', IngestionDashboardPage::$manifests_row_status_manifest_error['xpath']));
        $not_allowed += count($I->findElements('xpath', IngestionDashboardPage::$manifests_row_status_processing['xpath']));
        $not_allowed += count($I->findElements('xpath', IngestionDashboardPage::$manifests_row_status_completed['xpath']));
        $not_allowed += count($I->findElements('xpath', IngestionDashboardPage::$manifests_row_status_completed_with_errors['xpath']));
        $not_allowed += count($I->findElements('xpath', IngestionDashboardPage::$manifests_row_status_cancelled['xpath']));
        $I->assertGreaterThan(0, $allowed);
        $I->assertEquals(0, $not_allowed);
    }
  
    public function seeCancelOptionInManifestsSection() {
        $I = $this;
        for ($i=0, $n=count(IngestionDashboardPage::$manifests_row_statuses); $i<$n; $i++) {
            if ($i == 1 || $i == 5 || $i == 6) {
                $row_status = str_replace(
                    '{{text}}',
                    IngestionDashboardPage::$manifests_row_statuses[$i],
                    IngestionDashboardPage::$manifests_row_status['xpath']);
                if (count($I->findElements('xpath', $row_status))) {
                    $I->scrollTo($row_status);
                    $I->moveMouseOver($row_status);
                    $I->moveMouseOver($row_status . IngestionDashboardPage::$manifests_three_dots['xpath']);
                    $I->see('Cancel');
                }
            }
        }
    }

    public function seePopupWithJsonData() {
        $I = $this;
        $index = rand(1, count($I->findElements('xpath', IngestionDashboardPage::$manifests_json_links['xpath'])));
        $json_link = '(' . IngestionDashboardPage::$manifests_json_links['xpath'] . ')[' . $index . ']';
        $I->scrollTo($json_link);
        $I->click($json_link);
        $I->waitForElementVisible(IngestionDashboardPage::$json_popup);
        $I->seeElement(IngestionDashboardPage::$json_popup);
    }
  
    public function accessTranscodesSection() {
        $I = $this;
        $I->click(IngestionDashboardPage::$transcodes_tab);
    }

    public function seeTranscodesSectionTableColumnsAreDisplayed() {
        $I = $this;
        $uri = $I->grabFromCurrentUrl();
        for ($i=(strpos($uri,'/vrv/') === false ? 1 : 0), $n=count(IngestionDashboardPage::$transcodes_columns_text); $i<$n; $i++) {
            $I->seeElement(str_replace(
                '{{text}}',
                IngestionDashboardPage::$transcodes_columns_text[$i],
                IngestionDashboardPage::$transcodes_columns['xpath']
            ));
        }
    }

    public function seeTranscodesSectionStatusColumnOptionsAreDisplayed() {
        $I = $this;
        $total = 0;
        for ($i=0, $n=count(IngestionDashboardPage::$transcodes_filter_options_text); $i<$n; $i++) {
            $transcodes_filter_options_text = strtolower(IngestionDashboardPage::$transcodes_filter_options_text[$i]);
            $selector = str_replace(
                ['{{class}}', '{{text}}'],
                [str_replace(' ', '_', $transcodes_filter_options_text), $transcodes_filter_options_text],
                IngestionDashboardPage::$transcode_status['xpath']
            );
            $total += count($I->findElements('xpath', $selector));
        }
        $I->assertGreaterThan(0, $total);
    }

    public function seeTranscodesSectionFilterOptionsAreDisplayed() {
        $I = $this;
        $I->moveMouseOver(IngestionDashboardPage::$filter);
        for ($i=0, $n=count(IngestionDashboardPage::$transcodes_filter_options_text); $i<$n; $i++) {
            $I->seeElement(str_replace(
                '{{text}}',
                IngestionDashboardPage::$transcodes_filter_options_text[$i],
                IngestionDashboardPage::$transcodes_filter_options
            ));
        }
    }

    public function seeTranscodesSectionThreeDotsAreDisplayed() {
        $I = $this;
        $this->displayThreeDots();
        $I->seeElement($this->temp['transcodes_row'] . IngestionDashboardPage::$transcodes_three_dots['xpath']);
    }

    public function seeTranscodesSectionRowOptionsAreDisplayed() {
        $I = $this;
        $this->displayThreeDots();
        $I->click($this->temp['transcodes_row'] . IngestionDashboardPage::$transcodes_three_dots['xpath']);
        for ($i=0, $n=count(IngestionDashboardPage::$transcodes_row_options); $i<$n; $i++) {
            $I->seeElement($this->temp['transcodes_row'] . IngestionDashboardPage::$transcodes_three_dots['xpath'] . str_replace(
                '{{text}}',
                IngestionDashboardPage::$transcodes_row_options[$i],
                IngestionDashboardPage::$transcodes_actions['xpath']
            ));
        }
    }

    public function accessTranscodesSectionRowOptionsDialog($option) {
        $I = $this;
        $this->displayThreeDots();
        $I->click($this->temp['transcodes_row'] . IngestionDashboardPage::$transcodes_three_dots['xpath']);
        $I->click($this->temp['transcodes_row'] . IngestionDashboardPage::$transcodes_three_dots['xpath'] . str_replace(
            '{{text}}',
            $option,
            IngestionDashboardPage::$transcodes_actions['xpath']
        ));
    }

    public function seeDialogRetryTranscodingIsDisplayed($option) {
        $I = $this;
        $I->seeElement(IngestionDashboardPage::$dialog_retry_transcoding);
    }

    private function displayThreeDots() {
        $I = $this;
        $index = rand(1, count($I->findElements('xpath', IngestionDashboardPage::$transcodes_rows['xpath'])));
        $this->temp['transcodes_row'] = str_replace('{{index}}', $index, IngestionDashboardPage::$transcodes_row['xpath']);
        $I->scrollTo($this->temp['transcodes_row']);
        $I->moveMouseOver($this->temp['transcodes_row']);
    }
}