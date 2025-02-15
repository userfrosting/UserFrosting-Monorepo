<script setup lang="ts">
import FormLogin from '../../components/Pages/Account/FormLogin.vue'
</script>

<template>
    <UFCardBoxBig>
        <h3 class="uk-card-title">{{ $t('LOGIN') }}</h3>
        <FormLogin />
        <ul class="uk-list">
            <li>
                <a @click="$emit('gotoForgotPassword')" data-test="gotoForgotPassword">
                    {{ $t('PASSWORD.FORGET') }}
                </a>
            </li>
            <li>
                <a @click="$emit('gotoResendVerification')" data-test="gotoResendVerification">
                    {{ $t('ACCOUNT.VERIFICATION.RESEND') }}
                </a>
            </li>
        </ul>
        <hr />
        <div class="uk-text-center">
            <p>{{ $t('REGISTRATION.QUESTION') }}</p>
            <button
                class="uk-button uk-button-default"
                @click="$emit('gotoRegistration')"
                data-test="gotoRegistration">
                <font-awesome-icon :icon="['fas', 'user-plus']" /> {{ $t('REGISTER') }}
            </button>
        </div>
    </UFCardBoxBig>
</template>
