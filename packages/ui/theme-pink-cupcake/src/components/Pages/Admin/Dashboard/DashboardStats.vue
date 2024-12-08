<script lang="ts" setup>
defineProps<{
    users: number
    roles: number
    groups: number
}>()
</script>
<template>
    <UFInfoBox :value="users" label="Users" faIcon="user" :to="{ name: 'admin.users' }" />
    <UFInfoBox :value="roles" label="Roles" faIcon="address-card" :to="{ name: 'admin.roles' }" />
    <UFInfoBox :value="groups" label="Groups" faIcon="users" :to="{ name: 'admin.groups' }" />
</template>
