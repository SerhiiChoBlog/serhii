import type { UnwrapNestedRefs } from '@vue/reactivity'
import type { Search } from '../types/types'

export default class {
    private readonly keys = {
        down: 'ArrowDown',
        up: 'ArrowUp',
        left: 'ArrowLeft',
        right: 'ArrowRight',
    };

    constructor(private search: UnwrapNestedRefs<Search>) {
    }

    public handle(key: string): void {
        if (!Object.values(this.keys).includes(key)) {
            return
        }

        this.clearAllSelectedFlags()

        switch (key) {
            case this.keys.down:
                this.search.suggestionsTarget === 'posts' ? this.movePostsDown() : this.moveProjectsDown()
                break
            case this.keys.up:
                this.search.suggestionsTarget === 'posts' ? this.movePostsUp() : this.moveProjectsUp()
                break
            case this.keys.left:
            case this.keys.right:
                this.moveHorizontal()
        }
    }

    private clearAllSelectedFlags(): void {
        this.search.posts.map(post => {
            post.selected = false
            return post
        })

        this.search.projects.map(post => {
            post.selected = false
            return post
        })
    }

    private moveProjectsDown(): void {
        this.search.suggestionsIndex += 1

        if (!this.search.projects[this.search.suggestionsIndex]) {
            this.search.suggestionsIndex = 0
        }

        this.search.projects[this.search.suggestionsIndex].selected = true
    }

    private moveHorizontal(): void {
        this.search.suggestionsIndex = 0

        if (this.search.suggestionsTarget === 'posts') {
            this.search.suggestionsTarget = 'projects'
            this.search.projects[0].selected = true
            return
        }

        this.search.suggestionsTarget = 'posts'
        this.search.posts[0].selected = true
    }

    private moveProjectsUp(): void {
        this.search.suggestionsIndex -= 1

        if (!this.search.projects[this.search.suggestionsIndex]) {
            this.search.suggestionsIndex = this.search.posts.length - 1
        }

        this.search.projects[this.search.suggestionsIndex].selected = true
    }

    private movePostsUp(): void {
        this.search.suggestionsIndex -= 1

        if (!this.search.posts[this.search.suggestionsIndex]) {
            this.search.suggestionsIndex = this.search.posts.length - 1
        }

        this.search.posts[this.search.suggestionsIndex].selected = true
    }

    private movePostsDown(): void {
        this.search.suggestionsIndex += 1

        if (!this.search.posts[this.search.suggestionsIndex]) {
            this.search.suggestionsIndex = 0
        }

        this.search.posts[this.search.suggestionsIndex].selected = true
    }
}
