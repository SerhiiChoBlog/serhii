import type { User } from '@shared/types/models'

export {}

declare global {
    interface Window {
        Auth: User | null
    }
}
