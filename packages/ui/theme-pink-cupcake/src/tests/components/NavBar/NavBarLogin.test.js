import { expect, test, describe } from 'vitest'
import { mount, config } from '@vue/test-utils'
import NavBarLogin from '../../../components/NavBar/NavBarLogin.vue'

config.global.stubs['FormLogin'] = { template: '<span></span>' }

describe('NavBarLogin.vue', () => {
    test('Render correctly', () => {
        const wrapper = mount(NavBarLogin)
        expect(wrapper.exists()).toBe(true)
    })
})
