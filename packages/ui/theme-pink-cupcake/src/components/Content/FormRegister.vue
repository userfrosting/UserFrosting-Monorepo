<script setup lang="ts">
import { ref } from 'vue'
import UIkit from 'uikit'
import type { AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import { Register } from '@userfrosting/sprinkle-account/composables'
import type { UserInterface, RegisterForm } from '@userfrosting/sprinkle-account/interfaces'

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
</script>

<template>
    <form v-on:submit.prevent="submitForm()">
        <fieldset class="uk-fieldset uk-form-stacked">
            <UFAlert data-test="error" v-if="error" :alert="error" />

            <div class="uk-margin">
                <label class="uk-form-label" for="first_name">Name and email</label>
                <div class="uk-form-controls uk-grid-small" uk-grid>
                    <div class="uk-width-1-2">
                        <input
                            class="uk-input"
                            type="text"
                            placeholder="First Name"
                            aria-label="First Name"
                            id="first_name"
                            data-test="first_name"
                            v-model="form.first_name" />
                    </div>
                    <div class="uk-width-1-2">
                        <input
                            class="uk-input"
                            type="text"
                            placeholder="Last Name"
                            aria-label="Last Name"
                            data-test="last_name"
                            v-model="form.last_name" />
                    </div>
                    <div class="uk-width-1-1">
                        <input
                            class="uk-input"
                            type="email"
                            placeholder="Email"
                            aria-label="Email"
                            data-test="email"
                            v-model="form.email" />
                        <!-- {% if site.registration.require_email_verification %}{{translate('EMAIL.VERIFICATION_REQUIRED')}}{% else %}{{translate('EMAIL.YOUR')}}{% endif %} -->
                    </div>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Username</label>
                <!-- <span class="pull-right"><a href="#" id="form-register-username-suggest">[{{translate('SUGGEST')}}]</a></span> -->
                <input
                    class="uk-input"
                    type="text"
                    placeholder="Username"
                    aria-label="Username"
                    data-test="username"
                    v-model="form.user_name" />
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Password</label>
                <div class="uk-form-controls uk-grid-small" uk-grid>
                    <div class="uk-width-1-2">
                        <input
                            class="uk-input"
                            type="password"
                            placeholder="Password"
                            aria-label="Password"
                            data-test="password"
                            v-model="form.password" />
                    </div>
                    <div class="uk-width-1-2">
                        <input
                            class="uk-input"
                            type="password"
                            placeholder="Confirm Password"
                            aria-label="Confirm Password"
                            data-test="passwordc"
                            v-model="form.passwordc" />
                    </div>
                    <!-- {{translate('PASSWORD.BETWEEN', {min: site.password.length.min, max: site.password.length.max})}} -->
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Locale</label>
                <select
                    class="uk-select"
                    id="form-stacked-select"
                    data-test="locale"
                    v-model="form.locale">
                    <option v-for="(value, key) in getAvailableLocales()" :value="key" :key="key">
                        {{ value }}
                    </option>
                </select>
                <!-- <p class="help-block">{{translate("LOCALE.ACCOUNT")}}.</p> -->
            </div>

            <!-- {% if site.registration.captcha %} -->
            <div class="uk-margin">
                <label class="uk-form-label" for="r-form-captcha">Captcha</label>
                <div class="uk-form-controls uk-grid-small" uk-grid>
                    <div class="uk-width-2-3">
                        <input
                            class="uk-input"
                            type="password"
                            placeholder="Captcha"
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

            <p>
                By registering an account with UserFrosting, you accept
                <a>the terms and conditions</a>.
            </p>

            <div class="uk-text-center">
                <button class="uk-button uk-button-primary" :disabled="loading">Sign me up</button>
            </div>
        </fieldset>
    </form>
</template>
