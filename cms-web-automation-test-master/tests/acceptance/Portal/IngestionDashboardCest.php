<?php
use  \Step\IngestionDashboardSteps;

class IngestionDashboardCest {

    public function _before(\Step\LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: C358025
     *
     * @group test_priority_3
     *
     */
    public function verifyIngestionTabIsDisplayedInLeftMenu(IngestionDashboardSteps $I) {
        $I->wantTo('Verify if "Ingestion" tab is displayed in left menu - C358025');
        $I->seeIngestionTabIsDisplayedInLeftMenu();
    }

    /**
     * TESTRAIL TESTCASE ID: C358026
     *
     * @group test_priority_3
     *
     */
    public function verifyIngestionBreadcrumbNavigation(IngestionDashboardSteps $I) {
        $I->wantTo('Verify if breadcrumb navigation is displayed as required - C358026');
        $I->amOnIngestDashboardPage();
        $I->seeBreadcrumbNavigationIsDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C358027
     *
     * @group test_priority_3
     *
     */
    public function checkTabs(IngestionDashboardSteps $I) {
        $I->wantTo('Check "Manifests" and "Transcodes" tabs are displayed on the page - C358027');
        $I->amOnIngestDashboardPage();
        $I->seeTabIsDisplayed('manifests_tab');
        $I->seeTabIsDisplayed('transcodes_tab');
    }

    /**
     * TESTRAIL TESTCASE ID: C358031
     *
     * @group test_priority_3
     *
     */
    public function verifyManifestsSectionRowsDetails(IngestionDashboardSteps $I) {
        $I->wantTo('Verify if "Manifests" section rows details are displayed as required - C358031');
        $I->amOnIngestDashboardPage();
        $I->accessManifestsSection();
        $I->seeManifestsSectionRowsDetailsAreDisplayed();
    }
  
    /**
     * TESTRAIL TESTCASE ID: C358028
     *
     * @group test_priority_3
     *
     */
    public function verifyTranscodesSectionColumns(IngestionDashboardSteps $I) {
        $I->wantTo('Verify if "Transcodes" section columns are displayed as required - C358028');
        $I->accessIngestDashboardPage();
        $I->accessTranscodesSection();
        $I->seeTranscodesSectionTableColumnsAreDisplayed();
    }
  
    /**
     * TESTRAIL TESTCASE ID: C358029
     *
     * @group test_priority_3
     *
     */
    public function verifyTranscodesSectionStatusColumnOptions(IngestionDashboardSteps $I) {
        $I->wantTo('Verify "Transcodes" section status column options - C358029');
        $I->amOnIngestDashboardPage();
        $I->accessTranscodesSection();
        $I->seeTranscodesSectionStatusColumnOptionsAreDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C358030
     *
     * @group test_priority_3
     *
     */
    public function verifyTranscodesSectionFilterOptions(IngestionDashboardSteps $I) {
        $I->wantTo('Verify if "Transcodes" section filter options are displayed as required - C358030');
        $I->amOnIngestDashboardPage();
        $I->accessTranscodesSection();
        $I->seeTranscodesSectionFilterOptionsAreDisplayed();
    }
  
    /**
     * TESTRAIL TESTCASE ID: C358032
     *
     * @group test_priority_3
     *
     */
    public function verifyTranscodesSectionThreeDots(IngestionDashboardSteps $I) {
        $I->wantTo('Verify in "Transcodes" section if three dots are displayed on hover - C358032');
        $I->amOnIngestDashboardPage();
        $I->accessTranscodesSection();
        $I->seeTranscodesSectionThreeDotsAreDisplayed();
    }
  
    /**
     * TESTRAIL TESTCASE ID: C566184
     *
     * @group test_priority_3
     *
     */
    public function verifyManifestsFilterPendingOption(IngestionDashboardSteps $I) {
        $I->wantTo('Verify in "Manifests" section if filter "Pending" option works as expected - C566184');
        $I->amOnIngestDashboardPage();
        $I->accessManifestsSection();
        $I->filter('Pending');
        $I->seeManifestsRowsAreFilteredByPending();
    }
  
    /**
     * TESTRAIL TESTCASE ID: C566191
     *
     * @group test_priority_3
     *
     */
    public function verifyManifestsSectionCancelOptionForRowStatus(IngestionDashboardSteps $I) {
        $I->wantTo('Verify in "Manifests" section if "Cancel" option is available for row status - C566191');
        $I->amOnIngestDashboardPage();
        $I->accessManifestsSection();
        $I->seeCancelOptionInManifestsSection();
    }
  
    /**
     * TESTRAIL TESTCASE ID: C377622
     *
     * @group test_priority_3
     *
     */
    public function verifyManifestsSectionJsonDataPopup(IngestionDashboardSteps $I) {
        $I->wantTo('Verify in "Manifests" section if the popup with JSON data is available - C377622');
        $I->amOnIngestDashboardPage();
        $I->accessManifestsSection();
        $I->seePopupWithJsonData();
    }  
}