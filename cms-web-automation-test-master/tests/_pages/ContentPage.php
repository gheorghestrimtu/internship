<?php

class ContentPage
{
    // include url of current page
    public static $URL = '/chan/partnertest/catalog';
    public static $URL_ingest = '/chan/ingesttest/catalog';

    public static $contentUrl = '/catalog/content/'; //Requires guid to be valid
    public static $contentListUrl = '/catalog/'; //Requires guid to be valid
    public static $mediaUrl = '/catalog/media/'; //Requires guid to be valid

    public static $episodeThumbnails = '/catalog/thumbnail/'; //Requires guid to be valid

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    //Content list pages
    public static $addFilterDropdown = 'div.opener';
    public static $addFilterDropdown_series = "//div[@class='options']//div[text()='Series']";
    public static $addFilterDropdown_movie = "//div[@class='options']//div[text()='Movies']";
    public static $addFilterDropdown_remove = "//div[@class='options']//div[@class='remove']";

    public static $scrollableTable = 'table.scrollable';

    public static $pageSelectDropdown = '//table//select';

    public static function tableRowByTitle($title)
    {
        return "//tr/td/span[text()='" . $title . "']";
    }

    public static function tableRowEditBtnByTitle($title)
    {
        return "//tr/td/span[text()='" . $title . "']/..//i[contains(@class, 'edit')]";
    }

    //Content pages
    public static $attributesList = 'div.attributes';
    public static $sortableTable = 'table.sortable';
    public static $clickableTable = 'table.clickable';

    //Table rows - Content Page
    public static $checkboxCol = '1';
    public static $titleCol = '3';
    public static $typeCol = '4';
    public static $guidCol = '5';
    public static $seasonsCol = '6';
    public static $episodesCol = '7';
    public static $publishedPercentCol = '8';
    public static $transcodePercentCol = '9';

    //Table rows - Season List
    public static $checkboxCol_season = '1';
    public static $numberCol_season = '2';
    public static $titleCol_season = '3';
    public static $typeCol_season = '4';
    public static $guidCol_season = '5';
    public static $episodesCol_season = '6';
    public static $publishedPercentCol_season = '7';
    public static $transcodePercentCol_season = '8';

    //Table rows - Episode List
    public static $checkboxCol_episode = '1';
    public static $numberCol_episode = '3';
    public static $titleCol_episode = '4';
    public static $typeCol_episode = '5';
    public static $guidCol_episode = '6';
    public static $publishedPercentCol_episode = '7';
    public static $transcodePercentCol_episode = '8';

    //EDIT PAGES
    public static $attributesSection = "//form[contains(@class, 'attributes')]";

    //Visibility
    public static $publishCheckbox = "(//div[contains(@class, 'attributes')])[1]//label[contains(@class, 'checkbox')]";
    public static $publishCheckboxChecked = "(//div[contains(@class, 'attributes')])[1]//label[contains(@class, 'checked')]";

    //Windowing
    public static $geoLocationRow = "//label[text()='Geo Location']/..";
    public static $geoLocationRow_input = "//label[text()='Geo Location']/..//input";

    public static $windowing_listingBegin_input = "(//div[@class='date-time-input'])[1]//input";
    public static $windowing_listingBegin_clear = "(//div[@class='date-time-input'])[1]//button[@class='date-clear']";

    public static $windowing_premiumStartOfWindow_input = "(//div[@class='date-time-input'])[2]//input";
    public static $windowing_premiumStartOfWindow_clear = "(//div[@class='date-time-input'])[2]//button[@class='date-clear']";

    public static $windowing_premiumEndOfWindow_input = "(//div[@class='date-time-input'])[3]//input";
    public static $windowing_premiumEndOfWindow_clear = "(//div[@class='date-time-input'])[3]//button[@class='date-clear']";

    public static $windowing_freeStartOfWindow_input = "(//div[@class='date-time-input'])[4]//input";
    public static $windowing_freeStartOfWindow_clear = "(//div[@class='date-time-input'])[4]//button[@class='date-clear']";

    public static $windowing_freeEndOfWindow_input = "(//div[@class='date-time-input'])[5]//input";
    public static $windowing_freeEndOfWindow_clear = "(//div[@class='date-time-input'])[5]//button[@class='date-clear']";

    public static $windowing_premiumCheckbox = "//div[contains(@class, 'form-window')]//div[contains(@class, 'form-window')][1]//label[contains(@class, 'checkbox')]";
    public static $windowing_premiumCheckboxChecked = "//div[contains(@class, 'form-window')]//div[contains(@class, 'form-window')][1]//label[contains(@class, 'checked')]";

    public static $windowing_freeCheckbox = "//div[contains(@class, 'form-window')]//div[contains(@class, 'form-window')][2]//label[contains(@class, 'checkbox')]";
    public static $windowing_freeCheckboxChecked = "//div[contains(@class, 'form-window')]//div[contains(@class, 'form-window')][2]//label[contains(@class, 'checked')]";


    public static $calendar_caption_xpath = '//*[@class="DayPicker-Caption"]';
    public static $calendar_main_xpath = '//div[contains(@class, "DayPicker") and contains(@class, "DayPicker")]';
    public static $calendar_main = 'div.DayPicker.DayPicker--en';
    public static $calendar_prevBtn = 'span.DayPicker-NavButton--prev';
    public static $calendar_nextBtn = 'span.DayPicker-NavButton--next';

    public static $calendar_confirm = "//*[text()='OK']";
    public static $calendar_cancel = "//*[text()='Cancel']";

    //Attributes List Rows
    public static $channelRow = "//label[text()='Channel']/..";

    public static $seriesTitleRow = "//label[text()='Series Title']/..";
    public static $seriesTitleRow_editable = "//label[text()='Series Title']/..//input";

    public static $seasonTitleRow = "//label[text()='Season Title']/..";
    public static $seasonTitleRow_editable = "//label[text()='Season Title']/..//input";

    public static $seasonNumberRow = "//label[text()='Season Number']/..";
    public static $seasonNumberRow_editable = "//label[text()='Season Number']/..//input";

    public static $episodeTitleRow = "//label[text()='Episode Title']/..";
    public static $episodeTitleRow_editable = "//label[text()='Episode Title']/..//input";

    public static $episodeNumberRow = "//label[text()='Episode Number']/..";
    public static $episodeNumberRow_editable = "//label[text()='Episode Number']/..//input";

    public static $movieTitleRow = "//label[text()='Movie Title']/..";
    public static $movieTitleRow_editable = "//label[text()='Movie Title']/..//input";

    public static $descriptionRow = "//label[text()='Description']/..";
    public static $descriptionRow_editable = "//label[text()='Description']/..//textarea";

    public static $categoriesRow = "//label[text()='Categories']/..";

    public static $tagsRow = "//label[text()='Tags']/..";

    public static $audioLangRow = "//label[text()='Audio Language']/..";

    public static $subtitlesRow = "//label[text()='Subtitles']/..";

    public static $publisherRow = "//label[text()='Publisher']/..";

    public static $maturityRow = "//label[text()='Maturity Rating']/..";

    public static $releaseYearRow = "//label[text()='Year']/..";

    public static $airDateRow = "//label[text()='Air Date']/..";
    public static $airDateRow_editable = "//label[text()='Air Date']/..//input";

    //Video Page
    public static $adBreaksRow = "//label[text()='Ad Breaks']/..";

    public static $videoTypeRow = "//label[text()='Video Type']/..";

    public static $videoTitleRow = "//label[text()='Video Title']/..";
    public static $videoTitleRow_editable = "//label[text()='Video Title']/..//input";

    public static $durationRow = "//label[text()='Duration']/..";

    public static $videoHashRow = "//label[text()='Video Hash']/..";

    //Tables
    //Seasons
    public static $seasonsTable = "//h1[text()='Seasons']/..//table";

    public static $seasonsTable_numberHeader = "//h1[text()='Seasons']/..//table/thead/tr/th[1]";
    public static $seasonsTable_firstNumber = "//h1[text()='Seasons']/..//table/tbody/tr/td[1]";

    public static $seasonsTable_titleHeader = "//h1[text()='Seasons']/..//table/thead/tr/th[2]";
    public static $seasonsTable_firstTitle = "//h1[text()='Seasons']/..//table/tbody/tr/td[2]";

    public static $seasonsTable_guidHeader = "//h1[text()='Seasons']/..//table/thead/tr/th[3]";
    public static $seasonsTable_firstGuid = "//h1[text()='Seasons']/..//table/tbody/tr/td[3]";

    public static $seasonsTable_episodesHeader = "//h1[text()='Seasons']/..//table/thead/tr/th[4]";
    public static $seasonsTable_firstEpisodes = "//h1[text()='Seasons']/..//table/tbody/tr/td[4]";

    //Episodes
    public static $episodesTable = "//h1[text()='Episodes']/..//table";

    public static $episodesTable_numberHeader = "//h1[text()='Episodes']/..//table/thead/tr/th[1]";
    public static $episodesTable_firstNumber = "//h1[text()='Episodes']/..//table/tbody/tr/td[1]";

    public static $episodesTable_titleHeader = "//h1[text()='Episodes']/..//table/thead/tr/th[2]";
    public static $episodesTable_firstTitle = "//h1[text()='Episodes']/..//table/tbody/tr/td[2]";

    public static $episodesTable_guidHeader = "//h1[text()='Episodes']/..//table/thead/tr/th[3]";
    public static $episodesTable_firstGuid = "//h1[text()='Episodes']/..//table/tbody/tr/td[3]";

    //Videos
    public static $videoTable = "//h1[text()='Videos']/..//table";

    public static $videoTable_titleHeader = "//h1[text()='Videos']/..//table/thead/tr/th[1]";
    public static $videoTable_firstTitle = "//h1[text()='Videos']/..//table/tbody/tr/td[1]/span";

    public static $videoTable_durationHeader = "//h1[text()='Videos']/..//table/thead/tr/th[2]";
    public static $videoTable_firstDuration = "//h1[text()='Videos']/..//table/tbody/tr/td[2]";

    public static $videoTable_guidHeader = "//h1[text()='Videos']/..//table/thead/tr/th[3]";
    public static $videoTable_firstGuid = "//h1[text()='Videos']/..//table/tbody/tr/td[3]";

    //Images
    public static $imagesTable = "//h1[text()='Images']/..//table";

    public static $imagesTable_titleHeader = "//h1[text()='Images']/..//table/thead/tr/th[2]";
    public static $imagesTable_firstTitle = "//h1[text()='Images']/..//table/tbody/tr/td[2]";

    public static $imagesTable_typeHeader = "//h1[text()='Images']/..//table/thead/tr/th[3]";
    public static $imagesTable_firstType = "//h1[text()='Images']/..//table/tbody/tr/td[3]";


    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }
}