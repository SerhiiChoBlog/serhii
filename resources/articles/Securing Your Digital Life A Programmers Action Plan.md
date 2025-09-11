## Introduction
<blockquote>
    <p>What I'm about to tell you is top secret. There's a powerful group of people out there that are secretly running the world. I'm talking about the guys, no one knows about the guys who are invisible. The top 1% of the top 1%. The guys that play God without permission. And now I think they're following me.</p>
    <img src="https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1756472826.webp" alt="Elliot Alderson in a dark hoodie with a black background" />
    <h6>Elliot Alderson (Mr. Robot series)</h6>
</blockquote>

I've never started an article with a quote, but this dialogue from Elliot Alderson was the first thing that came to my head when I started writing it. **The surveillance and existential paranoia displayed in that great series perfectly capture the digital landscape we navigate today.**

Recent scandals involving British and other politicians pushing for widespread monitoring, data collection, and mandatory face scans to confirm your age have highlighted the escalating trend towards government and corporate surveillance. This raises serious concerns about privacy and individual freedom in the digital age.

![People are protesting. Holding banners with the sign: Stop watching all of us](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1756478455.jpg)

Even though this article will not be political, it's difficult to ignore the increasing tension between individual privacy and governmental/corporate agendas. **The greediness for more power over people and control over their digital footprints is evident**, particularly from whistleblowers like Edward Snowden, who revealed how much personal data governments the National Security Agency (NSA) collect.

![NSA logo surrounded by logos of Facebook, Yahoo, Skype, Apple, and Google](https://serhii.io/storage/posts/content/moving-from-macos-back-to-linux-as-a-programmer-1756293717.jpg)

This ongoing war on privacy has led millions to investigate how to reclaim their digital freedom. **DuckDuckGo search engine went from 1.64 million daily queries in 2013 (Snowden revelation) to over 100 million in 2024. It's a mind-blowing 6000% increase in daily searches.**

![Advertizing banner with the DuckDuckGo ad: Google tracks you. We don't](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1756478715.jpg)

<a href="https://proton.me/mail" title="Link to ProtonMail website" target="_blank">ProtonMail</a> founded their company after Snowden's leaks in 2013, and in 2025 they have over **70 million users**, illustrating a clear and growing public mandate for privacy-focused digital services.

Switching from Gmail to ProtonMail is a good first move, but it's like putting window bars on a single window when you have 10 of them. I don't consider myself a guru of privacy, but I have been pushing hard on privacy since January 2019, and since then, I've changed the digital footprints of my some of relatives and myself.

And yes, **as tech professionals, this responsibility extends to teaching and protecting our relatives who are strangers to all that tech stuff.** Because while you understand what DNS is, for your parents, this abbreviation doesn't ring a bell.

<blockquote>
    <p>You don't know how much you appreciate your privacy until you don't have it.</p>
    <img src="https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1756479356.webp" alt="Photo of Morgan Freeman, actor and producer" />
    <h6>Morgan Freeman (actor, producer)</h6>
</blockquote>

Anyway, I'm not your privacy advisor; I'm just a tech who cares about this stuff. So, take my advice with a grain of salt and do your own research if you want to delve deeper. But I'm going to walk you through a comprehensive action plan for securing your digital life, offering practical steps to enhance your digital life and those people you care about. And we'll start with the first and most important step, your operating system.

## Use Linux
The most fundamental aspect of digital security begins with the underlying free and open-source, fully functional operating system. It’s like a foundation upon which all the other security measures are built. If you skip this step and keep using Windows or macOS then all of the following steps in this article are pretty much don't make sense.

In truth, the field of fully open-source operating systems is narrow. As of 2025, we have only FreeBSD and GNU/Linux.

Tip. GNU/Linux is the full, proper name for the operating system most people refer to simply as "Linux." The term GNU/Linux is used to give credit to both projects and acknowledge their movement. However, throughout this article, I'm going to refer to GNU/Linux as just Linux, for simplicity.

FreeBSD is a good choice; I have nothing against it; however, I’ve never used it myself and thus cannot recommend it or comment on it. I just know it has a robust, long-standing reputation for stability and security in server environments.

**Linux, on the other hand, is a great choice** because it has a vast and active community, frequent security updates, and lots of different flavors. This diversity allows users to select a distribution tailored to their specific security needs and technical proficiency, ranging from user-friendly options to highly configurable systems like <a href="https://archlinux.org/" title="Link to Arch Linux website" target="_blank">Arch Linux</a>.

Keep in mind that Linux is not a silver bullet. While it's a great alternative to Windows and macOS, it's not perfect. A common downside of some Linux desktop environments is that they can be less polished and more buggy than the tightly integrated macOS.

![A Steam Deck with Linux logo on the screen](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1757157853.jpg)

You can just start by running Linux on a virtual machine if you've never done it before. This approach allows for risk-free experimentation with various distributions and desktop environments, familiarizing oneself with the nuances of a Linux system without altering the primary operating system. Keep in mind that the experience with Linux inside a virtual machine is not as performant as running it natively, but it’s a good starting point.

## Safe ISO File
It doesn't matter how safe your house is if your back door is not locked. That's why it's important to follow basic security practices when it comes to downloading installation files like ISO (often called an ISO image).

**ISO image is a complete snapshot of a disc, commonly used for operating system installations.** All you need to know about this file format is that it encapsulates a bootable environment. It means that this environment can be tinkered with. That's why we have such thing as checksums.

To check the checksum of a file, you typically use command-line utility like `sha256sum` on Linux. This cryptographic hash function generates a unique string of characters for a given file, and if you change at least 1 byte in that target file, the resulting checksum will be drastically different. This allows you to know if the downloaded file has been modified or not.

You run `sha256sum your-file` and compare the output to the published checksum provided by the official website.

```bash
# Navigate to your Downloads folder first, then run:
sha256sum fedora-workstation-42.x86_64.iso
```
If they match, then you can be confident that your downloaded ISO file is authentic and untampered with.

## No Proprietary Software
<blockquote>
    <p>It's more than unsettling to realize there are large companies out there developing backdoors, exploits and trojans.</p>
    <img src="https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1757154012.webp" alt="Photo of Mikko Hyppönen in glasses" />
    <h6>Mikko Hyppönen (computer security expert)</h6>
</blockquote>

**Proprietary software, by its nature, often operates as a black box, making it impossible for users to inspect its inner workings for vulnerabilities or malicious functionalities.** Processes that are constantly running on your machine can collect sensitive data and transmit it without explicit user consent. I do not consider myself a paranoid individual, but it is not a secret that companies like Microsoft, Apple, Facebook, and Google routinely collect vast amounts of user data. Especially Google, since their whole business model is to sell you targeted ads.

![chrome, watsup, skype and google logos are spying behind the girl who is sitting with her laptop on a sofa in a cartoon style](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1757248167.webp)

If you installed a fresh Linux installation and are thinking of getting your favorite Google Chrome browser, be mindful that you are reintroducing the same issue that you had before. Running Google Chrome on Linux is like installing a surveillance camera with the default password `admin` into your secured house. The rule is simple: if it's not open source, it doesn't get root-level trust.

And it applies to browser extensions, which can introduce huge security vulnerabilities. **Before installing a browser extension check if it’s open source and keep close attention to its requested permissions.** Unfortunately, there is no perfect way to check the checksum of the extension itself and compare it to the original version, we can only rely on Mozilla and Google to ensure the integrity of their extension marketplaces.

### Use Alternatives
For every proprietary software application, there is typically a robust open-source alternative that offers similar or even the same functionality. There are exceptions, of course, but most of the time you can find pretty much anything, including flatpak applications.

Here is a list of recommendations if you are looking for free alternatives:

- **Email:** ProtonMail or Tutanota offer end-to-end encrypted email services with a bunch of features
- **Cloud Storage:** ProtonDrive and Nextcloud provide secure storage. Nextcloud is a self-hosted solution
- **Daily Browser:** Firefox, Brave, Vivaldi and tons of others. If you like Chrome, just use Brave and you will not see any differences in terms of user interface
- **Search Engine:** DuckDuckGo, Brave Search and Startpage are the best privacy-focused solutions
- **Graphic Design:** GIMP is the best choice if you want to switch from Photoshop
- **Office Suite:** LibreOffice is a comprehensive alternative to Microsoft Office, offering word processing, spreadsheets, and presentation tools that are compatible with common file formats.
- **Code Editor:** Vim, Neovim, and Emacs are true open-source options for developers, but if you prefer a more modern UI, VS Code, while partially proprietary, still provides significant open-source components and a vast ecosystem of extensions. If you can avoid VS Code (due to its Microsoft telemetry and proprietary elements), that’s a huge advantage. We will talk more about this later in the article.

I can continue this list for a long time, but the core principle remains: prioritize open-source solutions to enhance security, transparency, and user control over your digital environment. You can always search for alternatives and you will find help online.

## Secure Browsing
Browsing is something we as tech professionals do constantly, whether for research, development, debugging, or just personal use. The personal use part is particularly important and requires extra vigilance.

When I type a query in a search bar, I don’t want anyone to attach this search query to my identity, nor do I want my browsing habits or visited websites tracked and correlated with my personal data. I want to be able to save my browser tabs in private, encrypted storage so that even if someone gets access to my computer, they cannot see those saved tabs. That’s where browser extensions in combination with open-source philosophy shine.

### Browser Extensions
There are at least 3 browser extensions that you must have by default. These are:
- <a href="https://addons.mozilla.org/en-US/firefox/addon/duckduckgo-for-firefox/" title="Link to Mozilla DuckDuckGo Privacy Essentials page" target="_blank">DuckDuckGo Privacy Essentials</a>: Only essential if you use DuckDuckGo as your default search engine. It enhances that specific experience.
- <a href="https://addons.mozilla.org/en-US/firefox/addon/ublock-origin/" title="Link to Mozilla uBlock Origin page" target="_blank">uBlock Origin</a>: Essential for everyone. The best content blocker period.
- <a href="https://addons.mozilla.org/en-US/firefox/addon/privacy-badger17/" title="Link to Mozilla Privacy Badger page" target="_blank">Privacy Badger</a>: A great supplement to block sneaky trackers that slip through.

Note. DuckDuckGo Privacy Essentials extension only makes sense if you use DuckDuckGo as your primary search engine.

I'm giving you Mozilla links because I recommend Firefox-based browsers for their stronger privacy stance. Plus, uBlock Origin's <a href="https://github.com/gorhill/uBlock/wiki/uBlock-Origin-works-best-on-Firefox" title="Link to the Wiki" target="_blank">maintainers also recommend</a> using it on Firefox. But if you need it for Chromium, just get the extension from the official <a href="https://ublockorigin.com/" title="Link to official uBlock Origin extension website" target="_blank">ublockorigin.com</a> website. If you use the Brave browser, you may not need uBlock Origin as it has a built-in blocker, though many still use it for finer control.

![uBlock Origin additional information for different browsers](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1757592362.webp)

Before installing any new extension, make sure that it's open source and doesn't have a permission of accessing your data for all websites. Of course, those 3 extensions that I've listed above are the exeption from this rule because they cannot work without getting access to all the data for all the websites.

### Tab Guardian
This desire for private tab management is exactly why I developed the <a href="https://addons.mozilla.org/en-US/firefox/addon/tab-guardian/" title="Link to Mozilla Tab Guardian extension page" target="_blank">Tab Guardian</a> extension that is available for Chromium and Firefox-based browsers.

![Tab Guardian extension banner with a sign 'See all of your saved tab groups at a glance on the main screen'](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1757587311.png)

I’m a bit biased towards this extension because I developed it specifically to address the critical need for encrypted and private tab management, ensuring that sensitive browsing data remains inaccessible even in the event of system compromise.

It allows you to store and retrieve your browser tabs in a few clicks, but **the coolest feature of Tab Guardian is “Private groups”**, which allows you to create encrypted groups with a password to prevent anyone from accessing them.

### Use Tor for Maximum Privacy
For the ultimate level of anonymity in your browsing, the Tor network is the gold standard. But keep in mind that it's a separate tool for specific, high-privacy needs. It doesn’t replace your daily browsers since Tor is significantly slower due to its multi-layered encryption and relay system.

![Tor Browser home page that says 'Explore. Privately'](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1757591016.webp)

The other reason is that companies like Google and Meta actively discourage its use because if they don't know who you are, they cannot monetize your online activity. But honestly, **you shouldn’t use their services anyway if you care about your privacy.**

## The Security Fundamentals
### Use a Password Manager
- Use a password manager like <a href="https://proton.me/pass" title="Link to Proton Pass password manager" target="_blank">Proton Pass</a> or <a href="https://bitwarden.com/" title="Link to Bitwarden website" target="_blank">Bitwarden</a>. I wish I could recommend more, but I can't because I haven't used others. 1Password is the most popular and close source, I would avoid it at all cost.

### Use Encryption
- Use full-disk encryption tools like LUKS (Linux Unified Key Setup) to encrypt your SSD (Solid-State Drive). Most Linux distros have it built-in into the installer. Just make sure to enable it during installation

### Use 2FA
- Use strong passwords and enable 2FA (Two-Factor Authentication) wherever possible

## Secure Software Management
### 1. Use Official Repos
- Try not to use unofficial repositories. Unfortunately, sometimes you need them. For example, <a href="https://tableplus.com/download/linux" title="Link to Table Plus download page" target="_blank">Table Plus</a> app is not available on Flathub or on official Fedora repositories.

### 2. Use Flatpak Packages
- Use Flatpak packages when possible
- I would also recommended to install <a href="https://flathub.org/apps/io.github.flattool.Warehouse" title="Link to Flathub store" target="_blank">Warehouse</a>

### 3. Use Flatseal App
- Install <a href="https://flathub.org/apps/com.github.tchx84.Flatseal" title="Link to Flathub store" target="_blank">Flatseal</a> app and tweak permissions for each of your Flatpak app. There are 2 main things you need to look, "Share -> Network" setting and "Filesystem -> All system files". Make sure apps that doesn't need network access and system files access don't have that right

## Development Workflow
- Use VIM, Neovim, Emacs, or any other free and open-source code editor. Don't recommend IDEs like VSCode or JetBrains products, but if you must use VSCode, remember to disable telemetry in the settings because it's enabled by default. Add these 3 lines to your `settings.json` configuration file:

```json
{
    "telemetry.feedback.enabled": false,
    "telemetry.editStats.enabled": false,
    "telemetry.telemetryLevel": "off",
}
```

- It would have been nice to avoid GitHub, but any other Git hosting services are also backed by big tech companies. So, use whatever you are comfortable with.
- Be Cautious with Scripts. Avoid piping `curl` directly to `bash` and always review scripts before executing them.
- Don't use Docker, use Podman

The secure thing is marketing crap-Docker containers are isolated in theory, but root access means if anything's hacked, you're done. Podman fixes it by never running a root daemon-containers stay in your namespace, no way to jump out unless you literally say privileged. So Podman isn't bulletproof, but it's like way secure than Docker. That's why big corps transitioning to Podman.

## Network Security
- Use a VPN: Briefly explain its purpose (encrypts traffic from your ISP, hides your IP from the immediate website) and contrast it with Tor (VPN provides privacy from your local network, Tor provides anonymity from the destination). You could mention providers like Proton VPN or Mullvad that align with the privacy ethos.

- Use a DNS-over-HTTPS (DoH) resolver: This prevents your ISP from seeing every website you query. This is a simple but powerful change. You could recommend a provider like cloudflare-dns.com or dns.nextdns.io.

- Consider a Firewall: Briefly mention application firewalls like ufw (Uncomplicated Firewall) to easily deny all incoming connections by default.

## Conclusion
Securing your digital life is an ongoing process. Start with the fundamentals (strong passwords, encryption), then gradually replace tools and adopt more advanced practices (using Tor, avoiding big tech). Remember, the goal is to make it as difficult as possible for anyone to track you or access your data.
