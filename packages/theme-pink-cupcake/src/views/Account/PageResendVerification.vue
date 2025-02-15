<script setup lang="ts">
import FormResendVerification from '../../components/Pages/Account/FormResendVerification.vue'
</script>

<template>
    <UFCardBoxBig>
        <h3 class="uk-card-title">{{ $t('ACCOUNT.VERIFICATION.RESEND') }}</h3>
        <p>{{ $t('ACCOUNT.VERIFICATION.EMAIL') }}</p>
        <FormResendVerification />
    </UFCardBoxBig>
</template>
