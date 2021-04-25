import { ref } from 'vue'
import getDateDiff from '@/modules/getDateDiff'

export default () => {
    const currentDate = new Date()
    const startedCareerDate = new Date(2017, 5, 24)
    const dateDiff = getDateDiff(currentDate, startedCareerDate)

    const experience = ref(dateDiff)
    const fullExperience = ref(`${experience.value.years} years ${experience.value.months} months`)

    return { fullExperience, roundYears: dateDiff.roundYears }
}