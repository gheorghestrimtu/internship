<?php
namespace Page;

class ContentSeasonEditPage extends ContentEditPage {

    //For Viewing Full Data
    private static $guid_view_full_proto0 = 'G6Q4MN7ER';
    private static $guid_view_full_staging = 'GY098Q5GY';

    //For Viewing Minimum Data
    private static $guid_view_minimum_proto0 = 'GRE5PQG86';
    private static $guid_view_minimum_staging = 'GYQ4XM146';

    //For Editing Data
    private static $guid_edit_proto0 = 'GYX04WK0R';
    private static $guid_edit_staging = 'G6NQE1GZ6';


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