<?php
namespace Page;

abstract class ContentEditPage {

    public static $URL = '/catalog/content/{{guid}}';


    // ATTRIBUTES
    public static $title = ['xpath' => '//label[contains(text()," Title")]/following-sibling::input'];
    public static $channel = ['xpath' => '//label[text() = "Channel"]/following-sibling::span'];

    // Related Content
    public static $linked_content_input = ['xpath' => '//label[text()="Linked Content"]/following-sibling::div//input'];
    public static $linked_content_button = ['xpath' => '//label[text()="Linked Content"]/following-sibling::div//button'];
    public static $linked_content_unlink = ['xpath' => '//label[text()="Linked Content"]/following-sibling::div//a[@class="unlink"]'];
    public static $linked_content_error = ['xpath' => '//label[text()="Linked Content"]/following-sibling::div//div[@class="input-error"]'];

    // Related Content - Card
    public static $linked_card_flags = ['xpath' => '//div[contains(@class, "content-card") and position() = 1]/*[@class="flags"]'];
    public static $linked_card_guid = ['xpath' => '//div[contains(@class, "content-card") and position() = 1]/*[@class="guid"]'];
    public static $linked_card_title = ['xpath' => '//div[contains(@class, "content-card") and position() = 1]/h2'];
    public static $linked_card_channel = ['xpath' => '//div[contains(@class, "content-card") and position() = 1]/h1'];
    public static $linked_card_2_flags = ['xpath' => '//div[contains(@class, "content-card") and position() = 2]/*[@class="flags"]'];
    public static $linked_card_2_guid = ['xpath' => '//div[contains(@class, "content-card") and position() = 2]/*[@class="guid"]'];
    public static $linked_card_2_title = ['xpath' => '//div[contains(@class, "content-card") and position() = 2]/h2/span'];
    public static $linked_card_2_channel = ['xpath' => '//div[contains(@class, "content-card") and position() = 2]/h1'];

    // Visibility
    public static $published_unchecked_text = 'Media is currently hidden from all users.';
    public static $published_checked_text = 'Users who match window settings can view and/or watch content as defined.';
    public static $published_checkbox = ['xpath' => '(//div[@class="form-item"])[descendant::span[text()="Published"]]//label[contains(@class, "checkbox")]'];
    public static $published_checkbox_checked = "(//div[contains(@class, 'attributes')])[1]//label[contains(@class, 'checked')]";

    public static $last_published_format = 'F d, Y g:i A T';
    public static $last_published = ['xpath' => '//div[./h1[text()="Visibility"]]//div[@class="messages"]/small'];
    public static $last_published_data = ['xpath' => '//div[./h1[text()="Visibility"]]//div[@class="messages"]/small/span[2]'];

    public static $localization_sub = ['xpath' => '//input[@id="localization_sub"]'];
    public static $localization_dub = ['xpath' => '//input[@id="localization_dub"]'];

    public static $image_section = ['xpath' => '//h1[text()="Images"]'];
    public static $landscape_image = ['xpath' => '//td[text()="Landscape Poster"]'];
    public static $category_row = ['xpath' => '//td[text()="{{category}}"]'];
    public static $category_rows = ['xpath' => '//td[text()="{{category}}"]/ancestor::tr'];
    public static $specific_category_row = ['xpath' => '(//td[text()="{{category}}"])[{{index}}]{{pencil}}'];
    public static $guid_row = ['xpath' => '//span[text()="{{guid}}"]/ancestor::span/ancestor::td/ancestor::tr'];
    public static $category_row_not_zero = ['xpath' => '/td[{{index}}][not(contains(text(), "0"))]'];
    public static $category_row_cell = ['xpath' => ''];
    public static $pencil = ['xpath' => '/ancestor::tr/td/i[contains(@class,"edit")]'];
    public static $pencil2 = ['xpath' => '/td/i[contains(@class,"edit")]'];
    public static $video_row = ['xpath' => '//h1[text()="Videos"]/following-sibling::table/tbody/tr[{{index}}]'];
    public static $video_type_cell = ['xpath' => '({{xpath}})[{{index}}]/ancestor::tr/td[6]'];
    public static $video_guid_cell = ['xpath' => '({{xpath}})[{{index}}]/ancestor::tr/td[7]'];
    public static $maturity_rating_input = ['xpath' => '//input[@id="rating_type_{{type}}"]'];
    public static $maturity_rating_tv_label = ['xpath' => '//label[@for="rating_type_tv"]'];
    public static $maturity_rating_movie_label = ['xpath' => '//label[@for="rating_type_movie"]'];
    public static $maturity_rating_tv_input = ['xpath' => '//input[@id="rating_type_tv"]'];
    public static $maturity_rating_movie_input = ['xpath' => '//input[@id="rating_type_movie"]'];
    public static $maturity_rating_checked = ['css' => 'input[name="rating_type"]:checked'];
    public static $maturity_rating_options = ['css' => 'input[name="rating"][data-reactid*="{{type}}"]'];
    public static $maturity_rating_options_li = ['css' => 'ul.maturity-rating-input > li[data-reactid*="{{type}}"] > ul[data-reactid*="{{type}}"] > li'];
    public static $maturity_rating_option_label = ['css' => 'ul[data-reactid*="{{type}}"] > li:nth-child({{index}}) > label'];
    public static $maturity_rating_option_checked = ['css' => 'input[name="rating"]:checked'];
    public static $maturity_rating_option_li = ['css' => 'ul.maturity-rating-input > li[data-reactid*="{{type}}"] > ul[data-reactid*="{{type}}"] > li:nth-child({{index}})'];
    public static $save_bar = ['xpath' => '//div[@class="save-bar"]/button'];
    public static $LandscapeImage = ['xpath' => '//td[text()="Landscape Poster"]'];
    public static $PortraitImage = ['xpath' => '//td[text()="Portrait Poster"]'];
    public static $change_thumbnail = ['xpath' => '//a[@class="change-thumbnail"]'];
    public static $poster_image = "//h1[text()='Images']/..//table/tbody/tr/td[3][text()='{{image_type}}']";
    public static $sectionAfterAttributes = ['xpath' => '//form[contains(@class, "attributes")]/following-sibling::div/h1'];

    public static $ExtraVideoGuids = [
        'Movie' => [['GRDQZ4J9Y'], ['GYWEPXNMY'], ['GR2PZWV8R']],
        'Series' => [['GRP891EMR']],
        'Season' => [['GRP891EMR', 'G68V8JP96']],
        'Episode' => [['G6WEPXWM6', 'GY098Q5GY', 'GY7582XM6']]
    ];
    public static $LandscapeImageGuids = [
        'Movie' => [['GRDQZ4J9Y'], ['GYWEPXNMY'], ['GR2PZWV8R']],
        'Series' => [['GR49808Z6'], ['G6WEPX886'], ['GRP891EMR']],
        'Season' => [['GR49808Z6', 'GY19857KR']],
        'Episode' => [['GR49808Z6', 'GY19857KR', 'GRJQD2ZWY'], ['GR49808Z6', 'GRP891Z1R', 'GY2PZW9MY']]
    ];
    public static $PortraitImageGuids = [
        'Movie' => [['GRDQZ4J9Y'], ['GYWEPXNMY'], ['GR2PZWV8R']],
        'Series' => [['GR49808Z6'], ['G6WEPX886'], ['GRP891EMR']],
        'Season' => [['GR49808Z6', 'GY19857KR']],
        'Episode' => [['GR49808Z6', 'GY19857KR', 'GRJQD2ZWY'], ['GR49808Z6', 'GRP891Z1R', 'GY2PZW9MY']]
    ];

    public static function getEditGuidByContentType($type) {
        switch ($type) {
            case 'series':
                return ContentSeriesEditPage::getEditGuid();
            case 'season':
                return ContentSeasonEditPage::getEditGuid();
            case 'episode':
                return ContentEpisodeEditPage::getEditGuid();
            case 'movie':
                return ContentMovieEditPage::getEditGuid();
            default:
                return ContentMovieEditPage::getEditGuid();
        }
    }

    public static function urlByGuid($guid){
        return str_replace('{{guid}}',$guid,self::$URL);
    }
}