<?php

namespace Page;

class AbstractPage {

    // Top menu
    public static $channel_dropdown = ['xpath' => '//nav/select[@name="channel"]'];
    public static $channel_dropdown_options = ['xpath' => '//nav/select[@name="channel"]/option'];
    public static $channel_dropdown_selected_option = ['xpath' => '//nav/select[@name="channel"]/option[@selected]'];
    public static $channels_array = ['VRV', 'Cartoon Hangover', 'Crunchyroll', 'Funimation', 'Geek & Sundry', 'Ginx', 'Machinima', 'Mondo', 'Nerdist', 'RiffTrax', 'Rooster Teeth', 'Seeso', 'Shudder'];

    // Side bar
    public static $side_nav_links = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[not(@class="selected")]'];
    public static $content_link = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[text()="Content"]'];
    public static $feed_link = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[text()="Feed"]'];
    public static $channels_link = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[text()="Channels"]'];
    public static $ftp_accounts_link = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[text()="FTP ACCOUNTS"]'];
    public static $sidenav = 'div.side-nav';

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

    public static $table_rows=['xpath'=>'//table/tbody/tr'];

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: EditPage::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

}