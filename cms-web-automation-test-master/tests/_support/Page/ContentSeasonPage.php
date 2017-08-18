<?php
namespace Page;

class ContentSeasonPage {
    public static $URL = '';
    public static $table_rows=['xpath'=>'//table/tbody/tr'];
    public static $rows_with_episodes=['xpath'=>'//tr[descendant::td[position()=6 and text()!="0"]]'];
    public static $rows_with_unpuplished_episodes=['xpath'=>'//tr[descendant::td[6][text()!="0" ] and descendant::td[7][ text()!="100%" ]]'];
    public static $type_column = '4';
}