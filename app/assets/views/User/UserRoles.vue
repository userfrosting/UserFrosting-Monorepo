<script setup lang="ts">
import { defineProps } from 'vue'

const { slug } = defineProps<{
    slug: string
}>()
</script>

<template>
    <UFCardBox title="Roles">
        <UFSprunjeTable :dataUrl="'/api/users/u/' + slug + '/roles'" searchColumn="name">
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
                <UFSprunjeColumn></UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
