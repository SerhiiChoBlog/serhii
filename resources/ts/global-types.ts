import type { User } from '@shared/types/models'

export { }

declare global {
    const User: User | undefined
}
