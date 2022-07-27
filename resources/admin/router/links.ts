import { UserSidebarLink } from '../../types/types'
import dispatchEvent from '../modules/dispatchEvent'
import appConfig from '../appConfig'

const links: UserSidebarLink[] = [
    {
        href: '/',
        routeName: null,
        title: 'Site',
        icon: 'fa-home',
    },
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
        routeName: null,
        href: 'javascript:',
        title: 'Logout',
        icon: 'fa-sign-out-alt',
        action: () => dispatchEvent(appConfig.events.logout),
    },
]

export default links
