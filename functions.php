<?php

require_once get_template_directory() . '/vendor/autoload.php';

add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
});

