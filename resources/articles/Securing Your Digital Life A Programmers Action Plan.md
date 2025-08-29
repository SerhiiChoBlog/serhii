## Introduction
- It's not easy to be safe and private

You might think that my list is overkill, but that's what I do myself and I don't feel limited or restricted in any way. If you are okay with your digital life as it is, then you don't need to read further. Just remember that every time you Google something, you are giving away your privacy. Arguments like "I have nothing to hide" or "I don't care if they track me" are invalid. You might not care, but your data is valuable and can be used against you in the future. So, it's better to be safe than sorry.

Anyways, I'm not your privacy advisor, I'm just a tech who cares about this stuff. So, take my advice with a grain of salt and do your own research.

## Use Linux
- Fedora, Linux Mint, Pop!_OS, Arch if you are bold, or any other popular Linux distro.

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
