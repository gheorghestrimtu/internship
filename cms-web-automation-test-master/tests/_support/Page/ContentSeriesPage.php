<?php
namespace Page;

class ContentSeriesPage {
    public static $URL = '';

    public static $all_seasons=['xpath'=>'//tr[descendant::td[position()=4 and text()="Season" ] ]'];
    public static $table_rows=['xpath'=>'//table/tbody/tr'];

}