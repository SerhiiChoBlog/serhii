import DateDiff from "@/interfaces/DateDiff"

const dateDiff = require('date-diff')

export default (date1: Date, date2: Date): DateDiff => {
    const codingMonths = new dateDiff(date1, date2).months()

    return {
        years: Math.floor(codingMonths / 12),
        months: codingMonths % 12,
    }
}