<script setup lang="ts">
import FormForgotPassword from '../../components/Pages/Account/FormForgotPassword.vue'
</script>

<template>
    <UFCardBoxBig>
        <h3 class="uk-card-title">{{ $t('PASSWORD.FORGOTTEN') }}</h3>
        <p>{{ $t('PASSWORD.FORGET.EMAIL') }}</p>
        <FormForgotPassword />
    </UFCardBoxBig>
</template>
