<script setup lang="ts">
import moment from 'moment'
import { defineProps } from 'vue'

const { slug } = defineProps<{
    slug: string
}>()
</script>

<template>
    <UFCardBox title="Role Users">
        <UFSprunjeTable :dataUrl="'/api/roles/r/' + slug + '/users'" searchColumn="name">
            <template #actions>
                <button class="uk-button uk-button-default">
                    <font-awesome-icon icon="user-plus" /> Add user
                </button>
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">User</UFSprunjeHeader>
                <UFSprunjeHeader>Actions</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
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
                    <button class="uk-button uk-button-danger uk-button-small">
                        <font-awesome-icon icon="trash" />
                    </button>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
