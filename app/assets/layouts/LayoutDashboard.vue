<script setup lang="ts">
import NavBar from '../components/NavBar.vue'
import FooterContent from '../components/FooterContent.vue'
import AdminSidebarMenuItems from '@userfrosting/sprinkle-admin/components/SidebarMenuItems.vue'
</script>

<template>
    <NavBar />
    <UFSideBar>
        <UFSideBarLabel label="NAVIGATION" />
        <AdminSidebarMenuItems />
    </UFSideBar>
    <UFMainContent>
        <RouterView />
    </UFMainContent>
    <FooterContent />
</template>
