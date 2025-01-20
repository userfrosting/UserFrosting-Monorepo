<script setup lang="ts">
import type { UserPasswordRequest } from '@userfrosting/sprinkle-admin/interfaces'

/**
 * Form Model
 */
const formData = defineModel<UserPasswordRequest>({
    default: {
        password: '',
        passwordc: ''
    }
})

/**
 * Emits
 */
const emits = defineEmits(['submit'])
</script>
<template>
    <form v-on:submit.prevent="emits('submit')">
        <!-- Prevent browsers from trying to autofill the password field.  See http://stackoverflow.com/a/23234498/2970321 -->
        <input type="text" style="display: none" />
        <input type="password" style="display: none" />

        <fieldset class="uk-fieldset uk-form-stacked">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">Password</label>
                <div class="uk-inline uk-width-1-1">
                    <font-awesome-icon class="fa-form-icon" icon="key" fixed-width />
                    <input
                        class="uk-input"
                        type="password"
                        placeholder="Password"
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
                <label class="uk-form-label" for="form-stacked-text">Confirm Password</label>
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

            <div class="uk-text-right" uk-margin>
                <button class="uk-button uk-button-default uk-modal-close" type="button">
                    Cancel
                </button>
                <button class="uk-button uk-button-primary" type="submit" tabindex="3">Save</button>
            </div>
        </fieldset>
    </form>
</template>
