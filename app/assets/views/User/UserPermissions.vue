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
                <UFSprunjeColumn>
                    <div>
                        <code>{{ item.slug }}</code>
                    </div>
                    <div>
                        ↳ <code>{{ item.conditions }}</code>
                    </div>
                    <div>
                        <i>{{ item.description }}</i>
                    </div>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
