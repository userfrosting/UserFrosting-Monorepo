<script setup lang="ts">
const { id } = defineProps<{
    id: string | number
}>()
</script>

<template>
    <UFCardBox title="PERMISSION.USERS">
        <UFSprunjeTable
            :dataUrl="'/api/permissions/p/' + id + '/users'"
            searchColumn="name"
            hideFilters>
            <template #header>
                <UFSprunjeHeader sort="name">{{ $t('USER') }}</UFSprunjeHeader>
                <UFSprunjeHeader>{{ $t('PERMISSION.VIA_ROLES') }}</UFSprunjeHeader>
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
