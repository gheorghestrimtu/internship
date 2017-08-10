<?php

class VideoEditCest
{
    public static $environment = 'undefined';
    public static $loginCookie = 'undefined';

    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        //Set the environment for the cest
        if (VideoEditCest::$environment == 'undefined')
        {
            VideoEditCest::$environment = AcceptanceUtils::getEnvironment($I);
        }

        VideoEditCest::$loginCookie = AcceptanceUtils::login($I, LoginInfo::$username, LoginInfo::$password, VideoEditCest::$loginCookie);
    }

    public function _after(AcceptanceTester $I)
    {
    }

    //TESTS
    //EPISODE
    /**
    * TESTRAIL TESTCASE ID: C15657
    *
    * @group test_priority_2
    */
    public function episodeClickChangeThumbnailLink(AcceptanceTester $I)
    {
        $I->wantTo('Verify cliking the Change Thumbnail link on an Episode Video takes us to the thumbnail page. - C15657');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('Change Thumbnail', 30);
        $I->click('Change Thumbnail');

        $I->expect('We are taken to the thumbnails page.');
        $I->waitForText('THUMBNAILS', 30);
        $I->waitForText('CURRENT THUMBNAIL', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15656
    *
    * @group test_priority_2
    */
    public function episodeNoThumbnailMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Thumbnail message appears on episode videos. - C15656');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeVideoViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeVideoViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('THUMBNAIL', 30);
        $I->waitForText('VIDEO PREVIEW', 30);

        $I->expect('The No Thumbnail message appears. No image is shown.');
        $I->dontSeeElement("//img");
        $I->see('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C166964
    *
    * @group test_priority_2
    */
    public function episodeChangeThumbnailLinkNotVisible(AcceptanceTester $I)
    {
        $I->wantTo('Verify the Change Thumbnail link does not show up if there is no encoded video. - C166964');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeVideoViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeVideoViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('THUMBNAIL', 30);
        $I->waitForText('VIDEO PREVIEW', 30);

        $I->expect('The Change Thumbnail link does not appear.');
        $I->dontSee('Change Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C15659
    *
    * @group test_priority_2
    */
    public function episodeVideoTypeDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Type is displayed on Episode Video. - C15659');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Video Type is displayed.');
        $I->waitForText('episode', 30, ContentPage::$videoTypeRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15658
    *
    * @group test_priority_2
    */
    public function episodeAdBreakDisplays(AcceptanceTester $I)
    {
        $I->wantTo('Verify Ad Break is displayed on Episode Video. - C15658');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Ad break is displayed.');
        $I->waitForText('00:00:05', 30, '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C15660
    *
    * @group test_priority_2
    */
    public function episodeVideoDurationDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Duration is displayed on Episode Video. - C15660');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Video Duration is displayed.');
        $I->waitForText('00:24:00', 30, ContentPage::$durationRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15668
    *
    * @group test_priority_2
    */
    public function episodeEditVideoTitle(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Title can be edited. - C15668');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$episodeVideoEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$episodeVideoEditData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->scrollTo(ContentPage::$videoTitleRow_editable);
        $I->fillField(ContentPage::$videoTitleRow_editable, "Edited Title");
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Edited Title");

        $I->amGoingTo('Change title again.');
        $I->scrollTo(ContentPage::$videoTitleRow_editable);
        $I->fillField(ContentPage::$videoTitleRow_editable, "Altered Title");
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Altered Title");
    }

    //MOVIE
    /**
    * TESTRAIL TESTCASE ID: C15721
    *
    * @group test_priority_2
    */
    public function movieClickChangeThumbnailLink(AcceptanceTester $I)
    {
        $I->wantTo('Verify cliking the Change Thumbnail link on an Movie Video takes us to the thumbnail page. - C15721');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('Change Thumbnail', 30);
        $I->click('Change Thumbnail');

        $I->expect('We are taken to the thumbnails page.');
        $I->waitForText('THUMBNAILS', 30);
        $I->waitForText('CURRENT THUMBNAIL', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15720
    *
    * @group test_priority_2
    */
    public function movieNoThumbnailMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Thumbnail message appears on movie videos. - C15720');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieVideoViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieVideoViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('THUMBNAIL', 30);
        $I->waitForText('VIDEO PREVIEW', 30);

        $I->expect('The No Thumbnail message appears. No image is shown.');
        $I->dontSeeElement("//img");
        $I->see('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C166965
    *
    * @group test_priority_2
    */
    public function movieChangeThumbnailLinkNotVisible(AcceptanceTester $I)
    {
        $I->wantTo('Verify the Change Thumbnail link does not show up if there is no encoded video. - C166965');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieVideoViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieVideoViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('THUMBNAIL', 30);
        $I->waitForText('VIDEO PREVIEW', 30);

        $I->expect('The Change Thumbnail link does not appear.');
        $I->dontSee('Change Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C15723
    *
    * @group test_priority_2
    */
    public function movieVideoTypeDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Type is displayed on Movie Video. - C15723');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Video Type is displayed.');
        $I->waitForText('movie', 30, ContentPage::$videoTypeRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15722
    *
    * @group test_priority_2
    */
    public function movieAdBreakDisplays(AcceptanceTester $I)
    {
        $I->wantTo('Verify Ad Break is displayed on Movie Video. - C15722');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Ad break is displayed.');
        $I->waitForText('00:00:05', 30, '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C15724
    *
    * @group test_priority_2
    */
    public function movieVideoDurationDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Duration is displayed on Movie Video. - C15724');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Video Duration is displayed.');
        $I->waitForText('00:24:00', 30, ContentPage::$durationRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15732
    *
    * @group test_priority_2
    */
    public function movieEditVideoTitle(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Title can be edited. - C15732');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$movieVideoEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$movieVideoEditData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->scrollTo(ContentPage::$videoTitleRow_editable);
        $I->fillField(ContentPage::$videoTitleRow_editable, "Edited Title");
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Edited Title");

        $I->amGoingTo('Change title again.');
        $I->scrollTo(ContentPage::$videoTitleRow_editable);
        $I->fillField(ContentPage::$videoTitleRow_editable, "Altered Title");
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Altered Title");
    }

    //SERIES EXTRA
    /**
    * TESTRAIL TESTCASE ID: C15751
    *
    * @group test_priority_2
    */
    public function seriesExtraClickChangeThumbnailLink(AcceptanceTester $I)
    {
        $I->wantTo('Verify cliking the Change Thumbnail link on an Series Extra Video takes us to the thumbnail page. - C15751');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesExtraVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesExtraVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('Change Thumbnail', 30);
        $I->click('Change Thumbnail');

        $I->expect('We are taken to the thumbnails page.');
        $I->waitForText('THUMBNAILS', 30);
        $I->waitForText('CURRENT THUMBNAIL', 30);
    }

    /**
    * TESTRAIL TESTCASE ID: C15750
    *
    * @group test_priority_2
    */
    public function seriesExtraNoThumbnailMessage(AcceptanceTester $I)
    {
        $I->wantTo('Verify the No Thumbnail message appears on Series Extra videos. - C15750');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesExtraVideoViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesExtraVideoViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('THUMBNAIL', 30);
        $I->waitForText('VIDEO PREVIEW', 30);

        $I->expect('The No Thumbnail message appears. No image is shown.');
        $I->dontSeeElement("//img");
        $I->see('No Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C166966
    *
    * @group test_priority_2
    */
    public function seriesExtraChangeThumbnailLinkNotVisible(AcceptanceTester $I)
    {
        $I->wantTo('Verify the Change Thumbnail link does not show up if there is no encoded video. - C166966');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesExtraVideoViewMinimumData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesExtraVideoViewMinimumData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);
        $I->waitForText('THUMBNAIL', 30);
        $I->waitForText('VIDEO PREVIEW', 30);

        $I->expect('The Change Thumbnail link does not appear.');
        $I->dontSee('Change Thumbnail');
    }

    /**
    * TESTRAIL TESTCASE ID: C15753
    *
    * @group test_priority_2
    */
    public function seriesExtraVideoTypeDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Type is displayed on Series Extra Video. - C15753');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesExtraVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesExtraVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Video Type is displayed.');
        $I->waitForText('trailer', 30, ContentPage::$videoTypeRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15752
    *
    * @group test_priority_2
    */
    public function seriesExtraAdBreakDisplays(AcceptanceTester $I)
    {
        $I->wantTo('Verify Ad Break is displayed on Series Extra Video. - C15752');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesExtraVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesExtraVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Ad break is displayed.');
        $I->waitForText('00:00:05', 30, '//div[@class="adbreaks-input"]/ul/li/span');
    }

    /**
    * TESTRAIL TESTCASE ID: C15754
    *
    * @group test_priority_2
    */
    public function seriesExtraVideoDurationDisplayed(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Duration is displayed on Series Extra Video. - C15754');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesExtraVideoViewData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesExtraVideoViewData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Video Duration is displayed.');
        $I->waitForText('00:24:00', 30, ContentPage::$durationRow);
    }

    /**
    * TESTRAIL TESTCASE ID: C15762
    *
    * @group test_priority_2
    */
    public function seriesExtraEditVideoTitle(AcceptanceTester $I)
    {
        $I->wantTo('Verify Video Title can be edited. - C15762');
        if(VideoEditCest::$environment == 'staging')
        {
            $guid = TestContentGuids::$seriesExtraVideoEditData_staging;
        }
        else //proto0
        {
            $guid = TestContentGuids::$seriesExtraVideoEditData_proto0;
        }
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->scrollTo(ContentPage::$videoTitleRow_editable);
        $I->fillField(ContentPage::$videoTitleRow_editable, "Edited Title");
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Edited Title");

        $I->amGoingTo('Change title again.');
        $I->scrollTo(ContentPage::$videoTitleRow_editable);
        $I->fillField(ContentPage::$videoTitleRow_editable, "Altered Title");
        $I->click('Save Changes');
        $I->wait(2);

        $I->amGoingTo('Reload the page.');
        $I->amOnPage(ContentPage::$mediaUrl . $guid);

        $I->expect('Title has been saved.');
        $I->seeInField(ContentPage::$videoTitleRow_editable, "Altered Title");
    }
}
