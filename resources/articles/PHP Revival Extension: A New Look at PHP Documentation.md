# PHP Revival Extension: A New Look at PHP Documentation

While PHP keeps surprising developers with new language features, the official website at [www.php.net](https://www.php.net) has remained unchanged over the years. That's where the PHP Revival comes to the rescue.

## Introduction

PHP is getting more and more attention in the web development landscape, with a growing community and constant improvements to the language. Frameworks like Laravel and Symfony have contributed to the increased popularity of PHP and attracted new developers to the language. **However, the official documentation at www.php.net has remained largely the same, with a dated look and feel that can be off-putting to new users.**

Even developers who have worked with PHP for years wish to see an update to improve the overall user experience. **Why hasn’t anyone tried to improve the documentation website** and make a contribution back to the PHP community? That's the question I was asking myself in July 2019.

It seemed odd that there are so many talented developers who use PHP daily, but none of them have tackled the issue of the outdated documentation website, despite the importance of the language.

What if they did? Perhaps they tried, but that's where my story begins.

Note. I want to point out that I'm not a UI/UX expert, nor am I a JavaScript expert. I'm just a software engineer whose main task is to solve problems and build things to make the lives of others easier.

## Initial Attempt: Documentation Website Redesign

In July 2019, I took it upon myself to start working on [pull request #289](https://github.com/php/web-php/pull/289), which would improve the look of the [www.php.net](https://www.php.net) website. I decided to start small, focusing on the outdated navigation bar and, in my opinion, the poor color scheme.

After several iterations, I came up with a new design that would improve the overall user experience. Below, is an image of the proposed changes:

![https://serhii.io/storage/posts/content/php-revival-extension-a-new-look-at-php-documentation-1728463497.png](https://serhii.io/storage/posts/content/php-revival-extension-a-new-look-at-php-documentation-1728463497.png)

After 40 days of waiting for the PR to be reviewed, I received feedback. It stated that my style changes to www.php.net would affect sites like doc.php.net, news.php.net, people.php.net, etc. because they share the same CSS files.

Realizing that modifying the style for [www.php.net](https://www.php.net) while maintaining compatibility with all the other sites wasn't feasible, I knew I needed a different approach to achieve my goal.

## Customizing Documentation Experience

At that point, I decided to create a browser [extension](https://php-revival.github.io/) to let users experience an improved version of [www.php.net](https://www.php.net) without impacting other PHP websites on the same domain. An additional goal was to provide users with features such as code copying, code execution, and embedded PHP-related videos on the homepage.

But, as time passed, it became clear that the extension was getting the attention of the PHP developers. The feedback was overwhelmingly positive, and it was motivation to continue working on the extension.

As for the time of writing this article, I've achieved the following features:

- Improves site styling
- Applies a dark theme with syntax highlighting to code examples
- Enables copying of code examples
- Allows evaluation of PHP code examples
- Adds useful PHP-related links to the homepage
- Includes a section of PHP-related videos on the homepage
- Provides quick access to www.php.net with a single click on the extension icon

Looking ahead, I plan to introduce more features and enhance the existing ones. I welcome any suggestions and feedback from the community to help shape the extension's development.

## Behind the Code: Technical Challenges and Solutions

The PHP Revival extension is built using modern web technologies SASS, TypeScript, and Webpack. The extension is compatible with Chromium-based browsers like Brave, Edge and Chrome, and also supports Firefox.

For everyone who is interested, I want to share some of the technical challenges I faced while developing the extension and how I overcame them.

### Challenge 1: Override CSS Styles

One of the technical challenges I faced was the ability to override some of the CSS styles on the official PHP documentation with the `!important` rule. If you ever watched a CSS tutorial, you know that using `!important` is considered bad practice, but on [www.php.net](https://www.php.net) there are plenty of style rules that use `!important` flag.

There are several ways to override CSS styles with the `!important` flag, but the most common are either using JavaScript to inject styles directly into the HTML or applying the `!important` flag in CSS. Since browser extension stylesheets have higher specificity than the website stylesheets, I decided to go with the second option, because it was easier to implement and maintain.

Tip. Higher specificity in CSS means that the styles in your extension’s stylesheet will take precedence over the website’s existing styles, allowing you to effectively override them without needing complex workarounds. This is particularly beneficial in the context of browser extensions because it ensures that your custom styles will be applied consistently across the site, without being unintentionally overridden by the original site’s CSS.

### Challenge 2: Modify DOM Elements

to be continued...

## Should You Use the PHP Revival Extension?

If you're a PHP developer who uses the official PHP documentation regularly, the PHP Revival extension is a must-have. You can at least try it out and see if it's something you'd like to use. If not, you can always disable or remove the extension.

If you like the extension but feel that something is missing or could be improved, please let me know in the comments below. I'm always open to suggestions and feedback. I'll do my best to implement the most requested features and improve the extension, as long as it benefits the PHP developers.

## Conclusion

Looking back at 2019, I couldn’t have imagined that a small contribution to the community would lead to such an unexpected change in direction. I'm grateful for the support and feedback from the community, and I'm excited to continue working on the [PHP Revival](https://php-revival.github.io/) extension as long as it benefits everybody.

I hope this article has inspired you to make a small contribution or any other community you're part of. Remember, every bit helps, and you never know where it might lead you.