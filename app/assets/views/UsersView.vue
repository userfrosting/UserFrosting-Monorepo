<template>
    <UFHeaderPage
        title="Users"
        caption="A listing of the users for your site. Provides management tools including the ability to
        edit user details, manually activate users, enable/disable users, and more." />

    <UFCardBox>
        <template #header> <font-awesome-icon icon="user" /> Users </template>
        <template #footer>
            <a href="#" class="uk-button uk-button-primary">Create User</a>
        </template>
    </UFCardBox>
</template>
