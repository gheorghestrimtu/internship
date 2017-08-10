<?php
namespace Page;

class ContentPage {

    public static $URL = '/chan/partnertest/catalog';

    // Content Table

    //Table rows - Content Page
    public static $checkbox_column = '1';
    public static $title_column = '3';
    public static $type_column = '4';
    public static $guid_column = 5;
    public static $seasons_column = '6';
    public static $episodes_column = '7';
    public static $published_column = 8;
    public static $transcode_percent_col = '9';



    public static $checkbox = ['xpath' => '/td/input[@type="checkbox"]'];
    public static $edit_pencil = ['xpath' => '//i[contains(@class, "edit") and contains(@class, "fa-pencil")]'];
    public static $rows_with_image = ['xpath' => '//tr/td[@class="img"]/img/ancestor::tr'];
    public static $rows_without_image = ['xpath' => '//tr/td[@class="img" and not(img)]/ancestor::tr'];
    public static $unpublished_rows = ['xpath' => '//tr[descendant::td[position()=4 and text()="{{category}}"] and descendant::td[position()=9 and text()="100%"] and descendant::td[position()=8 and text()="0%"]]'];
    public static $row_with_guid = ['xpath' => '//tr[descendant::td[position()=5] and descendant::*[text() = "{{guid}}"]]'];
    public static $per_page_dropdown = ['xpath' => '//table//select'];

    // Catalog Actions
    public static $publish_content_button = '//div[@class="catalog-actions"]//button[text()="Publish Content"]';

    // Modal Popup - Publish content
    public static $alert_popup = ['xpath' => '//div[contains(@class, "alert-popup")]'];
    public static $alert_popup_button_cancel = ['xpath' => '//div[contains(@class, "alert-popup")]//button[@class="cancel"]'];
    public static $alert_popup_button_publish = ['xpath' => '//div[contains(@class, "alert-popup")]//button[@class="yes"]'];

    // Toast
    public static $toast_success = ['xpath' => '//div[contains(@class, "toast") and contains(@class, "success")]'];

    public static function unpublished_rows($category) {
        return str_replace('{{category}}', $category, self::$unpublished_rows['xpath']);
    }

    public static function row_by_guid($guid) {
        return str_replace('{{guid}}', $guid, self::$row_with_guid['xpath']);
    }
}