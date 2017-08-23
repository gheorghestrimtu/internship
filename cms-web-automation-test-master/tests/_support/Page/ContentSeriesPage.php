<?php
namespace Page;

class ContentSeriesPage extends AbstractPage {
    public static $URL = 'catalog/{{guid}}';

    public static $all_seasons=['xpath'=>'//tr[descendant::td[position()=4 and text()="Season" ] ]'];

    public static function urlByGuid($guid){
        return str_replace('{{guid}}',$guid,self::$URL);
    }

    public static $rows_with_episodes= ['xpath' => ''];
}