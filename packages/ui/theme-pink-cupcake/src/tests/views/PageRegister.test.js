import { expect, test, describe } from 'vitest'
import { mount, config } from '@vue/test-utils'
import PageRegister from '../../views/PageRegister.vue'
import CardBoxBig from '../../components/Content/CardBoxBig.vue'
import CardBox from '../../components/Content/CardBox.vue'
import UFAlert from '../../components/UFAlert.vue'

// Register global components
config.global.components['UFCardBoxBig'] = CardBoxBig
config.global.components['UFCardBox'] = CardBox
config.global.components['UFAlert'] = UFAlert

// Mock FormRegister & FontAwesomeIcon
config.global.stubs['FontAwesomeIcon'] = { template: '<span></span>' }
config.global.stubs['FormRegister'] = { template: '<span></span>' }

describe('PageRegister.vue', () => {
    test('Render correctly', () => {
        const wrapper = mount(PageRegister)
        expect(wrapper.exists()).toBe(true)
    })

    test('Emits gotoLogin event', async () => {
        const wrapper = mount(PageRegister)
        await wrapper.find('[data-test="gotoLogin"]').trigger('click')
        expect(wrapper.emitted('gotoLogin')).toBeTruthy()
    })
})
