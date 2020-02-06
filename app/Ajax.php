<?php

namespace Portfolio;

class Ajax
{
    public function __construct()
    {
        check_ajax_referer('portfolio');
    }
}
