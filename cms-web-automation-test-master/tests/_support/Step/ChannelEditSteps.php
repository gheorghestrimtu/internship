<?php
namespace Step;

use Page\ChannelEditPage;

class ChannelEditSteps extends \AcceptanceTester {

    private $test_email = 'test@test.com';

    public function initialAdjustments($recipients_required) {
        $I = $this;
        if ($recipients_required) {
            if (!count($I->findElements('xpath', str_replace('{{test_email}}', $this->test_email, ChannelEditPage::$added_recipients_row_by_email['xpath'])))) {
                $this->openAddRecipientDialogBox();
                $I->typeEmailAddress(true);
                $I->addRecipient();
            }
        } else {
            $rows = $I->findElements('xpath', ChannelEditPage::$add_recipient_text['xpath']) ? [] : $I->findElements('xpath', ChannelEditPage::$added_recipients_rows['xpath']);
            for ($i=count($rows); $i>0; $i--) {
                $remove_button = str_replace('{{index}}', $i, ChannelEditPage::$delete_recipient_button_by_index['xpath']);
                $I->moveMouseOver(str_replace('{{index}}', $i, ChannelEditPage::$added_recipients_row_by_index['xpath']));
                $I->waitForElementVisible($remove_button);
                $I->click($remove_button);
                $this->confirmDeletingAddedRecipient();
            }
        }
    }

    public function shouldBeOnChannelEditPage() {
        $I = $this;
        $I->waitForElementVisible(ChannelEditPage::$channel_details_text);
    }

    public function amOnChannelEditPage() {
        $I = $this;
        $I->amOnPage(ChannelEditPage::$URL);
        $I->waitForElementVisible(ChannelEditPage::$images);
    }

    public function amOnChannelEditPageEmailNotificationsTab($recipients_required) {
        $I = $this;
        $this->amOnChannelEditPage();
        $this->accessTab('email_notification_text');
        $this->initialAdjustments($recipients_required);
    }

    public function editChannel($input, $edited_text) {
        $I = $this;
        $I->wait(1);
        $I->fillField($input, $edited_text);
        $I->click(ChannelEditPage::$save_changes_button);
    }

    public function changesShouldBeSaved($input, $edited_text) {
        $I = $this;
        $I->seeInField($input, $edited_text);
    }
  
    public function tabShouldBeDisplayed($tab) {
        $I = $this;
        $I->waitForElementVisible(ChannelEditPage::${$tab}, 30);
    }

    public function accessTab($tab) {
        $I = $this;
        $this->tabShouldBeDisplayed($tab);
        $I->click(ChannelEditPage::${$tab});
    }

    public function shouldBeOnEmailNotificationsTabContent() {
        $I = $this;
        $I->waitForElementVisible(ChannelEditPage::$add_recipient_text, 30);
        $I->waitForText(ChannelEditPage::$missing_recipient_message);
    }

    public function openAddRecipientDialogBox() {
        $I = $this;
        $I->click(ChannelEditPage::$add_recipient_button);
        $I->waitForElement(ChannelEditPage::$add_recipient_dialog_box);
    }

    public function verifyDialogBoxElements() {
        $I = $this;
        $I->waitForElement(ChannelEditPage::$add_recipient_dialog_box_title);
        $I->waitForElement(ChannelEditPage::$add_recipient_dialog_box_input_email);
        $I->waitForElement(ChannelEditPage::$add_recipient_dialog_box_checkbox_starts);
        $I->waitForElement(ChannelEditPage::$add_recipient_dialog_box_checkbox_completed);
        $I->waitForElement(ChannelEditPage::$add_recipient_dialog_box_checkbox_fails);
        $I->waitForElement(ChannelEditPage::$add_recipient_dialog_box_button_cancel);
        $I->waitForElement(ChannelEditPage::$add_recipient_dialog_box_button_add);
    }

    public function typeEmailAddress($valid) {
        $I = $this;
        $email_address = $valid ? $this->test_email : explode('@', $this->test_email)[0];
        $I->fillField(ChannelEditPage::$add_recipient_dialog_box_input_email, $email_address);
        $I->click(ChannelEditPage::$add_recipient_dialog_box_title);
    }

    public function warningShouldAppear() {
        $I = $this;
        $I->waitForElementVisible(ChannelEditPage::$add_recipient_dialog_box_warning, 30);
    }

    public function buttonShouldBeActive() {
        $I = $this;
        $disabled = $I->grabAttributeFrom(ChannelEditPage::$add_recipient_dialog_box_button_add, 'disabled');
        $I->assertEmpty($disabled);
    }

    public function buttonShouldNotBeActive() {
        $I = $this;
        $disabled = $I->grabAttributeFrom(ChannelEditPage::$add_recipient_dialog_box_button_add, 'disabled');
        $I->assertNotEmpty($disabled);
    }

    public function cancelAddingRecipient() {
        $I = $this;
        $I->click(ChannelEditPage::$add_recipient_dialog_box_button_cancel);
    }

    public function addRecipient() {
        $I = $this;
        $I->click(ChannelEditPage::$add_recipient_dialog_box_button_add);
    }

    public function dialogBoxShouldBeClosed() {
        $I = $this;
        $I->dontSeeElement(ChannelEditPage::$add_recipient_dialog_box);
    }

    public function clickOnDialogCheckboxes() {
        $I = $this;
        $I->click(ChannelEditPage::$add_recipient_dialog_box_checkbox_starts);
        $I->click(ChannelEditPage::$add_recipient_dialog_box_checkbox_completed);
        $I->click(ChannelEditPage::$add_recipient_dialog_box_checkbox_fails);
    }

    public function dialogCheckboxesShouldBeChecked() {
        $I = $this;
        $I->wait(1);
        $I->seeCheckboxIsChecked(ChannelEditPage::$add_recipient_dialog_box_checkbox_starts);
        $I->seeCheckboxIsChecked(ChannelEditPage::$add_recipient_dialog_box_checkbox_completed);
        $I->seeCheckboxIsChecked(ChannelEditPage::$add_recipient_dialog_box_checkbox_fails);
    }

    public function dialogCheckboxesShouldBeUnchecked() {
        $I = $this;
        $I->wait(1);
        $I->dontSeeCheckboxIsChecked(ChannelEditPage::$add_recipient_dialog_box_checkbox_starts);
        $I->dontSeeCheckboxIsChecked(ChannelEditPage::$add_recipient_dialog_box_checkbox_completed);
        $I->dontSeeCheckboxIsChecked(ChannelEditPage::$add_recipient_dialog_box_checkbox_fails);
    }

    public function addedRecipientShouldBeDisplayed() {
        $I = $this;
        $I->waitForElementVisible(ChannelEditPage::$added_recipients_table, 30);
        $I->waitForElementVisible(str_replace('{{test_email}}', $this->test_email, ChannelEditPage::$added_recipients_row_by_email['xpath']), 30);
    }

    public function addNewRecipientButtonShouldBeDisplayed() {
        $I = $this;
        $I->seeElement(ChannelEditPage::$add_another_recipient_button);
    }

    public function saveChangesButtonShouldBeActive() {
        $I = $this;
        $disabled = $I->grabAttributeFrom(ChannelEditPage::$save_all_changes_button, 'disabled');
        $I->assertEmpty($disabled);
    }

    public function saveChangesButtonShouldNotBeActive() {
        $I = $this;
        $disabled = $I->grabAttributeFrom(ChannelEditPage::$save_all_changes_button, 'disabled');
        $I->assertNotEmpty($disabled);
    }

    public function deleteAddedRecipientButtonShouldBeDisplayed() {
        $I = $this;
        $row = str_replace('{{test_email}}', $this->test_email, ChannelEditPage::$added_recipients_row_by_email['xpath']);
        $delete_button = str_replace('{{test_email}}', $this->test_email, ChannelEditPage::$delete_recipient_button_by_email['xpath']);
        $I->moveMouseOver($row);
        $I->waitForElementVisible($delete_button, 30);
    }

    public function clickOnCheckboxes() {
        $I = $this;
        $I->click(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_starts['xpath']));
        $I->click(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_completed['xpath']));
        $I->click(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_fails['xpath']));
    }

    public function checkboxesShouldBeChecked() {
        $I = $this;
        $I->wait(1);
        $I->seeCheckboxIsChecked(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_starts['xpath']));
        $I->seeCheckboxIsChecked(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_completed['xpath']));
        $I->seeCheckboxIsChecked(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_fails)['xpath']);
    }

    public function checkboxesShouldBeUnchecked() {
        $I = $this;
        $I->wait(1);
        $I->dontSeeCheckboxIsChecked(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_starts['xpath']));
        $I->dontSeeCheckboxIsChecked(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_completed['xpath']));
        $I->dontSeeCheckboxIsChecked(str_replace('{{test_email}}', $this->test_email,  ChannelEditPage::$checkbox_fails['xpath']));
    }

    public function deleteAddedRecipient() {
        $I = $this;
        $delete_button = str_replace('{{test_email}}', $this->test_email, ChannelEditPage::$delete_recipient_button_by_email['xpath']);
        $this->deleteAddedRecipientButtonShouldBeDisplayed();
        $I->click($delete_button);
        $this->cancelDeletingAddedRecipient();
        $this->deleteAddedRecipientButtonShouldBeDisplayed();
        $I->click($delete_button);
        $this->confirmDeletingAddedRecipient();
    }

    public function cancelDeletingAddedRecipient() {
        $I = $this;
        $I->waitForElementVisible(ChannelEditPage::$alert_popup, 30);
        $I->click(ChannelEditPage::$cancel_deleting_recipient_button);
    }

    public function confirmDeletingAddedRecipient() {
        $I = $this;
        $I->waitForElementVisible(ChannelEditPage::$alert_popup, 30);
        $I->click(ChannelEditPage::$confirm_deleting_recipient_button);
    }

    public function alertPopupShouldBeClosed() {
        $I = $this;
        $I->dontSeeElement(ChannelEditPage::$alert_popup);
    }

    public function addedRecipientShouldBeDeleted() {
        $I = $this;
        $I->dontSeeElement(str_replace('{{test_email}}', $this->test_email, ChannelEditPage::$added_recipients_row_by_email['xpath']));
    }
  
    public function channelStatusShouldBeDisplayed() {
        $I = $this;
        $I->seeElement(\Codeception\Util\Locator::combine(ChannelEditPage::$channel_status_live['xpath'], ChannelEditPage::$channel_status_off['xpath']));
    }
  
    public function seeStatus() {
        $I = $this;
        $total = 0;
        $total += count($I->findElements('xpath', ChannelEditPage::$status_live['xpath']));
        $total += count($I->findElements('xpath', ChannelEditPage::$status_off['xpath']));
        $I->assertEquals(1, $total);
    }

}