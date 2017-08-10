<?php
namespace Page;

class ImageEditPage {

    // Image
    public static $image = ['xpath' => '//div[@class="image-preview"]/img'];
    public static $replace_image = ['xpath' => '//a[text()="Replace Image"]'];

    // Small size previews
    public static $small_previews = ['xpath' => '//div[@class="small-sizes"]/img'];

    // Attributes
    public static $attribute_row = ['xpath' => '//div[@class="attributes"]//label/parent::div'];
    public static $attribute_value = ['xpath' => '//div[@class="attributes"]//label[text()="{{attribute}}"]/parent::div/span'];
    public static $attribute_column = ['xpath' => '//div[@class="attributes"]//label'];
    public static $download_full_size = ['xpath' => '//a[text()="Download Full Size"]'];

}