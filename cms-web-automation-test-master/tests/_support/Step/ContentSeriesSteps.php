<?php
namespace Step;
use Page\ContentSeriesPage;
use Step\ContentSteps;

class ContentSeriesSteps extends ContentSteps{
    public function seeCorrectNumberOfSeasons($seasons){
        $I=$this;
        $rowCount=$I->findElements('xpath',ContentSeriesPage::$table_rows['xpath']);
        $I->assertEquals($seasons,count($rowCount),'Correct number of seasons');
    }

    public function clickRandomSeasonAndReturnNumberOfEpisodes(){
        $I=$this;
        $randomSeason=$I->findRandomElement(ContentSeriesPage::$all_seasons);
        $episodes=$I->findElementInElement($randomSeason,'/td[6]')->getText();
        $I->findElementInElement($randomSeason,'/td[6]')->click();
        return $episodes;
    }

    public function clickRandomSeasonWithEpisodes(){
        $I=$this;
        $I->waitAjaxLoad();
        $randomSeries=$I->findRandomElement(ContentSeriesPage::$rows_with_episodes['xpath']);
        $I->findElementInElement($randomSeries,'/td['.ContentPage::$type_column.']')->click();
    }

}