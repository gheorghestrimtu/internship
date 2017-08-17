<?php
namespace Step;
use Page\ContentSeriesPage;
class ContentSeriesSteps extends \AcceptanceTester {
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

}