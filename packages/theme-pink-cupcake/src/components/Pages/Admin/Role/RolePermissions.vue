<script setup lang="ts">
import RoleManagePermissionModal from './RoleManagePermissionModal.vue'
import type { RoleInterface } from '@userfrosting/sprinkle-account/interfaces'

const { role } = defineProps<{
    role: RoleInterface
}>()
</script>

<template>
    <UFCardBox title="ROLE.PERMISSIONS">
        <UFSprunjeTable :dataUrl="'/api/roles/r/' + role.slug + '/permissions'" searchColumn="name">
            <template #actions="{ sprunjer }">
                <RoleManagePermissionModal
                    :role="role"
                    @saved="sprunjer.fetch()"
                    class="uk-button uk-button-default" />
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">{{ $t('PERMISSION') }}</UFSprunjeHeader>
                <UFSprunjeHeader sort="properties">{{ $t('DESCRIPTION') }}</UFSprunjeHeader>
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
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
