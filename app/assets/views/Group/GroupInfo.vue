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

        <div uk-grid>
            <div class="uk-width-auto@m">
                <strong><font-awesome-icon icon="users" /> Users</strong>
            </div>
            <div class="uk-width-expand@m uk-text-right">
                <span class="uk-badge">{{ group.users_count }}</span>
            </div>
        </div>
        <!-- TODO : Edit Btn -->
        <!-- TODO : DElete Btn -->
    </UFCardBox>
</template>
