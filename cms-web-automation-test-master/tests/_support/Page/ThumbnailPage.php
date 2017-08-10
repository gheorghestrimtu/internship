<?php
namespace Page;

class ThumbnailPage {

    public static $URL = '/catalog/thumbnail/';

    public static $episodeVideoEditDataThumbnailSet_proto0 = 'GRDQNM1WY';
    public static $episodeVideoEditDataThumbnailSet_staging = 'G6NQE1ZQ6';
    public static $movieVideoEditDataThumbnailSet_proto0 = 'GYMGP3J4Y';
    public static $movieVideoEditDataThumbnailSet_staging = 'GY8V8J09Y';
    public static $extraVideoEditDataThumbnailSet_proto0 = 'GRDQ43JGY';
    public static $extraVideoEditDataThumbnailSet_staging = 'G6GGDPE46';

    public static $episodeVideoEditDataThumbnailNotSet_proto0 = 'G6JQ2EPVR';
    public static $episodeVideoEditDataThumbnailNotSet_staging = 'GYVNPXJQ6';
    public static $movieVideoEditDataThumbnailNotSet_proto0 = 'GR49M7X16';
    public static $movieVideoEditDataThumbnailNotSet_staging = 'GR75823MY';
    public static $extraVideoEditDataThumbnailNotSet_proto0 = 'GY195DWQR';
    public static $extraVideoEditDataThumbnailNotSet_staging = 'GYMG01J5Y';

    public static $currentThumbnail = ['xpath' => '//*[@class="thumbnails-installed"]/div/div/img'];
    public static $currentThumbnailNotAttached = ['xpath' => '//*[@class="thumbnails-installed"]/div[@class="frontend-warning"]'];
    public static $availableThumbnails = ['xpath' => '//*[@class="thumbnails-available"]/div/div/img'];
    public static $availableThumbnailsButtons = ['xpath' => '//*[@class="thumbnails-available"]/div/div/div/div/button'];
    public static $popupContainer = ['xpath' => '//div[contains(@class,"alert-popup")]'];
    public static $popupYesButton = ['xpath' => '//div[contains(@class,"alert-popup")]/button[@class="yes"]'];
    public static $popupCancelButton = ['xpath' => '//div[contains(@class,"alert-popup")]/button[@class="cancel"]'];
    public static $successNotificationContainer = ['xpath' => '//div[contains(@class,"success show")]'];
    public static $thumbnailsEnabledTab = ['xpath' => '//div[@class="thumbnails-preview"]/small[@class="enabled"]'];
    public static $thumbnailsTab = ['css' => 'div[class="thumbnail"][style*="{{width}}"]'];

}