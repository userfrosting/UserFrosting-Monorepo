<script setup lang="ts">
import { defineProps } from 'vue'

const { slug } = defineProps<{
    slug: string
}>()
</script>

<template>
    <UFCardBox title="Roles">
        <UFSprunjeTable
            :dataUrl="'/api/users/u/' + slug + '/roles'"
            searchColumn="name"
            hideFilters>
            <template #actions>
                <button class="uk-button uk-button-default">
                    <font-awesome-icon icon="address-card" /> Add role
                </button>
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">Role</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">Description</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">Actions</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <strong>
                        <RouterLink
                            :to="{
                                name: 'admin.role',
                                params: { slug: item.slug }
                            }">
                            {{ item.name }}
                        </RouterLink>
                    </strong>
                </UFSprunjeColumn>
                <UFSprunjeColumn>{{ item.description }}</UFSprunjeColumn>
                <UFSprunjeColumn>
                    <button class="uk-button uk-button-danger uk-button-small">
                        <font-awesome-icon icon="trash" />
                    </button>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
