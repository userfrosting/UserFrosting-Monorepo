<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useTranslator } from '@userfrosting/sprinkle-core/stores'
import { Severity } from '@userfrosting/sprinkle-core/interfaces'
import type { UserResponse } from '@userfrosting/sprinkle-admin/interfaces'
import UserEditModal from './UserEditModal.vue'
import UserDeleteModal from './UserDeleteModal.vue'
import UserActivateModal from './UserActivateModal.vue'
import UserPasswordModal from './UserPasswordModal.vue'
import UserPasswordResetModal from './UserPasswordResetModal.vue'

const router = useRouter()
const { $tdate } = useTranslator()
const { user } = defineProps<{
    user: UserResponse
}>()

const emits = defineEmits(['updated'])
</script>

<template>
    <UFCardBox>
        <div class="uk-text-center uk-margin">
            <img :src="user.avatar" alt="avatar" class="uk-border-circle" />
            <h3 class="uk-text-center uk-margin-remove">{{ user.full_name }}</h3>
            <p class="uk-margin-remove uk-text-meta" v-if="user.user_name" data-test="meta">
                ({{ user.user_name }})
            </p>
            <slot data-test="slot"></slot>
        </div>
        <hr />
        <!-- TODO : Find a way to slot the description list -->
        <dl class="uk-description-list">
            <dt><font-awesome-icon icon="envelope" /> Email</dt>
            <dd class="uk-text-meta">{{ user.email }}</dd>
            <dt><font-awesome-icon icon="users" /> Group</dt>
            <dd class="uk-text-meta" v-if="user.group">
                <router-link :to="{ name: 'admin.group', params: { slug: user.group.slug } }">
                    {{ user.group.name }}
                </router-link>
            </dd>
            <dd class="uk-text-meta" v-else><i>None</i></dd>
            <dt><font-awesome-icon icon="language" /> Locale</dt>
            <dd class="uk-text-meta">{{ user.locale_name }}</dd>
            <dt><font-awesome-icon icon="user-shield" /> Status</dt>
            <dd class="uk-text-meta">
                <UFLabel :severity="Severity.Danger" v-if="user.flag_enabled == false">
                    Disabled
                </UFLabel>
                <UFLabel :severity="Severity.Warning" v-else-if="user.flag_verified == false">
                    Unactivated
                </UFLabel>
                <UFLabel :severity="Severity.Success" v-else>Active</UFLabel>
            </dd>
            <dt><font-awesome-icon icon="calendar" /> Created on</dt>
            <dd class="uk-text-meta">{{ $tdate(user.created_at, 'DDD') }}</dd>
            <!-- <slot data-test="slot"></slot> -->
        </dl>
        <hr />
        <UserEditModal
            :user="user"
            @saved="emits('updated')"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-primary uk-button-small" />
        <UserPasswordModal
            :user="user"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-default uk-button-small" />
        <UserPasswordResetModal
            :user="user"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-default uk-button-small" />
        <UserActivateModal
            :user="user"
            @saved="emits('updated')"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-default uk-button-small" />
        <UserDeleteModal
            :user="user"
            @deleted="router.push({ name: 'admin.users' })"
            class="uk-width-1-1 uk-margin-small-bottom uk-button uk-button-danger uk-button-small" />
        <slot data-test="slot"></slot>
    </UFCardBox>
</template>
