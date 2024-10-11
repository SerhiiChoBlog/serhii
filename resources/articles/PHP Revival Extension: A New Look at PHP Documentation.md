# PHP Revival extension: New look on PHP Documentation

While PHP keeps surprising developers with new language features, the official website at [www.php.net](https://www.php.net) has remained unchanged over the years. That's where the PHP Revival comes in to the rescue.

## Introduction

PHP is getting more and more attention in the web development landscape, with a growing community and constant improvements to the language. Frameworks like Laravel and Symfony have contributed to the increased popularity of PHP and attracted new developers to the language. **However, the official documentation at www.php.net has remained largely the same, with a dated look and feel that can be off-putting to new users.**

Even developers who have worked with PHP for years wish to see an update to improve the overall user experience. **Why does no one try to improve the documentation website** and make the contribution back to the PHP Community? That's the question I was asking myself in July 2019.

It seemed odd that so many talented developers who use PHP daily, but none of them have tackled the issue of the outdated documentation website, despite the importance of the language.

What if they did? Perhaps they tried, but that's where my story begins.

Note. I want to point out that I'm not a UI/UX expert, nor am I a JavaScript expert. I'm just a software engineer whose main task is to solve problems and build things to make the lives of others easier.

## Documentation Website Redesign

In July 2019, I took it upon myself to start working on [pull request #289](https://github.com/php/web-php/pull/289) that would improve the look of the [www.php.net](https://www.php.net) website. I decided to start small, focusing on the outdated navigation bar and, in my opinion, the poor color scheme.

After several iterations, I came up with a new design that would improve the overall user experience.

![https://serhii.io/storage/posts/content/php-revival-extension-a-new-look-at-php-documentation-1728463497.png](https://serhii.io/storage/posts/content/php-revival-extension-a-new-look-at-php-documentation-1728463497.png)

After 40 days of waiting for the PR to be reviewed, I received feedback. It stated that my style changes to www.php.net would affect sites like doc.php.net, news.php.net, people.php.net, etc. because they share the same CSS files.

Realizing that modifying the style for [www.php.net](https://www.php.net) while maintaining compatibility with all the other sites wasn't feasible, I knew I needed a different approach to achieve my goal.

## PHP Revival Extension: Customizing Documentation Experience

At that point, I decided to create a browser extension to let users experience an improved version of [www.php.net](https://www.php.net) without affecting other PHP websites on the same domain. An additional goal was to provide users with features such as code copying, code execution, and embedded PHP-related videos on the homepage.

But, as the time passed, it became clear that the extension is getting the attention of the PHP developers. The feedback was overwhelmingly positive, and it was a motivation to continue working on the extension.

As for the time of writing this article, I've achieved the following features:

- Improves site styling
- Applies a dark theme with syntax highlighting to code examples
- Enables copying of code examples
- Allows evaluation of PHP code examples
- Adds useful PHP-related links to the homepage
- Includes a section of PHP-related videos on the homepage
- Provides quick access to www.php.net with a single click on the extension icon

Looking ahead, I plan to introduce more features and enhance the existing ones. I welcome any suggestions and feedback from the community to help shape the extension's development.

## Should You Use the PHP Revival Extension?

If you're a PHP developer who uses the official PHP documentation regularly, the PHP Revival extension is a must-have. You can at least try it out and see if it's something you'd like to use. If now, you can always disable or remove the extension.

If you like the extension but feel that something is missing or could be improved, please let me know in the comments below. I'm always open to suggestions and feedback. I'll do my best to implement the most requested features and improve the extension as long as it benefits the PHP community.

## Conclusion

Looking back at 2019, I couldn't have imagined that an attempt to make a small contribution to the PHP community would lead to such an unexpected change in direction. I'm grateful for the support and feedback I've received from the community, and I'm excited to continue working on the PHP Revival extension as long as it benefits the PHP community.
