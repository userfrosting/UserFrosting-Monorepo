<script setup lang="ts">
import FormRegister from '../components/Content/FormRegister.vue'
</script>

<template>
    <UFCardBoxBig>
        <h3 class="uk-card-title">Register</h3>
        <FormRegister />
        <hr />
        <div class="uk-text-center">
            <p>Already have an account ?</p>
            <button
                class="uk-button uk-button-default"
                @click="$emit('gotoLogin')"
                data-test="gotoLogin">
                <font-awesome-icon :icon="['fas', 'right-to-bracket']" /> Login
            </button>
        </div>
    </UFCardBoxBig>
</template>
