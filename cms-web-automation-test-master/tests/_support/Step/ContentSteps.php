<?php
namespace Step;

use Page\ContentPage;
use Page\ContentEditPage;
use Page\ContentSeasonPage;
use Page\ContentSeriesPage;

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
            $howMany=$this->grabTextFrom(ContentPage::$maximum_items);
            $max=substr($howMany,strpos($howMany,'of')+3);
            $this->assertEquals($max, count($this->findElements(ContentPage::$table_rows['xpath'])), 'Should have ' . $max . ' items per page');
            return;
        }
        $this->assertEquals($numberOfElements, count($this->findElements(ContentPage::$table_rows['xpath'])), 'Should have ' . $numberOfElements . ' items per page');

    }

    public function clickEditPencil($row){
        $this->moveMouseOver(['xpath'=> '//table//tr['. $row .']']);
        $this->click(ContentPage::$edit_pencil);
    }

    public function shouldSeeTitleIsValid($titleGuid){
        $I=$this;
        $row=ContentPage::row_by_guid($titleGuid);
        $title=$I->grabTextFrom(['xpath'=>'//table//tr['.$row.']//td['.ContentPage::$title_column.']']);
        $I->clickEditPencil($row);
        $I->waitAjaxLoad();
        $I->seeInField(ContentEditPage::$title,$title);
    }

    public function chooseRandomContentAndReturnGuid(){
        $I=$this;
        $I->waitAjaxLoad();
        $I->selectNumberOfItemsPerPage("All");
        $randomMovie=$I->findRandomElement(ContentPage::$table_rows['xpath']);
        $guid=$I->findElementInElement($randomMovie,'/td[' . ContentPage::$guid_column . ']')->getText();
        return $guid;
    }

    public function chooseGuidOfItemByTypeAndPosition($type,$position){
        return $this->grabTextFrom(ContentPage::findGuidByTypeAndPosition($type,$position));
    }

    public function shouldSeeTableSortedByTitle(){
        $I=$this;
        $titleList=array_map('strtolower',$I->grabMultiple(ContentPage::$all_titles));
        $sortedTitleList=$titleList;
        sort($sortedTitleList);
        for($i=0;$i<count($titleList);$i++){
            if($titleList[$i]!=$sortedTitleList[$i]){
                echo ($i+1).'|';
            }
        }
        print_r($sortedTitleList);
        $I->assertTrue(array_values($sortedTitleList)===array_values($titleList),'Should be sorted alphabetically');
    }

    public function shouldSeeTableReverseSortedByTitle(){
        $I=$this;
        $titleList=$I->grabMultiple(ContentPage::$all_titles);
        $sortedTitleList=$titleList;
        usort($sortedTitleList, 'strcasecmp');
        $reverseSortedTitleList=array_reverse($sortedTitleList);
        $I->assertTrue($reverseSortedTitleList===$titleList,'Should be sorted reverse alphabetically');
    }

    public function shouldSeeOnlyMoviesAndSeries(){
        $I=$this;
        $I->waitForElementVisible(ContentPage::$all_types['xpath']);
        $I->selectNumberOfItemsPerPage("All");
        $list=$I->grabMultiple(ContentPage::$all_types);
        $listWithoutMoviesAndSeries=array_diff($list,['Movie','Series']);
        $I->assertTrue(count($listWithoutMoviesAndSeries)==0,"Only Movies and Series in type column");
    }

    public function shouldSeeOnlyType($typeArray){
        $I=$this;
        $I->waitForElementVisible(ContentPage::$all_types['xpath']);
        $I->selectNumberOfItemsPerPage("All");
        $list=$I->grabMultiple(ContentPage::$all_types);
        $listWithoutMoviesAndSeries=array_diff($list,$typeArray);
        $I->assertTrue(count($listWithoutMoviesAndSeries)==0,"Only Movies and Series in type column");
    }

    public function shouldSeeGuidsAreListed(){
        $I=$this;
        $I->waitForElementVisible(ContentPage::$all_guids['xpath']);
        $I->selectNumberOfItemsPerPage("All");
        $list=$I->grabMultiple(ContentPage::$all_guids);
        $I->assertFalse(in_array('',$list),"I see GUID for all elements");
    }

    public function clickRandomSeriesAndReturnNumberOfSeasons(){
        $I=$this;
        $I->selectNumberOfItemsPerPage("All");
        $randomSeries=$I->findRandomElement(ContentPage::$rows_with_series['xpath']);
        $seasons=$I->findElementInElement($randomSeries,'/td[' . ContentPage::$seasons_column . ']')->getText();
        $I->findElementInElement($randomSeries,'/td['.ContentPage::$type_column.']')->click();
        return $seasons;
    }



    public function clickRandomSeriesWithEpisodes(){
        $I=$this;
        $I->waitAjaxLoad();
        $randomSeries=$I->findRandomElement(ContentPage::$rows_with_series_and_episodes['xpath']);
        $I->findElementInElement($randomSeries,'/td['.ContentPage::$type_column.']')->click();
    }

    public function seePublishedPercentage(){
        $I=$this;
        $I->see('Published');
        $percentageList=$I->grabMultiple(ContentPage::$all_published_percentage['xpath']);
        $regexedPercentageList=preg_grep('/^\d+(?:\.\d+)?%$/',$percentageList);
        $I->assertEquals($regexedPercentageList,$percentageList,'Published entries are percentages');
    }

    public function seeTranscodedPercentage(){
        $I=$this;
        $I->see('Transcoded');
        $percentageList=$I->grabMultiple(ContentPage::$all_transcoded_percentage['xpath']);
        $regexedPercentageList=preg_grep('/^\d+(?:\.\d+)?%$|N\/A/',$percentageList);
        $I->assertEquals($regexedPercentageList,$percentageList,'Transcoded entries are percentages or N/A');
    }

    public function shouldSeeTableSortedByPublished(){
        $I=$this;
        $publishedList=$I->grabMultiple(ContentPage::$all_published_percentage);
        $sortedPublishedList=$publishedList;
        usort($sortedPublishedList,'strcasecmp');
        print_r($sortedPublishedList);
        print_r($publishedList);
        $I->assertTrue($publishedList===$sortedPublishedList,'Tabel Should be sorted by Published');
    }

    public function shouldSeeTableReverseSortedByPublished(){
        $I=$this;
        $publishedList=$I->grabMultiple(ContentPage::$all_published_percentage);
        $sortedPublishedList=$publishedList;
        usort($sortedPublishedList,'strcasecmp');
        $reverseSortedPublishedList=array_reverse($sortedPublishedList);
        $I->assertTrue($reverseSortedPublishedList===$publishedList,'Table Should be reverse sorted by Published');
    }

    public function shouldSeeTableSortedByTranscoded(){
        $I=$this;
        $transcodedList=$I->grabMultiple(ContentPage::$all_transcoded_percentage);
        $sortedTranscodedList=$transcodedList;
        usort($sortedTranscodedList,'strnatcasecmp');
        $I->assertEquals($sortedTranscodedList,$transcodedList,'Tabel Should be sorted by Transcoded');
    }

    public function shouldSeeTableReverseSortedByTranscoded(){
        $I=$this;
        $transcodedList=$I->grabMultiple(ContentPage::$all_transcoded_percentage);
        $sortedTranscodedList=$transcodedList;
        usort($sortedTranscodedList,'strnatcasecmp');
        $reverseSortedTranscodedList=array_reverse($sortedTranscodedList);
        $I->assertEquals($reverseSortedTranscodedList,$transcodedList,'Table Should be reverse sorted by Transcoded');
    }

    public function findContentItemByTitle($title)
    {
        $I=$this;
        $I->selectNumberOfItemsPerPage("All");
        $I->amGoingTo('Wait for ' . $title . ' to be visible.');
        $I->waitForElement(ContentPage::findTitle($title), 60);
    }

    public function clickRandomContentInTableAndReturnGuid($rows_with_content_selector){
        $I=$this;
        $I->selectNumberOfItemsPerPage("All");
        $randomSeries=$I->findRandomElement($rows_with_content_selector);
        $guid=$I->findElementInElement($randomSeries,'/td[' . ContentPage::$guid_column . ']')->getText();
        $I->findElementInElement($randomSeries,'/td['.ContentPage::$type_column.']')->click();
        return $guid;
    }


    public function clickEditPencilOnRandomContentInTableAndReturnGuid($rows_with_content_selector){
        $I=$this;
        $I->selectNumberOfItemsPerPage("All");
        $randomSeries=$I->findRandomElement($rows_with_content_selector);
        $guid=$I->findElementInElement($randomSeries,'/td[' . ContentPage::$guid_column . ']')->getText();
        $I->findElementInElement($randomSeries,ContentPage::$edit_pencil['xpath'])->click();
        return $guid;
    }
}

