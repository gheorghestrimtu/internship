<?php
namespace Page;

class ContentEpisodeEditPage extends ContentEditPage {


    public static $episodeViewData_proto0 = 'GYWEX5NNY';
    public static $episodeViewData_staging = 'GY7582XM6';

    public static $episodeViewMinimumData_proto0 = 'GR9PJE1D6';
    public static $episodeViewMinimumData_staging = 'GYJQD2XD6';

    public static function getEditGuid() {
        return self::${'guid_edit_' . APPLICATION_ENV};
    }

    public static $guid_for_random_episode='';

    public static $rows_with_unpuplished_episodes=['xpath'=>'//tr[descendant::td[7][text()!="Yes" ]]'];

    public static $type_column='5';
    public static $guid_column='6';

    public static $episode_title_input = ['xpath' => '//label[text() = "Episode Title"]/following-sibling::input'];
    public static $episode_number_input = ['xpath' => '//label[text() = "Episode Number"]/following-sibling::input'];
    public static $episode_description_input = ['xpath' => '//label[text() = "Description"]/following-sibling::textarea'];
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


    public static $field = ['xpath' => '//label[text() = "{{field}}"]'];

    public static function getField($fieldName){
        return str_replace('{{field}}', $fieldName, self::$field['xpath']);
    }

}