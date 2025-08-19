<?php

declare(strict_types=1);

use Dom\Text;

return [
    'languages' => [
        [
            'image' => 'storage/tools/php.webp',
            'title' => 'PHP',
            'content' => <<<TEXT
            PHP was my first programming language and remains a key part of my
            career. I've built numerous applications and open-source packages
            while staying up-to-date with the latest PHP advancements.
            TEXT,
        ],
        [
            'image' => 'storage/tools/go.webp',
            'title' => 'Go',
            'content' => <<<TEXT
            Go is my go-to language since 2019. I've utilized it for personal
            and open-source projects such as
            <a href="https://time-ago.github.io" class="underline"
            rel="noreffer" target="_blank">Timeago</a> date-time converter, and
            <a href="https://textwire.github.io" class="underline"
            rel="noreffer" target="_blank">Textwire</a> templating language for
            simplifying developer experience while building frontend with Go.
            It's a beautiful language that fits into my lifestyle.
            TEXT,
        ],
        [
            'image' => 'storage/tools/ts.webp',
            'title' => 'TypeScript',
            'content' => <<<TEXT
            I TypeScript for front-end development with Vue, React, and native
            JavaScript. Since 2019, I've used it to enhance project
            maintainability by reducing bugs and typos.
            TEXT,
        ],
        [
            'image' => 'storage/tools/sql.webp',
            'title' => 'SQL',
            'content' => <<<TEXT
            SQL is a fundamental part of my backend development process. I
            write complex queries, CRUD operations, and optimize joins/unions
            to ensure efficient database interactions.
            TEXT,
        ],
    ],

    'frameworks' => [
        [
            'image' => 'storage/tools/laravel.webp',
            'title' => 'Laravel',
            'content' => <<<TEXT
            I leverage Laravel's robust features alongside the repository
            pattern and TDD to create clean, maintainable, and well-structured
            applications.
            TEXT,
        ],
        [
            'image' => 'storage/tools/vue.webp',
            'title' => 'Vue',
            'content' => <<<TEXT
            I build SPAs with Vue 3, VueRouter, and Vuex. I particularly enjoy
            working with the Composition API, TypeScript, and script setup to
            create dynamic, efficient user interfaces.
            TEXT,
        ],
        [
            'image' => 'storage/tools/react.webp',
            'title' => 'React',
            'content' => <<<TEXT
            While Vue is my primary choice, I use React with TypeScript for
            specific needs, especially when third-party libraries like
            react-pdf offer unique solutions.
            TEXT,
        ],
        [
            'image' => 'storage/tools/wordpress.webp',
            'title' => 'WordPress',
            'content' => <<<TEXT
            My WordPress experience revolves around plugin development,
            integrating payment systems (Mollie, Wayforpay, Bitpay), CRM
            integrations (like Megaplan), and building custom API webhooks.
            TEXT,
        ],
    ],

    'technologies' => [
        [
            'image' => 'storage/tools/podman.webp',
            'title' => 'Containers',
            'content' => <<<TEXT
            I began using containers in 2018 to isolate my development
            environment from the underlying operating system, ensuring greater
            consistency and portability. Since then, I've leveraged both Podman
            and Docker to run services such as Redis, MySQL, and PostgreSQL in
            secure, isolated containers. Podman has become my go-to choice for
            daily use, as its daemonless architecture enhances system security
            without compromising functionality.
            TEXT,
        ],
        [
            'image' => 'storage/tools/linux.webp',
            'title' => 'Linux',
            'content' => <<<TEXT
            For the past five years, I relied on Ubuntu as my primary desktop
            OS, and I've since transitioned to Fedora as my daily driver,
            enhancing my ability to manage environments, write scripts, and
            automate system tasks with greater efficiency. As an avid follower
            of Linux news, I continuously deepen my knowledge of Linux systems,
            staying updated on the latest tools, features, and best practices
            to optimize my workflow and tackle new challenges effectively.
            TEXT,
        ],
        [
            'image' => 'storage/tools/tailwind.webp',
            'title' => 'Tailwind CSS',
            'content' => <<<TEXT
            I adopted Tailwind CSS in 2021 for building modern, scalable UIs,
            replacing SASS, Bootstrap, Bulma, and Materialize. Its
            utility-first approach is more efficient, and I actively follow
            Tailwind updates to sharpen my skills. I love crafting modular
            components with integrated CSS and JavaScript for clean,
            maintainable code. I’m always excited to leverage Tailwind’s
            evolving features to create sleek designs.
            TEXT,
        ],
    ],

    'skills' => [
        [
            'image' => 'storage/tools/cybersecurity.webp',
            'title' => 'Cybersecurity',
            'content' => <<<TEXT
            As a passionate hobbyist, I dive into cybersecurity and ethical
            hacking, exploring how devices and networks communicate to uncover
            ways to secure them. I’m fascinated by studying this side of the
            world where I can learn how to protect systems and data.
            TEXT,
        ],
        [
            'image' => 'storage/tools/langs.webp',
            'title' => 'Speaking Multiple Languages',
            'content' => <<<TEXT
            Since 2014, I've been mastering English, which has become my second
            language at this point. I'm fluent in 3 languages: Russian, English
            and Ukrainian. I can also read and speak a little bit of Chinese
            Mandarin at a very basic level.
            TEXT,
        ],
        [
            'image' => 'storage/tools/type.webp',
            'title' => 'Proficient in Touch Typing',
            'content' => <<<TEXT
            Touch typing allows me to focus on problem-solving rather than
            keystrokes. I'm proficient with both Latin and Cyrillic keyboards,
            which helps me maintain productivity across languages. While typing
            is not a skill that directly impacts development, it significantly
            boosts my efficiency.
            TEXT,
        ],
    ],
];
