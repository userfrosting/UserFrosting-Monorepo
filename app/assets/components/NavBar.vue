<script setup>
import { useAuthStore } from '@userfrosting/sprinkle-account/stores'

// Logout API variables
const auth = useAuthStore()
</script>

<template>
    <UFNavBar title="Userfrosting">
        <UFNavBarItem :to="{ name: 'home' }" label="Home" />
        <UFNavBarItem :to="{ name: 'about' }" label="About" />
        <UFNavBarItem :to="{ name: 'auth' }" label="Auth" />
        <UFNavBarLogin v-if="!auth.isAuthenticated" />
        <UFNavBarUserCard
            v-if="auth.isAuthenticated"
            :username="auth.user.full_name"
            :avatar="auth.user.avatar"
            :meta="auth.user.user_name">
            <UFNavBarUserCardButton label="Logout" @click="auth.logout()" />
        </UFNavBarUserCard>
    </UFNavBar>
</template>
