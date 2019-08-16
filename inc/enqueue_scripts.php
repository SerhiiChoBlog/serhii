<?php

use Portfolio\Helper;

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('portfolio-style', Helper::getDirUri('style.css'), [], Helper::fileVersion('style.css'));
    wp_register_script('portfolio-js', Helper::getDirUri('assets/main.js'), [], Helper::fileVersion('assets/main.js'));
    wp_deregister_script('jquery');

    wp_localize_script('portfolio-js', 'sho_globals', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('portfolio'),
    ]);

    wp_enqueue_script('portfolio-js', Helper::getDirUri('assets/main.js'), [], Helper::fileVersion('assets/main.js'), true);
});