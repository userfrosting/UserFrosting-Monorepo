<script setup>
import { useLogoutApi } from '@userfrosting/sprinkle-account/api'
import { useAuthStore } from '@userfrosting/sprinkle-account/stores'

// Logout API variables
const auth = useAuthStore()
const { loading, logout } = useLogoutApi(auth)
</script>

<template>
    <div class="uk-margin uk-text-center">
        <button class="uk-button uk-button-default" @click="logout()" :disabled="loading">
            Logout
        </button>
    </div>
</template>
