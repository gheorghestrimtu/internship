<?php
namespace Page;

class ContentPage {

    public static $URL = '/chan/partnertest/catalog';

    // Content Table

    //Content list pages
    public static $addFilterDropdown = ['css'=>'div.opener'];
    public static $addFilterDropdown_series = ['xpath'=>"//div[@class='options']//div[text()='Series']"];
    public static $addFilterDropdown_movie = ['xpath'=>"//div[@class='options']//div[text()='Movies']"];
    public static $addFilterDropdown_remove = ['xpath' => "//div[@class='options']//div[@class='remove']"];

    //Table rows - Content Page
    public static $checkbox_column = '1';
    public static $title_column = '3';
    public static $type_column = '4';
    public static $guid_column = 5;
    public static $seasons_column = '6';
    public static $episodes_column = '7';
    public static $published_column = 8;
    public static $transcode_percent_col = '9';

    public static $table_rows=['xpath'=>'//table/tbody/tr'];
    public static $all_titles=['xpath'=>'//table//tr//td[3]'];
    public static $all_types=['xpath'=>'//table//tr/td[4]'];
    public static $all_guids=['xpath'=>'//table//tr/td[5]'];
    public static $all_published_percentage=['xpath'=>'//table//tr/td[8]'];
    public static $all_transcoded_percentage=['xpath'=>'//table//tr/td[9]'];

    public static $maximum_items=['xpath'=>'//table/tfoot//div/div'];


    public static $checkbox = ['xpath' => '/td/input[@type="checkbox"]'];
    public static $edit_pencil = ['xpath' => '//i[contains(@class, "edit") and contains(@class, "fa-pencil")]'];
    public static $rows_with_image = ['xpath' => '//tr/td[@class="img"]/img/ancestor::tr'];
    public static $rows_without_image = ['xpath' => '//tr/td[@class="img" and not(img)]/ancestor::tr'];
    public static $unpublished_rows = ['xpath' => '//tr[descendant::td[position()=4 and text()="{{category}}"] and descendant::td[position()=9 and text()="100%"] and descendant::td[position()=8 and text()="0%"]]'];
    public static $row_with_guid = ['xpath' => '//tr[descendant::td[position()=5] and descendant::*[text() = "{{guid}}"]]'];
    public static $per_page_dropdown = ['xpath' => '//table//select'];
    public static $rows_with_series = ['xpath' => '//tr[descendant::td[position()=4 and text()="Series"] ]'];
    public static $rows_with_series_and_episodes = ['xpath' => '//tr[descendant::td[position()=6 and text()!="0"]]'];
    public static $rows_with_movie = ['xpath' => '//tr[descendant::td[position()=4 and text()="Movie"]]'];

    //Table Header
    public static $table_header = ['xpath' => '//table//tr/th'];
    public static $table_header_title = ['xpath' => '//table//tr/th[3]'];
    public static $table_header_published = ['xpath' => '//table//tr/th[8]'];
    public static $table_header_transcoded = ['xpath' => '//table//tr/th[9]'];

    //Special Titles
    public static $title_for_testing_publish_percentages='Test Series Publish Percentages';
    public static $published_percentages_for_title_for_testing_publish_percentages=['xpath'=>'//span[contains(text(), \'Test Series Publish Percentages\')]/../../td[8]'];
    public static $title_for_testing_transcoded_percentages='Test Series Transcode Percentages';
    public static $transcoded_percentages_for_title_for_testing_transcoded_percentages=['xpath'=>'//span[contains(text(), \'Test Series Transcode Percentages\')]/../../td[9]'];
    public static $title_for_testing_transcode_status_ignores_extras='Series Transcoding Extras';
    public static $transcoded_percentages_for_title_for_testing_transcode_status_ignores_extras=['xpath'=>'//span[contains(text(), \'Series Transcoding Extras\')]/../../td[9]'];


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

    public static function tableRowByTitle($title)
    {
        return "//tr/td/span[text()='" . $title . "']";
    }

}