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
                this.movePostsDown()
                break
            case this.keys.up:
                this.movePostsUp()
                break
            case this.keys.left:
                this.movePostsDown()
                break
            case this.keys.right:
                this.movePostsUp()
        }
    }

    private clearAllSelectedFlags(): void {
        this.search.posts.map(post => {
            post.selected = false
            return post
        })
    }

    private moveProjectsDown(): void {
        if (!this.search.projects[this.search.index]) {
            return
        }

        this.search.projects[this.search.index].selected = true
        this.search.index += 1
    }

    private moveProjectsUp(): void {
        if (!this.search.projects[this.search.index]) {
            return
        }

        this.search.projects[this.search.index].selected = true
        this.search.index -= 1
    }

    private movePostsUp(): void {
        this.search.index -= 1

        if (!this.search.posts[this.search.index]) {
            this.search.index = this.search.posts.length - 1
        }

        this.search.posts[this.search.index].selected = true
    }

    private movePostsDown(): void {
        this.search.index += 1

        if (!this.search.posts[this.search.index]) {
            this.search.index = 0
        }

        this.search.posts[this.search.index].selected = true
    }
}
