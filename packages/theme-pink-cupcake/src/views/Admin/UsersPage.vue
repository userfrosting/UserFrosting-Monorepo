<script setup>
import { Severity } from '@userfrosting/sprinkle-core/interfaces'
import moment from 'moment'
import UserCreateModal from '../../components/Pages/Admin/User/UserCreateModal.vue'
import UserEditModal from '../../components/Pages/Admin/User/UserEditModal.vue'
import UserDeleteModal from '../../components/Pages/Admin/User/UserDeleteModal.vue'
import UserActivateModal from '../../components/Pages/Admin/User/UserActivateModal.vue'
</script>

<template>
    <UFHeaderPage
        title="Users"
        caption="A listing of the users for your site. Provides management tools including the ability to
        edit user details, manually activate users, enable/disable users, and more." />

    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/users" searchColumn="name">
            <template #actions="{ sprunjer }">
                <UserCreateModal @saved="sprunjer.fetch()" class="uk-button uk-button-primary" />
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">User</UFSprunjeHeader>
                <UFSprunjeHeader sort="last_activity">Last Activity</UFSprunjeHeader>
                <UFSprunjeHeader sort="status">Status</UFSprunjeHeader>
                <UFSprunjeHeader>Actions</UFSprunjeHeader>
            </template>

            <template #body="{ item, sprunjer }">
                <UFSprunjeColumn>
                    <strong>
                        <RouterLink
                            :to="{
                                name: 'admin.user',
                                params: { user_name: item.user_name }
                            }">
                            {{ item.full_name }} ({{ item.user_name }})
                        </RouterLink>
                    </strong>
                    <div class="uk-text-meta">{{ item.email }}</div>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
                    <div>{{ moment(item.last_activity.occurred_at).format('dddd') }}</div>
                    <div>
                        {{ moment(item.last_activity.occurred_at).format('MMM Do, YYYY h:mm a') }}
                    </div>
                    <i>{{ item.last_activity.description }}</i>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
                    <UFLabel :severity="Severity.Danger" v-if="item.flag_enabled == false">
                        Disabled
                    </UFLabel>
                    <UFLabel :severity="Severity.Warning" v-else-if="item.flag_verified == false">
                        Unactivated
                    </UFLabel>
                    <UFLabel :severity="Severity.Success" v-else>Active</UFLabel>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
                    <button class="uk-button uk-button-default uk-button-small" type="button">
                        Actions <font-awesome-icon icon="caret-down" fixed-width />
                    </button>
                    <div
                        class="uk-padding-small"
                        uk-dropdown="pos: bottom-right; mode: click; offset: 2">
                        <ul class="uk-nav uk-dropdown-nav">
                            <li>
                                <RouterLink
                                    :to="{
                                        name: 'admin.user',
                                        params: { user_name: item.user_name }
                                    }">
                                    <font-awesome-icon icon="eye" fixed-width /> View
                                </RouterLink>
                            </li>
                            <li>
                                <UserEditModal
                                    :user="item"
                                    @saved="sprunjer.fetch()"
                                    class="uk-drop-close" />
                            </li>
                            <li><a href="#">Change User Password</a></li>
                            <li>
                                <UserActivateModal
                                    :user="item"
                                    @saved="sprunjer.fetch()"
                                    class="uk-drop-close" />
                            </li>
                            <li>
                                <UserDeleteModal
                                    :user="item"
                                    @deleted="sprunjer.fetch()"
                                    class="uk-drop-close" />
                            </li>
                        </ul>
                    </div>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
