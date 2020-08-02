import getDateDiff from '../modules/getDateDiff'

export default [
    {
        type: 'Name',
        value: 'Serhii Cho',
    },
    {
        type: 'Experience',
        value: getDateDiff(new Date(), new Date(2017, 5, 24)),
    },
    {
        type: 'Nationality',
        value: 'Ukrainian',
    },
    {
        type: 'Location',
        value: 'Kharkiv, Ukraine',
    },
    {
        type: 'Email',
        value: 'serhiicho@protonmail.com',
    },
]