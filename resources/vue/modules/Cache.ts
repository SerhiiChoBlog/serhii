import { isEqual } from 'lodash'

export default class {
    public static add<T>(key: string, item: T): void {
        let oldItems = this.get<T>(key)

        oldItems = oldItems.filter(oldItem => !isEqual(oldItem, item))
        oldItems.push(item)

        const newItems = oldItems.reverse().splice(0, 5).reverse()

        localStorage.setItem(key, JSON.stringify(newItems))
    }

    public static get<T>(key: string): T[] {
        const history = localStorage.getItem(key)
        return history ? JSON.parse(history) : []
    }
}
