## Introduction
<blockquote>
    <p>What I'm about to tell you is top secret. There's a powerful group of people out there that are secretly running the world. I'm talking about the guys, no one knows about the guys who are invisible. The top 1% of the top 1%. The guys that play God without permission. And now I think they're following me.</p>
    <img src="https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1756472826.webp" alt="Elliot Alderson in a dark hoodie with a black background" />
    <h6>Elliot Alderson (Mr. Robot series)</h6>
</blockquote>

I've never started an article with a quote, but this dialogue from Elliot Alderson was the first thing that came to my head when I started writing it. **The surveillance and existential paranoia displayed in that great series perfectly capture the digital landscape we navigate today.**

Recent scandals involving British and other politicians pushing for ubiquitous monitoring, data collection, and mandatory face scans to confirm your age have highlighted the escalating trend towards government and corporate surveillance. This raises serious concerns about privacy and individual freedom in the digital age.

![People are protesting. Holding banners with the sign: Stop watching all of us](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1756478455.jpg)

Even though this article will not be political, it's difficult to ignore the increasing tension between individual privacy and governmental/corporate agendas. **The greediness for more power over people and control over their digital footprints is evident**, particularly with revelations from whistleblowers like Edward Snowden underscoring the vast extent of personal data collection by state actors like the National Security Agency (NSA).

![NSA logo surrounded by logos of Facebook, Yahoo, Skype, Apple, and Google](https://serhii.io/storage/posts/content/moving-from-macos-back-to-linux-as-a-programmer-1756293717.jpg)

This ongoing war on privacy has led millions to investigate how to reclaim their digital freedom. **DuckDuckGo search engine went from 1.64 million daily queries in 2013 (Snowden revelation) to over 100 million in 2024. It's a mind-blowing 6000% increase in daily searches.**

![Advertizing banner with the DuckDuckGo ad: Google tracks you. We don't](https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1756478715.jpg)

ProtonMail founded their company after Snowden's leaks in 2013, and in 2025 they have over **70 million users**, illustrating a clear and growing public mandate for privacy-focused digital services.

Switching from Gmail to ProtonMail is a good first move, but it's like putting window bars on a single window when you have 10 of them. I don't consider myself a guru of privacy, but I have been pushing hard on it since 2020, and since then, I've changed the digital footprints of my relatives and myself.

And yes, **as tech professionals, this responsibility extends to teaching and protecting our relatives who are strangers to all that tech stuff.**

<blockquote>
    <p>You don't know how much you appreciate your privacy until you don't have it.</p>
    <img src="https://serhii.io/storage/posts/content/securing-your-digital-life-a-programmers-action-plan-1756479356.webp" alt="Photo of Morgan Freeman, actor and producer" />
    <h6>Morgan Freeman (actor, producer)</h6>
</blockquote>

Anyway, I'm not your privacy advisor; I'm just a tech who cares about this stuff. So, take my advice with a grain of salt and do your own research if you want to delve deeper. But I'm going to walk you through a comprehensive action plan for securing your digital life, offering practical steps to enhance your digital life and those people you care about. And we'll start with the first and most important step, your operating system.

## Use Linux
- Fedora, Linux Mint, Pop!\_OS, Arch if you are bold, or any other popular Linux distro.
The most fundamental 

## Safe ISO File
- It doesn't matter how safe your house if your back door is not locked. That's why it's important to follow basic security practices when it comes to downloading installation files like ISO.
- Download ISO images only from official websites and compare checksums before installing

## No Proprietary Software
- Don't use proprietary software (e.g., Google Chrome, Gmail, Google, etc.)
- Install only open-source apps and browser extensions

### Use Alternatives
- Use alternatives like Proton Mail, Proton Drive, Proton Calendar, DuckDuckGo, Brave Browser, Firefox, LibreOffice, etc.

## Secure Browsing
### Browser Extensions
- Suggest key extensions like uBlock Origin (not just an ad-blocker, a key privacy tool) and perhaps Privacy Badger.

### Use Tor for Maximum Privacy
- For the ultimate level of anonymity in your browsing, the Tor network is the gold standard. It's a separate tool for specific, high-privacy needs.

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

## Network Security
- Use a VPN: Briefly explain its purpose (encrypts traffic from your ISP, hides your IP from the immediate website) and contrast it with Tor (VPN provides privacy from your local network, Tor provides anonymity from the destination). You could mention providers like Proton VPN or Mullvad that align with the privacy ethos.

- Use a DNS-over-HTTPS (DoH) resolver: This prevents your ISP from seeing every website you query. This is a simple but powerful change. You could recommend a provider like cloudflare-dns.com or dns.nextdns.io.

- Consider a Firewall: Briefly mention application firewalls like ufw (Uncomplicated Firewall) to easily deny all incoming connections by default.

## Conclusion
Securing your digital life is an ongoing process. Start with the fundamentals (strong passwords, encryption), then gradually replace tools and adopt more advanced practices (using Tor, avoiding big tech). Remember, the goal is to make it as difficult as possible for anyone to track you or access your data.
