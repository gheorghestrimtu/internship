<?php
use \Codeception\Example;
use \Step\BreadcrumbNavigationSteps;

class BreadcrumbNavigationCest {

    public function _before(\Step\LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: 15683, 15529, 15576, 15615
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "test_case_id": "C15683"}
     * @example {"category": "Series", "test_case_id": "C15529"}
     * @example {"category": "Season", "test_case_id": "C15576"}
     * @example {"category": "Episode", "test_case_id": "C15615"}
     */
    public function checkBreadcrumbNavigationOnContentEditPage(Example $example, BreadcrumbNavigationSteps $I) {
        $I->wantTo('Verify if the breadcrumb navigation is displayed on the page "catalog/content" for "' . $example['category'] . '" - ' . $example['test_case_id']);
        $I->amOnContentEditPage($example['category']);
        $I->seeBreadcrumbNavigationIsDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: 15717, 15653, 15791, 15786, 15787, 15789
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "subcategory": "Video", "test_case_id": "C15717"}
     * @example {"category": "Episode", "subcategory": "Video", "test_case_id": "C15653"}
     * @example {"category": "Movie", "subcategory": "ExtraVideo", "test_case_id": "C15791"}
     * @example {"category": "Series", "subcategory": "ExtraVideo", "test_case_id": "C15786"}
     * @example {"category": "Season", "subcategory": "ExtraVideo", "test_case_id": "C15787"}
     * @example {"category": "Episode", "subcategory": "ExtraVideo", "test_case_id": "C15789"}
     */
    public function checkBreadcrumbNavigationOnMediaEditPage(Example $example, BreadcrumbNavigationSteps $I) {
        $I->wantTo('Verify if the breadcrumb navigation is displayed on the page "catalog/media" for "' . $example['category'] . '" - ' . $example['test_case_id']);
        $I->amOnMediaEditPage($example['category'], $example['subcategory']);
        $I->seeBreadcrumbNavigationIsDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: 15742, 15678, 15772, 15785, 15788, 15773
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "subcategory": "Thumbnail", "test_case_id": "C15742"}
     * @example {"category": "Episode", "subcategory": "Thumbnail", "test_case_id": "C15678"}
     * @example {"category": "Movie", "subcategory": "ExtraThumbnail", "test_case_id": "C15772"}
     * @example {"category": "Series", "subcategory": "ExtraThumbnail", "test_case_id": "C15785"}
     * @example {"category": "Season", "subcategory": "ExtraThumbnail", "test_case_id": "C15788"}
     * @example {"category": "Episode", "subcategory": "ExtraThumbnail", "test_case_id": "C15773"}
     */
    public function checkBreadcrumbNavigationOnThumbnailEditPage(Example $example, BreadcrumbNavigationSteps $I) {
        $I->wantTo('Verify if the breadcrumb navigation is displayed on the page "catalog/thumbnail" for "' . $example['category'] . '" - ' . $example['test_case_id']);
        $I->amOnThumbnailEditPage($example['category'], $example['subcategory']);
        $I->seeBreadcrumbNavigationIsDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: 15778, 15777, 15780, 15779, 15782, 15781, 15784, 15783
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "subcategory": "LandscapeImage", "test_case_id": "C15778"}
     * @example {"category": "Movie", "subcategory": "PortraitImage", "test_case_id": "C15777"}
     * @example {"category": "Series", "subcategory": "LandscapeImage", "test_case_id": "C15780"}
     * @example {"category": "Series", "subcategory": "PortraitImage", "test_case_id": "C15779"}
     * @example {"category": "Season", "subcategory": "LandscapeImage", "test_case_id": "C15782"}
     * @example {"category": "Season", "subcategory": "PortraitImage", "test_case_id": "C15781"}
     * @example {"category": "Episode", "subcategory": "LandscapeImage", "test_case_id": "C15784"}
     * @example {"category": "Episode", "subcategory": "PortraitImage", "test_case_id": "C15783"}
     */
    public function checkBreadcrumbNavigationOnImageEditPage(Example $example, BreadcrumbNavigationSteps $I) {
        $I->wantTo('Verify if the breadcrumb navigation is displayed on the page "catalog/image" for "' .
            $example['category'] . '" - ' . $example['test_case_id']);
        $I->amOnImageEditPage($example['category'], $example['subcategory']);
        $I->seeBreadcrumbNavigationIsDisplayed();
    }

}