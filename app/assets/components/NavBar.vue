<template>
    <UFNavBar title="Userfrosting">
        <UFNavBarItem :to="{ name: 'home' }" label="Home" />
        <UFNavBarItem :to="{ name: 'about' }" label="About" />
        <UFNavBarItem :to="{ name: 'auth' }" label="Auth" />
    </UFNavBar>
</template>
