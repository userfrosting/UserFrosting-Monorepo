<script setup lang="ts">
import { useRouter } from 'vue-router'
const router = useRouter()
</script>

<template>
    <UFPageRegister @goto-login="router.push({ name: 'account.login' })" />
</template>
