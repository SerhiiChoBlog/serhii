import NavbarState from '@/store/interfaces/NavbarState'
import ProjectsState from './ProjectsState'

export default interface RootState {
    navbar: NavbarState
    projects: ProjectsState
}