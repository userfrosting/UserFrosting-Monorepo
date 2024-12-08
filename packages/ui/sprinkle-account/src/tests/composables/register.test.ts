import { afterEach, describe, expect, test, vi } from 'vitest'
import axios from 'axios'
import type { UserInterface } from 'src/interfaces'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'
import { useConfigStore } from '@userfrosting/sprinkle-core/stores'
import type { RegisterForm } from '../../interfaces'
import { Register } from '../../composables'

const { getDefaultForm, doRegister, getAvailableLocales, getCaptchaUrl } = Register

const testUser: UserInterface = {
    id: 1,
    user_name: 'JohnDoe',
    first_name: 'John',
    last_name: 'Doe',
    full_name: 'John Doe',
    email: 'john.doe@example.com',
    avatar: '',
    flag_enabled: true,
    flag_verified: true,
    group_id: null,
    locale: 'en_US',
    created_at: '',
    updated_at: '',
    deleted_at: null
}

const form: RegisterForm = {
    first_name: 'John',
    last_name: 'Doe',
    email: 'john.doe@example.com',
    user_name: 'JohnDoe',
    password: 'password',
    passwordc: 'password',
    locale: 'en_US',
    captcha: 'captcha',
    spiderbro: 'http://'
}

// Mock the config store
vi.mock('@userfrosting/sprinkle-core/stores')
const mockUseConfigStore = {
    get: vi.fn()
}

describe('register', () => {
    afterEach(() => {
        vi.clearAllMocks()
        vi.resetAllMocks()
    })

    test('should return default form', () => {
        // Arrange
        mockUseConfigStore.get.mockReturnValue('fr_CA')
        vi.mocked(useConfigStore).mockReturnValue(mockUseConfigStore as any)

        // Act
        const result = getDefaultForm()

        // Assert
        expect(useConfigStore).toHaveBeenCalled()
        expect(mockUseConfigStore.get).toHaveBeenCalledWith(
            'site.registration.user_defaults.locale',
            'en_US'
        )
        expect(result).toEqual({
            first_name: '',
            last_name: '',
            email: '',
            user_name: '',
            password: '',
            passwordc: '',
            locale: 'fr_CA',
            captcha: '',
            spiderbro: 'http://'
        })
    })

    test('should return available locales', () => {
        // Arrange
        const locales = ['en_US', 'fr_FR', 'es_ES']
        mockUseConfigStore.get.mockReturnValue(locales)
        vi.mocked(useConfigStore).mockReturnValue(mockUseConfigStore as any)

        // Act
        const result = getAvailableLocales()

        // Assert
        expect(useConfigStore).toHaveBeenCalled()
        expect(mockUseConfigStore.get).toHaveBeenCalledWith('locales.available')
        expect(result).toEqual(locales)
    })

    test('should return captcha URL', () => {
        expect(getCaptchaUrl()).toBe('/account/captcha')
    })

    test('should register successfully', async () => {
        // Arrange
        const response = { data: testUser }
        vi.spyOn(axios, 'post').mockResolvedValue(response as any)

        // Act
        const result = await doRegister(form)

        // Assert
        expect(axios.post).toHaveBeenCalledWith('/account/register', form)
        expect(result).toStrictEqual(testUser)
    })

    test('should throw an error when registration fails', async () => {
        // Arrange
        const error = { response: { data: { description: 'Registration failed' } } }
        vi.spyOn(axios, 'post').mockRejectedValue(error as any)

        // Act & Assert
        await expect(doRegister(form)).rejects.toEqual({
            description: 'Registration failed',
            style: Severity.Danger,
            closeBtn: true
        })
        expect(axios.post).toHaveBeenCalledWith('/account/register', form)
    })
})
