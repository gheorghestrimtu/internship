<?php
namespace Page;

class ChannelsPage {

    public static $URL = '/channels';
    public static $channels = array("Cartoon Hangover", "Crunchyroll", "Funimation", "Geek & Sundry",
        "Ginx", "Machinima", "Mondo", "Nerdist", "RiffTrax", "Rooster Teeth", "Seeso", "Shudder", "Tested", "VRV");

    public static $auto_ingest_column = ['xpath' => '//th[text()="Auto Ingest"]'];
    public static $channel_row = ['xpath' => '//td/span[text()="{{channel}}"]'];
    public static $add_channel_button = ['css' => 'a[class*="add-channel"]'];
    public static $new_channel_modal = ['css' => 'div.channel.dialog'];
    public static $partner_channel_row = ['xpath' => '//td/span[contains(text(), \'Portal\')]'];
    public static $partner_channel_edit_button = ['xpath' => '//td/span[contains(text(), \'Portal\')]/../i'];
    public static $auto_ingest_button = ['xpath' => '//td/div[text()="{{text}}"]'];

    public static $auto_ingest_button_text = ['AUTO', 'MANUAL'];

}