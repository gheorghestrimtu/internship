<?php

class ChannelPage
{
    // include url of current page
    public static $URL = '/channels';
    public static $URL_editChannel = '/channels/partnertest';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    public static $newChannelModal = 'div.channel.dialog';

    //Edit Channel
    public static $titleEdit_input = "//form/div[3]/input";
    public static $descriptionEdit_input = "//form/div[4]/textarea";
    public static $colorEdit_input = "//form/div[5]/div/input";

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