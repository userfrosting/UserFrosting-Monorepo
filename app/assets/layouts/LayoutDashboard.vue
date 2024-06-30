<script setup lang="ts">
import NavBar from '../components/NavBar.vue'
import FooterContent from '../components/FooterContent.vue'
</script>

<template>
    <NavBar />
    <UFSideBar>
        <UFSideBarLabel label="NAVIGATION" />
    </UFSideBar>
    <UFMainContent>
        <RouterView />
    </UFMainContent>
    <FooterContent />
</template>
