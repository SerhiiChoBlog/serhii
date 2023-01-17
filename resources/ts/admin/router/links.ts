import { UserSidebarLink } from '@shared/types'
import dispatchEvent from '@shared/modules/dispatchEvent'
import logout from '@shared/modules/logout'

const links: UserSidebarLink[] = [
    {
        routeName: 'dashboard',
        title: 'Dashboard',
        icon: 'fa-columns',
    },
    {
        routeName: 'posts',
        title: 'Posts',
        icon: 'fa-newspaper',
    },
    {
        routeName: 'tags',
        title: 'Tags',
        icon: 'fa-tags',
    },
    {
        routeName: 'post-views',
        title: 'Post views',
        icon: 'fa-eye',
    },
    {
        routeName: 'visitors',
        title: 'Visitors',
        icon: 'fa-users',
    },
    {
        routeName: 'social-shares',
        title: 'Shares',
        icon: 'fa-share-alt',
    },
    {
        routeName: 'referrers',
        title: 'Referrers',
        icon: 'fa-link',
    },
    {
        routeName: 'hits',
        title: 'Hits',
        icon: 'fa-shoe-prints',
    },
    {
        routeName: 'post-publications',
        title: 'Publications',
        icon: 'fa-envelope',
    },
    {
        routeName: null,
        href: 'javascript:',
        title: 'Logout',
        icon: 'fa-sign-out-alt',
        action: logout,
    },
]

export default links
