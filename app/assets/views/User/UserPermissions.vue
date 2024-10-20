<script setup lang="ts">
import { defineProps } from 'vue'

const { user_name } = defineProps<{
    user_name: string
}>()
</script>

<template>
    <UFCardBox title="Permissions">
        <UFSprunjeTable :dataUrl="'/api/users/u/' + user_name + '/permissions'" searchColumn="name">
            <template #header>
                <UFSprunjeHeader sort="name">Permission</UFSprunjeHeader>
                <UFSprunjeHeader sort="properties">Slug/Condition</UFSprunjeHeader>
                <UFSprunjeHeader>Has permission via roles</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <strong>
                        <RouterLink
                            :to="{
                                name: 'admin.permission',
                                params: { id: item.id }
                            }">
                            {{ item.name }}
                        </RouterLink>
                    </strong>
                </UFSprunjeColumn>
                <UFSprunjeColumn>{{ item.description }}</UFSprunjeColumn>
                <UFSprunjeColumn>
                    <RouterLink
                        v-for="role in item.roles_via"
                        :key="role.id"
                        :to="{ name: 'admin.role', params: { slug: role.slug } }">
                        <UFLabel>{{ role.name }}</UFLabel>
                    </RouterLink>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
