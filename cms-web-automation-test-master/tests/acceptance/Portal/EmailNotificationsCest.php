<?php
use \Step\ChannelEditSteps;

class EmailNotificationsCest {

    public function _before(\Step\LoginSteps $I) {
        $I->login();
    }

    /**
     * TESTRAIL TESTCASE ID: C362391
     *
     * @group test_priority_3
     *
     */
    public function checkTabs(ChannelEditSteps $I) {
        $I->wantTo('Check "Channel Details" and "Email Notifications" tabs are displayed on the page - C362391');
        $I->amOnChannelEditPage();
        $I->tabShouldBeDisplayed('channel_details_text');
        $I->tabShouldBeDisplayed('email_notification_text');
    }

    /**
     * TESTRAIL TESTCASE ID: C362393
     *
     * @group test_priority_3
     *
     */
    public function accessEmailNotificationsTabContent(ChannelEditSteps $I) {
        $I->wantTo('Access Email Notification Tab Content - C362393');
        $I->amOnChannelEditPageEmailNotificationsTab(false);
        $I->shouldBeOnEmailNotificationsTabContent();
    }

    /**
     * TESTRAIL TESTCASE ID: C362394
     *
     * @group test_priority_3
     *
     */
    public function emailInputValidation(ChannelEditSteps $I) {
        $I->wantTo('Check email address inserted is validated - C362394');
        $I->amOnChannelEditPageEmailNotificationsTab(false);
        $I->openAddRecipientDialogBox();
        $I->verifyDialogBoxElements();
        $I->typeEmailAddress(false);
        $I->warningShouldAppear();
        $I->buttonShouldNotBeActive();
        $I->typeEmailAddress(true);
        $I->buttonShouldBeActive();
    }

    /**
     * TESTRAIL TESTCASE ID: C376488
     *
     * @group test_priority_3
     *
     */
    public function verifyInvalidEmailAddress(ChannelEditSteps $I) {
        $I->wantTo('Verify invalid email address - C376488');
        $I->amOnChannelEditPageEmailNotificationsTab(false);
        $I->openAddRecipientDialogBox();
        $I->typeEmailAddress(false);
        $I->warningShouldAppear();
        $I->buttonShouldNotBeActive();
    }

    /**
     * TESTRAIL TESTCASE ID: C367216
     *
     * @group test_priority_3
     *
     */
    public function verifyDialogBoxCheckboxes(ChannelEditSteps $I) {
        $I->wantTo('Verify dialog box checkboxes checked/unchecked - C367216');
        $I->amOnChannelEditPageEmailNotificationsTab(false);
        $I->openAddRecipientDialogBox();
        $I->clickOnDialogCheckboxes();
        $I->dialogCheckboxesShouldBeChecked();
        $I->clickOnDialogCheckboxes();
        $I->dialogCheckboxesShouldBeUnchecked();
    }

    /**
     * TESTRAIL TESTCASE ID: C362395
     *
     * @group test_priority_3
     *
     */
    public function cancelAddingRecipient(ChannelEditSteps $I) {
        $I->wantTo('Cancel adding a new recipient - C362395');
        $I->amOnChannelEditPageEmailNotificationsTab(false);
        $I->openAddRecipientDialogBox();
        $I->cancelAddingRecipient();
        $I->dialogBoxShouldBeClosed();
    }

    /**
     * TESTRAIL TESTCASE ID: C376487
     *
     * @group test_priority_3
     *
     */
    public function addRecipient(ChannelEditSteps $I) {
        $I->wantTo('Add a new recipient - C376487');
        $I->amOnChannelEditPageEmailNotificationsTab(false);
        $I->openAddRecipientDialogBox();
        $I->typeEmailAddress(true);
        $I->buttonShouldBeActive();
        $I->addRecipient();
        $I->dialogBoxShouldBeClosed();
    }

    /**
     * TESTRAIL TESTCASE ID: C376490
     *
     * @group test_priority_3
     *
     */
    public function checkAddedRecipientsAreDisplayed(ChannelEditSteps $I) {
        $I->wantTo('Check added recipients are displayed - C376490');
        $I->amOnChannelEditPageEmailNotificationsTab(true);
        $I->addedRecipientShouldBeDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C376491
     *
     * @group test_priority_3
     *
     */
    public function checkAddingAnotherRecipientPosibilityExists(ChannelEditSteps $I) {
        $I->wantTo('Check the possibility of adding another recipient exists - C376491');
        $I->amOnChannelEditPageEmailNotificationsTab(true);
        $I->addedRecipientShouldBeDisplayed();
        $I->addNewRecipientButtonShouldBeDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C376492
     *
     * @group test_priority_3
     *
     */
    public function editAddedRecipient(ChannelEditSteps $I) {
        $I->wantTo('Check if the added recipient can be editted - C376492');
        $I->amOnChannelEditPageEmailNotificationsTab(true);
        $I->addedRecipientShouldBeDisplayed();
        $I->clickOnCheckboxes();
        $I->checkboxesShouldBeChecked();
        $I->clickOnCheckboxes();
        $I->checkboxesShouldBeUnchecked();
    }

    /**
     * TESTRAIL TESTCASE ID: C436667
     *
     * @group test_priority_3
     *
     */
    public function deletingRecipientPosibilityExists(ChannelEditSteps $I) {
        $I->wantTo('Check the possibility of deleting added recipient exists - C436667');
        $I->amOnChannelEditPageEmailNotificationsTab(true);
        $I->addedRecipientShouldBeDisplayed();
        $I->deleteAddedRecipientButtonShouldBeDisplayed();
    }

    /**
     * TESTRAIL TESTCASE ID: C436668
     *
     * @group test_priority_3
     *
     */
    public function savingChangesPosibilityExists(ChannelEditSteps $I) {
        $I->wantTo('Check the possibility of saving changes exists - C436668');
        $I->amOnChannelEditPageEmailNotificationsTab(true);
        $I->addedRecipientShouldBeDisplayed();
        $I->saveChangesButtonShouldNotBeActive();
        $I->clickOnCheckboxes();
        $I->saveChangesButtonShouldBeActive();
    }

    /**
     * TESTRAIL TESTCASE ID: C376489
     *
     * @group test_priority_3
     *
     */
    public function deleteRecipient(ChannelEditSteps $I) {
        $I->wantTo('Delete recipient - C376489');
        $I->amOnChannelEditPageEmailNotificationsTab(true);
        $I->addedRecipientShouldBeDisplayed();
        $I->deleteAddedRecipient();
        $I->alertPopupShouldBeClosed();
        $I->addedRecipientShouldBeDeleted();
    }

}