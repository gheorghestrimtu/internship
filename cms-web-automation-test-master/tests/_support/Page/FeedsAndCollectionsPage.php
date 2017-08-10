<?php
namespace Page;

class FeedsAndCollectionsPage extends AbstractPage {

    public static $URL = '/chan/partnertest/featured';

    //Feeds
    public static $firstFeed_container = 'div.panel.feed-editor';
    public static $feed_content = 'div.feed-panel-tabs';
    public static $feed_titleInput = 'input.inline-edit.title';
    public static $feed_promo_title_input = '.inline-edit.inline-promo';
    public static $feed_descInput = 'input.inline-edit.description';
    public static $feed_firstTitle = 'div.inline-edit.title';
    public static $feed_panelList = 'ul.panel-list';
    public static $feeds_header = '//div[@class="info"]/div[text()="FEEDS"]';
    public static $feeds_link = ['xpath' => '//a[text()="Feeds"]'];
    public static $feed_items =['xpath' => '(//i[contains(@class, "fa-gear")])[3]/ancestor::div[contains(@class, "feed-editor")]//input[contains(@class, "inline-promo")]'];

    //Collections
    public static $collections_content = 'div.feed-panel-tabs.shelf';
    public static $collections_titleInput = 'input.inline-edit.title';
    public static $collections_guid_input = '//input[contains(@class, \'content-id\')]';
    public static $collections_descInput = 'input.inline-edit.description';
    public static $collections_description = 'div.inline-edit.description';
    public static $collections_link = ['xpath' => '//a[text()="Collections"]'];
    public static $add_new_collection_link = '//a[text()="New Collection"]';
    public static $collection_title = '//h3[contains(@class, \'entry-comment\')][last()-1]';
    public static $collection_description = '//h3[contains(@class, \'entry-comment\')]';
    public static $collection_type = '//li[contains(@class, \'feed-list-entry\')]/div/span';
    public static $collections_title = '//div[contains(@class, \'title\')]';
    public static $delete_collection_link = '//a[contains(text(), \'Delete Collection\')]';
    public static $edit_collection_link = '//a[contains(text(), \'Edit Collection\')]';

    //Feeds & Collections
    public static $gear_button = '//i[contains(@class, \'fa-gear\')]';
    public static $edit_link = '//a[text()="Edit Collection" or text()="Edit Feed"]';
    public static $save_changes_button = 'button.button.success';
    public static $modal_close_button = '//i[contains(@class, \'fa-times\')]';
    public static $add_media_button = 'div.fa-plus';

    //Collection texts
    public static $create_new_collection_text = 'You are creating a new collection';
    public static $collection_title_edit_text = 'Edit Auto Test Collection';
    public static $collection_title_text = 'Auto Test Collection';
    public static $collection_description_edit_text = 'Automation description - Do not edit this collection';
    public static $collection_description_text = 'Automation description';
    public static $popup_delete_text = 'Delete collection - are you sure? There is no undo.';
    public static $toast_delete_collection_text = 'Collection deleted';
    public static $toast_add_collection_text = 'Collection successfully created';
    public static $popup_add_item_text = 'You must add one item to the collection.';
    public static $popup_specify_title_text = 'You must specify a title for the collection.';


    //For adding to Feeds/Collections
    public static $seriesGuid_proto0 = 'G6K5P7QPY';
    public static $seriesGuid_staging = 'GRP891EMR';


    public static $seasonGuid_proto0 = 'GRVNXQJZY';
    public static $seasonGuid_staging = 'G68V8JP96';

    public static $episodeGuid_proto0 = 'G6P81JEG6';
    public static $episodeGuid_staging = 'GYDQZ4W96';

    public static $movieGuid_proto0 = 'GYP81JJGY';
    public static $movieGuid_staging = 'GRDQZ4J9Y';

    public static $collectionGuid_proto0 = 'G6ZXDKEDR';
    public static $collectionGuid_staging = 'G69P8J70Y';

    public static $channelGuid_proto0 = 'GY5VV50EY';
    public static $channelGuid_staging = 'GY5VV50EY';

}