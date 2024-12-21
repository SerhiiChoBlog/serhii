# Comprehensive Guide to the PHP Type System: From Mixed to Never
Discover how modern PHP embraces strong typing, from core types to advanced concepts. Master type safety, avoid type juggling pitfalls, and boost code quality with static analysis and more.

## Introduction
PHP has significantly evolved, with one of the most notable changes being its shift to strong typing. It always was a loosely typed language like Python and Ruby, allowing developers to write code without explicitly defining types. However, with new versions of PHP, the language has introduced several features to support strong typing.

In this comprehensive guide, we'll explore the PHP type system in depth, covering core types, type juggling, and static analysis tools for type safety. I'm sure you'll find something new even if you are an experienced PHP developer.

By the end of this guide, you'll have a solid understanding of PHP's type system and how to leverage it to write more robust and maintainable code. If you are still someone who is not convinced about the importance of types in PHP, and still prefer the dynamic typing, this guide will help you understand the significance of types in modern PHP development and teach you how to work with them effectively.

By mastering PHP’s type system, you’ll not only write more robust and maintainable code but also strengthen your skills in crafting reliable software. Let's dive in!

### The Shift to Strict Typing in PHP: Why Types Matter
// todo

- Type conversion pitfalls without strict types

There is nothing wrong with not using types in PHP, it all depends on the context and the project you are working on. Don't feel that you are doing something wrong if you are not using types in PHP. Everything discussed in this article is to help you understand the importance of types in PHP and how to work with them effectively.

If you don't want to use types and static analysis, that's perfectly fine. But if you are working on a large project with a team of developers, using types and static analysis tools can help you catch bugs early, improve code quality, and make your codebase more maintainable.

## Core PHP Types

### An In-Depth Overview of PHP's Core Types
### Understanding Parameter, Return, and Property Typing

## Type Errors in PHP
- Passing the wrong data type to a function with strict typing enabled.
- Returning an invalid type from a function with a declared return type.
- Assigning an incompatible value to a typed property.

## Type Juggling

### Demystifying Type Juggling: Definition and Impact
### Best Practices for Avoiding Common Type Conversion Pitfalls

## Advanced Types: Mixed and Never

### Exploring the Role of Mixed and Never in PHP
### Practical Use Cases for Mixed and Never Types

## Static Analysis for Type Safety

### Enhancing Type Safety with PHPStan and Psalm


Psalm is another popular static analysis tool for PHP that focuses on type safety. As they describe it, Psalm is a free & open-source static analysis tool that helps you identify problems in your code, so you can sleep a little better.

From what I've seen, it's very similar to PHPStan, almost identical in terms of features and functionality. Although, Psalm has a few extra features like SQL injection detection and other security-related checks that PHPStan doesn't have.

But, PHPStan was recommended by the [Rasmus Lerdorf](https://en.wikipedia.org/wiki/Rasmus_Lerdorf) himself in one of his talks, so I went for PHPStan from the beginning.

### Leveraging Static Analysis Tools to Improve Code Quality

## Are There More Types Coming to PHP?
// todo: I hope not, not because I don't like types, but because I think PHP has enough types already. Plus, adding more types will make the language slower and more complex. I hope they focus more on improving the existing PHP codebase and improve performance and security. Even though PHP's code execution is faster than other brother languages like Python and Ruby, there is always room for improvement.

// todo: give link on PHP Open Collective

## Conclusion
// todo: Mastering the PHP Type System
todo: use backtick operator for some example