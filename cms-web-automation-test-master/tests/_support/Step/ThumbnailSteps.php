<?php
namespace Step;

use Page\ThumbnailPage;

class ThumbnailSteps extends \AcceptanceTester {

    public $temp = [];

    public function amOnVideoEditDataPage($category, $thumbnail_set) {
        $I = $this;
        $I->amOnPage($this->getUrl($category . 'VideoEditDataThumbnail' . (!$thumbnail_set ? 'Not' : '') . 'Set_'));
    }

    public function availableTumbnailsShouldBeDisplayed() {
        $I = $this;
        $I->waitForElementVisible(ThumbnailPage::$availableThumbnails, 30);
    }

    public function currentTumbnailShouldBeDisplayed() {
        $I = $this;
        $I->waitForElementVisible(ThumbnailPage::$currentThumbnail, 30);
    }

    public function currentTumbnailShouldNotBeDisplayed() {
        $I = $this;
        $I->waitForElementVisible(ThumbnailPage::$currentThumbnailNotAttached, 30);
    }

    public function changeThumbnailImage($change) {
        $I = $this;
        $this->temp['img_src'] = [];
        $this->getImageSrc(ThumbnailPage::$currentThumbnail['xpath']);
        $this->clickRandomImage('xpath', ThumbnailPage::$availableThumbnails['xpath']);
        $I->waitForElementVisible(ThumbnailPage::$popupContainer, 30);
        $I->click($change ? ThumbnailPage::$popupYesButton : ThumbnailPage::$popupCancelButton);
        if ($change) {
            $I->waitForElementVisible(ThumbnailPage::$successNotificationContainer, 30);
        }
        $I->wait(10);
        $this->getImageSrc(ThumbnailPage::$currentThumbnail);
    }

    public function thumbnailImageShouldChange() {
        $I = $this;
        $I->assertNotEquals($this->temp['img_src'][0], $this->temp['img_src'][1]);
    }

    public function thumbnailImageShouldNotChange() {
        $I = $this;
        $I->assertEquals($this->temp['img_src'][0], $this->temp['img_src'][1]);
    }

    public function changeThumbnailSize() {
        $I = $this;
        $this->temp['total'] = [];
        $tabs = [
            'small' => ['width' => '33', 'click' => 'large'],
            'medium' => ['width' => '50', 'click' =>  'small'],
            'large' => ['width' => '100', 'click' =>  'medium']
        ];
        $current_size = $I->grabTextFrom(ThumbnailPage::$thumbnailsEnabledTab);
        $this->temp['total'][] = count($I->findElements('css', str_replace('{{width}}', $tabs[$current_size]['width'], ThumbnailPage::$thumbnailsTab['css'])));
        $I->click('//div[@class="thumbnails-preview"]/small[text()="' . $tabs[$current_size]['click'] . '"]');
        $new_size = $tabs[$current_size]['click'];
        $this->temp['total'][] = count($I->findElements('css', str_replace('{{width}}', $tabs[$new_size]['width'], ThumbnailPage::$thumbnailsTab['css'])));
    }

    public function thumbnailsSizeShouldChange() {
        $I = $this;
        $I->assertEquals($this->temp['total'][0], $this->temp['total'][1]);
    }

    private function getUrl($param) {
        return ThumbnailPage::$URL . ThumbnailPage::${$param . APPLICATION_ENV};
    }

    private function getImageSrc($selector) {
        $I = $this;
        $index = count($this->temp['img_src']);
        $this->temp['img_src'][$index] = $I->grabAttributeFrom($selector, 'src');
    }

    private function clickRandomImage($method, $selector) {
        $I = $this;
        $elements = $I->findElements($method, $selector);
        $index = rand(1, count($elements));
        $image = '(' . $selector . ')[' . $index . ']';
        $button = '(' . ThumbnailPage::$availableThumbnailsButtons['xpath'] . ')[' . $index . ']';
        $I->wait(30);
        $I->scrollTo($image);
        $I->moveMouseOver($image);
        $I->waitForElementVisible($button);
        $I->click($button);
    }

}