import ContactModalState from '@/store/interfaces/ContactModalState'
import NavbarState from '@/store/interfaces/NavbarState'
import ProjectsState from './ProjectsState'

export default interface RootState {
    contactModal: ContactModalState
    navbar: NavbarState
    projects: ProjectsState
}