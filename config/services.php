<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'youtube' => [
        'key' => env('YOUTUBE_API_KEY'),
        'url' => 'https://youtube.googleapis.com/youtube/v3/search',
    ],

    'github' => [
        'projects_urls' => [
            'https://api.github.com/users/SerhiiCho/repos',
            'https://api.github.com/users/php-revival/repos',
            'https://api.github.com/users/smooth-loader/repos',
            'https://api.github.com/users/textwire/repos',
            'https://api.github.com/users/wp-pager/repos',
        ],
        'readme_url' => 'https://raw.githubusercontent.com/SerhiiCho/{repo}/master/README.md',
    ],

];
