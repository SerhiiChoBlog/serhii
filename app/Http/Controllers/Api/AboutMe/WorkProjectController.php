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
    public const PHPUNIT = 'phpunit';

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
                <p>Shobar is a restaurant bar in Kharkiv, with a unique atmosphere and delicious food. The website was created with WordPress CMS and a custom theme designed and developed by me. The website has a custom menu plugin that allows the administrator to manipulate the content for the whole website.</p>
                <p>🏆 The best part about this project is that it has a custom developed payment system using the Ukrainian payment system WayForPay and a custom developed delivery system including cart and checkout.</p>
                HTML,
                link: 'https://shobar.com.ua/',
                technologies: [self::WP, self::PHP, self::TS, self::SASS],
            ),
            new WorkProject(
                image_uri: '/storage/tools/client-cabinet.webp',
                title: 'Client Cabinet',
                subtitle: 'Client Cabinet for a Dutch tax company',
                content: <<<HTML
                <p>Client Cabinet is a private project for a company that I was working for. This project represents a personal cabinet for clients of the company. It's an SPA application with Laravel on the backend and Vue with TailwindCSS on the frontend.</p>
                <p>🏆 The best part of this project for me was working with VuePrime UI library and Authorization system with Laravel Sanctum. I learned a lot about how to create a secure SPA application and how to avoid complex custom components by using a UI library that hides all the complexity and allows you to focus on the business logic.</p>
                HTML,
                link: 'https://mijn.nalog.nl/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL, self::TAILWIND, self::PHPUNIT],
            ),
            new WorkProject(
                image_uri: '/storage/tools/site-zoo.webp',
                title: 'ZOO ZOO ZOO',
                subtitle: 'E-commerce project for a pet shop',
                content: <<<HTML
                <p>ZOO ZOO ZOO is a huge project that consists of 2 websites, Android and iOS applications that rely on the same API and admin panel. All the products of ZOO ZOO ZOO are coming from the external service called 1C via a custom build synchronization system. I am responsible for the website and backend API, while 2 of my colleagues are responsible for the mobile applications.</p>
                <p>🏆 The best part of this project for me was working with other developers. I learned a lot about teamwork, communication and how it is important to always keep up to date in the API documentation.</p>
                HTML,
                link: 'https://zoo-zoo-zoo.com.ua/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL, self::TAILWIND, self::PHPUNIT],
            ),
            new WorkProject(
                image_uri: '/storage/tools/blitz.webp',
                title: 'Blitz',
                subtitle: 'Web application for offering legal consultations',
                content: <<<HTML
                <p>Amazing project for the Nalog.NL company that I was working for many years. It's a Laravel/Vue application that allows the company to offer legal consultations to their clients. Clients have a quick and easy way to book a consultation with a lawyer or any other specialist of the company.</p>
                <p>🏆 The best part of this project for me was working with our small IT team that consisted of 4 developers at that time. It's been a big honor for me to work on such a wonderful project with Ihor and Oleksandr, who were a part of the Blitz project and were helping me a lot</p>
                HTML,
                link: 'https://blitz.nalog.nl/',
                technologies: [self::VUE, self::TS, self::PHP, self::LARAVEL, self::TAILWIND, self::PHPUNIT],
            ),
            new WorkProject(
                image_uri: '/storage/tools/site-olexiy.webp',
                title: 'Olexiy Chornenkyi',
                subtitle: 'Personal website for Android Developer',
                content: <<<HTML
                <p>Personal portfolio website for a skilled Android Developer and a brother of mine. The website is a React application with TailwindCSS and TypeScript. It contains multiple sections, including a portfolio, testimonials and personal skills. It uses many parallax effects and animations that come with the <strong>react-scroll-parallax</strong> library.</p>
                <p>🏆 The best part of this project is that I was able to work with my brother and help him to create an SPA that he wanted to have to represent himself as a professional Android Developer. We work with Olexiy together on several projects where I'm mostly responsible for WEB apps.</p>
                HTML,
                link: 'https://jiskelo.dev/',
                technologies: [self::REACT, self::TS, self::TAILWIND],
            ),
        ];
    }
}
