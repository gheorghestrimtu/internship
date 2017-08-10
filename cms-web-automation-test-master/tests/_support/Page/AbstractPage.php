<?php

namespace Page;

class AbstractPage {

    // Top menu
    public static $channel_dropdown = ['xpath' => '//nav/select[@name="channel"]'];
    public static $channel_dropdown_options = ['xpath' => '//nav/select[@name="channel"]/option'];
    public static $channels_array = ['VRV', 'Cartoon Hangover', 'Crunchyroll', 'Funimation', 'Geek & Sundry', 'Ginx', 'Machinima', 'Mondo', 'Nerdist', 'RiffTrax', 'Rooster Teeth', 'Seeso', 'Shudder'];

    // Side bar
    public static $side_nav_links = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[not(@class="selected")]'];
    public static $content_link = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[text()="Content"]'];
    public static $feed_link = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[text()="Feed"]'];
    public static $channels_link = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[text()="Channels"]'];
    public static $ftp_accounts_link = ['xpath' => '//*[@id="workspace"]/section/nav/ul//a[text()="FTP ACCOUNTS"]'];

}