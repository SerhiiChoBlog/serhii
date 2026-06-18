## Introduction

In my nine-year programming career, I've never used a **virtual private server (VPS)** for any of my projects because shared hosting always did the job. I would probably still be using it if it wasn't for the constant price increase.

I want to use this article to document my journey going from shared hosting to VPS to give other tech brothers and sisters information about what issues they might face and what they should expect.

Yesterday, on May 25, 2026, I purchased a KVM1 plan VPS on Hostinger because it was the best solution for my personal tech blog in terms of money spent and value gained. I have searched through a couple of other options, like Digital Ocean and others, and Hostinger was a perfect fit for me. And, cherry on top, it has a referral program where you can invite a friend and you both get additional discounts. That was precisely what I needed because **I had just such a friend who also wanted me to move his WordPress site from shared hosting**.

I'm not a professional sysadmin, but as a programmer who has worked in the field for nine years, I'll walk you through my experience moving from shared hosting to VPS. We'll start by talking about the conveniences and differences between both and the transition into the migration process. Let's start by addressing the elephant in the room: What makes VPS different from shared hosting?

## Difference Between VPS and Shared Hosting

Shared hosting is like renting a room in a noisy dormitory with shared common areas like a kitchen and bathroom. One neighbor's party can affect everyone's experience. If someone uses too much bandwidth or their site gets attacked, it impacts your performance too.

VPS is like moving into your house where you have your walls and full control over the environment. You can paint the rooms any color you want without asking permission, install whatever you need, and your neighbors' activities don't directly impact your space.

Note. Some providers offer shared vCPUs, meaning if someone is blasting music in their house, they're still going to impact neighbors. Others provide dedicated cores, where you're essentially in a soundproof room. **A vCPU, or virtual CPU, is a piece of a physical processor assigned to your virtual machine by a hypervisor.**

Note. A hypervisor, sometimes called a virtual machine monitor, is software that controls communications with the CPU of the computer. Instead of speaking to the CPU directly, the hypervisor intercepts those signals and decides in which order they should be sent. Why do you need that, you might ask? The answer is when you have 2 or more operating systems talking to the same CPU at the same time. Basically, **a hypervisor is what makes it possible to share the same physical CPU with multiple computers.**

That's why it's better to have VPS than shared hosting if you want more freedom. With VPS, you can have any Linux distribution that you want with any software that you want. Shared hosting puts you in an existing distribution with other users already there. You cannot see them if you type `ls /home`. But they are there.

## The Cost of Conveniences

The biggest advantages of shared hosting are the integrated, user-friendly panels like cPanel and DirectAdmin. They are truly wonderful pieces of software. The amount of configuration you can do there is insane.

![C-Panel interface example](/storage/posts/content/escaping-shared-hosting-my-first-dive-into-vps-managment-1780064087.png)

But at the same time, these interfaces prevented me from learning how to work with Linux directly through the terminal. A good example is <a href="https://www.phpmyadmin.net/" title="Link to Hostinger VPS plan" target="_blank">phpMyAdmin</a>, a tool for administering MySQL and MariaDB over the web. While it's convenient to use the interface, my MySQL CLI knowledge faded a little more each year.

![phpMyAdmin panel example](/storage/posts/content/escaping-shared-hosting-my-first-dive-into-vps-managment-1780064529.png)

While integrated panels are convenient, for programmers, they act as a barrier to learning. You'll never learn how to install a new PHP version with its extensions on a production server. Or how to set up Apache 2 with its mods.

Because if you try to do any of those things on shared hosting, you'll quickly find out that you don't have root permissions. Remember our comparison with the dormitory room? You can do things inside your room, but everything outside of it doesn't belong to you. That brings us neatly to the next chapter.

## Root Permissions

Having root access to your system grants the absolute authority to manage every aspect of the operating system, including the installation of custom services and management of configuration files.

If you need a specific Python library or PHP extension, you can always install it without any issues on VPS. Shared hosting, on the other hand, restricts you to a specific set of pre-installed programs.

Sure, one of the solutions is contacting your hosting support and asking them to install it, but this process is often slow and might lead to refusals from the hosting provider if you ask for too much or too often.

But with VPS, you have the full power to do anything you want, and that’s what I was missing for all of those years of managing my infrastructure on shared hosting. I can now build and run custom binaries, put my project into a container with Podman, restart any service that I want, and more.

One thing left: the migration itself.

## The Migration Process

Migrating a project from shared hosting to VPS for nerds like me is not as difficult as one might assume. I’m sure it would be a struggle for non-tech people, but this article targets individuals with software development knowledge and basic system administration.

It’s not all sunshine and rainbows, though. I’ll share the hidden pitfalls later in this article, because they also exist, but for now, let’s focus on planning the actual move.

I’m going to assume that you will manage your VPS through the CLI instead of installing cPanel and other interfaces like phpMyAdmin to manage your system. There is nothing wrong with doing so. However, bypassing graphical interfaces encourages a deeper mastery of underlying system services.

### Planning

The first real step in any migration is choosing the right hosting provider. I’m not going to compare any hosting providers because they change every year, but I’ve personally tried Digital Ocean, Hostinger, and a couple of local options, and I’ve settled on Hostinger because Digital Ocean was pricier. It doesn’t mean that you should also pick Hostinger. That’s just my pick based on the price and the UI for managing my VPS.

But if you also go for Hostinger like me, I have a link at the end of this article to help you save 20% on your first purchase. But promise that you’ll decide on your hosting provider yourself rather than just blindly following my link. That’s why I’ve moved it to the very bottom of the article instead of placing it right here for easy access.

Regardless of your provider, try to find coupons and discounts for your desired plan. You can save a significant amount of money if you look for referral links and coupon codes. Many providers are glad to provide you discounts to make you sign up for their service.

### Execution

Once you select your preferred provider, it’s time to set up your VPS. Usually, you’ll pick such options as a distribution, storage capacity, and a server geolocation. Thereafter, you’ll need to setup an SSH connection with your VPS and come up with a password for the root user.

Once access is secured, you can create a user with sudo privileges and disable root SSH by changing one line in your `/etc/ssh/sshd_config` file.

```plaintext
PermitRootLogin no
```

The reason is that you don’t want to execute commands as the root user directly, as this exposes your system to significant security risks. Additionally, it will lead to permissions issues where root files will not be accessible by a web server.

You should also update your system and, depending on your workflow, install the required software. In my case, I’ve installed Apache 2 with the needed mods, MariaDB, and certbot for automatic SSL.

### Hidden Pitfalls

One of the things you need to keep in mind while making the move is the mail server. If you are using an external SMTP service like SendGrid, Brevo, or Mailgun, the transition remains relatively straightforward. However, hosting your own mail server introduces challenges regarding IP reputation.

It’s not that difficult to setup a mail server on Linux, but to configure it so that your mail doesn’t go to a spam folder on most email providers is a different story. Basically, you can spend days and weeks configuring your own mail server, or you can just use an SMTP service.

In my case, I’ve just created an account on one of those services because some of them are giving free daily emails, which is what I need.

### Black Hole

I cannot elaborate on the transition to VPS without explaining the biggest issue that I had in this journey. While writing this article, I still don’t know whose fault it was. It could have been me, my ISP, or the hosting provider, but I must share it with everyone. Let’s discuss what the black hole is first.

Wikipedia says that in networking, a black hole refers to a place in the network where incoming or outgoing traffic is discarded without informing the source that the data did not reach its intended recipient. To put it simply, it functions as a digital void where data packets enter but never exit, often leaving the sender unaware that a connection failure has occurred.

Tip. As programmers, we usually think of the internet as requests and responses. But at a lower level, request and response are just bits (zeros and ones). 8 bits make up a byte, and a packet is simply a group of those bytes. Each packet contains a header and a payload (message). The header is holding information about a sender and receiver, and the payload is a small chunk of your request's content. It holds only a small chunk of your message because the size of a single packet is typically around 1,500 bytes. You can observe packets in real time using tools like Wireshark.

In your browser, it would look like an infinite page loading or a connection timeout because the network layer silently drops the traffic without transmitting an error signal to your router.

When I tested to access my website with VPN enabled, it would work fine for some VPN servers, and some of them had the same issue. It wasn’t a DNS issue because I was also testing the SSH connection, which was connecting by IP address instead of domain.

After making sure I’m not running any firewalls and my /etc/hosts.deny is empty, I’ve contacted the hosting provider and explained the issue. Their argument was that they are not blocking any IP addresses for my VPS, and my website works perfectly fine from their end.

After searching for more information about what to do in these situations, I learned about a cool network diagnostic tool called **MTR (My Traceroute),** and it made me love Linux even more than before. This is a fantastic program that combines the functionality of ping and traceroute in a single tool. Since it shows the results live, we need to pass `--report` or `--report-wide` flag to print the output once instead of serving it live.

```bash
mtr --report 31.97.72.194
```

After running that command on my server's IP address, I got this:

```plaintext
Start: 2026-05-31T19:41:25+0300
HOST: linux                       Loss%   Snt   Last   Avg  Best  Wrst StDev
  1.|-- _gateway                   0.0%    10    1.1   1.1   0.7   1.4   0.2
  2.|-- 10.18.82.154               0.0%    10    1.8   2.0   1.5   2.5   0.3
  3.|-- 193.105.3.149              0.0%    10    3.2   3.4   1.7   4.2   0.7
  4.|-- 10.132.223.16              0.0%    10   39.3  24.6   9.3 103.6  29.7
  5.|-- v110.cors.kbps1.he.net     0.0%    10   14.7  12.0   9.0  19.5   3.8
  6.|-- ve951.cors.kbps1.he.net    0.0%    10   11.3  10.8  10.0  11.6   0.6
  7.|-- be7.core1.waw1.he.net      0.0%    10   25.9  26.9  24.8  34.6   2.8
  8.|-- port-channel4.core2.vno1.  0.0%    10   30.1  30.1  29.5  31.0   0.5
  9.|-- ???                       100.0    10    0.0   0.0   0.0   0.0   0.0
```

Note. I've modified some IP addresses in the output to hide the real route from my ISP to neighboring countries. Even though it's not confidential information, it's completely public, and anyone can find those IPs.

For the result, we get a beautiful table with all the hops starting from the gateway (your router) and ending with question marks at hop 9 with 100% packet loss. That question mark line is the black hole. This clearly tells us that my packets travel far past my ISP and disappear after `port-channel4.core2.vno1.he.net` which points to Hurricane Electric LLC's router in Lithuania.

To make sure the data is correct, I also executed `sudo tcptraceroute 31.97.72.194` and got a similar result. Like I said before, I still don't know whose fault it was. Probably incorrect BGP routing, but the issue was resolved after a couple of days by itself. I'm assuming it's because BGP routing tables got updated, but that's just my guess.

Anyway, I just wanted to mention this issue with my VPS because it had a significant impact on my experience. Keep these Linux commands in your belt when debugging disappearing packets.

## Web Server Issues

After solving the BGP routing issue and adding final configurations to the web server, I needed to make sure everything works. I've noticed right away that my Laravel website was loading the main page perfectly fine, but as soon as I switched to any other page, it would give me a 404 (not found) error. If you are using Apache, like in my case, then it's oftentimes a path overrides issue. You need to go into your Apache configuration file in `/etc/apache2/apache2.conf` and change `AllowOverride` line to have value `All` for your project directory:

```diff
<Directory /var/www/>
    Options Indexes FollowSymLinks
-    AllowOverride None
+    AllowOverride All
    Require all granted
</Directory>
```

After that change, we obviously must restart Apache by running:

```bash
sudo systemctl restart apache2
```

After you restart the server, Apache is now going to read `.htaccess` files and apply those configurations on a fly instead of depending on the main configuration file. That should solve the 404 issue for Laravel and other frameworks that rely on `.htaccess` files.

## Locking Down Your Permissions

Another issue you might have could be related to your server not being able to modify files in specific directories. The best way to go about it is:

1. **Make your user own all the project files.** Even if the server gets hacked, they cannot modify anything.
2. **Make the project owned by the www-data group.** Your server will be able to read all the files.
3. **Make all the project directories executable.** On Linux, non-executable directories cannot be accessed.
4. **Make all the project files owned by your user and read-only by the group.** Restrict the server from modifying any files in your project.
5. **Allow the www-data group to modify specific directories.** Your server needs to have read and write permissions for specific directories like cache and logs.

Here is the list of commands similar to what I was executing on my VPS:

```bash
# Go into your project
cd /var/www/html/serhiicho.com

# Change ownership for all the files
sudo chown -R my-user:www-data .

# Make all directories accessible by user and a group
sudo find . -type d -exec chmod 750 {} +

# Make all the files owned by your user and read-only by the group
sudo find . -type f -exec chmod 740 {} +

# Make specific directories writable by the server
sudo chmod -R 770 storage/logs storage/framework bootstrap/cache

# Make specific directories owned only by www-data user and group
sudo chown -R www-data:www-data storage/logs storage/framework bootstrap/cache
```

Your user needs to be a member of `www-data` group in order to at least read the files owned by the server. You can check which users are in `www-data` group, you can run:

```bash
cat /etc/group | grep www-data
```

If there are no users, you'll get somethign like this: `www-data:x:33:`. To add your user to the `www-data` group, you can run `usermod` command:

```bash
sudo usermod -aG www-data your-username
```

The `-aG` flag in this case tells Linux to add the user to the group instead of replacing all existing groups.

## Conclusion

A final verdict and a 'Who is this for?' summary to provide a practical takeaway for the reader.

## Links

- <a href="https://www.hostinger.com/cart?REFERRALCODE=LIJSERHIIVHW&referral_id=019e6331-8531-7077-8b1d-6abd8ad00273" title="My referral Hostinger link with the discount" target="_blank">My referral Hostinger link with the discount</a>
- <a href="https://www.hostinger.com/cart?product=vps%3Avps_kvm_1&period=24&referral_type=cart_link&REFERRALCODE=LIJSERHIIVHW&referral_id=019e6338-64cf-73b8-b590-6a7b2e0860c6" title="Link to Hostinger KVM1 plan" target="_blank">KVM1 20% discount</a>
