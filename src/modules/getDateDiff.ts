import DateDiff from "@/interfaces/DateDiff"

const dateDiff = require('date-diff')

export default (date1: Date, date2: Date): DateDiff => {
    const codingDiff = new dateDiff(date1, date2)
        .years()
        .toString()
        .split('.')

    const years = parseInt(codingDiff[0])
    const months = parseInt(codingDiff[1])
    let roundYears = years

    if (months > 6)
        roundYears += 1

    return {
        years,
        months,
        roundYears,
    }
}