<?php
use \Codeception\Example;
use  \Step\ContentEditSteps;
use Step\ContentSteps;

class MaturityRatingCest {

    public function _before(\Step\LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: C349641, C349672, C349677, C349682
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "test_case_id": "C349641"}
     * @example {"category": "Series", "test_case_id": "C349672"}
     * @example {"category": "Season", "test_case_id": "C349677"}
     * @example {"category": "Episode", "test_case_id": "C349682"}
     */
    public function checkTypes(Example $example, ContentSteps $I, ContentEditSteps $contentEditPage) {
        $I->wantTo('Check "TV" and "Movie" types are displayed in "' . $example['category'] . '" category - ' . $example['test_case_id']);
        $I->navigateToContentEditPage($example['category']);
        $contentEditPage->typesTVAndMovieShouldBeDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C349643, C349673, C349678, C349683
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "test_case_id": "C349643"}
     * @example {"category": "Series", "test_case_id": "C349673"}
     * @example {"category": "Season", "test_case_id": "C349678"}
     * @example {"category": "Episode", "test_case_id": "C349683"}
     */
    public function verifyTypeIsSelected(Example $example, ContentSteps $I, ContentEditSteps $contentEditPage) {
        $I->wantTo('Verify if type is selected  in "' . $example['category'] . '" category - ' . $example['test_case_id']);
        $I->navigateToContentEditPage($example['category']);
        $contentEditPage->typeShouldBeSelected();
    }

    /**
     * TESTRAIL TESTCASE ID: C349644, C349674, C349679, C349684
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "test_case_id": "C349644"}
     * @example {"category": "Series", "test_case_id": "C349674"}
     * @example {"category": "Season", "test_case_id": "C349679"}
     * @example {"category": "Episode", "test_case_id": "C349684"}
     */
    public function selectMovieType(Example $example, ContentSteps $I, ContentEditSteps $contentEditPage) {
        $I->wantTo('Select "Movie" type in "' . $example['category'] . '" category - ' . $example['test_case_id']);
        $I->navigateToContentEditPage($example['category']);
        $contentEditPage->selectMovieType();
    }

    /**
     * TESTRAIL TESTCASE ID: C349645, C349675, C349680, C349685
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "test_case_id": "C349645"}
     * @example {"category": "Series", "test_case_id": "C349675"}
     * @example {"category": "Season", "test_case_id": "C349680"}
     * @example {"category": "Episode", "test_case_id": "C349685"}
     */
    public function selectRandomOptionOfSelectedType(Example $example, ContentSteps $I, ContentEditSteps $contentEditPage) {
        $I->wantTo('Select random option of selected type in "' . $example['category'] . '" category and save it - ' . $example['test_case_id']);
        $I->navigateToContentEditPage($example['category']);
        $contentEditPage->selectRandomOption();
        $contentEditPage->changesShouldBeSavedAfterRefresh();
    }

    /**
     * TESTRAIL TESTCASE ID: C349646, C349676, C349681, C349686
     *
     * @group test_priority_3
     *
     * @example {"category": "Movie", "test_case_id": "C349646"}
     * @example {"category": "Series", "test_case_id": "C349676"}
     * @example {"category": "Season", "test_case_id": "C349681"}
     * @example {"category": "Episode", "test_case_id": "C349686"}
     */
    public function switchBetweenTypesAndOptions(Example $example, ContentSteps $I, ContentEditSteps $contentEditPage) {
        $I->wantTo('Switch between "TV" and "Movie" types and their options in "' . $example['category'] . '" category - ' . $example['test_case_id']);
        $I->navigateToContentEditPage($example['category']);
        $contentEditPage->selectMaturityRatingOption('tv', false);
        $contentEditPage->selectMaturityRatingOption('movie', true);
        $contentEditPage->onlyOneRatingCategoryShouldBeSelected();
        $contentEditPage->selectedCategoryShouldNotBeUnselected();
        $contentEditPage->changesShouldBeSavedAfterRefresh();
    }

}