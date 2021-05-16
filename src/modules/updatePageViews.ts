import { getUpdatePageViewsUrl } from '@/config'
import { RouteLocationNormalizedLoaded } from 'vue-router'
import { isProduction } from '@/config'

export default (route: RouteLocationNormalizedLoaded) => {
    if (!isProduction)
        return

    const slug = getSlug(route)

    if (!slug)
        return

    const params = {
        method: 'POST',
        body: JSON.stringify({ slug, page_type: getPageType(route) }),
        headers: { 'Content-Type': 'application/json' },
    }

    fetch(getUpdatePageViewsUrl(), params).catch(err => console.error(err))
}

function getSlug(route: RouteLocationNormalizedLoaded): string | null {
    const projectPageSlug = route.params.projectName as string | null
    const homePageSlug = route.fullPath === '/' ? 'home' : null
    const postPageSlug = route.params.slug as string | null

    let slug = projectPageSlug || homePageSlug || postPageSlug

    if (!slug)
        return null

    if (slug[slug.length - 1] === '/')
        slug = slug.slice(0, -1)

    return slug
}

function getPageType(route: RouteLocationNormalizedLoaded): string {
    if (route.params.projectName)
        return 'project'

    return 'other'
}