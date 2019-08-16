<?php

namespace Portfolio;

use WP_Query;
use Portfolio\DarkTheme;

class Ajax
{
    public function __construct()
    {
        check_ajax_referer('portfolio');
    }
}
