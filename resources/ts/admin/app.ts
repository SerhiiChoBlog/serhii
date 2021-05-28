import smoothLoader from 'smooth-loader'
import './components/editBlog'
import flatpickr from 'flatpickr'
import 'flatpickr/dist/flatpickr.min.css'

smoothLoader()

flatpickr('#datetime', {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
})
