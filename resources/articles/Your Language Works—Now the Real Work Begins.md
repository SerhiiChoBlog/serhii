## Introduction
**Are you currently working on a new programming language? Wondering how to make it more accessible to others? Wonder what to do next?** I hope you wrote documentation for it because without the documentation, not many people can use your language. Not only that, but users expect this documentation to be easily searchable and accessible. One `README.md` file on GitHub is not sufficient. Thankfully, tools like [VitePress](https://vitepress.dev/ "Link to the VitePress website") and [Docusaurus](https://docusaurus.io/ "Link to the VitePress website") make it relatively easy to write documentation websites.

![VitePress and Docusaurus](https://serhii.io/storage/posts/content/your-language-works-now-the-real-work-begins-1753513711.png)

Language and docs are great, but now you need at least syntax highlighting to start. What should we use for that, TextMate grammar? Tree-sitter? It depends on the editor you want to support. VSCode because of its popularity and maybe something like Neovim or Emacs for 10x developers.

For VSCode we can just write regex for the TextMate grammar, but for Neovim, which uses Tree-sitter, we need to write a Tree-sitter parser and query files that look something like S-expressions. You’ll likely want an LSP for advanced features like autocompletion.

My point is that **after creating a language, more effort is required to build the surrounding ecosystem**. If the language you are writing is something small and insignificant, it might not matter, but if your creation is something complex, it requires an ecosystem around it.

Imagine you've just created a revolutionary new programming language, but without the right tools and documentation, it might as well be a secret code known only to you. The ecosystem improves usability, enhances developer experience, and can attract more users to your language.

The ecosystem is precisely what I’ve been spending the past 6 months building, which includes:

* VSCode extension
* Neovim plugin
* Tree-sitter parser
* LSP server
* A documentation website with Docusaurus
* The language itself

I'll go through some challenges and learnings I experienced after building [Textwire](https://github.com/textwire "Link to Textwire GitHub"), a template language for writing HTML templates in Go. Here is what I've learned...

## This Article is For

Planning to build a programming language or a program with custom syntax? If that's the case, then you are at the right place. This article will be good information for your next project because I was exactly in your shoes. **I'll share practical advice on building an ecosystem around your language, including pitfalls I've encountered.**

Keep in mind that this article doesn't require you to have an advanced understanding of programming, but if you are planning to build your own programming language, advanced skills are necessary for building a language. Not for reading this material.

I'm not going into small details on how to build your programming language; this article is focused more on the ecosystem itself rather than a particular program. **It covers tools and resources for syntax highlighting, editor support, documentation, and other essential components.**

Tip. I have an article, [Writing Your Own Lexer with Simple Steps](/posts/writing-your-own-lexer-with-simple-steps "Link to the article"), which is very popular on this platform. Check it out if you are interested in that.

## Writing a Language Is Tough
Designing a programming language is inherently complex. There is a reason why people who work on programming languages are usually programmers with years of experience. **Building a programming language is an arduous and time-consuming task.** One overlooked challenge: error messages with proper line numbers. A bad parser error can frustrate users for years.

Tutorials make it seem easy—because they’ve done the hard work for you. Don't listen to those pseudo gurus (myself included) on YouTube and Twitch saying that you just need to read a special book that will teach you everything.

Books are a starting point, but mastery requires grinding through your mistakes. I’m no expert—just someone who’s wrestled with these problems firsthand. And that’s the only way to truly learn. So, I've started my journey with writing and designing a language.

## 1. Writing a Language
You define syntax and decide on semantics. Doing thorough preliminary work will make your life easier later. Depending on your specifics, you might want to write a tokenizer, a parser, a compiler or interpreter.

* **A tokenizer (lexer) converts source text into structured tokens like keywords, identifiers, and literals.** Usually, tokens are just constants. For example, for, `x = 5 + 3`, the tokenizer outputs something like `[IDENT(x), EQUALS, NUMBER(5), PLUS, NUMBER(3)]`.
* **A parser receives a stream of tokens and outputs a recursively generated abstract syntax tree (AST for short).** The AST is a hierarchical representation of your program’s structure, where each node describes an operation or statement. In the example `x = 5 + 3`, our AST node can be `AssignStatement(target: 'x', value: BinaryExpression(operator: '+', left: 5, right: 3))`. Program has statements; one of those statements is the assign statement, which contains all the information about the statement.
* **An evaluator is the component that executes the code.** The evaluator either walks the AST to execute code directly (interpreter) or lowers it to bytecode/machine code (compiler). It's also responsible for handling the semantics of your language, such as variable scope, function calls, and control flow.

Note. Sometimes developers use the word "interpreter" interchangeably with "evaluator", though technically the interpreter is the whole system (lexer + parser + evaluator). The evaluator is the part that executes the code.

These components are fundamental in transforming human-readable code into machine-executable instructions. **The tokenizer breaks down the source code into a stream of tokens, which are then parsed to form an AST. The AST will be fed into the evaluator, which executes the code or generates low-level code.**

If your language (like [Textwire](https://github.com/textwire "Link to Textwire GitHub")) is a combination of multiple syntaxes, it will be more complex. In my case, I had Textwire embedded into HTML, which meant I could just treat all HTML code as a string and parse it as such.

80% of all the complexity that I had to deal with was the fact that Textwire is tied to HTML. Handling ambiguous syntax like `<span @if>Text</span>` required custom parsing rules. The code example below is just HTML, there is no Textwire syntax in it:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@myTitle</title>
</head>
<body>
    @content
</body>
</html>
```

Notice how `@myTitle` and `@content` could be either Textwire directives or just part of HTML text - this ambiguity forces complex parsing rules.

My parser needs to be able to differentiate between things like `@content` and valid Textwire directives like `@if`, `@for`, etc. This is where the complexity arises, especially when your language is elegant and easy to read. The simpler the syntax, the more complex the parser becomes.

Parsing `@if(true) { @html('<span>Text</span>') }` is so much easier than parsing `@if(true)<span>Text</span>@end`, which is what Textwire does. The main motto of Textwire is "Easy for you, hard for the parser".

If you have something similar, you will have to deal with the same issues because there are not many resources online about this topic. But no matter how elegant your language design, it's worthless without documentation that makes it accessible. Let's discuss how to create docs that users will love.

## 2. Writing Documentation
**I recommend writing documentation alongside your language—not after.** I find it to be a lot easier because you document structures first, and implement it afterward. Writing docs first forces you to clarify designs upfront—giving you a reference to guide implementation.

**Documentation is crucial for adoption. It’s not just about explaining syntax; it’s about guiding users through your language's features, error handling, best practices, and common pitfalls.** For example, documenting how `@if` handles edge cases (like `@if(nil)`) before implementing it prevents messy surprises later.

I'm not writing this to make myself look better than everybody else, I'm trying to stick with this philosophy myself, since I started writing Textwire. I wrote [documentation for Textwire](https://textwire.github.io/ "Link to Textwire documentaion") as I was building it, which helped me to keep track of what I was doing and why. It also made it easier to explain the language to others.

Even though I don't have thousands of users, I still have a few people who appreciate the documentation. It’s not perfect, but it’s a work in progress. I’m constantly updating it as I extend the Textwire language and add new features. 

## TODO: NOTES
- Make a note that my use case was very different from what the usual language syntax is.
