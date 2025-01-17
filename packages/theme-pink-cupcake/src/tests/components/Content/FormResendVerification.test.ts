import { mount, config } from '@vue/test-utils'
import { describe, test, expect, vi, afterEach } from 'vitest'
import FormResendVerification from '../../../components/Pages/Account/FormResendVerification.vue'
import UFAlert from '../../../components/UFAlert.vue'
import { Severity, type AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import { resendVerification } from '@userfrosting/sprinkle-account/composables'

// Register the UFAlert component stub globally
config.global.stubs['UFAlert'] = UFAlert
config.global.stubs['FontAwesomeIcon'] = { template: '<span></span>' }

// Test email var
const email: String = 'john.doe@example.com'

// Mock composables
vi.mock('@userfrosting/sprinkle-account/composables', () => {
    return {
        resendVerification: vi.fn()
    }
})

// Mocked response
const mockedResponse: AlertInterface = {
    description: 'Mocked message',
    style: Severity.Success,
    closeBtn: true
}

describe('FormResendVerification.vue', () => {
    afterEach(() => {
        vi.clearAllMocks()
    })

    test('Renders correctly', () => {
        const wrapper = mount(FormResendVerification)
        expect(wrapper.exists()).toBe(true)
    })

    test('Handles success', async () => {
        // Arrange
        vi.mocked(resendVerification).mockResolvedValueOnce(mockedResponse)

        const wrapper = mount(FormResendVerification)
        // @ts-ignore
        wrapper.vm.email = email
        await (wrapper.vm as any).sendForm()

        expect(resendVerification).toHaveBeenCalledTimes(1)
        expect(resendVerification).toHaveBeenCalledWith(email)
        expect(wrapper.find('[data-test="error"]').exists()).toBe(true)
        expect(wrapper.get('[data-test="error"]').text()).toMatch('Mocked message')
    })

    test('Handles failure', async () => {
        // Arrange
        vi.mocked(resendVerification).mockRejectedValueOnce(mockedResponse)

        const wrapper = mount(FormResendVerification)
        // @ts-ignore
        wrapper.vm.email = email
        await (wrapper.vm as any).sendForm()

        // Spy on the authStore & UIkit notification method
        expect(resendVerification).toHaveBeenCalledTimes(1)
        expect(resendVerification).toHaveBeenCalledWith(email)
        expect(wrapper.find('[data-test="error"]').exists()).toBe(true)
        expect(wrapper.get('[data-test="error"]').text()).toMatch('Mocked message')
    })

    test('Manages loading state correctly', async () => {
        // Arrange
        vi.mocked(resendVerification).mockResolvedValueOnce(mockedResponse)

        const wrapper = mount(FormResendVerification).vm as any
        expect(wrapper.loading).toBe(false)
        wrapper.email = email
        const sendPromise = wrapper.sendForm()
        expect(wrapper.loading).toBe(true)
        await sendPromise
        expect(wrapper.loading).toBe(false)
    })

    test('Handle form using the v-model', async () => {
        // Arrange
        vi.mocked(resendVerification).mockResolvedValueOnce(mockedResponse)

        // Set forms values
        const wrapper = mount(FormResendVerification)
        wrapper.find('[data-test="email"]').setValue(email)

        // Submit form
        await wrapper.find('form').trigger('submit')

        // Spy on the authStore & UIkit notification method
        expect(resendVerification).toHaveBeenCalledTimes(1)
        expect(resendVerification).toHaveBeenCalledWith(email)
    })
})
