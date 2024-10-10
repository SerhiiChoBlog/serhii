# PHP Revival extension: New look on PHP Documentation

While PHP keeps surprising developers with new language features, the official website at [www.php.net](https://www.php.net) has remained unchanged over the years. That’s where the PHP Revival comes in to the rescue.

## Introduction

PHP is getting more and more attention in the web development landscape, with a growing community and constant improvements to the language. Frameworks like Laravel and Symfony have contributed to the increased popularity of PHP and attracted new developers to the language. **However, the official documentation at www.php.net has remained largely the same, with a dated look and feel that can be off-putting to new users.**

Even developers who have worked with PHP for years wish to see an update to improve the overall user experience. **Why does no one try to improve the documentation website** and make the contribution back to the PHP Community? That’s the question I was asking myself in July 2019.

It seemed odd that so many talented developers who use PHP daily, but none of them have tackled the issue of the outdated documentation website, despite the importance of the language.

What if they did? Perhaps they tried, but that’s where my story begins.

Note. I want to point out that I’m not a UI/UX expert, nor am I a JavaScript expert. I’m just a software engineer whose main task is to solve problems and build things to make the lives of others easier.

## Documentation Website Redesign

In July 2019, I took it upon myself to start working on [pull request #289](https://github.com/php/web-php/pull/289) that would improve the look of the [www.php.net](https://www.php.net) website. I decided to start small, focusing on the outdated navigation bar and, in my opinion, the poor color scheme.

After several iterations, I came up with a new design that would improve the overall user experience.

![https://serhii.io/storage/posts/content/php-revival-extension-a-new-look-at-php-documentation-1728463497.png](https://serhii.io/storage/posts/content/php-revival-extension-a-new-look-at-php-documentation-1728463497.png)

After 40 days of waiting for the PR to be reviewed, I received feedback. It stated that my style changes to www.php.net would affect sites like doc.php.net, news.php.net, people.php.net, etc. because they share the same CSS files.

Realizing that modifying the style for [www.php.net](https://www.php.net) while maintaining compatibility with all the other sites wasn’t feasible, I knew I needed a different approach to achieve my goal.

## PHP Revival Extension: Customizing Documentation Experience

That's when I decided to create a browser extension that would allow users to use an improved version of the [www.php.net](https://www.php.net) website without affecting other PHP websites. The additional goal was to provide users with several features like code copy, code execution and imbedded PHP-related videos on the main (home) page.