import Cache from '@/modules/Cache'
import appConfig from '@/appConfig'

export default class {
    public static set(ids: number[]): void {
        Cache.set<number[]>(appConfig.storage.selectedSubscriptionTags, ids)
    }

    public static get(): number[] | null {
        return Cache.get<number[]>(appConfig.storage.selectedSubscriptionTags)
    }

    public static deleteAll(): void {
        this.set([])
    }
}
