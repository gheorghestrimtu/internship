<?php
namespace Page;

class ContentMovieEditPage extends ContentEditPage {

    //For Viewing Full Data
    private static $guid_view_full_proto0 = 'G6ZXQ00ZR';
    private static $guid_view_full_staging = 'GYWEPXNMY';

    //For Viewing Minimum Data
    private static $guid_view_minimum_proto0 = 'GY5VEDDDY';
    private static $guid_view_minimum_staging = 'GYE53PDPR';

    //For Editing Data
    private static $guid_edit_proto0 = 'GYMG1XXVY';
    private static $guid_edit_staging = 'GR2PZWV8R';


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