<?php
namespace Page;

class IngestionDashboardPage {

    public static $URL = '/chan/ingesttest/dashboard/';

    public static $ingest_breadcrumb_navigation = ['xpath' => '//ul[@class="breadcrumbs"]/li/span[text()="Ingestion"]'];
    public static $ingest_tab_after_feed = ['xpath' => '//a[text()="Feed"]/ancestor::li/following-sibling::li/a'];
    public static $filter = ['xpath' => '//div[@class="filter"]/ancestor::div/ancestor::div[contains(@class, "show")]//div[@class="opener"]'];
    public static $filter_option = ['xpath' => '//div[@class="filter"]/div[@class="options"]/div[text()="{{text}}"]'];
    public static $manifests_tab = ['xpath' => '//a[text()="Manifests"]'];
    public static $manifests_rows = ['xpath' => '//*[@class="manifest-row"]'];
    public static $manifests_row = ['xpath' => '(//*[@class="manifest-row"])[{{index}}]'];
    public static $manifests_json_links = ['xpath' => '//a[contains(text(), ".json")]'];
    public static $manifests_row_status = ['xpath' => '//tr/td[contains(@class, "manifest-status")]/div[text()="{{text}}"]'];
    public static $manifests_row_status_ready_for_ingest = ['xpath' => '//tr/td[contains(@class, "manifest-status")]/div[text()="ready for ingest"]'];
    public static $manifests_row_status_processing = ['xpath' => '//tr/td[contains(@class, "manifest-status")]/div[text()="processing"]'];
    public static $manifests_row_status_completed = ['xpath' => '//tr/td[contains(@class, "manifest-status")]/div[text()="completed"]'];
    public static $manifests_row_status_completed_with_errors = ['xpath' => '//tr/td[contains(@class, "manifest-status")]/div[text()="completed with errors"]'];
    public static $manifests_row_status_cancelled = ['xpath' => '//tr/td[contains(@class, "manifest-status")]/div[text()="cancelled"]'];
    public static $manifests_row_status_missing_files = ['xpath' => '//tr/td[contains(@class, "manifest-status")]/div[text()="missing files"]'];
    public static $manifests_row_status_manifest_error = ['xpath' => '//tr/td[contains(@class, "manifest-status")]/div[text()="manifest error"]'];
    public static $manifests_three_dots = ['xpath' => '/ancestor::td/following-sibling::td/div'];
    public static $transcodes_tab = ['xpath' => '//a[text()="Transcodes"]'];
    public static $transcodes_rows = ['xpath' => '//*[@class="transcode-row"]'];
    public static $transcodes_row = ['xpath' => '(//*[@class="transcode-row"])[{{index}}]'];
    public static $transcodes_filter_options = ['xpath' => '//div[@class="transcodes-actions"]/div[@class="filter"]/div[@class="options"]/div[text()="{{text}}"]'];
    public static $transcodes_columns = ['xpath' => '//table[@class="ingest-table"]/thead/tr/th[text()="{{text}}"]'];
    public static $transcode_status = ['xpath' => '//td[contains(@class, "{{class}}")]/div[text()="{{text}}"]'];
    public static $transcodes_three_dots = ['xpath' => '/tr/td[7]/div[@class="actions-menu"]'];
    public static $transcodes_actions = ['xpath' => '/div[@class="transcode-actions"]/div[text()="{{text}}"]'];
    public static $dialog_retry_transcoding = ['xpath' => '//div[contains(@class, "alert-popup")]/h1[text()="Retry Transcoding?"]'];
    public static $json_popup = ['xpath' => '//div[@class="task-details-widget"]'];

    public static $ingest_tab_name = 'INGESTION';
    public static $manifests_row_details_columns_text = ['Task Type', 'Status', 'Media'];
    public static $manifests_row_statuses = ['ready for ingest', 'processing', 'completed', 'completed with errors', 'cancelled', 'missing files', 'manifest error'];
    public static $transcodes_filter_options_text = ['Pending', 'Queued', 'Processing', 'Cancelled', 'Completed', 'Failed'];
    public static $transcodes_columns_text = ['Channel', 'Mezzanine', 'Media ID', 'Manifest', 'Started', 'Last Modified', 'Status'];
    public static $transcodes_row_options = ['Cancel', 'Prioritize', 'Retry'];
  
}