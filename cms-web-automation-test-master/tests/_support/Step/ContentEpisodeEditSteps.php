<?php
namespace Step;

use ContentPage;
use Page\ContentEditPage;
use Page\ContentEpisodeEditPage;
use TestContentGuids;

class ContentEpisodeEditSteps extends ContentEditSteps
{

    public function amOnEpisodeEditPage()
    {
        if ($this->getScenario()->current('env') == 'proto0') {
            $guid = TestContentGuids::$episodeViewData_proto0;
        } else {
            $guid = TestContentGuids::$episodeViewData_staging;
        }

        $I = $this;
        $I->amOnPage(ContentPage::$contentUrl . $guid);
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
        $randomEpisode = $I->findRandomElement(ContentEpisodeEditPage::$table_rows['xpath']);
        ContentEpisodeEditPage::$guid_for_publish = $I->findElementInElement($randomEpisode, '/td[' . ContentEpisodeEditPage::$guid_column . ']')->getText();
        $I->findElementInElement($randomEpisode, '/td[' . ContentEpisodeEditPage::$type_column . ']')->click();
    }

    public function clickRandomUnpuplishedEpisode()
    {
        $I = $this;
        $I->waitAjaxLoad();
        $randomEpisode = $I->findRandomElement(ContentEpisodeEditPage::$rows_with_unpuplished_episodes['xpath']);
        ContentEpisodeEditPage::$guid_for_publish = $I->findElementInElement($randomEpisode, '/td[' . ContentEpisodeEditPage::$guid_column . ']')->getText();
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



}