<?php
use \Codeception\Util\Locator;
use \Step\FeedsAndCollectionsSteps;
use \Page\FeedsAndCollectionsPage;

class CollectionsCest {

    public function _before(\Step\LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: C9180
     *
     * @group test_priority_2
     */
    public function verifyClickFeedFromCollections(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can get to the Feed page via the Collections page - C9180');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->clickOnFeedsLink();
        $I->shouldBeOnFeedsTab();
    }

    /**
     * TESTRAIL TESTCASE ID: C9209
     *
     * @group test_priority_2
     */
    public function verifyCollectionsDeleteCollection(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can delete a Collection - C9209');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->addNewCollection();
        $I->clickOnSaveChangesButton();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->deleteCollection(true);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsRemoved();
    }

    /**
     * TESTRAIL TESTCASE ID: C9194
     *
     * @group test_priority_1
     */
    public function verifyCollectionsAddNewCollection(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can add another Collection - C9194');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->addNewCollection();
        $I->clickOnSaveChangesButton();
        $I->seeToastMessage(FeedsAndCollectionsPage::$toast_add_collection_text);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsSaved('seriesGuid_', 'Series In Feed For Automation', 'Series in feed.', 'series');
        $I->deleteCollection(true);
    }

    /**
     * TESTRAIL TESTCASE ID: C29299
     *
     * @group test_priority_3
     */
    public function verifyCollectionsAddNewCollectionEmptyTitle(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify that Collection cannot be created with an empty title - C29299');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->clickOnAddNewCollectionButton();
        $I->addNewCollectionWithEmptyTitle();
        $I->seeInPopup(FeedsAndCollectionsPage::$popup_specify_title_text);
        $I->acceptPopup();
        $I->closeTheModal();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsNotAdded();
    }

    /**
     * TESTRAIL TESTCASE ID: C29300
     *
     * @group test_priority_3
     */
    public function verifyCollectionsAddNewCollectionNoItems(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify that Collection cannot be created without any items - C29300');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->addNewCollectionWithNoItems();
        $I->seeInPopup(FeedsAndCollectionsPage::$popup_add_item_text);
        $I->acceptPopup();
        $I->closeTheModal();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsNotAdded();
    }

    /**
     * TESTRAIL TESTCASE ID: C29301
     *
     * @group test_priority_2
     */
    public function verifyCollectionsAddNewCollectionDiscardChanges(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can discard the changes of a collection they are adding - C29301');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->addNewCollection();
        $I->closeTheModal();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsNotAdded();

    }

    /**
     * TESTRAIL TESTCASE ID: C29302
     *
     * @group test_priority_3
     */
    public function verifyCollectionsCancelDelete(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can cancel the deletion of a collection - C29302');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->deleteCollection(false);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsNotRemoved();
    }

    /**
     * TESTRAIL TESTCASE ID: C9206
     *
     * @group test_priority_2
     */
    public function verifyCollectionsAddSecondCollection(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify the New Collection button still works when there is already a collection present - C9206');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->seeAdditionalCollectionAlreadyExists();
        $I->addNewCollection();
        $I->clickOnSaveChangesButton();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsSaved('seriesGuid_', 'Series In Feed For Automation', 'Series in feed.', 'series');
        $I->deleteCollection(true);
    }

    /**
     * TESTRAIL TESTCASE ID: C9195
     *
     * @group test_priority_1
     */
    public function verifyCollectionsUpdateTitle(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can update the title of the Collections - C9195');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->editCollection(FeedsAndCollectionsPage::$collections_titleInput, FeedsAndCollectionsPage::$collection_title_edit_text);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionsIsUpdated(FeedsAndCollectionsPage::$collection_title_edit_text, Locator::lastElement(FeedsAndCollectionsPage::$collections_title));
        $I->editCollection(FeedsAndCollectionsPage::$collections_titleInput, FeedsAndCollectionsPage::$collection_title_text);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionsIsUpdated(FeedsAndCollectionsPage::$collection_title_text, Locator::lastElement(FeedsAndCollectionsPage::$collections_title));
    }

    /**
     * TESTRAIL TESTCASE ID: C9196
     *
     * @group test_priority_2
     */
    public function verifyCollectionsUpdateDescription(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can update the description of the Collections - C9196');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->editCollection(FeedsAndCollectionsPage::$collections_descInput, FeedsAndCollectionsPage::$collection_description_edit_text);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionsIsUpdated(FeedsAndCollectionsPage::$collection_description_edit_text, Locator::lastElement(FeedsAndCollectionsPage::$collections_description));
        $I->editCollection(FeedsAndCollectionsPage::$collections_descInput,  FeedsAndCollectionsPage::$collection_description_text);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionsIsUpdated(FeedsAndCollectionsPage::$collection_description_text, Locator::lastElement(FeedsAndCollectionsPage::$collections_description));
    }

    /**
     * TESTRAIL TESTCASE ID: C29303
     *
     * @group test_priority_2
     */
    public function verifyCollectionEdit(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can bring up the editing modal - C29303');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->openEditModal();
        $I->seeEditModal('You are editing a collection');
    }

    /**
     * TESTRAIL TESTCASE ID: C9208
     *
     * @group test_priority_1
     */
    public function verifyCollectionsDeleteContent(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can delete content from the Collections - C9208');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->openEditModal();
        $I->addMedia('series');
        $I->clickOnSaveChangesButton();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->openEditModal();
        $I->removeItem();
        $I->clickOnSaveChangesButton();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsRemoved();
    }

    /**
     * TESTRAIL TESTCASE ID: C9197, C10988, C9198, C9199, C15866, C10989
     *
     * @group test_priority_1
     *
     * @example {"guid": "seriesGuid_","title": "Series In Feed For Automation", "description":"Series in feed.", "type": "series", "test_case_id": "C9197"}
     * @example {"guid": "seasonGuid_","title": "Season In Feed For Automation", "description":"Season in feed.", "type": "season", "test_case_id": "C10988"}
     * @example {"guid": "episodeGuid_","title": "Episode In Feed For Automation", "description":"Episode in feed.", "type": "episode", "test_case_id": "C9198"}
     * @example {"guid": "movieGuid_","title": "Movie In Feed For Automation", "description":"Movie in feed.", "type": "movie", "test_case_id": "C9199"}
     * @example {"guid": "channelGuid_","title": "Crunchyroll", "description":"Crunchyroll is a leading global", "type": "channel", "test_case_id": "C15866"}
     * @example {"guid": "collectionGuid_","title": "Automation Collection", "description":"To test collections in feeds. Do not edit.", "type": "collection", "test_case_id": "C10989"}
     */
    public function verifyCollectionsAddNewContent(\Codeception\Example $example, FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can add a new "' . $example['type'] . '" to the Collections - ' . $example['test_case_id']);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->openEditModal();
        $I->addMedia($example['type']);
        $I->clickOnSaveChangesButton();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsSaved($example['guid'], $example['title'], $example['description'], $example['type']);
        $I->openEditModal();
        $I->removeItem();
        $I->clickOnSaveChangesButton();
    }

    /**
     * TESTRAIL TESTCASE ID: C11060
     *
     * @group test_priority_3
     */
    public function collectionsClearTitle(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify that the Collection does not save a blank title - C11060');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveTitle();
        $I->editCollection(FeedsAndCollectionsPage::$collections_titleInput, '');
        $I->seeInPopup(FeedsAndCollectionsPage::$popup_specify_title_text);
        $I->acceptPopup();
        $I->closeTheModal();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeOldTitleIsStillPresent();
    }

    /**
     * TESTRAIL TESTCASE ID: C11061
     *
     * @group test_priority_3
     */
    public function verifyCollectionsClearDescription(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can update the description of the Collections - C11061');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->editCollection(Locator::lastElement(FeedsAndCollectionsPage::$collections_descInput), FeedsAndCollectionsPage::$collection_description_edit_text);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->see(FeedsAndCollectionsPage::$collection_description_edit_text, Locator::lastElement(FeedsAndCollectionsPage::$collections_description));
        $I->editCollection(FeedsAndCollectionsPage::$collections_descInput, '');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->dontSee(FeedsAndCollectionsPage::$collection_description_edit_text, Locator::lastElement(FeedsAndCollectionsPage::$collections_description));
        $I->editCollection(Locator::lastElement(FeedsAndCollectionsPage::$collections_descInput), FeedsAndCollectionsPage::$collection_description_text);
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->see(FeedsAndCollectionsPage::$collection_description_text, Locator::lastElement(FeedsAndCollectionsPage::$collections_description));
    }

    /**
     * TESTRAIL TESTCASE ID: C29304
     *
     * @group test_priority_3
     */
    public function verifyCollectionsClearAllItems(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify that the Collection does not save after being emptied - C29304');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->openEditModal();
        $I->removeAllMedia();
        $I->clickOnSaveChangesButton();
        $I->wait(3);
        $I->seeInPopup(FeedsAndCollectionsPage::$popup_add_item_text);
        $I->acceptPopup();
        $I->closeTheModal();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsNotRemoved();
    }

    /**
     * TESTRAIL TESTCASE ID: C29305
     *
     * @group test_priority_2
     */
    public function verifyCollectionsEditDiscardChanges(FeedsAndCollectionsSteps $I) {
        $I->wantTo('Verify user can discard changes to a collection when editing - C29305');
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->saveCollectionContent();
        $I->openEditModal();
        $I->addMedia('series');
        $I->closeTheModal();
        $I->amOnFeedsPage();
        $I->clickOnCollectionLink();
        $I->seeCollectionIsNotAdded();
    }
}