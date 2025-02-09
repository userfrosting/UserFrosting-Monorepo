<template>
    <UFSideBarItem :to="{ name: 'admin.dashboard' }" faIcon="gauge-high" :label="$t('DASHBOARD')" />
    <UFSideBarItem :to="{ name: 'admin.users' }" faIcon="user" label="Users" />
    <UFSideBarItem :to="{ name: 'admin.activities' }" faIcon="list-check" label="Activities" />
    <UFSideBarItem :to="{ name: 'admin.roles' }" faIcon="address-card" label="Roles" />
    <UFSideBarItem :to="{ name: 'admin.permissions' }" faIcon="key" label="Permissions" />
    <UFSideBarItem :to="{ name: 'admin.groups' }" faIcon="users" label="Groups" />
</template>
