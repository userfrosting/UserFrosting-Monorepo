<script setup lang="ts">
import { ref, computed } from 'vue'
import UIkit from 'uikit'
import type { AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import { Register } from '@userfrosting/sprinkle-account/composables'
import type { UserInterface, RegisterForm } from '@userfrosting/sprinkle-account/interfaces'
import { useConfigStore, useTranslator } from '@userfrosting/sprinkle-core/stores'

// Variables
const { getDefaultForm, doRegister, getAvailableLocales, getCaptchaUrl } = Register
const loading = ref(false)
const error = ref<AlertInterface | null>()
let form: RegisterForm = getDefaultForm()

/**
 * TODO :
 *  1. Add Username Suggest
 *  2. Check username availability
 *  3. Add password strength, other config
 */

// Form action
async function submitForm() {
    loading.value = true
    error.value = null
    await doRegister(form)
        .then((user: UserInterface) => {
            // TODO : The notification message should be from the API since
            // there's two type of message.
            UIkit.notification({
                message: 'Succesfully registered ' + user?.full_name + '!',
                status: 'success',
                pos: 'top-right',
                timeout: 4000
            })
        })
        .catch((err: AlertInterface) => {
            error.value = err
        })
        .finally(() => {
            loading.value = false
        })
}

const tos = computed(() => {
    const config = useConfigStore()
    const { translate } = useTranslator()
    return translate('TOS_AGREEMENT', {
        site_title: config.get('site.title'),
        link_attributes: '' // TODO
    })
})
</script>

<template>
    <form v-on:submit.prevent="submitForm()">
        <fieldset class="uk-fieldset uk-form-stacked">
            <UFAlert data-test="error" v-if="error" :alert="error" />

            <div class="uk-margin">
                <label class="uk-form-label" for="first_name">{{ $t('NAME_AND_EMAIL') }}</label>
                <div class="uk-form-controls uk-grid-small" uk-grid>
                    <div class="uk-width-1-2">
                        <input
                            class="uk-input"
                            type="text"
                            :placeholder="$t('FIRST_NAME')"
                            aria-label="First Name"
                            id="first_name"
                            data-test="first_name"
                            v-model="form.first_name" />
                    </div>
                    <div class="uk-width-1-2">
                        <input
                            class="uk-input"
                            type="text"
                            :placeholder="$t('LAST_NAME')"
                            aria-label="Last Name"
                            data-test="last_name"
                            v-model="form.last_name" />
                    </div>
                    <div class="uk-width-1-1">
                        <input
                            class="uk-input"
                            type="email"
                            :placeholder="$t('EMAIL')"
                            aria-label="Email"
                            data-test="email"
                            v-model="form.email" />
                        <!-- TODO -->
                        <!-- {% if site.registration.require_email_verification %}{{ $t('EMAIL.VERIFICATION_REQUIRED') }}{% else %}{{ $t('EMAIL.YOUR') }}{% endif %} -->
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">{{ $t('USERNAME') }}</label>
                <!-- TODO -->
                <!-- <span class="pull-right"><a href="#" id="form-register-username-suggest">[{{translate('SUGGEST')}}]</a></span> -->
                <input
                    class="uk-input"
                    type="text"
                    :placeholder="$t('USERNAME')"
                    aria-label="Username"
                    data-test="username"
                    v-model="form.user_name" />
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">{{ $t('PASSWORD') }}</label>
                <div class="uk-form-controls uk-grid-small" uk-grid>
                    <div class="uk-width-1-2">
                        <input
                            class="uk-input"
                            type="password"
                            :placeholder="$t('PASSWORD')"
                            aria-label="Password"
                            data-test="password"
                            v-model="form.password" />
                    </div>
                    <div class="uk-width-1-2">
                        <input
                            class="uk-input"
                            type="password"
                            :placeholder="$t('PASSWORD.CONFIRM')"
                            aria-label="Confirm Password"
                            data-test="passwordc"
                            v-model="form.passwordc" />
                    </div>
                    <!-- TODO -->
                    <!-- {{translate('PASSWORD.BETWEEN', {min: site.password.length.min, max: site.password.length.max})}} -->
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">{{ $t('LOCALE') }}</label>
                <span class="uk-text-meta">{{ $t('LOCALE.ACCOUNT') }}.</span>
                <select
                    class="uk-select"
                    id="form-stacked-select"
                    data-test="locale"
                    v-model="form.locale">
                    <option v-for="(value, key) in getAvailableLocales()" :value="key" :key="key">
                        {{ value }}
                    </option>
                </select>
            </div>

            <!-- {% if site.registration.captcha %} -->
            <div class="uk-margin">
                <label class="uk-form-label" for="r-form-captcha">{{ $t('CAPTCHA.VERIFY') }}</label>
                <div class="uk-form-controls uk-grid-small" uk-grid>
                    <div class="uk-width-2-3">
                        <input
                            class="uk-input"
                            type="password"
                            :placeholder="$t('CAPTCHA.SPECIFY')"
                            aria-label="Captcha"
                            id="r-form-captcha"
                            data-test="captcha"
                            v-model="form.captcha" />
                    </div>
                    <div class="uk-width-1-3">
                        <img :src="getCaptchaUrl()" id="captcha" data-target="#r-form-captcha" />
                    </div>
                </div>
            </div>
            <!-- {% endif %} -->

            <!-- TODO Add TOS in modal -->
            <p v-html="tos"></p>

            <div class="uk-text-center">
                <button class="uk-button uk-button-primary" :disabled="loading">
                    {{ $t('REGISTER_ME') }}
                </button>
            </div>
        </fieldset>
    </form>
</template>
