import { RouteRecordRaw } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Posts from '../views/Posts/Posts.vue'
import CreatePost from '../views/Posts/CreatePost.vue'
import EditPost from '../views/Posts/EditPost.vue'
import Tags from '../views/Tags/Tags.vue'
import CreateTag from '../views/Tags/CreateTag.vue'
import EditTag from '../views/Tags/EditTag.vue'
import PostViews from '../views/PostViews.vue'
import Visitors from '../views/Visitors.vue'
import SocialShares from '../views/SocialShares.vue'
import Hits from '../views/Hits.vue'

const routes: RouteRecordRaw[] = [
    { path: '/admin/dashboard', name: 'dashboard', component: Dashboard },
    { path: '/admin/posts', name: 'posts', component: Posts },
    { path: '/admin/posts/create', name: 'posts-create', component: CreatePost },
    { path: '/admin/posts/:id/edit', name: 'posts-edit', component: EditPost },
    { path: '/admin/tags', name: 'tags', component: Tags },
    { path: '/admin/tags/create', name: 'tags-create', component: CreateTag },
    { path: '/admin/tags/:id/edit', name: 'tags-edit', component: EditTag },
    { path: '/admin/post-views', name: 'post-views', component: PostViews },
    { path: '/admin/visitors', name: 'visitors', component: Visitors },
    { path: '/admin/social-shares', name: 'social-shares', component: SocialShares },
    { path: '/admin/hits', name: 'hits', component: Hits },
]

export default routes
