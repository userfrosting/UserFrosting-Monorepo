<script setup lang="ts">
import { useRouter } from 'vue-router'
import type { GroupResponse } from '@userfrosting/sprinkle-admin/interfaces'
import GroupEditModal from './GroupEditModal.vue'
import GroupDeleteModal from './GroupDeleteModal.vue'

const router = useRouter()
const { group } = defineProps<{
    group: GroupResponse
}>()

const emits = defineEmits(['groupUpdated'])
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
            <dt><font-awesome-icon icon="users" /> {{ $t('USER', group.users_count) }}</dt>
            <dd>
                <span class="uk-badge">{{ group.users_count }}</span>
            </dd>
        </dl>
        <hr />
        <GroupEditModal
            :group="group"
            @saved="emits('groupUpdated')"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-primary uk-button-small" />
        <GroupDeleteModal
            :group="group"
            @deleted="router.push({ name: 'admin.groups' })"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-danger uk-button-small" />
        <slot data-test="slot"></slot>
    </UFCardBox>
</template>
