import { UserSidebarLink } from '../types/types'

const links: UserSidebarLink[] = [
    {
        route_name: '',
        title: 'Site',
        icon: 'fa-home',
    },
    {
        route_name: 'dashboard',
        title: 'Dashboard',
        icon: 'fa-columns',
    },
    {
        route_name: 'posts',
        title: 'Posts',
        icon: 'fa-newspaper',
    },
    {
        route_name: 'tags',
        title: 'Tags',
        icon: 'fa-tags',
    },
    {
        route_name: 'page-views',
        title: 'Post views',
        icon: 'fa-eye',
    },
    {
        route_name: 'visitors',
        title: 'Visitors',
        icon: 'fa-users',
    },
    {
        route_name: 'social-shares',
        title: 'Shares',
        icon: 'fa-share-alt',
    },
    {
        route_name: 'referrers',
        title: 'Referrers',
        icon: 'fa-link',
    },
    {
        route_name: 'hits',
        title: 'Hits',
        icon: 'fa-shoe-prints',
    },
    {
        route_name: 'logout',
        title: 'Logout',
        icon: 'fa-sign-out-alt',
    },
]

export default links
