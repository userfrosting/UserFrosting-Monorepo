<script setup lang="ts">
const { slug } = defineProps<{
    slug: string
}>()
</script>

<template>
    <UFCardBox title="Role Users">
        <UFSprunjeTable
            :dataUrl="'/api/roles/r/' + slug + '/users'"
            searchColumn="name"
            hideFilters>
            <template #header>
                <UFSprunjeHeader sort="name">User</UFSprunjeHeader>
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
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
