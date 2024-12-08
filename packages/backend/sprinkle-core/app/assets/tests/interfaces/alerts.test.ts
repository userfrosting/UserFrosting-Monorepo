import { describe, expect, test } from 'vitest'
import { type AlertInterface, Severity } from '../../interfaces'

describe('AlertInterface', () => {
    test('should create an alert with title and description', () => {
        const alert: AlertInterface = {
            title: 'Test Alert',
            description: 'This is a test alert'
        }

        expect(alert.title).toBe('Test Alert')
        expect(alert.description).toBe('This is a test alert')
    })

    test('should create an alert with style', () => {
        const alert: AlertInterface = {
            style: Severity.Success
        }

        expect(alert.style).toBe(Severity.Success)
    })

    test('should create an alert with close button and hide icon', () => {
        const alert: AlertInterface = {
            closeBtn: true,
            hideIcon: true
        }

        expect(alert.closeBtn).toBe(true)
        expect(alert.hideIcon).toBe(true)
    })
})

describe('Severity', () => {
    test('should have the correct values', () => {
        expect(Severity.Primary).toBe('Primary')
        expect(Severity.Secondary).toBe('Secondary')
        expect(Severity.Success).toBe('Success')
        expect(Severity.Warning).toBe('Warning')
        expect(Severity.Danger).toBe('Danger')
        expect(Severity.Info).toBe('Info')
    })
})
