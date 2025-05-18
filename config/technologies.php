<?php

declare(strict_types=1);

return [

    'languages' => [
        [
            'image' => 'storage/tools/php.webp',
            'title' => 'PHP',
            'content' => <<<TEXT
            PHP was my first programming language and remains a key part of my career.
            I've built numerous applications and open-source packages while staying up-to-date with the latest PHP advancements.
            TEXT,
        ],
        [
            'image' => 'storage/tools/go.webp',
            'title' => 'Go',
            'content' => <<<TEXT
            Go is my go-to language since 2019. I've utilized it for personal and open-source projects such as
            <a href="https://time-ago.github.io" class="underline" rel="noreffer" target="_blank">Timeago</a> date-time converter, and
            <a href="https://textwire.github.io" class="underline" rel="noreffer" target="_blank">Textwire</a> templating language for
            simplifying developer experience while building frontend with Go. It's a beautiful language that fits into my lifestyle.
            TEXT,
        ],
        [
            'image' => 'storage/tools/ts.webp',
            'title' => 'TypeScript',
            'content' => <<<TEXT
            I TypeScript for front-end development with Vue, React, and native JavaScript.
            Since 2019, I've used it to enhance project maintainability by reducing bugs and typos.
            TEXT,
        ],
        [
            'image' => 'storage/tools/sql.webp',
            'title' => 'SQL',
            'content' => <<<TEXT
            SQL is a fundamental part of my backend development process.
            I write complex queries, CRUD operations, and optimize joins/unions to ensure efficient database interactions.
            TEXT,
        ],
    ],

    'frameworks' => [
        [
            'image' => 'storage/tools/laravel.webp',
            'title' => 'Laravel',
            'content' => "I leverage Laravel's robust features alongside the repository pattern and TDD to create clean, maintainable, and well-structured applications.",
        ],
        [
            'image' => 'storage/tools/vue.webp',
            'title' => 'Vue',
            'content' => "I build SPAs with Vue 3, VueRouter, and Vuex. I particularly enjoy working with the Composition API, TypeScript, and script setup to create dynamic, efficient user interfaces.",
        ],
        [
            'image' => 'storage/tools/react.webp',
            'title' => 'React',
            'content' => "While Vue is my primary choice, I use React with TypeScript for specific needs, especially when third-party libraries like react-pdf offer unique solutions.",
        ],
        [
            'image' => 'storage/tools/wordpress.webp',
            'title' => 'WordPress',
            'content' => "My WordPress experience revolves around plugin development, integrating payment systems (Mollie, Wayforpay, Bitpay), CRM integrations (like Megaplan), and building custom API webhooks.",
        ],
    ],

    'technologies' => [
        [
            'image' => 'storage/tools/docker.webp',
            'title' => 'Docker',
            'content' => <<<TEXT
            I started working with Docker in 2018, which allowed me to decouple my development environment from the OS.
            Since then, I've used Docker to run services like Redis, MySQL, and PostgreSQL in a consistent, isolated environment.
            TEXT,
        ],
        [
            'image' => 'storage/tools/linux.webp',
            'title' => 'Linux',
            'content' => <<<TEXT
            I'm proficient with Unix-based systems (Linux/macOS) and regularly use tools like SSH, symbolic links, cron jobs, bash scripts, and dpkg.
            This enables me to manage environments, write scripts, and automate system tasks effectively.
            TEXT,
        ],
        [
            'image' => 'storage/tools/tailwind.webp',
            'title' => 'Tailwind CSS',
            'content' => <<<TEXT
            Tailwind CSS became part of my tech stack in 2021, and I now use it for most projects requiring modern, scalable UI design.
            Previously, I relied on SASS, Bootstrap, Bulma, and Materialize, but Tailwind's utility-first approach has proven more efficient.
            TEXT,
        ],
    ],

    'skills' => [
        [
            'image' => 'storage/tools/communicate.webp',
            'title' => 'Effective Communicator',
            'content' => <<<TEXT
            I prioritize effective communication as it's the cornerstone of teamwork and collaboration.
            My calm demeanor and strong principles allow me to exchange knowledge and ideas freely with colleagues and clients.
            Would be awesome to work in a team with you!
            TEXT,
        ],
        [
            'image' => 'storage/tools/flags.webp',
            'title' => 'Speaking Multiple Languages',
            'content' => <<<TEXT
            Since 2014, I've been mastering English, which has become my second language at this point.
            I'm fluent in 3 languages: Russian, English and Ukrainian.
            I can also read and speak a little bit of Chinese Mandarin at a basic level.
            TEXT,
        ],
        [
            'image' => 'storage/tools/type.webp',
            'title' => 'Proficient in Touch Typing',
            'content' => <<<TEXT
            Touch typing allows me to focus on problem-solving rather than keystrokes.
            I'm proficient with both Latin and Cyrillic keyboards, which helps me maintain productivity across languages.
            While typing is not a skill that directly impacts development, it significantly boosts my efficiency.
            TEXT,
        ],
    ],
];
