<script setup>
import AuthCheck from '../components/Auth/AuthCheck.vue'
import Login from '../components/Auth/AuthLogin.vue'
import Logout from '../components/Auth/AuthLogout.vue'
import { useAuthStore } from '@userfrosting/sprinkle-account/stores'
const auth = useAuthStore()
</script>

<template>
    <h1 class="uk-heading-divider">Authentication Test</h1>
    <div class="uk-grid-divider uk-child-width-expand@s" uk-grid>
        <div v-if="auth.isAuthenticated">
            <Logout />
        </div>
        <div v-else>
            <Login />
        </div>
        <div>
            <AuthCheck />
        </div>
    </div>
</template>
