<?php
namespace Step;

use Page\ContentPage;
use Page\ContentEditPage;

class ContentSteps extends \AcceptanceTester {

    public $temp = [];

    public function amOnContentPage() {
        $I = $this;
        $I->amOnPage(ContentPage::$URL);
        $I->waitForElement(ContentPage::$rows_with_image);
    }

    public function selectRandomMovie() {
        $I = $this;
        $row = $I->findRandomElement(ContentPage::unpublished_rows('Movie'));
        $I->findElementInElement($row, ContentPage::$checkbox['xpath'])->click();
        $guid = $I->findElementInElement($row, '/td[' . ContentPage::$guid_column . ']')->getText();
        return $guid;
    }

    public function shouldSeeContentIsPublished($guid) {
        $I = $this;
        $row = $I->findElement(ContentPage::row_by_guid($guid));
        $published = $I->findElementInElement($row, '/td[' . ContentPage::$published_column . ']')->getText();
        $I->assertEquals($published, '100%');
    }

    public function publishSelectedContent() {
        $I = $this;
        $I->clickWithLeftButton(ContentPage::$publish_content_button);
        $I->waitForElementVisible(ContentPage::$alert_popup['xpath'], 60);
        $I->clickWithLeftButton(ContentPage::$alert_popup_button_publish['xpath']);
        $I->waitForElementVisible(ContentPage::$toast_success);
    }

    public function navigateToContentEditPageWithLandscapePoster() {
        $I = $this;
        $row = $I->findRandomElement(ContentPage::$rows_with_image['xpath']);
        $I->findElementInElement($row, ContentPage::$edit_pencil['xpath'])->click();
    }

    public function navigateToContentEditPageWithoutLandscapePoster() {
        $I = $this;
        $row = $I->findRandomElement(ContentPage::$rows_without_image['xpath']);
        $I->findElementInElement($row, ContentPage::$edit_pencil['xpath'])->click();
    }

    public function navigateToContentEditPage($category, $edit=true) {
        $I = $this;
        if ($category == 'Episode') {
            $this->navigateToContentEditPage('Season', false);
        } elseif ($category == 'Season') {
            $this->navigateToContentEditPage('Series', false);
        } else {
            $I->amOnPage(ContentPage::$URL);
        }
        $category_row = str_replace('{{category}}', $category, ContentEditPage::$category_row['xpath']);
        $I->waitForElementVisible($category_row, 30);
        $this->temp['cycles'] = 0;
        $index = $this->maturityRatingGetRandomIndex($category, $category_row);
        $I->click(str_replace(
            ['{{category}}', '{{index}}', '{{pencil}}'],
            [$category, $index, ($edit ? ContentEditPage::$pencil['xpath'] : '')],
            ContentEditPage::$specific_category_row['xpath']
        ));
        $I->waitAjaxLoad();
    }

    private function maturityRatingGetRandomIndex($category, $xpath) {
        $I = $this;
        if ($this->temp['cycles'] == 100) {
            return false;
        }
        $this->temp['cycles']++;
        $index = rand(1, count($I->findElements('xpath', $xpath)));
        if ($category == 'Series' || $category == 'Season') {
            $total = $I->grabTextFrom(str_replace(['{{xpath}}', '{{index}}'], [$xpath, $index], ContentEditPage::$video_type_cell['xpath']));
            if ($total == '0') {
                $index = $this->maturityRatingGetRandomIndex($category, $xpath);
            }
            if ($category == 'Series') {
                $total = $I->grabTextFrom(str_replace(['{{xpath}}', '{{index}}'], [$xpath, $index], ContentEditPage::$video_guid_cell['xpath']));
                if ($total == '0') {
                    $index = $this->maturityRatingGetRandomIndex($category, $xpath);
                }
            }
        }
        return $index;
    }

    public function selectNumberOfItemsPerPage($numberOfElementsDisplay){
        $I = $this;
        $I->selectOption(ContentPage::$per_page_dropdown,$numberOfElementsDisplay);
        $I->waitAjaxLoad();
    }

    public function shouldSeePageDropdownElements($numberOfElements){
        if($numberOfElements=='All'){
            $howMany=$this->grabTextFrom(['xpath'=>'//table/tfoot//div/div']);
            $max=substr($howMany,strpos($howMany,'of')+3);
            $this->assertEquals($max, count($this->findElements('//table/tbody/tr')), 'Should have ' . $max . ' items per page');
            return;
        }
        //$this->seeElement(['xpath'=>'//table//tr['. $numberOfElements .']']);
        //$this->dontSeeElement(['xpath'=>'//table//tr['. ($numberOfElements+1) .']']);
        $this->assertEquals($numberOfElements, count($this->findElements('//table/tbody/tr')), 'Should have ' . $numberOfElements . ' items per page');

    }

    public function clickEditPencil($row){
        $this->moveMouseOver(['xpath'=> '//table//tr['. $row .']']);
        $this->click(ContentPage::$edit_pencil);
        //tr[1]//i[contains(@class, "edit") and contains(@class, "fa-pencil")]
    }

    public function shouldSeeTitleIsValid($titleGuid){
        $I=$this;
        $row=ContentPage::row_by_guid($titleGuid);
        $title=$I->grabTextFrom(['xpath'=>'//table//tr['.$row.']//td['.ContentPage::$title_column.']']);
        $I->clickEditPencil($row);
        $I->seeInField(ContentEditPage::$title,$title);
        //$input=$I->grabValueFrom(ContentEditPage::$title);
        //$I->assertEquals($title,$input);
    }

    public function chooseGuidOfItemByTypeAndPosition($type,$position){
        return $this->grabTextFrom(['xpath'=>'//table/tbody/tr[contains(. ,\''.$type.'\')]['.$position.']/td[5]']);
    }

    public function shouldSeeTableSortedByTitle(){
        $I=$this;
        $titleList=$I->grabMultiple(ContentPage::$all_titles);
        $sortedTitleList=$titleList;
        natcasesort($sortedTitleList);
        $I->assertEquals($sortedTitleList,$titleList,'Should be sorted alphabetically');
    }


}
