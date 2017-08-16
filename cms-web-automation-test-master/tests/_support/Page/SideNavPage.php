<?php

namespace Page;

class SideNavPage
{
    // include url of current page
    public static $URL = '';
    public static $PortalAndContentTestingURL = '/chan/partnertest/catalog';
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $breadcrumbs = 'ul.breadcrumbs';
    public static $table="table";
    public static $firstFeedContainer="div.panel.feed-editor";
    public static $channelsContainer="div.channels";

    public static $sidenav = 'div.side-nav';

    public static $contentLink = "//*[@id='workspace']/section/nav/ul//a[text()='Content']";
    public static $feedLink = "//*[@id='workspace']/section/nav/ul//a[text()='Feed']";
    public static $channelsLink = "//*[@id='workspace']/section/nav/ul//a[text()='Channels']";

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