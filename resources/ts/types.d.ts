import type { User } from '@shared/types/models'

export { }

declare module 'vue' {
    interface ComponentCustomProperties {
        Auth: User | undefined
    }
}
