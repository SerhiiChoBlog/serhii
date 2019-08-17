<?php

use Portfolio\Hook;

require_once 'vendor/autoload.php';

(new Hook)
    ->addThumbFieldToJsonObject()
    ->disableWordpressStuff()
    ->addAfterThemeSupport()
    ->registerAssets();

