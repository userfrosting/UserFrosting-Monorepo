<script setup lang="ts">
import type { GroupApi } from '../../composable/group'
import { defineProps } from 'vue'

const { group } = defineProps<{
    group: GroupApi
}>()
</script>

<template>
    <UFCardBox>
        <div class="uk-text-center">
            <font-awesome-icon v-if="group.icon" :icon="group.icon" class="fa-5x" />
        </div>
        <h3 class="uk-text-center uk-margin-remove">{{ group.name }}</h3>
        <p class="uk-text-meta">
            {{ group.description }}
        </p>
        <hr />
        <!-- TODO : Find a way to slot the description list -->
        <dl class="uk-description-list">
            <dt><font-awesome-icon icon="users" /> Users</dt>
            <dd>
                <span class="uk-badge">{{ group.users_count }}</span>
            </dd>
        </dl>
        <hr />
        <button
            class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom uk-button-small">
            Edit Group
        </button>
        <button
            class="uk-button uk-button-danger uk-width-1-1 uk-margin-small-bottom uk-button-small">
            Delete Group
        </button>
        <slot data-test="slot"></slot>
    </UFCardBox>
</template>
