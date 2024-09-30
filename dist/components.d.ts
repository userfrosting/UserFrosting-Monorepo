import { App } from 'vue';
import { default as AlertContainer } from './components/AlertContainer.vue';
import { default as AppLink } from './components/Content/AppLink.vue';
import { default as InfoBox } from './components/Content/InfoBox.vue';
import { default as CardBox } from './components/Content/CardBox.vue';
import { default as CardBoxBig } from './components/Content/CardBoxBig.vue';
import { default as MainContent } from './components/Content/MainContent.vue';
import { default as HeaderPage } from './components/Content/HeaderPage.vue';
import { default as FooterContent } from './components/Content/FooterContent.vue';
import { default as FormLogin } from './components/Content/FormLogin.vue';
import { default as FormRegister } from './components/Content/FormRegister.vue';
import { default as FormForgotPassword } from './components/Content/FormForgotPassword.vue';
import { default as NavBar } from './components/NavBar/NavBar.vue';
import { default as NavBarDropdown } from './components/NavBar/NavBarDropdown.vue';
import { default as NavBarDropdownSeparator } from './components/NavBar/NavBarDropdownSeparator.vue';
import { default as NavBarItem } from './components/NavBar/NavBarItem.vue';
import { default as NavBarLogin } from './components/NavBar/NavBarLogin.vue';
import { default as NavBarUserCard } from './components/NavBar/NavBarUserCard.vue';
import { default as NavBarUserCardButton } from './components/NavBar/NavBarUserCardButton.vue';
import { default as PageLogin } from './views/PageLogin.vue';
import { default as PageRegister } from './views/PageRegister.vue';
import { default as PageForgotPassword } from './views/PageForgotPassword.vue';
import { default as PageResendVerification } from './views/PageResendVerification.vue';
import { default as SideBar } from './components/SideBar/SideBar.vue';
import { default as SideBarDropdown } from './components/SideBar/SideBarDropdown.vue';
import { default as SideBarItem } from './components/SideBar/SideBarItem.vue';
import { default as SideBarLabel } from './components/SideBar/SideBarLabel.vue';
export { AlertContainer, AppLink, InfoBox, CardBox, CardBoxBig, MainContent, HeaderPage, FooterContent, FormLogin, FormRegister, FormForgotPassword, NavBar, NavBarDropdown, NavBarDropdownSeparator, NavBarItem, NavBarLogin, NavBarUserCard, NavBarUserCardButton, PageLogin, PageRegister, PageForgotPassword, PageResendVerification, SideBar, SideBarDropdown, SideBarItem, SideBarLabel };
declare const _default: {
    install: (app: App) => void;
};
export default _default;
declare module 'vue' {
    interface GlobalComponents {
        UFAlertContainer: typeof AlertContainer;
        UFAppLink: typeof AppLink;
        UFInfoBox: typeof InfoBox;
        UFCardBox: typeof CardBox;
        UFCardBoxBig: typeof CardBoxBig;
        UFMainContent: typeof MainContent;
        UFHeaderPage: typeof HeaderPage;
        UFFooterContent: typeof FooterContent;
        UFFormLogin: typeof FormLogin;
        UFFormRegister: typeof FormRegister;
        UFFormForgotPassword: typeof FormForgotPassword;
        UFNavBar: typeof NavBar;
        UFNavBarDropdown: typeof NavBarDropdown;
        UFNavBarDropdownSeparator: typeof NavBarDropdownSeparator;
        UFNavBarLogin: typeof NavBarLogin;
        UFNavBarItem: typeof NavBarItem;
        UFNavBarUserCard: typeof NavBarUserCard;
        UFNavBarUserCardButton: typeof NavBarUserCardButton;
        UFPageLogin: typeof PageLogin;
        UFPageRegister: typeof PageRegister;
        UFPageForgotPassword: typeof PageForgotPassword;
        UFPageResendVerification: typeof PageResendVerification;
        UFSideBar: typeof SideBar;
        UFSideBarDropdown: typeof SideBarDropdown;
        UFSideBarItem: typeof SideBarItem;
        UFSideBarLabel: typeof SideBarLabel;
    }
}
