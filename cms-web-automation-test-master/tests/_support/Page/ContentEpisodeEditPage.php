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


    public static function getViewGuid() {
        return self::${'guid_view_full_' . APPLICATION_ENV};
    }

    public static function getViewMinimumGuid() {
        return self::${'guid_view_minimum_' . APPLICATION_ENV};
    }

    public static function getEditGuid() {
        return self::${'guid_edit_' . APPLICATION_ENV};
    }

}