<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\AboutMe;

use App\Dto\WorkProject;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class WorkProjectController extends Controller
{
    public const WP = 'wordpress';
    public const PHP = 'php';
    public const TS = 'typescript';
    public const JS = 'javascript';
    public const LARAVEL = 'laravel';
    public const REACT = 'react';
    public const VUE = 'vue';
    public const TAILWIND = 'tailwind';
    public const SASS = 'sass';

    public function __invoke(): JsonResponse
    {
        return response()->json($this->getWorkProjects());
    }

    /**
     * @return array<int, WorkProject>
     */
    private function getWorkProjects(): array
    {
        return [
            new WorkProject(
                image_uri: '/storage/tools/site-sho.webp',
                title: 'Shobar',
                subtitle: 'WordPress website with custom theme and plugins',
                content: <<<HTML
                <p>Shobar is a restaurant bar in Kharkiv, Ukraine with a unique atmosphere and delicious food. The website was created with WordPress CMS and custom theme designed and developed by me. The website has a custom menu plugin that allows the administrator to manipulate the content fo the whole website.</p>
                <p>It has a custom developed payment system using Ukrainian payment system WayForPay and a custom developed delivery system with cart and checkout.</p>
                HTML,
                link: 'https://shobar.com.ua/',
                technologies: [self::WP, self::PHP, self::TS, self::SASS],
            ),
            new WorkProject(
                image_uri: '/storage/tools/client-cabinet.webp',
                title: 'Client cabinet',
                subtitle: 'Client cabinet for a Dutch tax company',
                content: 'todo',
                link: 'https://mijn.nalog.nl/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL, self::TAILWIND],
            ),
            new WorkProject(
                image_uri: '/storage/tools/site-zoo.webp',
                title: 'ZooZooZoo',
                subtitle: 'E-commerce project for a pet shop',
                content: 'todo',
                link: 'https://zoo-zoo-zoo.com.ua/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL, self::TAILWIND],
            ),
            new WorkProject(
                image_uri: '/storage/tools/blitz.webp',
                title: 'Blitz',
                subtitle: 'Client cabinet for a Dutch tax company',
                content: 'todo',
                link: 'https://blitz.nalog.nl/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL, self::TAILWIND],
            ),
            new WorkProject(
                image_uri: '/storage/tools/site-olexiy.webp',
                title: 'Jiskelo',
                subtitle: 'Personal website for Android Developer',
                content: 'todo',
                link: 'https://jiskelo.dev/',
                technologies: [self::REACT, self::TS, self::TAILWIND],
            ),
        ];
    }
}
