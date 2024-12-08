<script setup lang="ts">
import { useRouter } from 'vue-router'
const router = useRouter()
</script>

<template>
    <UFPageLogin
        @goto-registration="router.push({ name: 'account.register' })"
        @goto-forgot-password="router.push({ name: 'account.forgot-password' })"
        @goto-resend-verification="router.push({ name: 'account.resend-verification' })" />
</template>
