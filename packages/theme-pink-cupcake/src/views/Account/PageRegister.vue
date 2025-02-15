<script setup lang="ts">
import FormRegister from '../../components/Pages/Account/FormRegister.vue'
</script>

<template>
    <UFCardBoxBig>
        <h3 class="uk-card-title">{{ $t('REGISTER') }}</h3>
        <FormRegister />
        <hr />
        <div class="uk-text-center">
            <p>{{ $t('ACCOUNT.HAVE_ONE') }}</p>
            <button
                class="uk-button uk-button-default"
                @click="$emit('gotoLogin')"
                data-test="gotoLogin">
                <font-awesome-icon :icon="['fas', 'right-to-bracket']" /> {{ $t('LOGIN') }}
            </button>
        </div>
    </UFCardBoxBig>
</template>
