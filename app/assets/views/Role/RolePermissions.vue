<script setup lang="ts">
import { defineProps } from 'vue'

const { role } = defineProps<{
    role: string
}>()
</script>

<template>
    <UFCardBox title="Permissions">
        <UFSprunjeTable :dataUrl="'/api/roles/r/' + role + '/permissions'" searchColumn="name">
            <template #actions>
                <button class="uk-button uk-button-default">
                    <font-awesome-icon icon="key" /> Add permission
                </button>
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">Permission</UFSprunjeHeader>
                <UFSprunjeHeader sort="properties">Slug/Condition</UFSprunjeHeader>
                <UFSprunjeHeader>Actions</UFSprunjeHeader>
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
                <UFSprunjeColumn>
                    <button class="uk-button uk-button-danger uk-button-small">
                        <font-awesome-icon icon="trash" />
                    </button>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
