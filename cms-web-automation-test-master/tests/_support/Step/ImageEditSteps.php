<?php
namespace Step;

use Codeception\Util\Fixtures;
use Codeception\Util\Locator;
use Page\ImageEditPage;

class ImageEditSteps extends AbstractStep {

    private $image_type;
  
    public function shouldSeeImage() {
        $I = $this;
        $I->waitForElementVisible(ImageEditPage::$image['xpath']);
        $I->assertEquals(640, $I->grabAttributeFrom(ImageEditPage::$image, 'width'));
    }

    public function shouldSeeSmallSizePreviews() {
        $I = $this;

        $image = Locator::elementAt(ImageEditPage::$small_previews['xpath'], 1);
        $I->assertEquals(170, $I->grabAttributeFrom($image, 'width'));

        $image = Locator::elementAt(ImageEditPage::$small_previews['xpath'], 2);
        $I->assertEquals(105, $I->grabAttributeFrom($image, 'width'));

        $image = Locator::elementAt(ImageEditPage::$small_previews['xpath'], 3);
        $I->assertEquals(70, $I->grabAttributeFrom($image, 'width'));
    }

    public function shouldSeeImageAttributes() {
        $I = $this;

        $I->scrollTo(Locator::elementAt(ImageEditPage::$attribute_column['xpath'], 3));

        $I->see('Image Type', Locator::elementAt(ImageEditPage::$attribute_row['xpath'], 1));
        $I->assertEquals(Fixtures::get('poster_type'), $this->getValueForAttribute('Image Type'));

        $I->see('Dimensions', Locator::elementAt(ImageEditPage::$attribute_column['xpath'], 2));
        $I->waitForRegExp('/\d+×\d+px/', 10, Locator::elementAt(ImageEditPage::$attribute_row['xpath'], 2));

        $I->see('Filename', Locator::elementAt(ImageEditPage::$attribute_column['xpath'], 3));
        $I->assertRegExp('/.+\.(jpg|jpeg|png|gif)/', $I->getValueForAttribute('Filename'));
    }

    public function getValueForAttribute($attribute) {
        $I = $this;
        $selector = str_replace('{{attribute}}', $attribute, ImageEditPage::$attribute_value['xpath']);
        return implode("", $I->grabMultiple($selector));
    }

}