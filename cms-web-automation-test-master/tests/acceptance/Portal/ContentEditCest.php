<?php

use Page\ContentEditPage;
use Step\LoginSteps;
use Step\MediaEditSteps;
use Step\ContentEditSteps;
use Codeception\Example;

class ContentEditCest {

    public function _before(LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: C15771, C15741, C15677
     *
     * @group test_priority_2
     *
     * @example {"staging": "G6GGDPE46", "proto0": "GRDQ43JGY", "test_case_id": "C15771"}
     * @example {"staging": "GY8V8J09Y", "proto0": "G6VNXQQZR", "test_case_id": "C15741"}
     * @example {"staging": "GYVNPXJQ6", "proto0": "G6JQ2EPVR", "test_case_id": "C15677"}
     */
    public function saveChangesButtonIsAlwaysVisible(Example $example, MediaEditSteps $I) {
        $I->wantTo("Check if Save Changes button is always visible - " . $example['test_case_id']);
        $I->amOnMediaEditPage($example[APPLICATION_ENV]);
        $I->scrollToBottom(100, function () use ($I)  {
            $I->shouldSeeSaveChangesButtonIsVisible();
        });
    }

    /**
     * TESTRAIL TESTCASE ID: C15716, C15652, C15614, C15575
     *
     * @group test_priority_2
     *
     * @example {"staging": "GYWEPXNMY", "proto0": "G6ZXQ00ZR", "test_case_id": "C15716"}
     * @example {"staging": "GY7582XM6", "proto0": "GYWEX5NNY", "test_case_id": "C15652"}
     * @example {"staging": "GY19857KR", "proto0": "GR2PWQK0R", "test_case_id": "C15614"}
     * @example {"staging": "GR49808Z6", "proto0": "G6P81Q7V6", "test_case_id": "C15575"}
     */
    public function saveChangesButtonIsAboveNextSection(Example $example, ContentEditSteps $I) {
        $I->wantTo("Check if Save Changes button is above the next section - " . $example['test_case_id']);
        $I->amOnContentEditPage($example[APPLICATION_ENV]);
        $I->scrollToBottom(100, function() use ($I) {
            $I->shouldSeeSaveChangesButtonAboveNextSection();
        });
    }

    /**
     * TESTRAIL TESTCASE ID: C1143921, C1143920, C1143919, C1143918
     *
     * @group test_priority_2
     *
     * @example {"page": "Episode", "test_case_id": "C1143921"}
     * @example {"page": "Season", "test_case_id": "C1143920"}
     * @example {"page": "Series", "test_case_id": "C1143919"}
     * @example {"page": "Movie", "test_case_id": "C1143918"}
     */
    public function checkSubDubOptions(Example $example, ContentEditSteps $I) {
        $I->wantTo('Check if User is able to choose and save Sub/Dub options from ' . $example['page']. ' page - ' . $example['test_case_id']);
        $I->navigateToContentEditPage($example['page']);
        $I->toggleSubDubOption();
        $I->pressSaveChangesButton();
        $I->reloadPage();
        $I->shouldSeeSubDubOptionsWasSaved();
    }

    /**
     * TESTRAIL TESTCASE ID: C1630542
     *
     * @group test_priority_2
     *
     * @example {"staging": "GYWEPXNMY", "proto0": "G6ZXQ00ZR", "test_case_id": "C1630542"}
     */
    public function checkPublishedTimestampChanges(Example $example, ContentEditSteps $I) {
        $I->wantTo('Check if Last Published is displayed when content was changed from unpublished to published - ' . $example['test_case_id']);
        $I->amOnContentEditPage($example[APPLICATION_ENV]);
        $I->shouldSeeNAOrOldLastPublished();

        // UnPublish content
        $I->uncheckPublishCheckbox();
        $I->pressSaveChangesButton();
        $I->reloadPage();
        $I->shouldSeeThatLastPublishedNotChanged();

        // Publish content
        $I->checkPublishCheckbox();
        $I->pressSaveChangesButton();
        $I->reloadPage();
        $I->shouldSeeNewLastPublished();
    }

    /**
     * TESTRAIL TESTCASE ID: C1630540
     *
     * @group test_priority_2
     *
     * @example {"staging": "GYWEPXNMY", "proto0": "G6ZXQ00ZR", "test_case_id": "C1630540"}
     */
    public function checkLastPublishedTimestampFormat(Example $example, ContentEditSteps $I) {
        $I->wantTo('Check if Last Published have correct format - ' . $example['test_case_id']);
        $I->amOnContentEditPage($example[APPLICATION_ENV]);
        $I->shouldSeeLastPublishedHasCorrectFormat();
    }

    /**
     * TESTRAIL TESTCASE ID: C1419424
     *
     * @group test_priority_2
     *
     * @example {"page": "Series", "test_case_id": "C1419424"}
     * @example {"page": "Season", "test_case_id": "C1419424"}
     * @example {"page": "Episode", "test_case_id": "C1419424"}
     * @example {"page": "Movie", "test_case_id": "C1419424"}
     */
    public function linkContentWithInvalidGuid(Example $example, ContentEditSteps $I) {
        $I->wantTo('Check if user is not able to link content with invalid guid for ' . $example['page'] . ' - ' . $example['test_case_id']);
        $I->amOnContentEditPage(ContentEditPage::getEditGuidByContentType($example['page']));
        $I->linkContentTo('999999999', false);
        $I->shouldSeeContentCannotBeLinked();
    }

}