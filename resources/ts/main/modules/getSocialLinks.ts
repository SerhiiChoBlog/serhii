import showToast from '@shared/modules/showToast'
import type { SocialLink } from '@shared/types'
import copy from 'copy-to-clipboard'

export default (postTitle: string): SocialLink[] => {
    const url = encodeURIComponent(window.location.href)

    return [
        {
            href: `https://twitter.com/intent/tweet?text=${postTitle}&url=${url}`,
            title: 'twitter',
            tip: 'Share to Twitter',
        },
        {
            href: `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
            title: 'linkedin',
            tip: 'Share to LinkedIn',
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
            href: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
            title: 'facebook',
            tip: 'Share to Facebook',
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
