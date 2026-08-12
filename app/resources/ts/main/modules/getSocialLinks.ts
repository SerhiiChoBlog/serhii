import showToast from '@shared/modules/showToast'
import type { SocialLink } from '@shared/types'
import copy from 'copy-to-clipboard'

export default (postTitle: string): SocialLink[] => {
    const url = encodeURIComponent(window.location.href)

    return [
        {
            href: `https://mastodon.social/share?text=${postTitle} ${url}`,
            title: 'mastodon',
            tip: 'Share to Mastodon',
        },
        {
            href: `https://www.reddit.com/submit?url=${url}&title=${postTitle}`,
            title: 'reddit',
            tip: 'Share to Reddit',
        },
        {
            href: `https://t.me/share/url?url=${url}&text=${postTitle}`,
            title: 'telegram',
            tip: 'Share to Telegram',
        },
        {
            href: null,
            title: 'clipboard',
            tip: 'Copy to a clipboard',
            action: () => {
                copy(window.location.href)

                showToast({
                    text: 'Current URL has been copied to your clipboard',
                    success: true,
                })
            },
        },
    ]
}
