import type { UnwrapNestedRefs } from '@vue/reactivity'
import type { Search } from '@/../types'

export default class {
    private readonly keys = {
        down: 'ArrowDown',
        up: 'ArrowUp',
        enter: 'Enter',
    };

    constructor(private search: UnwrapNestedRefs<Search>) {
    }

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
        const post = this.search.posts.find(post => post.selected)

        if (post) {
            window.location.href = `/posts/${post.slug}`
            return
        }

        console.error(`Cannot find any selected suggestions`)
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
