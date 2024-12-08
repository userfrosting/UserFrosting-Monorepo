<script setup lang="ts">
import NavBarDropdown from './NavBarDropdown.vue'
import FormLogin from '../Content/FormLogin.vue'
</script>

<template>
    <NavBarDropdown label="Login" class="uf-nav-login uk-text-center">
        <FormLogin />
        <div class="uk-text-center">
            <button
                class="uk-button uk-button-default"
                @click="$emit('gotoRegistration')"
                data-test="gotoRegistration">
                Register
            </button>
        </div>
        <slot></slot>
    </NavBarDropdown>
</template>
