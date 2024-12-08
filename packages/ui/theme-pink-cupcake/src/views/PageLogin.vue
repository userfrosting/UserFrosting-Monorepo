<script setup lang="ts">
import FormLogin from '../components/Content/FormLogin.vue'
</script>

<template>
    <UFCardBoxBig>
        <h3 class="uk-card-title">Login</h3>
        <FormLogin />
        <ul class="uk-list">
            <li>
                <a @click="$emit('gotoForgotPassword')" data-test="gotoForgotPassword"
                    >Forgot your password?</a
                >
            </li>
            <li>
                <a @click="$emit('gotoResendVerification')" data-test="gotoResendVerification"
                    >Resend verification email</a
                >
            </li>
        </ul>
        <hr />
        <div class="uk-text-center">
            <p>You don't have an account yet?</p>
            <button
                class="uk-button uk-button-default"
                @click="$emit('gotoRegistration')"
                data-test="gotoRegistration">
                <font-awesome-icon :icon="['fas', 'user-plus']" /> Register
            </button>
        </div>
    </UFCardBoxBig>
</template>
