import AuthState from '@/store/interfaces/AuthState'
import ContactModalState from '@/store/interfaces/ContactModalState'
import NavbarState from '@/store/interfaces/NavbarState'

export default interface RootState {
    contactModal: ContactModalState
    navbar: NavbarState
    auth: AuthState
}