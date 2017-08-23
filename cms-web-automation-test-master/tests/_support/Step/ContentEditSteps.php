<?php
namespace Step;

use Codeception\Exception\ElementNotFound;
use Codeception\Util\Fixtures;
use Page\ContentEditPage;
use Page\ContentEpisodeEditPage;

class ContentEditSteps extends ContentSteps {

    public $temp = [];
    public $savedDate=['monthYear'=>'','dayOfMonth'=>'','hours'=>'','minutes'=>'','formattedDate'=>''];

    public function amOnContentEditPage($guid, $wait = null) {
        $I = $this;
        $I->amOnPage(str_replace('{{guid}}', $guid, ContentEditPage::$URL));
        $I->waitAjaxLoad();
    }

    public function pressSaveChangesButton() {
        $I = $this;
        $I->waitElementToBeClickable(ContentEditPage::$save_bar['xpath']);
        $I->clickWithLeftButton(ContentEditPage::$save_bar);
        $I->waitAjaxLoad();
    }

    public function toggleSubDubOption() {
        $I = $this;
        Fixtures::add('localization_sub', $I->_toggleCheckbox(ContentEditPage::$localization_sub));
        Fixtures::add('localization_dub', $I->_toggleCheckbox(ContentEditPage::$localization_dub));
    }

    public function shouldSeeSubDubOptionsWasSaved() {
        $I = $this;
        $I->_checkCheckboxStatus(ContentEditPage::$localization_sub, Fixtures::get('localization_sub'));
        $I->_checkCheckboxStatus(ContentEditPage::$localization_dub, Fixtures::get('localization_dub'));
    }

    public function scrollToBottom($step, $callback = null) {
        $I = $this;
        $I->scrollBy(0, 1);
        parent::scrollToBottom($step, $callback);
    }

    public function unpublishContent($guid) {
        $I = $this;
        $I->amOnContentEditPage($guid);
        $I->waitForText(ContentEditPage::$published_checked_text);
        $I->click(ContentEditPage::$published_checkbox);
        $I->waitForText(ContentEditPage::$published_unchecked_text);
        $I->clickWithLeftButton(ContentEditPage::$save_bar['xpath']);
        $I->wait(3);
    }

    public function typesTVAndMovieShouldBeDisplayed() {
        $I = $this;
        $I->see('TV', ContentEditPage::$maturity_rating_tv_label);
        $I->see('Movie', ContentEditPage::$maturity_rating_movie_label);
    }

    public function typeShouldBeSelected() {
        $I = $this;
        $I->waitForElement(ContentEditPage::$maturity_rating_checked);
        $I->seeCheckboxIsChecked(ContentEditPage::$maturity_rating_checked);
    }

    public function selectMovieType() {
        $I = $this;
        $I->scrollTo(ContentEditPage::$maturity_rating_movie_input);
        $I->moveMouseOver(ContentEditPage::$maturity_rating_movie_input);
        $I->click(ContentEditPage::$maturity_rating_movie_input);
        $I->seeCheckboxIsChecked(ContentEditPage::$maturity_rating_movie_input);
    }

    public function selectRandomOption() {
        $I = $this;
        $I->scrollTo(ContentEditPage::$maturity_rating_checked);
        $id_selected_type = $I->grabAttributeFrom(ContentEditPage::$maturity_rating_checked, 'id');
        $type = explode('_', $id_selected_type)[2];
        $index = rand(1, count($I->findElements('css', str_replace('{{type}}', $type, ContentEditPage::$maturity_rating_options['css']))));
        $rating_type_option = str_replace(
            ['{{type}}', '{{index}}'],
            [$type, $index],
            ContentEditPage::$maturity_rating_option_label['css']
        );
        $I->scrollTo($rating_type_option);
        $I->click($rating_type_option);
        $I->click(ContentEditPage::$save_bar);
    }

    public function changesShouldBeSavedAfterRefresh() {
        $I = $this;
        $this->getCheckedInputBeforeAndAfterPageReload(ContentEditPage::$maturity_rating_option_checked['css'], false);
        $I->assertEquals($this->temp['ids'][0], $this->temp['ids'][1]);
    }

    public function selectMaturityRatingOption($type, $save) {
        $I = $this;
        $maturity_rating_input = str_replace('{{type}}', $type, ContentEditPage::$maturity_rating_input['xpath']);
        $I->scrollTo($maturity_rating_input);
        $I->click($maturity_rating_input);
        $index = rand(1, count($I->findElements('css', str_replace('{{type}}', $type, ContentEditPage::$maturity_rating_options_li['css']))));
        $I->click(str_replace(['{{type}}', '{{index}}'], [$type, $index], ContentEditPage::$maturity_rating_option_li['css']));
        if ($save) {
            $I->click(ContentEditPage::$save_bar);
        }
    }

    public function onlyOneRatingCategoryShouldBeSelected() {
        $I = $this;
        $total = count($I->findElements('css', ContentEditPage::$maturity_rating_checked['css']));
        $I->assertEquals($total, 1);
    }

    public function selectedCategoryShouldNotBeUnselected() {
        $I = $this;
        $id_checked_1 = $I->grabAttributeFrom(ContentEditPage::$maturity_rating_checked, 'id');
        $I->click('//input[@id="' . $id_checked_1 . '"]');
        $id_checked_2 = $I->grabAttributeFrom(ContentEditPage::$maturity_rating_checked, 'id');
        $I->assertEquals($id_checked_1, $id_checked_2);
    }

    private function getCheckedInputBeforeAndAfterPageReload($element, $visible) {
        $I = $this;
        $this->temp['ids'] = [];
        $this->temp['ids'][] = $I->grabAttributeFrom($element, 'id');
        $current_url = $I->grabFromCurrentUrl();
        $I->amOnPage($current_url);
        $I->waitForElementVisible($element . (!$visible ? ' + label' : ''), 30);
        $this->temp['ids'][] = $I->grabAttributeFrom($element, 'id');
    }

    public function accessPosterPage($image_type) {
        Fixtures::add("poster_type", $image_type);
        $selector = str_replace('{{image_type}}', $image_type, ContentEditPage::$poster_image);

        $I = $this;
        $I->waitForElement($selector);
        $I->moveMouseOver($selector);
        $I->clickWithLeftButton($selector, 10, 20);
    }

    public function shouldSeeSaveChangesButtonAboveNextSection() {
        $I = $this;
        $I->seeElement(ContentEditPage::$save_bar['xpath']);
        $y1 = $I->findElement(ContentEditPage::$save_bar['xpath'])->getLocation()->getY();
        $y2 = $I->findElement(ContentEditPage::$sectionAfterAttributes['xpath'])->getLocation()->getY();
        $I->assertGreaterThan($y1, $y2);
    }
  
    public function shouldSeeLandscapePoster() {
        $I = $this;
        $I->waitForElement(ContentEditPage::$image_section);
        $I->seeElement(ContentEditPage::$landscape_image);
    }

    public function shouldNotSeeLandscapePoster() {
        $I = $this;
        $I->waitForElement(ContentEditPage::$image_section);
        $I->dontSeeElement(ContentEditPage::$landscape_image);
    }

    public function shouldSeeLastPublishedHasCorrectFormat() {
        $I =$this;
        $lastPublished = $I->grabTextFrom(ContentEditPage::$last_published['xpath']);
        $lastPublished = str_replace('Last Published ', '', $lastPublished);
        $formattedLastPublished = date(ContentEditPage::$last_published_format, strtotime($lastPublished));
        $I->see('Last Published ' . $formattedLastPublished, ContentEditPage::$last_published);
    }

    public function checkPublishCheckbox() {
        $I = $this;
        $I->click(ContentEditPage::$published_checkbox);
        $I->see(ContentEditPage::$published_checked_text);
    }

    public function uncheckPublishCheckbox() {
        $I = $this;
        $I->click(ContentEditPage::$published_checkbox);
        $I->see(ContentEditPage::$published_unchecked_text);
    }

    public function shouldSeeNAOrOldLastPublished() {
        $I =$this;
        $lastPublished = $I->grabTextFrom(ContentEditPage::$last_published_data['xpath']);
        Fixtures::add('LastPublished', $lastPublished);
        if ($lastPublished == "N/A") {
            $I->see("N/A", ContentEditPage::$last_published_data);
        } else {
            $I->assertLessOrEquals(time(), strtotime($lastPublished));
        }
    }

    public function shouldSeeThatLastPublishedNotChanged() {
        $I = $this;
        $I->see(Fixtures::get('LastPublished'), ContentEditPage::$last_published);
    }

    public function shouldSeeNewLastPublished() {
        $I =$this;
        $I->dontSee(Fixtures::get('LastPublished'), ContentEditPage::$last_published);
        $lastPublished = $I->grabTextFrom(ContentEditPage::$last_published_data['xpath']);
        $I->assertGreaterThan(strtotime('-5 minutes'), strtotime($lastPublished));
        $I->assertLessOrEquals(time(), strtotime($lastPublished));
    }

    private function _checkCheckboxStatus($selector, $checked) {
        $I = $this;
        if ($checked) {
            $I->seeCheckboxIsChecked($selector);
        } else {
            $I->cantSeeCheckboxIsChecked($selector);
        }
    }

    private function _toggleCheckbox($selector) {
        $I = $this;

        $state = !(boolean)$I->grabAttributeFrom($selector, 'checked');
        $I->scrollTo($selector);
        if ($state) {
            $I->checkOption($selector);
        } else {
            $I->uncheckOption($selector);
        }

        return $state;
    }

    // Related Content

    public function linkContentTo($guid, $getAttributes = true) {
        $I = $this;
        Fixtures::add('current_page', $I->getCurrentUri());

        // Get information about the guid
        if ($getAttributes) {
            $I->amOnContentEditPage($guid);
            Fixtures::add($guid, $I->getAttributes());
            $I->amOnPage(Fixtures::get('current_page'));
        }

        // Unlink content if is already linked
        if (!$I->findElements(ContentEditPage::$linked_content_input)) {
            $I->removeLinkedContent();
        }

        // Link content
        $I->scrollTo(ContentEditPage::$linked_content_button);
        $I->fillField(ContentEditPage::$linked_content_input, $guid);
        $I->waitElementToBeClickable(ContentEditPage::$linked_content_button['xpath']);
        $I->click(ContentEditPage::$linked_content_button);
        $I->waitAjaxLoad();

        Fixtures::add('GUID', $guid);
    }

    public function removeLinkedContent() {
        $I = $this;
        $I->clickWithLeftButton(ContentEditPage::$linked_content_unlink);
        $I->waitAjaxLoad();
    }

    public function shouldSeeContentCannotBeLinked() {
        $I = $this;
        $I->see('The GUID may not exist or may be an invalid content type.', ContentEditPage::$linked_content_error);
    }

    public function shouldSeeContentWasLinked() {
        $I = $this;
        $url = explode('/', $I->getCurrentUri());

        $I->waitForText(end($url),10, ContentEditPage::$linked_card_guid);
        $I->see($I->grabTextFrom(ContentEditPage::$channel), ContentEditPage::$linked_card_channel);
        $I->see($I->grabTextFrom(ContentEditPage::$title), ContentEditPage::$linked_card_title);
        if ($I->grabAttributeFrom(ContentEditPage::$localization_sub, 'checked')) {
            $I->see('sub', ContentEditPage::$linked_card_flags);
        }

        if ($I->grabAttributeFrom(ContentEditPage::$localization_dub, 'checked')) {
            $I->see('dub', ContentEditPage::$linked_card_flags);
        }

        $attributes = Fixtures::get(Fixtures::get('GUID'));
        $I->see(Fixtures::get('GUID'), ContentEditPage::$linked_card_2_guid);
        $I->see($attributes->channel, ContentEditPage::$linked_card_2_channel);
        $I->see($attributes->title, ContentEditPage::$linked_card_2_title);
        if ($attributes->subbed) $I->see('sub', ContentEditPage::$linked_card_2_flags);
        if ($attributes->dubbed) $I->see('dub', ContentEditPage::$linked_card_2_flags);

    }

    private function getAttributes() {
        $I = $this;
        return (object)[
            'title' => $I->grabValueFrom(ContentEditPage::$title),
            'channel' => $I->grabTextFrom(ContentEditPage::$channel),
            'subbed' => $I->grabAttributeFrom(ContentEditPage::$localization_sub, 'checked'),
            'dubbed' => $I->grabAttributeFrom(ContentEditPage::$localization_dub, 'checked')
        ];
    }

    public function shouldSeeChannelTitle(){
        $I=$this;
        $I->waitAjaxLoad();
        $selected_channel=$I->grabTextFrom(ContentEditPage::$channel_dropdown_selected_option);
        $published_channel=$I->grabTextFrom(ContentEditPage::$channel);
        $I->assertEquals(trim($selected_channel),trim($published_channel));
    }

    public function setDate( $inputToSet, $monthYear, $dayOfMonth,$hour,$minutes, $formattedDate) {
        $I=$this;
        if(strcasecmp($formattedDate,'Select an Air Date')==0){
            $I->click(ContentEpisodeEditPage::$clear_date_button);
            return;
        }
        $I->amGoingTo('Open calendar');
        $I->wait(5);
        $I->scrollTo($inputToSet);
        $I->click($inputToSet);
        $I->waitForElementVisible(ContentEditPage::$calendar_main, 30);

        if (self::isFuture($dayOfMonth . ' ' . $monthYear, $I->grabValueFrom($inputToSet))) {
            $button = ContentEditPage::$calendar_nextBtn;
        } else {
            $button = ContentEditPage::$calendar_prevBtn;
        }

        $I->amGoingTo('Set the date for ' . $dayOfMonth . 'th of ' . $monthYear);
        $calendar = $I->findElement(ContentEditPage::$calendar_main_xpath);
        $caption = $I->findElementInElement($calendar, ContentEditPage::$calendar_caption_xpath);
        $date_reached=false;
        while(!$date_reached) {
            try{
                $I->isDisplayed(['xpath'=>"//div[contains(text(), '" . $monthYear . "')]"]);
                $date_reached=true;
            }catch(ElementNotFound $e){
                $I->scrollTo($button);
                $I->click($button);
                $I->wait(3);
            }

        }
        $I->click("//div[contains(@class, 'DayPicker-Body')]//div[text()='" . $dayOfMonth . "']");
        $I->fillField(ContentEpisodeEditPage::$calendar_hours,$hour);
        $I->fillField(ContentEpisodeEditPage::$calendar_minutes,$minutes);
        $I->expect('Correct date shows up in field.');
        $I->wait(5);
        $I->seeInField($inputToSet, $formattedDate);
        $I->wait(1);

        $I->amGoingTo('Click OK on the calendar.');
        $I->click(ContentEditPage::$calendar_confirm);
    }

    function isFuture($time, $now = 'today') {
        $now = strtotime($now);
        $now = $now ? $now : strtotime('today');
        return strtotime($time) > $now;
    }

    public function saveDate(){
        $I=$this;
        $I->savedDate['formattedDate']=$I->grabValueFrom(ContentEpisodeEditPage::$airDateRow_editable);
        if(strcasecmp($I->savedDate['formattedDate'],'Select an Air Date')==0){
            return;
        }
        $I->click(ContentEpisodeEditPage::$airDateRow_editable);
        $I->waitForElementVisible(ContentEpisodeEditPage::$calendar_main, 30);
        $I->savedDate['monthYear']=$I->grabTextFrom(ContentEpisodeEditPage::$calendar_caption_xpath);
        $I->savedDate['dayOfMonth']=$I->grabTextFrom(ContentEpisodeEditPage::$selected_date);
        $I->savedDate['hours']=$I->grabValueFrom(ContentEpisodeEditPage::$calendar_hours);
        $I->savedDate['minutes']=$I->grabValueFrom(ContentEpisodeEditPage::$calendar_minutes);
    }


}