<?php

use Portfolio\Hook;

require_once __DIR__ . '/vendor/autoload.php';

(new Hook)
    ->addThumbFieldToJsonObject()
    ->disableWordpressStuff()
    ->addAfterThemeSupport()
    ->addNewImageSize()
    ->registerAssets();
