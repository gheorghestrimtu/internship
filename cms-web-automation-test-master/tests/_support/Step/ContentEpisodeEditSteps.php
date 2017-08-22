<?php
namespace Step;


use Page\ContentEditPage;
use Page\ContentEpisodeEditPage;
use TestContentGuids;

class ContentEpisodeEditSteps extends ContentEditSteps
{

    public function amOnEpisodeEditPage()
    {
        if ($this->getScenario()->current('env') == 'proto0') {
            $guid = ContentEpisodeEditPage::$episodeViewData_proto0;
        } else {
            $guid = ContentEpisodeEditPage::$episodeViewData_staging;
        }

        $I = $this;
        $I->amOnPage(ContentEpisodeEditPage::$contentUrl . $guid);
        $I->waitAjaxLoad();
    }

    public function amOnEpisodeEditPageMinimumData(){
        if ($this->getScenario()->current('env') == 'proto0') {
            $guid = ContentEpisodeEditPage::$episodeViewMinimumData_proto0;
        } else {
            $guid = ContentEpisodeEditPage::$episodeViewMinimumData_staging;
        }

        $I = $this;
        $I->amOnPage(ContentEpisodeEditPage::$contentUrl . $guid);
        $I->waitAjaxLoad();
    }

    public function amOnRandomEpisodePage(ContentSeasonSteps $I2)
    {
        $I = $this;
        $I2->amOnContentPage();
        $I2->clickRandomSeriesWithEpisodes();
        $I2->clickRandomSeasonWithEpisodes();
        $I->clickRandomEpisode();
    }

    public function clickRandomEpisode()
    {
        $I = $this;
        $I->waitAjaxLoad();
        $I->selectNumberOfItemsPerPage("All");
        $randomEpisode = $I->findRandomElement(ContentEpisodeEditPage::$table_rows['xpath']);
        ContentEpisodeEditPage::$guid_for_random_episode = $I->findElementInElement($randomEpisode, '/td[' . ContentEpisodeEditPage::$guid_column . ']')->getText();
        $I->findElementInElement($randomEpisode, '/td[' . ContentEpisodeEditPage::$type_column . ']')->click();
    }

    public function clickRandomUnpuplishedEpisode()
    {
        $I = $this;
        $I->waitAjaxLoad();
        $I->selectNumberOfItemsPerPage("All");
        $randomEpisode = $I->findRandomElement(ContentEpisodeEditPage::$rows_with_unpuplished_episodes['xpath']);
        ContentEpisodeEditPage::$guid_for_random_episode = $I->findElementInElement($randomEpisode, '/td[' . ContentEpisodeEditPage::$guid_column . ']')->getText();
        $I->findElementInElement($randomEpisode, '/td[' . ContentEpisodeEditPage::$type_column . ']')->click();
    }

    public function amOnRandomUnpuplishedEpisodePage(ContentSeasonSteps $I2)
    {
        $I = $this;
        $I2->amOnContentPage();
        $I2->clickRandomSeriesWithUnpuplishedEpisodes();
        $I2->clickRandomSeasonWithUnpuplishedEpisodes();
        $I->clickRandomUnpuplishedEpisode();
    }

    public function shouldSeeField($fieldName)
    {
        $I = $this;
        $I->waitAjaxLoad();
        $I->seeElement(ContentEpisodeEditPage::getField($fieldName));
    }

    public function seeVideosGuid(){
        $I=$this;
        $I->see('GUID', ContentEpisodeEditPage::$videoTable_guidHeader);
        if($I->getScenario()->current('env') == 'staging')
        {
            $I->see('GY9P8J10R', ContentEpisodeEditPage::$videoTable_firstGuid);
        }
        else
        {
            $I->see('GYGGPWMEY', ContentEpisodeEditPage::$videoTable_firstGuid);
        }
    }

    public function seeVideosTitle(){
        $I=$this;
        $I->waitForElementVisible(ContentEpisodeEditPage::$clickableTable, 30);
        $I->see('VIDEOS','h1');
        $I->see('Title', ContentEpisodeEditPage::$videoTable_titleHeader);
        $I->see('series_view_filled_data_automation_1_episode_1_media_id', ContentEpisodeEditPage::$videoTable_firstTitle);
    }

    public function seeVideosDuration(){
        $I=$this;
        $I->waitForElementVisible(ContentEpisodeEditPage::$clickableTable, 30);
        $I->see('VIDEOS','h1');
        $I->see('Duration', ContentEpisodeEditPage::$videoTable_durationHeader);
        $I->see('00:24:00', ContentEpisodeEditPage::$videoTable_firstDuration);
    }

    public function dontSeeSortableVideoTable(){
        $I=$this;
        $I->expect('Video List is displayed, sortable class is not present.');
        $I->waitForElementVisible(ContentEpisodeEditPage::$clickableTable, 30);
        $I->see('VIDEOS','h1');
        $I->dontSee('.sortable');
    }

    public function dontSeeSortableImagesTable(){
        $I=$this;
        $I->waitForElementVisible(ContentEpisodeEditPage::$clickableTable, 30);
        $I->see("IMAGES",'h1');
        $I->dontSee('.sortable');
    }

    public function seeImagesList(){
        $I=$this;
        $I->expect('Images List is displayed.');
        $I->waitForElementVisible(ContentEpisodeEditPage::$clickableTable, 30);
        $I->see('IMAGES','h1');
        if($I->getScenario()->current('env') == 'staging')
        {
            $I->see('e653f1094306790084dd8262c5a0e168.png', ContentEpisodeEditPage::$imagesTable);
        }
        else
        {
            $I->see('45ad52a32ca5e4d374086aaa19c49e02.png', ContentEpisodeEditPage::$imagesTable);
        }
    }

    public function seeImagesTitle(){
        $I=$this;
        $I->expect('Image List Title Column is displayed.');
        $I->waitForElementVisible(ContentEpisodeEditPage::$clickableTable, 30);
        $I->see('IMAGES','h1');
        $I->see('Title', ContentEpisodeEditPage::$imagesTable_titleHeader);
        if($I->getScenario()->current('env') == 'staging')
        {
            $I->see('e653f1094306790084dd8262c5a0e168.png', ContentEpisodeEditPage::$imagesTable_firstTitle);
        }
        else //proto0
        {
            $I->see('45ad52a32ca5e4d374086aaa19c49e02.png', ContentEpisodeEditPage::$imagesTable_firstTitle);
        }
    }

    public function seeImagesType(){
        $I=$this;
        $I->expect('Image List Type Column is displayed.');
        $I->waitForElementVisible(ContentEpisodeEditPage::$clickableTable, 30);
        $I->see('IMAGES','h1');
        $I->see('Type', ContentEpisodeEditPage::$imagesTable_typeHeader);
        if($I->getScenario()->current('env') == 'staging')
        {
            $I->see('Portrait Poster', ContentEpisodeEditPage::$imagesTable_firstType);
        }
        else //proto0
        {
            $I->see('Landscape Poster', ContentEpisodeEditPage::$imagesTable_firstType);
        }
    }

    public function seeNoImagesMessage(){
        $I=$this;
        $I->waitForText('Landscape Poster image not found', 30);
        $I->waitForText('Portrait Poster image not found', 30);
    }


}