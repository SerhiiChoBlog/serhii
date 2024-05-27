<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\AboutMe;

use App\Dto\Testimonial;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json($this->getTestimonials());
    }

    /**
     * @return array<int, Testimonial>
     */
    private function getTestimonials(): array
    {
        return [
            new Testimonial(
                image_uri: '/storage/testimonials/ihor-niezhynskiy.jpg',
                name: 'Ihor Niezhynskiy',
                role: 'Head of IT department',
                content: <<<'HTML'
                <p>Dear Serhii,</p>
                <p>I wanted to take a moment to commend you on your outstanding performance as a developer. Your ability to solve complex problems using modern technologies is truly remarkable. I have been thoroughly impressed by your independent work and the way you take ownership of projects from start to finish.</p>
                <p>I am particularly proud of the results we achieved working together. Our main website saw an increase in visitors of over 100 times, thanks to your contributions. Additionally, the automation of various business processes that we implemented has been positively described by our colleagues.</p>
                <p>Your proficiency in PHP and JS, including all popular libraries, is impressive and has been instrumental in our success. Your skills have enabled us to deliver high-quality products that meet the needs of our customers.</p>
                <p>Overall, I am grateful to have you on our team. Your dedication and expertise have had a significant impact on company business. Thank you for your hard work and commitment.</p>
                HTML,
                link: 'https://www.linkedin.com/in/ihor-n-0a6383144/',
                short: 'Dear Serhii, I wanted to take a moment to commend you on your outstanding performance as a developer. Your ability to solve complex problems using modern technologies ...',
            ),
            new Testimonial(
                image_uri: '/storage/testimonials/julia-jurik.jpg',
                name: 'Julia Jurik',
                role: 'Dutch Tax Consultant',
                content: <<<'HTML'
                <p>I have been working with Sergey for 4 years now and I feel very comfortable working with him. Sergey is very responsible and completes tasks on time. Sergey and I work in different departments, but at any request he is ready to help. Thanks to Sergey, we now have a very convenient website and customers can quickly find information.</p>
                <p>I wish Sergei interesting projects.</p>
                HTML,
                link: 'https://www.linkedin.com/in/julia-jurik-2b93a1194/',
                short: 'I have been working with Sergey for 4 years now and I feel very comfortable working with him. Sergey is very responsible and completes tasks on time. Sergey and ...',
            ),
            new Testimonial(
                image_uri: '/storage/testimonials/oleksandr-kazakov.jpg',
                name: 'Oleksandr Kazakov',
                role: 'IT specialist',
                content: <<<'HTML'
                <p>A very cool developer, writes very clean and structured code, covers the code with tests and writes documentation for it, in my opinion Serhiy is a very skilled developer!</p>
                HTML,
                link: 'https://www.linkedin.com/in/oleksandr-kazakov-428a79208/',
            ),
            new Testimonial(
                image_uri: '/storage/testimonials/olexiy-chornenkiy.jpg',
                name: 'Olexiy Chornenkiy',
                role: 'Android Developer',
                content: <<<'HTML'
                <p>I am writing to recommend Serhii as an experienced software developer. Having worked closely with Serhii on several projects, I have always been impressed by his technical knowledge and personal qualities.
                <p>Serhii is an excellent programmer, well versed in languages such as JavaScript, TypeScript, PHP and SQL. He is also well versed in frameworks such as Laravel, Vue and React. His ability to find the right solutions in the shortest amount of time is outstanding, and his touch typing skills greatly increase his speed. Serhii is always dedicated to his work and always delivers clean and maintainable code on time.</p>
                <p>What sets Serhii apart is not only his technical knowledge, but also his exceptional communication skills and ability to work with others. He is a great team player and always takes the initiative to understand the requirements of a project and provide valuable ideas and suggestions to improve it. Serhii is also a pleasure to work with - he is approachable, friendly and always willing to go the extra mile to make a project a success.</p>
                <p>I had the pleasure of working with Serhii on several projects where he provided back-end APIs and web applications and I was responsible for Android application development and project management. He also developed a personal website for me (I think this is his best work for me). His work is impressive and always delights me as a developer and user.</p>
                <p>To sum up, I highly recommend Serhii as a software developer. His skills, dedication and personality make him an indispensable member of any team and I am proud to have worked with him. I am sure he will make a valuable contribution to any organization he works with.</p>
                HTML,
                link: 'https://www.linkedin.com/in/olexiy-chornenkiy-53b939242/',
                short: 'I am writing to recommend Serhii as an experienced software developer. Having worked closely with Serhii on several projects, I have always been impressed by his ...',
            ),
            new Testimonial(
                image_uri: '/storage/testimonials/svetlana-koshek.jpg',
                name: 'Svetlana Koshek',
                role: 'Independent Financial Services Professional',
                content: <<<'HTML'
                <p>Sergey has been working in my company for more than 4 years, and he has shown himself to be a responsible employee. All tasks were completed on time. Sergey knows how to independently prioritize work and he does not need control over tasks.</p>
                <p>We and our team are very grateful to Sergey for his work and wish him success in his career.</p>
                HTML,
                link: 'https://www.linkedin.com/in/svetlana-koshek-aa887325/',
                short: 'Sergey has been working in my company for more than 4 years, and he has shown himself to be a responsible employee. All tasks were completed on time. Sergey knows ...',
            ),
        ];
    }
}
