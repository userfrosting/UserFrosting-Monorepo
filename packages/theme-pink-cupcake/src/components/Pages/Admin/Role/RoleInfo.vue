<script setup lang="ts">
import { defineProps, defineEmits } from 'vue'
import { useRouter } from 'vue-router'
import type { RoleResponse } from '@userfrosting/sprinkle-admin/interfaces'
import RoleEditModal from './RoleEditModal.vue'
import RoleDeleteModal from './RoleDeleteModal.vue'

const router = useRouter()
const { role } = defineProps<{
    role: RoleResponse
}>()

const emits = defineEmits(['updated'])
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
        <RoleEditModal
            :role="role"
            @saved="emits('updated')"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-primary uk-button-small" />
        <RoleDeleteModal
            :role="role"
            @deleted="router.push({ name: 'admin.roles' })"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-danger uk-button-small" />
        <slot data-test="slot"></slot>
    </UFCardBox>
</template>
