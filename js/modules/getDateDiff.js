const dateDiff = require('date-diff');
const pluralize = require('pluralize')

export default (date1, date2) => {
    const codingDiff = new dateDiff(date1, date2)
        .years()
        .toString()
        .split('.')

    const years = parseInt(codingDiff[0])
    const yearsWord = pluralize('years', years)

    if (codingDiff.length == 2) {
        const months = parseInt(codingDiff[1])
        const monthsWord = pluralize('month', months)
        return `${years} ${yearsWord} ${months} ${monthsWord}`
    }

    return `${years} ${yearsWord}`
}