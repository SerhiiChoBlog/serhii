<?php

declare(strict_types=1);

use App\Dto\Testimonial;

return [
    new Testimonial(
        image_uri: 'https://via.placeholder.com/100',
        name: 'John Doe',
        role: 'CEO',
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.',
        short: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.',
    ),
    new Testimonial(
        image_uri: 'https://via.placeholder.com/100',
        name: 'John Doe 2',
        role: 'CEO',
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.',
        short: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.',
    ),
    new Testimonial(
        image_uri: 'https://via.placeholder.com/100',
        name: 'John Doe 3',
        role: 'CEO',
        content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.',
        short: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.',
    ),
];
