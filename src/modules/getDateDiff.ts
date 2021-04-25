import DateDiff from "@/interfaces/DateDiff"

const dateDiff = require('date-diff')

export default (date1: Date, date2: Date): DateDiff => {
    const codingMonths = new dateDiff(date1, date2).months()

    const years = Math.floor(codingMonths / 12)
    const months = codingMonths % 12
    const roundYears = Math.round(codingMonths / 12)

    return { years, months, roundYears }
}