<script setup lang="ts">
import FormUserProfile from '../../components/Pages/Account/FormUserProfile.vue'
</script>

<template>
    <UFCardBox :title="$t('ACCOUNT.SETTINGS.PERSONAL')">
        <FormUserProfile />
    </UFCardBox>
</template>
