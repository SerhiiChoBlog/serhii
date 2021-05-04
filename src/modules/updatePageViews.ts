import { getUpdatePageViewsUrl } from '@/config'
import { RouteLocationNormalizedLoaded } from 'vue-router'
import { isProduction } from '@/config'

export default (route: RouteLocationNormalizedLoaded) => {
    if (!isProduction)
        return

    const params = {
        method: 'POST',
        body: JSON.stringify({ slug: getSlug(route), page_type: getPageType(route) }),
        headers: { 'Content-Type': 'application/json' },
    }

    fetch(getUpdatePageViewsUrl(), params).catch(err => console.error(err))
}

function getSlug(route: RouteLocationNormalizedLoaded): string {
    let slug = route.params.projectName as string || route.fullPath

    if (slug === '/' || slug.includes('?'))
        return 'home'

    if (slug[0] === '/')
        slug = slug.substr(1)

    if (slug[slug.length - 1] === '/')
        slug = slug.slice(0, -1)

    return slug
}

function getPageType(route: RouteLocationNormalizedLoaded): string {
    if (route.params.projectName)
        return 'project'

    return 'other'
}