/**
 * Register every component globally
 * See : https://vuejs.org/guide/components/registration
 */
import type { App } from 'vue'

import UFAlert from './UFAlert.vue'
import UFLabel from './UFLabel.vue'
import UFModal from './Modals/UFModal.vue'
import UFModalAlert from './Modals/UFModalAlert.vue'
import UFModalConfirmation from './Modals/UFModalConfirmation.vue'
import UFModalPrompt from './Modals/UFModalPrompt.vue'
import AppLink from './Content/AppLink.vue'
import InfoBox from './Content/InfoBox.vue'
import CardBox from './Content/CardBox.vue'
import CardBoxBig from './Content/CardBoxBig.vue'
import MainContent from './Content/MainContent.vue'
import HeaderPage from './Content/HeaderPage.vue'
import FooterContent from './Content/FooterContent.vue'
import FormLogin from './Content/FormLogin.vue'
import FormRegister from './Content/FormRegister.vue'
import FormForgotPassword from './Content/FormForgotPassword.vue'
import NavBar from './NavBar/NavBar.vue'
import NavBarDropdown from './NavBar/NavBarDropdown.vue'
import NavBarDropdownSeparator from './NavBar/NavBarDropdownSeparator.vue'
import NavBarItem from './NavBar/NavBarItem.vue'
import NavBarLogin from './NavBar/NavBarLogin.vue'
import NavBarUserCard from './NavBar/NavBarUserCard.vue'
import NavBarUserCardButton from './NavBar/NavBarUserCardButton.vue'
import SideBar from './SideBar/SideBar.vue'
import SideBarDropdown from './SideBar/SideBarDropdown.vue'
import SideBarItem from './SideBar/SideBarItem.vue'
import SideBarLabel from './SideBar/SideBarLabel.vue'
import SprunjeColumn from './Sprunjer/SprunjeColumn.vue'
import SprunjeHeader from './Sprunjer/SprunjeHeader.vue'
import SprunjePaginator from './Sprunjer/SprunjePaginator.vue'
import SprunjeTable from './Sprunjer/SprunjeTable.vue'

export {
    UFAlert,
    UFLabel,
    UFModal,
    UFModalAlert,
    UFModalConfirmation,
    UFModalPrompt,
    AppLink,
    InfoBox,
    CardBox,
    CardBoxBig,
    MainContent,
    HeaderPage,
    FooterContent,
    FormLogin,
    FormRegister,
    FormForgotPassword,
    NavBar,
    NavBarDropdown,
    NavBarDropdownSeparator,
    NavBarItem,
    NavBarLogin,
    NavBarUserCard,
    NavBarUserCardButton,
    SideBar,
    SideBarDropdown,
    SideBarItem,
    SideBarLabel,
    SprunjeColumn,
    SprunjeHeader,
    SprunjePaginator,
    SprunjeTable
}

export default {
    install: (app: App) => {
        app.component('UFAlert', UFAlert)
            .component('UFLabel', UFLabel)
            .component('UFModal', UFModal)
            .component('UFModalAlert', UFModalAlert)
            .component('UFModalConfirmation', UFModalConfirmation)
            .component('UFModalPrompt', UFModalPrompt)
            .component('UFAppLink', AppLink)
            .component('UFInfoBox', InfoBox)
            .component('UFCardBox', CardBox)
            .component('UFCardBoxBig', CardBoxBig)
            .component('UFMainContent', MainContent)
            .component('UFHeaderPage', HeaderPage)
            .component('UFFooterContent', FooterContent)
            .component('UFFormLogin', FormLogin)
            .component('UFFormRegister', FormRegister)
            .component('UFFormForgotPassword', FormForgotPassword)
            .component('UFNavBar', NavBar)
            .component('UFNavBarDropdown', NavBarDropdown)
            .component('UFNavBarDropdownSeparator', NavBarDropdownSeparator)
            .component('UFNavBarItem', NavBarItem)
            .component('UFNavBarLogin', NavBarLogin)
            .component('UFNavBarUserCard', NavBarUserCard)
            .component('UFNavBarUserCardButton', NavBarUserCardButton)
            .component('UFSideBar', SideBar)
            .component('UFSideBarDropdown', SideBarDropdown)
            .component('UFSideBarItem', SideBarItem)
            .component('UFSideBarLabel', SideBarLabel)
            .component('UFSprunjeColumn', SprunjeColumn)
            .component('UFSprunjeHeader', SprunjeHeader)
            .component('UFSprunjePaginator', SprunjePaginator)
            .component('UFSprunjeTable', SprunjeTable)
    }
}

declare module 'vue' {
    export interface GlobalComponents {
        UFAlert: typeof UFAlert
        UFLabel: typeof UFLabel
        UFModal: typeof UFModal
        UFModalAlert: typeof UFModalAlert
        UFModalConfirmation: typeof UFModalConfirmation
        UFModalPrompt: typeof UFModalPrompt
        UFAppLink: typeof AppLink
        UFInfoBox: typeof InfoBox
        UFCardBox: typeof CardBox
        UFCardBoxBig: typeof CardBoxBig
        UFMainContent: typeof MainContent
        UFHeaderPage: typeof HeaderPage
        UFFooterContent: typeof FooterContent
        UFFormLogin: typeof FormLogin
        UFFormRegister: typeof FormRegister
        UFFormForgotPassword: typeof FormForgotPassword
        UFNavBar: typeof NavBar
        UFNavBarDropdown: typeof NavBarDropdown
        UFNavBarDropdownSeparator: typeof NavBarDropdownSeparator
        UFNavBarLogin: typeof NavBarLogin
        UFNavBarItem: typeof NavBarItem
        UFNavBarUserCard: typeof NavBarUserCard
        UFNavBarUserCardButton: typeof NavBarUserCardButton
        UFSideBar: typeof SideBar
        UFSideBarDropdown: typeof SideBarDropdown
        UFSideBarItem: typeof SideBarItem
        UFSideBarLabel: typeof SideBarLabel
        UFSprunjeColumn: typeof SprunjeColumn
        UFSprunjeHeader: typeof SprunjeHeader
        UFSprunjePaginator: typeof SprunjePaginator
        UFSprunjeTable: typeof SprunjeTable
    }
}
