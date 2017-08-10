<?php
namespace Step;

use WebDriverKeys;
use Codeception\Util\Fixtures;
use \Page\FeedsAndCollectionsPage;
use \Codeception\Util\Locator;

class FeedsAndCollectionsSteps extends AbstractStep {

    public $temp;

    public function amOnFeedsPage() {
        $I = $this;
        $I->amOnPage(FeedsAndCollectionsPage::$URL);
        $I->waitForElementVisible(FeedsAndCollectionsPage::$feed_panelList);
    }

    public function clickOnCollectionLink() {
        $I = $this;
        $I->click(FeedsAndCollectionsPage::$collections_link);
        $I->waitForElementVisible(FeedsAndCollectionsPage::$collections_content, 30);
    }

    public function clickOnFeedsLink() {
        $I = $this;
        $I->click(FeedsAndCollectionsPage::$feeds_link);
    }

    public function shouldBeOnFeedsTab() {
        $I = $this;
        $I->waitForElementVisible(FeedsAndCollectionsPage::$feeds_header, 30);
    }

    public function saveCollectionContent() {
        $I = $this;
        $this->temp = $I->grabTextFrom(FeedsAndCollectionsPage::$collections_content);
    }

    public function seeCollectionIsRemoved() {
       $this->checkCollections();
    }

    public function seeCollectionIsNotAdded() {
        $this->checkCollections();
    }

    public function seeCollectionIsNotRemoved() {
        $this->checkCollections();
    }

    public function seeAdditionalCollectionAlreadyExists() {
        $I = $this;
        $I->waitForElementVisible(FeedsAndCollectionsPage::$collections_title, 30);
    }

    public function seeCollectionIsSaved($guid, $title, $description, $type) {
        $I = $this;
        $I->waitForElement(Locator::lastElement(FeedsAndCollectionsPage::$collections_title));
        $I->see(FeedsAndCollectionsPage::$collection_title_text, Locator::lastElement(FeedsAndCollectionsPage::$collections_title));
        $I->seeInField(Locator::lastElement(FeedsAndCollectionsPage::$collections_guid_input), $this->getGuid($guid));
        $I->see($title, FeedsAndCollectionsPage::$collection_title);
        $I->see($description, Locator::lastElement(FeedsAndCollectionsPage::$collection_description));
        $I->see($type, Locator::lastElement(FeedsAndCollectionsPage::$collection_type));
    }

    public function addNewCollection() {
        $I = $this;
        $this->clickOnAddNewCollectionButton();
        $I->fillField(FeedsAndCollectionsPage::$collections_titleInput, FeedsAndCollectionsPage::$collection_title_edit_text);
        $I->fillField(FeedsAndCollectionsPage::$collections_guid_input, $this->getGuid('seriesGuid_'));
    }

    public function editCollection($selector, $title) {
        $I = $this;
        $this->openEditModal();
        $I->fillField($selector, $title);
        $I->clickOnSaveChangesButton();
    }

    public function editFirstFeedPromoTitle($title = null) {
        if (!$title) {} $title = uniqid('Promo Title ');
        Fixtures::add('feed_promo_title', $title);

        $I = $this;
        $I->fillField(FeedsAndCollectionsPage::$feed_promo_title_input, $title);
    }

    public function clearFirstFeedPromoTitle() {
        $I = $this;
        $title = $I->grabValueFrom(FeedsAndCollectionsPage::$feed_promo_title_input);
        $I->pressKey(FeedsAndCollectionsPage::$feed_promo_title_input, str_repeat(WebDriverKeys::BACKSPACE, strlen($title)));
    }
  
    public function shouldSeeNewPromoTitle() {
        $I = $this;
        $I->seeInField(Locator::firstElement(FeedsAndCollectionsPage::$feed_items['xpath']), Fixtures::get('feed_promo_title'));
    }

    public function shouldSeePromoTitleWasCleared() {
        $I = $this;
        $I->seeInField(Locator::firstElement(FeedsAndCollectionsPage::$feed_items['xpath']), '');
    }

    public function seeCollectionsIsUpdated($title, $selector) {
        $I = $this;
        $I->see($title, $selector);
    }

    public function clickOnSaveChangesButton() {
        $I = $this;
        $I->click(FeedsAndCollectionsPage::$save_changes_button);
        $I->wait(2);
    }

    public function seeToastMessage($text) {
        $I = $this;
        $I->waitForText($text, 30);
    }

    public function addNewCollectionWithEmptyTitle() {
        $I = $this;;
        $I->fillField(FeedsAndCollectionsPage::$collections_guid_input, $this->getGuid('seriesGuid_'));
        $I->click(FeedsAndCollectionsPage::$save_changes_button);
    }

    public function addNewCollectionWithNoItems() {
        $I = $this;
        $this->clickOnAddNewCollectionButton();
        $I->fillField(FeedsAndCollectionsPage::$collections_titleInput, FeedsAndCollectionsPage::$collection_title_edit_text);
        $I->click(FeedsAndCollectionsPage::$save_changes_button);
    }

    public function clickOnAddNewCollectionButton() {
        $I = $this;
        $I->click(FeedsAndCollectionsPage::$add_new_collection_link);
        $I->waitForText(FeedsAndCollectionsPage::$create_new_collection_text, 30);
    }

    public function deleteCollection($delete) {
        $I = $this;
        $I->moveMouseOver(Locator::lastElement(FeedsAndCollectionsPage::$gear_button));
        $I->waitForElementVisible(Locator::lastElement(FeedsAndCollectionsPage::$delete_collection_link), 30);
        $I->click(Locator::lastElement(FeedsAndCollectionsPage::$delete_collection_link));
        $I->seeInPopup(FeedsAndCollectionsPage::$popup_delete_text);
        if ($delete) {
            $I->acceptPopup();
            $I->waitForText(FeedsAndCollectionsPage::$toast_delete_collection_text, 30);
        } else {
            $I->cancelPopup();
            $I->dontSee(FeedsAndCollectionsPage::$toast_delete_collection_text);
        }
    }

    public function openEditModal() {
        $I = $this;
        $I->moveMouseOver(Locator::lastElement(FeedsAndCollectionsPage::$gear_button));
        $I->waitForElementVisible(Locator::lastElement(FeedsAndCollectionsPage::$edit_link));
        $I->click(Locator::lastElement(FeedsAndCollectionsPage::$edit_link));
    }

    public function seeEditModal($text) {
        $I = $this;
        $I->waitForText($text, 30);
        $I->seeElement(FeedsAndCollectionsPage::$collections_titleInput);
    }

    public function closeTheModal() {
        $I = $this;
        $I->click(FeedsAndCollectionsPage::$modal_close_button);
    }

    public function addMedia($media) {
        $I = $this;
        $I->click(FeedsAndCollectionsPage::$add_media_button);
        $I->wait(2);
        $I->fillField( '('.FeedsAndCollectionsPage::$collections_guid_input . ')[2]', $this->getGuid($media.'Guid_'));
        $I->wait(2);
    }

    public function removeItem() {
        $I = $this;
        $I->waitForElement('('.FeedsAndCollectionsPage::$modal_close_button . ')[3]', 30);
        $I->click('('.FeedsAndCollectionsPage::$modal_close_button . ')[3]');
    }

    public function removeAllMedia() {
        $I = $this;
        while (count($I->findElements('xpath', FeedsAndCollectionsPage::$modal_close_button)) > 1) {
            $I->click('('.FeedsAndCollectionsPage::$modal_close_button . ')[2]');
        }
    }

    public function saveTitle() {
        $I = $this;
        $this->temp = $I->grabTextFrom(Locator::lastElement(Locator::lastElement(FeedsAndCollectionsPage::$collections_title)));
    }

    public function seeOldTitleIsStillPresent() {
        $I = $this;
        $I->assertEquals($this->temp, $I->grabTextFrom(Locator::lastElement(FeedsAndCollectionsPage::$collections_title)));
    }

    private function getGuid($param) {
        return FeedsAndCollectionsPage::${$param . APPLICATION_ENV};
    }

    private function checkCollections() {
        $I = $this;
        $I->assertEquals($this->temp, $I->grabTextFrom(FeedsAndCollectionsPage::$collections_content));
    }

}