<script setup lang="ts">
import { useLoginApi } from '@userfrosting/sprinkle-account/api'
import { useAuthStore } from '@userfrosting/sprinkle-account/stores'
import type { LoginForm } from '@userfrosting/sprinkle-account/types'

// Form variables
let form: LoginForm = {
    user_name: '',
    password: ''
}

// Login API variables
const auth = useAuthStore()
const { loading, error, login } = useLoginApi(auth)
</script>

<template>
    <UFCardBox title="Login">
        <form class="uk-form-horizontal" uk-margin>
            <UFAlertContainer v-if="error" :alert="error" />
            <div>
                <label class="uk-form-label" for="form-horizontal-username">Username</label>
                <div class="uk-form-controls">
                    <input
                        class="uk-input"
                        id="form-horizontal-username"
                        type="text"
                        v-model="form.user_name" />
                </div>
            </div>
            <div>
                <label class="uk-form-label" for="form-horizontal-password">Password</label>
                <div class="uk-form-controls">
                    <input
                        class="uk-input"
                        id="form-horizontal-password"
                        type="password"
                        v-model="form.password" />
                </div>
            </div>
            <div class="uk-text-center">
                <font-awesome-icon icon="fa-solid fa-spinner" spin v-if="loading" />
                <button
                    class="uk-button uk-button-primary"
                    @click="login(form)"
                    :disabled="loading">
                    Login
                </button>
            </div>
        </form>
    </UFCardBox>
</template>
