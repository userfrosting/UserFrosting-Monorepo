import { expect, test, describe } from 'vitest'
import { mount, config } from '@vue/test-utils'
import PageLogin from '../../views/PageLogin.vue'
import CardBoxBig from '../../components/Content/CardBoxBig.vue'
import CardBox from '../../components/Content/CardBox.vue'
import UFAlert from '../../components/UFAlert.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// Register font-awesome-icon component
library.add(fas)
config.global.stubs['FontAwesomeIcon'] = FontAwesomeIcon

// Register global components
config.global.components['UFCardBoxBig'] = CardBoxBig
config.global.components['UFCardBox'] = CardBox
config.global.components['UFAlert'] = UFAlert

describe('PageLogin.vue', () => {
    test('Render correctly', () => {
        const wrapper = mount(PageLogin)
        expect(wrapper.exists()).toBe(true)
    })

    test('Emits gotoForgotPassword event', async () => {
        const wrapper = mount(PageLogin)
        await wrapper.find('[data-test="gotoForgotPassword"]').trigger('click')
        expect(wrapper.emitted('gotoForgotPassword')).toBeTruthy()
    })

    test('Emits gotoResendVerification event', async () => {
        const wrapper = mount(PageLogin)
        await wrapper.find('[data-test="gotoResendVerification"]').trigger('click')
        expect(wrapper.emitted('gotoResendVerification')).toBeTruthy()
    })

    test('Emits gotoRegistration event', async () => {
        const wrapper = mount(PageLogin)
        await wrapper.find('[data-test="gotoRegistration"]').trigger('click')
        expect(wrapper.emitted('gotoRegistration')).toBeTruthy()
    })
})
