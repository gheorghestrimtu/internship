<?php
namespace Page;

class ContentEpisodeEditPage extends ContentEditPage {


    //For Viewing Full Data
    private static $guid_view_full_proto0 = 'GYWEX5NNY';
    private static $guid_view_full_staging = 'GY7582XM6';

    //For Viewing Minimum Data
    private static $guid_view_minimum_proto0 = 'GR9PJE1D6';
    private static $guid_view_minimum_staging = 'GYJQD2XD6';

    //For Editing Data
    private static $guid_edit_proto0 = 'GR195D1Q6';
    private static $guid_edit_staging = 'GRMG01W5R';


    public static $episodeEditData_proto0 = 'GR195D1Q6';
    public static $episodeEditData_staging = 'GY7582XM6';


    public static function getViewGuid() {
        return self::${'guid_view_full_' . APPLICATION_ENV};
    }

    public static function getViewMinimumGuid() {
        return self::${'guid_view_minimum_' . APPLICATION_ENV};
    }

    public static function getEditGuid() {
        return self::${'guid_edit_' . APPLICATION_ENV};
    }

    public static $guid_for_testing_1='GY7582XM6';
    public static $guid_for_publish='';

    public static $rows_with_unpuplished_episodes=['xpath'=>'//tr[descendant::td[7][text()!="Yes" ]]'];

    public static $type_column='5';
    public static $guid_column='6';

    public static $series = ['xpath' => '//label[text() = "Series Title"]'];
    public static $season = ['xpath' => '//label[text() = "Season Title"]'];
    public static $season_number = ['xpath' => '//label[text() = "Season Number"]'];
    public static $episode_title_input = ['xpath' => '//label[text() = "Episode Title"]/following-sibling::input'];
    public static $episode_number = ['xpath' => '//label[text() = "Episode Number"]'];
    public static $episode_description = ['xpath' => '//label[text() = "Description"]'];

    public static $field = ['xpath' => '//label[text() = "{{field}}"]'];

    public static function getField($fieldName){
        return str_replace('{{field}}', $fieldName, self::$field['xpath']);
    }

}