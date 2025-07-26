
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

I'll go through some challenges and learnings I experienced after building [Textwire](https://github.com/textwire), a template language for writing HTML templates in Go. Here is what I've learned...

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
You define syntax and decide on semantics, and you do as much preliminary work as you can which will make your life easier eventually. Depending on your specifics, you might want to write a tokenizer, a parser, a compiler or interpreter.

* **A tokenizer (lexer) is the first layer in your program which has only a single job: convert written text into programmatic tokens.** Usually, tokens are just constants. For example, for, `x = 5 + 3`, the tokenizer outputs something like `[IDENT(x), EQUALS, NUMBER(5), PLUS, NUMBER(3)]`.
* **A parser receives a stream of tokens and outputs a recursively generated abstract syntax tree (AST for short).** You can consider AST to be an object that contains many other objects inside, which is basically the semantics of your program. In the example `x = 5 + 3`, our AST node can be `Program > AssignStatement`. Program has statements; one of those statements is the assign statement, which contains all the information about the statement.
* **An evaluator is the component that executes the code.** It can either execute the AST directly or generate low-level code, which is then executed by a virtual machine or compiled to machine code. It's also responsible for handling the semantics of your language, such as variable scope, function calls, and control flow.

Note. Sometimes developers use the word "interpreter" interchangeably with "evaluator", though technically the interpreter is the whole system (lexer + parser + evaluator). The evaluator is the part that executes the code.

These components are fundamental in transforming human-readable code into machine-executable instructions. **The tokenizer breaks down the source code into a stream of tokens, which are then parsed to form an AST. The AST will be fed into the evaluator, which executes the code or generates low-level code.**

These AST nodes are traversed by an interpreter to execute the code directly or generate low-level code if you write something like a compiler.





## TODO: NOTES
- I recommend writing documentation alongside your language—not after; you simultaneously need to work on your documentation for that particular language. I find it to be much more easier because you document statements or expressions first, and implement it afterwords.
- Make a note that my use case was very different from what the usual language syntax is.
