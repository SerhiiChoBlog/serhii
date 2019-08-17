<?php

use Portfolio\Hook;

require_once 'vendor/autoload.php';

(new Hook)
    ->disableWordpressStuff()
    ->addAfterThemeSupport()
    ->registerAssets();
