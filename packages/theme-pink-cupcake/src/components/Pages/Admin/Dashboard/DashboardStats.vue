<script lang="ts" setup>
import { useTranslator } from '@userfrosting/sprinkle-core/stores'
const { $t } = useTranslator()
defineProps<{
    users: number
    roles: number
    groups: number
}>()
</script>
<template>
    <UFInfoBox
        :value="users"
        :label="$t('USER', users)"
        faIcon="user"
        :to="{ name: 'admin.users' }" />
    <UFInfoBox
        :value="roles"
        :label="$t('ROLE', roles)"
        faIcon="address-card"
        :to="{ name: 'admin.roles' }" />
    <UFInfoBox
        :value="groups"
        :label="$t('GROUP', groups)"
        faIcon="users"
        :to="{ name: 'admin.groups' }" />
</template>
