<?php
namespace Step;

use Page\ContentSeasonPage;
use Step\ContentSeriesSteps;
use Step\ContentSteps;

class ContentSeasonSteps extends ContentSteps {
    public function seeCorrectNumberOfEpisodes($episodes){
        $I=$this;
        $rowCount=$I->findElements('xpath',ContentSeasonPage::$table_rows['xpath']);
        $I->assertEquals($episodes,count($rowCount),'Correct number of episodes');
    }

    public function clickRandomSeasonWithEpisodes(){
        $I=$this;
        $I->waitAjaxLoad();
        $randomSeries=$I->findRandomElement(ContentSeasonPage::$rows_with_episodes['xpath']);
        $I->findElementInElement($randomSeries,'/td['.ContentSeasonPage::$type_column.']')->click();
    }

    public function clickRandomSeasonWithUnpuplishedEpisodes(){
        $I=$this;
        $I->waitAjaxLoad();
        $randomSeries=$I->findRandomElement(ContentSeasonPage::$rows_with_unpuplished_episodes['xpath']);
        $I->findElementInElement($randomSeries,'/td['.ContentSeasonPage::$type_column.']')->click();
    }
}