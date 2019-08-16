<?php

$get_last_reports = function () {
    wp_die();
};
add_action('wp_ajax_get_last_reports', $get_last_reports);
add_action('wp_ajax_nopriv_get_last_reports', $get_last_reports);
