<?php

declare(strict_types=1);

namespace App\Services\Comment;

use HTMLPurifier;
use HTMLPurifier_Config;

readonly class CommentSanitizer
{
    public function sanitize(string $html): string
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'a[href|target|rel],br');
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true]);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('HTML.TargetBlank', true);
        $config->set('HTML.Nofollow', true);
        $config->set('Cache.DefinitionImpl', null);

        return (new HTMLPurifier($config))->purify($html);
    }
}
