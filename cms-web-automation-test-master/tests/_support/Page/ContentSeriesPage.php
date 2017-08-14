<?php
namespace Page;

class ContentSeriesPage {
    public static $URL = 'catalog/{{guid}}';

    public static $all_seasons=['xpath'=>'//tr[descendant::td[position()=4 and text()="Season" ] ]'];
    public static $table_rows=['xpath'=>'//table/tbody/tr'];


    public static function urlByGuid($guid){
        return str_replace('{{guid}}',$guid,self::$URL);
    }
}