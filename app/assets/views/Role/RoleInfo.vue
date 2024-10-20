<script setup lang="ts">
import type { RoleApi } from '../../composable/role'
import { defineProps } from 'vue'

const { role } = defineProps<{
    role: RoleApi
}>()
</script>

<template>
    <UFCardBox>
        <div class="uk-text-center">
            <font-awesome-icon icon="address-card" class="fa-5x" />
        </div>
        <h3 class="uk-text-center uk-margin-remove">{{ role.name }}</h3>
        <p class="uk-text-meta">
            {{ role.description }}
        </p>
        <hr />
        <!-- TODO : Find a way to slot the description list -->
        <dl class="uk-description-list">
            <dt><font-awesome-icon icon="users" /> Users</dt>
            <dd>
                <span class="uk-badge">{{ role.users_count }}</span>
            </dd>
        </dl>
        <hr />
        <button
            class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small">
            Edit Role
        </button>
        <button
            class="uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small">
            Delete Role
        </button>
        <slot data-test="slot"></slot>
    </UFCardBox>
</template>
