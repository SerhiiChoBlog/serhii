<?php

declare(strict_types=1);

return [

    'languages' => [
        [
            'image' => 'storage/tools/php.webp',
            'title' => 'PHP',
            'content' => <<<TEXT
            PHP was my first programming language.
            I've build tons of apps and several open-source packages throughout my career.
            I'm always following the latest news in PHP world to stay updated.
            Even though I'm slowly moving towards Go.
            TEXT,
        ],
        [
            'image' => 'storage/tools/ts.webp',
            'title' => 'TypeScript',
            'content' => <<<TEXT
            TypeScript is my go-to when I'm working with Vue, React or native JavaScript.
            I've started applying it to all the new projects since 2019 because I needed a tool to reduce the number of bugs and typos in JavaScript apps.
            TEXT,
        ],
        [
            'image' => 'storage/tools/go.webp',
            'title' => 'Go',
            'content' => <<<TEXT
            I've been using Go since 2019 mostly for my personal projects.
            One of them is the open-source package <a href="https://serhiicho.github.io/timeago-docs" class="underline" rel="noreffer" target="_blank">Timeago</a> for converting date time into human-readable format.
            TEXT,
        ],
        [
            'image' => 'storage/tools/sql.webp',
            'title' => 'SQL',
            'content' => <<<TEXT
            SQL is a must have language for building backend applications with SQL-databases.
            I can write all the common CRUD operations that developers use on a daily basis, including joins and unions.
            TEXT,
        ],
    ],

    'frameworks' => [
        [
            'image' => 'storage/tools/laravel.webp',
            'title' => 'Laravel',
            'content' => "I like to use all the features of the framework along with the repository pattern and TDD. It helps to organize and structure code in a very simple and readable way.",
        ],
        [
            'image' => 'storage/tools/vue.webp',
            'title' => 'Vue',
            'content' => "I've been using Vue along with the VueRouter and Vuex mostly for building Single Page Applications. I enjoy working with Vue 3, TypeScript and script setup.",
        ],
        [
            'image' => 'storage/tools/react.webp',
            'title' => 'React',
            'content' => "React.js with TypeScript is another JavaScript framework that I'm using from time to time. Usually I'm reaching for it when I need a library that Vue doesn't have. One of those amazing libraries is react-pdf.",
        ],
        [
            'image' => 'storage/tools/wordpress.webp',
            'title' => 'WordPress',
            'content' => "Mostly I'm building plugins for business sites, that need integration of payment systems like Mollie, Wayforpay and Bitpay, plugins for Megaplan CRM and Exact Online, web hooks and other functionalities.",
        ],
    ],

    'technologies' => [
        [
            'image' => 'storage/tools/docker.webp',
            'title' => 'Docker',
            'content' => <<<TEXT
            My first Docker experience started in 2018. I was fortunate to start using it so early in my career.
            It helped me to abstract my workspace from the operating system, and made it easy to work with different
            technologies like Redis, MySQL, PostgreSQL, etc.
            TEXT,
        ],
        [
            'image' => 'storage/tools/linux.webp',
            'title' => 'Linux',
            'content' => <<<TEXT
            I feel free using Unix based operating system like Linux and macOS.
            In my capacity a dozen terminal command which help me to quickly navigate, modify and interact with OS.
            Including writing simple bash scripts, cron jobs, symbolic links, ssh, dpkg, vim and other helpful tools.
            TEXT,
        ],
        [
            'image' => 'storage/tools/tailwind.webp',
            'title' => 'Tailwind CSS',
            'content' => <<<TEXT
            Tailwind CSS is on my radar since the beginning of 2021.
            That's when I've started applying it to almost all of my projects that needed CSS.
            But almost all of my old projects I was either compiling CSS from SASS, either using frameworks like
            Bootstrap, Materialize CSS, Bulma or Tailwind.
            TEXT,
        ],
    ],

    'skills' => [
        [
            'image' => 'storage/tools/communicate.webp',
            'title' => 'Communication',
            'content' => <<<TEXT
            I put communication skills on the first place because I think it's the most important personal skill
            for a person working in a team.
            I'm a very calm man, with my own principles and beliefs.
            I never judge anyone and I feel blessed to work in this field and exchange knowledge.
            TEXT,
        ],
        [
            'image' => 'storage/tools/flags.webp',
            'title' => 'Multilingual',
            'content' => <<<TEXT
            In 2014, I've started learning English daily. Since then, English became my second language. In total,
            I speak 4 languages, including Russian, Chinese Mandarin and Ukrainian. I wish to use Chinese in my future work projects.
            TEXT,
        ],
        [
            'image' => 'storage/tools/type.webp',
            'title' => 'Touch Typing',
            'content' => <<<TEXT
            We are coders, and we like to type countless number of symbols on the screen.
            Fast touch typing helps me to be less focused on the typing but dive more into the problem.
            I'm touch typing pretty confident on latin and cyrillic keyboards.
            TEXT,
        ],
    ],
];
