<template>
    <UFHeaderPage
        title="Roles"
        caption="A listing of the roles for your site.  Provides management tools for editing and deleting roles." />

    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/roles" searchColumn="name">
            <template #actions>
                <button class="uk-button uk-button-default">
                    <font-awesome-icon icon="address-card" /> Create Role
                </button>
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">Role</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">Description</UFSprunjeHeader>
                <UFSprunjeHeader>Actions</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <strong>
                        <RouterLink
                            :to="{
                                name: 'admin.role',
                                params: { slug: item.slug }
                            }">
                            {{ item.name }}
                        </RouterLink>
                    </strong>
                </UFSprunjeColumn>
                <UFSprunjeColumn>{{ item.description }}</UFSprunjeColumn>
                <UFSprunjeColumn>
                    <button class="uk-button uk-button-default uk-button-small" type="button">
                        Actions <font-awesome-icon icon="caret-down" fixed-width />
                    </button>
                    <div uk-dropdown>
                        <ul class="uk-nav uk-dropdown-nav">
                            <li><a href="#">Edit Role</a></li>
                            <li><a href="#">Delete Role</a></li>
                        </ul>
                    </div>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
