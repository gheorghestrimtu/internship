<?php
namespace Step;
use Page\ContentEditPage;
use Page\ContentPage;

class BreadcrumbNavigationSteps extends \AcceptanceTester {

    private $temp;

    public function amOnContentEditPage($category) {
        $this->temp = ['breadcrumb' => 'CONTENT'];
        $this->accessContentEditPageByCategory($category);
    }

    public function amOnMediaEditPage($category, $subcategory) {
        $this->temp = ['breadcrumb' => 'CONTENT'];
        if ($subcategory == 'ExtraVideo') {
            $this->getRandomGuid($category, $subcategory);
            $this->accessContentEditPageByGuid($category);
        } else {
            $this->accessContentEditPageByCategory($category);
        }
        $this->accessMediaEditPage($category, $subcategory);
    }

    public function amOnThumbnailEditPage($category, $subcategory) {
        $this->amOnMediaEditPage($category, ($subcategory == 'ExtraThumbnail' ? 'Extra' : '') . 'Video');
        $this->accessThumbnailEditPage($category, $subcategory);
    }

    public function amOnImageEditPage($category, $subcategory) {
        $this->temp = ['breadcrumb' => 'CONTENT'];
        $this->getRandomGuid($category, $subcategory);
        $this->accessContentEditPageByGuid($category);
        $this->accessImageEditPage($category, $subcategory);
    }

    public function seeBreadcrumbNavigationIsDisplayed() {
        $I = $this;
        $breadcrumb = str_replace(array("\r\n", "\n", "\r", "…"), "", $I->grabTextFrom('ul.breadcrumbs'));
        $I->assertEquals($breadcrumb, $this->temp['breadcrumb']);
    }

    private function accessContentEditPageByCategory($category, $edit_page=true) {
        $I = $this;
        if ($category == 'Episode') {
            $this->accessContentEditPageByCategory('Season', false);
        } elseif ($category == 'Season') {
            $this->accessContentEditPageByCategory('Series', false);
        } else {
            $I->amOnPage(ContentPage::$URL);
        }
        $row = $this->getRandomRow($category, $edit_page);
        $this->buildBreadcrumb($category, false, $row);
        $I->scrollTo($row);
        $I->moveMouseOver($row);
        $I->click($row);
        $I->waitAjaxLoad();
    }

    private function accessContentEditPageByGuid($category, $edit_page=true) {
        $I = $this;
        if ($category == 'Episode') {
            $this->accessContentEditPageByGuid('Season', false);
        } elseif ($category == 'Season') {
            $this->accessContentEditPageByGuid('Series', false);
        } else {
            $I->amOnPage(ContentPage::$URL);
        }
        $row = $this->getRandomGuidRow($category, $edit_page);
        $this->buildBreadcrumb($category, false, $row);
        $I->scrollTo($row);
        $I->moveMouseOver($row);
        $I->click($row);
        $I->waitAjaxLoad();
    }

    private function accessMediaEditPage($category, $subcategory) {
        $I = $this;
        $index = (($subcategory == 'ExtraVideo' && ($category == 'Movie' || $category == 'Episode')) ? 2 : 1);
        $video_row = str_replace('{{index}}', $index, ContentEditPage::$video_row['xpath']);
        $I->scrollTo($video_row);
        $I->click($video_row);
        $I->waitAjaxLoad();
        $this->buildBreadcrumb($category, $subcategory, false);
    }

    private function accessThumbnailEditPage($category, $subcategory) {
        $I = $this;
        if (!$this->waitForElementToLoad('xpath', ContentEditPage::$change_thumbnail['xpath'])) {
            $this->amOnThumbnailEditPage($category, $subcategory);
            return;
        }
        $I->scrollTo(ContentEditPage::$change_thumbnail['xpath']);
        $I->click(ContentEditPage::$change_thumbnail['xpath']);
        $I->waitAjaxLoad();
        $this->buildBreadcrumb($category, $subcategory, false);
    }

    private function accessImageEditPage($category, $subcategory) {
        $I = $this;
        $I->scrollTo(ContentEditPage::${$subcategory});
        $I->click(ContentEditPage::${$subcategory});
        $I->waitAjaxLoad();
        $this->buildBreadcrumb($category, $subcategory, false);
    }

    private function getRandomIndex($row) {
        $total_rows = $this->waitForElementToLoad('xpath', $row);
        return rand(1, $total_rows);
    }

    private function getRandomRow($category, $edit_page) {
        $rows = str_replace('{{category}}', $category, ContentEditPage::$category_rows['xpath']);
        if ($edit_page) {
            $rows .= ContentEditPage::$pencil2['xpath'];
        } elseif ($category == 'Series' || $category == 'Season') {
            $rows .= str_replace('{{index}}', ($category == 'Series' ? 7 : 6), ContentEditPage::$category_row_not_zero['xpath']);
        }
        $index = $this->getRandomIndex($rows);
        return '(' . $rows . ')[' . $index . ']';
    }

    private function getRandomGuid($category, $subcategory) {
        $index = rand(0, count(ContentEditPage::${$subcategory.'Guids'}[$category]) - 1);
        $this->temp['guids'] = ContentEditPage::${$subcategory.'Guids'}[$category][$index];
    }

    private function getRandomGuidRow($category, $edit_page) {
        $index = ($category == 'Episode' ? 2 : ($category == 'Season' ? 1 : 0));
        $row = str_replace('{{guid}}', $this->temp['guids'][$index], ContentEditPage::$guid_row['xpath']);
        $row .= ($edit_page ? ContentEditPage::$pencil2['xpath'] : '/td[3]');
        $this->waitForElementToLoad('xpath', $row);
        return $row;
    }

    private function buildBreadcrumb($category, $subcategory, $row) {
        $I = $this;
        switch ($subcategory) {
            case 'Video':
                $this->temp['breadcrumb'] .= 'VIDEO (' . strtoupper($category) . ')';
                break;
            case 'ExtraVideo':
                $this->temp['breadcrumb'] .= 'VIDEO (TRAILER)';
                break;
            case 'Thumbnail':
                $this->temp['breadcrumb'] .= 'THUMBNAIL';
                break;
            case 'ExtraThumbnail':
                $this->temp['breadcrumb'] .= 'THUMBNAIL';
                break;
            case 'LandscapeImage':
                $this->temp['breadcrumb'] .= 'IMAGE (LANDSCAPE POSTER)';
                break;
            case 'PortraitImage':
                $this->temp['breadcrumb'] .= 'IMAGE (PORTRAIT POSTER)';
                break;
            default:
                $extra = ($category == 'Season' || $category == 'Episode') ? strtoupper($category) . ' #' : '';
                $column_index = $category == 'Season' ? 2 : 3;
                $this->temp['breadcrumb'] .= $extra . strtoupper($this->shorter($I->grabTextFrom($row . '/ancestor::tr/td[' . $column_index . ']')));
        }
    }

    private function shorter($string) {
        $length = strlen($string);
        if ($length > 30) {
            return substr_replace($string, '', 15, $length - 30);
        }
        return $string;
    }

}