<?php
use \Codeception\Example;
use \Step\ThumbnailSteps;

class ThumbnailPageCest {

    public function _before(\Step\LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: C15680, C15744, C15774
     *
     * @group test_priority_3
     *
     * @example {"category": "episode", "test_case_id": "C15680"}
     * @example {"category": "movie", "test_case_id": "C15744"}
     * @example {"category": "extra", "test_case_id": "C15774"}
     */
    public function verifyCurrentThumbnailIsDisplayed(Example $example, ThumbnailSteps $I) {
        $I->wantTo('Verify if a thumbnail is displayed in "CURRENT THUMBNAIL" section - ' . $example['test_case_id']);
        $I->amOnVideoEditDataPage($example['category'], true);
        $I->currentTumbnailShouldBeDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C163446, C163449, C163452
     *
     * @group test_priority_3
     *
     * @example {"category": "episode", "test_case_id": "C163446"}
     * @example {"category": "movie", "test_case_id": "C163449"}
     * @example {"category": "extra", "test_case_id": "C163452"}
     */
    public function verifyCurrentThumbnailIsNotDisplayed(Example $example, ThumbnailSteps $I) {
        $I->wantTo('Verify if a thumbnail is not displayed in "CURRENT THUMBNAIL" section - ' . $example['test_case_id']);
        $I->amOnVideoEditDataPage($example['category'], false);
        $I->currentTumbnailShouldNotBeDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C15681, C15745, C15775
     *
     * @group test_priority_3
     *
     * @example {"category": "episode", "test_case_id": "C15681"}
     * @example {"category": "movie", "test_case_id": "C15745"}
     * @example {"category": "extra", "test_case_id": "C15775"}
     */
    public function verifyGeneratedThumbnailsAreDisplayed(Example $example, ThumbnailSteps $I) {
        $I->wantTo('Verify if thumbnails are displayed in "GENERATED THUMBNAILS" section - ' . $example['test_case_id']);
        $I->amOnVideoEditDataPage($example['category'], true);
        $I->availableTumbnailsShouldBeDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C15682, C15746, C15776
     *
     * @group test_priority_1
     *
     * @example {"category": "episode", "test_case_id": "C15682"}
     * @example {"category": "movie", "test_case_id": "C15746"}
     * @example {"category": "extra", "test_case_id": "C15776"}
     */
    public function changeCurrentThumbnail(Example $example, ThumbnailSteps $I) {
        $I->wantTo('Change current thumbnail in "CURRENT THUMBNAIL" section - ' . $example['test_case_id']);
        $I->amOnVideoEditDataPage($example['category'], true);
        $I->currentTumbnailShouldBeDisplayed();
        $I->changeThumbnailImage(true);
        $I->thumbnailImageShouldChange();
    }

    /**
     * TESTRAIL TESTCASE ID: C163445, C163448, C163451
     *
     * @group test_priority_3
     *
     * @example {"category": "episode", "test_case_id": "C163445"}
     * @example {"category": "movie", "test_case_id": "C163448"}
     * @example {"category": "extra", "test_case_id": "C163451"}
     */
    public function cancelChangingCurrentThumbnail(Example $example, ThumbnailSteps $I) {
        $I->wantTo('Cancel changing current thumbnail in "CURRENT THUMBNAIL" section - ' . $example['test_case_id']);
        $I->amOnVideoEditDataPage($example['category'], true);
        $I->currentTumbnailShouldBeDisplayed();
        $I->changeThumbnailImage(false);
        $I->thumbnailImageShouldNotChange();
    }

    /**
     * TESTRAIL TESTCASE ID: C163447, C163450, C163453
     *
     * @group test_priority_3
     *
     * @example {"category": "episode", "test_case_id": "C163447"}
     * @example {"category": "movie", "test_case_id": "C163450"}
     * @example {"category": "extra", "test_case_id": "C163453"}
     */
    public function switchThumbnailSize(Example $example, ThumbnailSteps $I) {
        $I->wantTo('Switch thumbnails sizes (small, medium, large) - ' . $example['test_case_id']);
        $I->amOnVideoEditDataPage($example['category'], true);
        $I->availableTumbnailsShouldBeDisplayed();
        $I->changeThumbnailSize();
        $I->thumbnailsSizeShouldChange();
        $I->changeThumbnailSize();
        $I->thumbnailsSizeShouldChange();
        $I->changeThumbnailSize();
        $I->thumbnailsSizeShouldChange();
    }
}