<?php
namespace Page;

class ChannelEditPage {

    public static $URL = '/channels/partnertest';

    public static $channel_details_text = ['xpath' => '//a[text()="Channel Details"]'];
    public static $email_notification_text = ['xpath' => '//a[text()="Email Notifications"]'];

    public static $channel_status_live = ['xpath' => '//div[@class="status"]/span[contains(text(), "Status")]/following-sibling::div[text()="LIVE"]'];
    public static $channel_status_off = ['xpath' => '//div[@class="status"]/span[contains(text(), "Status")]/following-sibling::div[text()="OFF"]'];

    public static $title_input = ['xpath' => '//form/div[3]/input'];
    public static $description_input = ['xpath' => '//form/div[4]/textarea'];
    public static $color_input = ['xpath' => '//form/div[5]/div/input'];
    public static $save_changes_button = ['css' => 'button.button.primary'];
    public static $images = '//*[@class="form-item"]/img';
    public static $auto_ingest_checkbox = ['xpath' => '//label[text()="Auto Ingest"]/following-sibling::span/input[@type="checkbox"]'];
    public static $status_live = ['xpath' => '//div[text()="LIVE"]'];
    public static $status_off = ['xpath' => '//div[text()="OFF"]'];

    public static $edited_title_text = 'Edited Portal & Content Testing';
    public static $title_text = 'Portal & Content Testing';
    public static $edited_description_text = 'EDITED For testing Portal and specific content scenarios.';
    public static $description_text = 'For testing Portal and specific content scenarios.';
    public static $edited_color = '#000000';
    public static $color_text = '#FFFFFF';

    public static $add_recipient_text = ['xpath' => '//h2[text()="Add first notification recipient"]'];
    public static $missing_recipient_message = 'No one is receiving email notifications yet';
    public static $add_recipient_button = ['xpath' => '//button[text()="Add Recipient"]'];
    public static $save_all_changes_button = ['xpath' => '//button[text()="Save Changes"]'];
    public static $add_recipient_dialog_box = ['css' => '.add-recipient'];
    public static $add_recipient_dialog_box_title = ['xpath' => '//div[contains(@class, "add-recipient")]/div/label[text()="Recipient Email Address"]'];
    public static $add_recipient_dialog_box_input_email = ['xpath' => '//div[contains(@class, "add-recipient")]/div/input[@placeholder="Email Address"]'];
    public static $add_recipient_dialog_box_checkbox_starts = ['xpath' => '//div[contains(@class, "add-recipient")]/div/div/label/input[contains(@data-reactid, "accepted")]'];
    public static $add_recipient_dialog_box_checkbox_completed = ['xpath' => '//div[contains(@class, "add-recipient")]/div/div/label/input[contains(@data-reactid, "completed")]'];
    public static $add_recipient_dialog_box_checkbox_fails = ['xpath' => '//div[contains(@class, "add-recipient")]/div/div/label/input[contains(@data-reactid, "errors")]'];
    public static $add_recipient_dialog_box_button_cancel = ['xpath' => '//div[contains(@class, "add-recipient")]/div/div/button[text()="Cancel"]'];
    public static $add_recipient_dialog_box_button_add = ['xpath' => '//div[contains(@class, "add-recipient")]/div/div/button[text()="Add Email"]'];
    public static $add_recipient_dialog_box_warning = ['xpath' => '//div[contains(@class, "add-recipient")]/div/div/div[text()="Invalid email address"]'];
    public static $add_another_recipient_button = ['xpath' => '//button[text()="Add Recipient"]'];
    public static $added_recipients_table = ['css' => 'table.listing-table'];
    public static $added_recipients_rows = ['xpath' => '//table[contains(@class, "listing-table")]/tbody/tr'];
    public static $added_recipients_row_by_index = ['xpath' => '(//table[contains(@class, "listing-table")]/tbody/tr)[{{index}}]'];
    public static $added_recipients_row_by_email = ['xpath' => '//td/span[text()="{{test_email}}"]/ancestor::td/ancestor::tr'];
    public static $checkbox_starts = ['xpath' => '//td/span[text()="{{test_email}}"]/ancestor::td/ancestor::tr/td/input[contains(@data-reactid, "accepted")]'];
    public static $checkbox_completed = ['xpath' => '//td/span[text()="{{test_email}}"]/ancestor::td/ancestor::tr/td/input[contains(@data-reactid, "completed")]'];
    public static $checkbox_fails = ['xpath' => '//td/span[text()="{{test_email}}"]/ancestor::td/ancestor::tr/td/input[contains(@data-reactid, "errors")]'];
    public static $delete_recipient_button_by_index = ['xpath' => '(//table[contains(@class, "listing-table")]/tbody/tr)[{{index}}]/td/button[@class="remove"]'];
    public static $delete_recipient_button_by_email = ['xpath' => '//td/span[text()="{{test_email}}"]/ancestor::td/ancestor::tr/td/button[@class="remove"]'];
    public static $alert_popup = ['css' => 'div.alert-popup'];
    public static $cancel_deleting_recipient_button = ['xpath' => '//div[contains(@class, "alert-popup")]/button[text()="Cancel"]'];
    public static $confirm_deleting_recipient_button = ['xpath' => '//div[contains(@class, "alert-popup")]/button[text()="Delete Email"]'];

}