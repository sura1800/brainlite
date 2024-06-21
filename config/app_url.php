<?php

return [
    'asset_base_url' => env('APP_URL', '').'/'.env('ASSET_BASE_PATH', ''),
    'asset_base_path' => env('ASSET_BASE_PATH', ''),
    'filename_append_str' => env('FILENAME_STR', 'jblegal'),
    'asset_legaldoc_url' => env('ASSET_PATH_LEGALDOC', 'public/upload/legaldoc/'),  // Storage Path
    'asset_ledgerdoc_url' => env('ASSET_PATH_LEGALDOC', 'public/upload/ledgerdoc/'),  // Storage Path

    'asset_sponsor_url' => env('ASSET_PATH_SPONSOR', 'upload/sponsor/images/'),
    'asset_exhibitor_url' => env('ASSET_PATH_EXHIBITOR', 'upload/exhibitor/images/'),
    'asset_speaker_url' => env('ASSET_PATH_SPEAKER', 'upload/speaker/images/'),
    'asset_slider_url' => env('ASSET_PATH_SLIDER', 'upload/slider/images/'),
];
