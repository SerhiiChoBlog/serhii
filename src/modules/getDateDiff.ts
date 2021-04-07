import DateDiffInterface from "@/interfaces/DateDiffInterface"

const dateDiff = require('date-diff');

export default (date1: Date, date2: Date): DateDiffInterface => {
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