<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\AboutMe;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Dto\WorkProject;

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
                content: 'todo',
                link: 'https://shobar.com.ua/',
                technologies: [self::WP, self::PHP, self::TS],
            ),
            new WorkProject(
                image_uri: '/storage/tools/client-cabinet.webp',
                title: 'Client cabinet',
                subtitle: 'Client cabinet for Dutch tax office',
                content: 'todo',
                link: 'https://mijn.nalog.nl/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL, self::TAILWIND],
            ),
            new WorkProject(
                image_uri: '/storage/tools/site-zoo.webp',
                title: 'ZooZooZoo',
                subtitle: 'WordPress website with custom theme and plugins',
                content: 'todo',
                link: 'https://zoo-zoo-zoo.com.ua/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL],
            ),
            new WorkProject(
                image_uri: '/storage/tools/blitz.webp',
                title: 'Blitz',
                subtitle: 'Client cabinet for Dutch tax office',
                content: 'todo',
                link: 'https://blitz.nalog.nl/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL, self::TAILWIND],
            ),
            new WorkProject(
                image_uri: '/storage/tools/site-olexiy.webp',
                title: 'Jiskelo',
                subtitle: 'Personal website',
                content: 'todo',
                link: 'https://jiskelo.dev/',
                technologies: [self::REACT, self::TS, self::TAILWIND],
            ),
        ];
    }
}
