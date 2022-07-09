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
                this.handleArrowDown()
                break
            case this.keys.up:
                this.handleArrowDown()
                break
            case this.keys.left:
                this.handleArrowDown()
                break
            case this.keys.right:
                this.handleArrowDown()
        }
    }

    private clearAllSelectedFlags(): void {
        this.search.posts.map(post => {
            post.selected = false
            return post
        })
    }

    private handleArrowDown(): void {
        if (!this.search.posts[this.search.index]) {
            this.search.index = 0
            this.search.projects[this.search.index].selected = true
            return
        }

        this.search.posts[this.search.index].selected = true

        this.search.index += 1
    }
}
