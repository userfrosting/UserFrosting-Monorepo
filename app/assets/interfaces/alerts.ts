/**
 * Alert Interface
 *
 * Represents a common interface for alert components. This interface is used by
 * API when an error occurs or a successful event occurs, and consumed by the
 * interface.
 */
import { Severity } from './severity'

export interface AlertInterface {
    title?: string
    description?: string
    style?: Severity | keyof typeof Severity
    closeBtn?: boolean
    hideIcon?: boolean
}
