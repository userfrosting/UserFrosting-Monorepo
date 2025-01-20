<template>
    <div uk-grid>
        <div class="uk-width-1-4">
            <UFCardBox title="My Profile" class="uf-sidenav">
                <ul class="uk-nav uk-nav-default">
                    <UFSideBarItem
                        :to="{ name: 'account.settings.profile' }"
                        faIcon="user"
                        label="Personal Information" />
                    <UFSideBarItem
                        :to="{ name: 'account.settings.email' }"
                        faIcon="envelope"
                        label="Update Email" />
                    <UFSideBarItem
                        :to="{ name: 'account.settings.password' }"
                        faIcon="lock"
                        label="Update Password" />
                    <slot />
                </ul>
            </UFCardBox>
        </div>
        <div class="uk-width-3-4">
            <RouterView />
        </div>
    </div>
</template>
