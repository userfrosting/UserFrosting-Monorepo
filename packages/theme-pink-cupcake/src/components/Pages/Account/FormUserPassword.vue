<script setup lang="ts">
import { ref } from 'vue'
import UIkit from 'uikit'
import { useUserPasswordEditApi } from '@userfrosting/sprinkle-account/composables'
import { useAuthStore } from '@userfrosting/sprinkle-account/stores'
import type { PasswordEditRequest } from '@userfrosting/sprinkle-account/interfaces'

/**
 * Variables
 */
const { check } = useAuthStore()
const formData = ref<PasswordEditRequest>({
    passwordcheck: '',
    password: '',
    passwordc: ''
})

/**
 * API - Use the password edit API.
 */
const { submitPasswordEdit } = useUserPasswordEditApi()

/**
 * Methods - Submit the form to the API and handle the response.
 */
const submitForm = () => {
    submitPasswordEdit(formData.value)
        .then((response) => {
            // Display a success notification
            UIkit.notification({
                message: response.message,
                status: 'success',
                pos: 'top-right',
                timeout: 4000
            })

            // Reset form data
            formData.value = {
                passwordcheck: '',
                password: '',
                passwordc: ''
            }

            // Refresh the user - In case we need to relogin
            check()
        })
        .catch((error) => {
            // Display an error notification
            UIkit.notification({
                message: error.description ?? 'An error occurred.',
                status: 'danger',
                pos: 'top-right',
                timeout: 4000
            })
        })
}
</script>

<template>
    <form v-on:submit.prevent="submitForm()">
        <fieldset class="uk-fieldset uk-form-stacked">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">New Password</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="key" fixed-width />
                    <input
                        class="uk-input"
                        type="password"
                        placeholder="New Password"
                        aria-label="Password"
                        data-test="password"
                        autofocus
                        tabindex="1"
                        autocomplete="false"
                        v-model="formData.password" />
                </div>
                <!-- {{translate('PASSWORD.BETWEEN', {min: site.password.length.min, max: site.password.length.max})}} -->
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Confirm New Password</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="key" fixed-width />
                    <input
                        class="uk-input"
                        type="password"
                        placeholder="Confirm Password"
                        aria-label="Confirm Password"
                        data-test="passwordc"
                        tabindex="2"
                        v-model="formData.passwordc" />
                </div>
            </div>

            <hr />

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Current Password</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="key" fixed-width />
                    <input
                        class="uk-input"
                        type="password"
                        placeholder="Current Password"
                        aria-label="Current Password"
                        data-test="passwordcheck"
                        tabindex="3"
                        v-model="formData.passwordcheck" />
                </div>
            </div>

            <div class="uk-text-center" uk-margin>
                <button class="uk-button uk-button-primary" type="submit" tabindex="4">Save</button>
            </div>
        </fieldset>
    </form>
</template>
