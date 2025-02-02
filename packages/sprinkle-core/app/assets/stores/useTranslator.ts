/**
 * Translator composable store.
 *
 * This pinia store is used to access the translator and to use the translator.
 */
import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import type { DictionaryEntries, DictionaryResponse, DictionaryConfig } from '../interfaces'
import { DateTime } from 'luxon'

export const useTranslator = defineStore(
    'translator',
    () => {
        /**
         * Variables
         */
        const defaultPluralKey = 'plural'
        const identifier = ref<string>('')
        const dictionary = ref<DictionaryEntries>({})
        const config = ref<DictionaryConfig>({
            name: '',
            regional: '',
            authors: [],
            plural_rule: 0,
            dates: ''
        })

        /**
         * Functions
         */
        // Load the dictionary from the API
        async function load() {
            axios.get<DictionaryResponse>('/api/dictionary').then((response) => {
                identifier.value = response.data.identifier
                config.value = response.data.config
                dictionary.value = response.data.dictionary
            })
        }

        // The translate function
        function $t(key: string, placeholders: string | number | object = ''): string {
            // console.debug('Translating', key, placeholders)

            let message: string = getMessageFromKey(key, placeholders)
            // console.debug('Message', message, key, placeholders)

            message = replacePlaceholders(message, placeholders)
            // console.debug('Translated', message)

            return message
        }

        /**
         * Format a date to the user locale
         *
         * @param date The date to format, in ISO format
         * @param format The format to use. Default to `DATETIME_MED_WITH_WEEKDAY`.
         *               See the Luxon documentation for more information on formatting
         *
         * @see https://moment.github.io/luxon/#/formatting?id=presets
         * @see https://moment.github.io/luxon/#/formatting?id=table-of-tokens
         */
        function $tdate(
            date: string,
            format: string | object = DateTime.DATETIME_MED_WITH_WEEKDAY
        ): string {
            const dt = DateTime.fromISO(date).setLocale(config.value.dates)
            if (typeof format === 'object') {
                return dt.toLocaleString(format)
            } else {
                return dt.toFormat(format)
            }
        }

        /**
         * Returns the Luxon DateTime object for the given date, with the user
         * locale, so Luxon methods can be used without having to set the locale
         *
         * @param date The date to format, in ISO format
         */
        function getDateTime(date: string): DateTime {
            return DateTime.fromISO(date).setLocale(config.value.dates)
        }

        function getMessageFromKey(
            key: string,
            placeholders: string | number | Record<string, any>
        ): string {
            // Return direct match
            if (dictionary.value[key] !== undefined) {
                return dictionary.value[key]
            }

            // First, let's see if we can get the plural rules.
            // A plural form will always have priority over the `@TRANSLATION` instruction
            // We start by picking up the plural key, aka which placeholder contains the numeric value defining how many {x} we have
            const pluralKey = dictionary.value[key + '.@PLURAL'] || defaultPluralKey

            // Let's get the plural value, aka how many {x} we have
            // If no plural value was found, we fallback to `@TRANSLATION` instruction or default to 1 as a last resort
            let pluralValue: number = 1
            if (typeof placeholders === 'object' && placeholders[pluralKey] !== undefined) {
                pluralValue = Number(placeholders[pluralKey])
            } else if (typeof placeholders === 'number' || typeof placeholders === 'string') {
                pluralValue = Number(placeholders)
            } else if (dictionary.value[key + '.@TRANSLATION'] !== undefined) {
                // We have a `@TRANSLATION` instruction, return this
                return dictionary.value[key + '.@TRANSLATION']
            }

            // If placeholders is a numeric value, we transform back to an array for replacement in the main message
            if (typeof placeholders === 'number' || typeof placeholders === 'string') {
                placeholders = { [pluralKey]: pluralValue }
            }

            // At this point, we need to go deeper and find the correct plural form to use
            const pluralRuleKey = pluralValue === 0 ? 0 : pluralValue <= 1 ? '1' : '2' // TODO: Implement plural rules
            // $plural = $this->getPluralMessageKey($message, $pluralValue);

            // Only return if the plural is not null. Will happen if the message array don't follow the rules
            if (dictionary.value[key + '.' + pluralRuleKey] !== undefined) {
                return dictionary.value[key + '.' + pluralRuleKey]
            }

            // One last check... If we don't have a rule, but the $pluralValue
            // as a key does exist, we might still be able to return it
            if (dictionary.value[key + '.' + pluralValue] !== undefined) {
                return dictionary.value[key + '.' + pluralValue]
            }

            // Return @TRANSLATION match
            if (dictionary.value[key + '.@TRANSLATION'] !== undefined) {
                return dictionary.value[key + '.@TRANSLATION']
            }

            // If the message is an array, but we can't find a plural form or a "@TRANSLATION" instruction, we can't go further.
            // We can't return the array, so we'll return the key
            return key
        }

        function replacePlaceholders(
            message: string,
            placeholders: string | number | Record<string, any>
        ): string {
            // If placeholders is not an object at this point, we make it an object, using `plural` as the key
            if (typeof placeholders !== 'object') {
                placeholders = { [defaultPluralKey]: placeholders }
            }

            // Interpolate translatable placeholders values. This allows to
            // pre-translate placeholder which value starts with the `&` character
            // console.debug('Looping Placeholders', placeholders)
            for (const [name, value] of Object.entries(placeholders)) {
                // console.debug(`> ${name}: ${value}`)

                //We don't allow nested placeholders. They will return errors on the next lines
                if (typeof value !== 'string') {
                    continue
                }

                // We test if the placeholder value starts the "&" character.
                // That means we need to translate that placeholder value
                if (value.startsWith('&')) {
                    // Remove the current placeholder from the master $placeholder
                    // array, otherwise we end up in an infinite loop
                    const data = Object.fromEntries(
                        Object.entries(placeholders).filter(([k, v]) => k !== name)
                    )

                    // Translate placeholders value and place it in the main $placeholder array
                    placeholders[name] = $t(value.substring(1), data)
                }
            }

            // We check for {{&...}} strings in the resulting message.
            // While the previous loop pre-translated placeholder value, this one
            // pre-translate the message string vars
            // We use some regex magic to detect them !
            message = message.replace(/{{&(([^}]+[^a-z]))}}/g, (match, p1) => {
                return $t(p1, placeholders)
            })

            // Now it's time to replace the remaining placeholder.
            for (const [name, value] of Object.entries(placeholders)) {
                const regex = new RegExp(`{{${name}}}`, 'g')
                message = message.replace(regex, String(value))
            }

            return message
        }

        function getPluralForm(pluralValue: number): string {
            return '' // TODO
        }

        /**
         * Return store
         */
        return { dictionary, load, config, identifier, $t, $tdate, getPluralForm, getDateTime }
    },
    { persist: true }
)
