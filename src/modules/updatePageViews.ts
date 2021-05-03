import { getUpdatePageViewsUrl } from '@/config'
import { RouteLocationNormalizedLoaded } from 'vue-router'

export default (route: RouteLocationNormalizedLoaded) => {
    const params = {
        method: 'POST',
        body: JSON.stringify({ slug: getSlug(route), page_type: getPageType(route) }),
        headers: { 'Content-Type': 'application/json' },
    }

    fetch(getUpdatePageViewsUrl(), params).catch(err => console.error(err))
}

function getSlug(route: RouteLocationNormalizedLoaded): string {
    let slug = route.params.projectName as string || route.fullPath

    if (slug === '/')
        slug = 'home'

    if (slug[0] === '/')
        slug = slug.substr(1)

    return slug
}

function getPageType(route: RouteLocationNormalizedLoaded): string {
    let pageType = 'other'

    if (route.params.projectName)
        pageType = 'project'

    return pageType
}