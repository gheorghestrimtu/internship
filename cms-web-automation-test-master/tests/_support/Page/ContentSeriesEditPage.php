<?php
namespace Page;

class ContentSeriesEditPage extends ContentEditPage {

    //For Viewing Full Data
    private static $guid_view_full_proto0 = 'GRZXQ0VZY';
    private static $guid_view_full_staging = 'G6WEPXWM6';

    //For Viewing Minimum Data
    private static $guid_view_minimum_proto0 = 'G6752GXZR';
    private static $guid_view_minimum_staging = 'G6ZXPQ83R';

    //For Editing Data
    private static $guid_edit_proto0 = 'G6752G3VR';
    private static $guid_edit_staging = 'GY19851ZR';


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