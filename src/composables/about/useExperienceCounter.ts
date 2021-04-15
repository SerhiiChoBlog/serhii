import { ref } from 'vue'
import getDateDiff from '@/modules/getDateDiff'

export default () => {
    const currentDate = new Date()
    const startedCareerDate = new Date(2017, 5, 24)

    const experience = ref(getDateDiff(currentDate, startedCareerDate))
    const fullExperience = ref(`${experience.value.years} years ${experience.value.months} months`)

    return { experience, fullExperience }
}