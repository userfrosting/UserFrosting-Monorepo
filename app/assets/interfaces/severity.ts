/**
 * Severity Enum
 *
 * This is a shared enum used to define the severity of different components
 * (e.g., alert, button, etc.). This makes it easier to reference severity
 * levels across multiple components, also defining a common concept across
 * themes.
 *
 * Template components must accept all values of this enum as valid input.
 * However, themes may choose to ignore or bind some values to another style.
 * For example, a theme might not have an 'Info' colored button. In this case,
 * the theme's button component must accept 'Info' as a valid input, but it can
 * map it to the 'Primary' style.
 */
export enum Severity {
    Primary = 'Primary',
    Secondary = 'Secondary',
    Success = 'Success',
    Warning = 'Warning',
    Danger = 'Danger',
    Info = 'Info',
    Muted = 'Muted', // Aka, Disabled
    Default = 'Default' // No-style or default style
}
