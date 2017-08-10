<?php

class FeedsAndListsPage
{
    // include url of current page
    public static $URL = '/chan/partnertest/featured';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $page_content = '#content-target main';

    //Feeds
    public static $firstFeed_container = 'div.panel.feed-editor';

    public static $feed_content = 'div.feed-panel-tabs';

    public static $feed_titleInput = 'input.inline-edit.title';
    public static $feed_descInput = 'input.inline-edit.description';

    public static $feed_firstTitle = 'div.inline-edit.title';

    public static $feed_panelList = 'ul.panel-list';

    //Collections
    public static $collections_content = 'div.feed-panel-tabs.shelf';

    public static $firstCollection_container = 'div.feed-panel-tabs.shelf div.panel.feed-editor';

    public static $collections_titleInput = 'input.inline-edit.title';
    public static $collections_descInput = 'input.inline-edit.description';

    public static $collections_firstTitle = 'div.inline-edit.title';
    public static $collections_firstDesc = 'div.inline-edit.description';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }
}