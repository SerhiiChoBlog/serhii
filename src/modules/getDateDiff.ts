import DateDiffInterface from "@/interfaces/DateDiffInterface"

const dateDiff = require('date-diff');

export default (date1: Date, date2: Date): DateDiffInterface => {
    const codingDiff = new dateDiff(date1, date2)
        .years()
        .toString()
        .split('.')

    return {
        years: parseInt(codingDiff[0]),
        months: parseInt(codingDiff[1]),
    }
}