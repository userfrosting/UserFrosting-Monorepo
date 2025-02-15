<script setup lang="ts">
import { ref } from 'vue'
import type { AlertInterface } from '@userfrosting/sprinkle-core/interfaces'
import { forgotPassword } from '@userfrosting/sprinkle-account/composables'

// Variables
const loading = ref(false)
const alert = ref<AlertInterface | null>()
let email: String = ''

// Form action
async function sendForm() {
    loading.value = true
    alert.value = null
    await forgotPassword(email)
        .then((success) => {
            alert.value = success
        })
        .catch((err) => {
            alert.value = err
        })
        .finally(() => {
            loading.value = false
        })
}
</script>

<template>
    <form v-on:submit.prevent="sendForm()">
        <fieldset class="uk-fieldset">
            <UFAlert data-test="error" v-if="alert" :alert="alert" />
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon" uk-icon="icon: mail"></span>
                    <input
                        class="uk-input"
                        type="email"
                        :placeholder="$t('EMAIL')"
                        aria-label="Email"
                        data-test="email"
                        v-model="email" />
                </div>
            </div>
            <div class="uk-text-center">
                <button class="uk-button uk-button-primary" :disabled="loading" data-test="submit">
                    {{ $t('PASSWORD.FORGET.EMAIL_SEND') }}
                </button>
            </div>
        </fieldset>
    </form>
</template>
