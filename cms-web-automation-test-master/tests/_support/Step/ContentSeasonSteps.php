<?php
namespace Step;

use Page\ContentSeasonPage;
use Step\ContentSeriesSteps;

class ContentSeasonSteps extends \AcceptanceTester {
    public function seeCorrectNumberOfEpisodes($episodes){
        $I=$this;
        $rowCount=$I->findElements('xpath',ContentSeasonPage::$table_rows['xpath']);
        $I->assertEquals($episodes,count($rowCount),'Correct number of episodes');
    }
}