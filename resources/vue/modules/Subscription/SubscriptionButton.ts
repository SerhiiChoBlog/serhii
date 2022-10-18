import Cache from '@/modules/Cache'
import appConfig from '@/appConfig'
import dispatchEvent from '@/modules/dispatchEvent'

export default class {
    public static rename(): void {
        const ids = Cache.get<number[]>(appConfig.storage.selectedSubscriptionTags)

        if (ids) {
            this.setTitle(`${ids.length} tags`)
        }
    }

    public static setAllTags(): void {
        this.setTitle('All tags')
    }

    public static setNoTags(): void {
        this.setTitle('No tags')
    }

    public static setTagsAmount(amount: number): void {
        this.setTitle(`${amount} tags`)
    }

    private static setTitle(title: string): void {
        dispatchEvent(appConfig.events.subscribeTagsButtonTitle, title)
    }
}
