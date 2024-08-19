import type { UnwrapNestedRefs } from '@vue/reactivity'
import type { Search } from '@shared/types'

export default class {
    private readonly keys = {
        down: 'ArrowDown',
        up: 'ArrowUp',
        enter: 'Enter',
    }

    constructor(private search: UnwrapNestedRefs<Search>) {}

    public handle(key: string): void {
        if (this.notNeededEvent(key) || this.suggestionsAreEmpty()) {
            return
        }

        switch (key) {
            case this.keys.enter:
                this.handleEnterKeyPress()
                break
            case this.keys.down:
                this.clearAllSelectedFlags()
                this.movePostsDown()
                break
            case this.keys.up:
                this.clearAllSelectedFlags()
                this.movePostsUp()
        }
    }

    private handleEnterKeyPress(): void {
        let post = this.search.posts.find(post => post.selected)

        if (!post) {
            post = this.search.posts[0]
        }

        if (!post) {
            return
        }

        window.location.href = `/posts/${post.slug}`
    }

    private notNeededEvent(key: string): boolean {
        return !Object.values(this.keys).includes(key)
    }

    private suggestionsAreEmpty(): boolean {
        return this.search.posts.length === 0
    }

    private clearAllSelectedFlags(): void {
        this.search.posts.map(post => {
            post.selected = false
            return post
        })
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
