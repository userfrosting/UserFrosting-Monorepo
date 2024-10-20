<template>
    <UFHeaderPage
        title="Groups"
        caption="A listing of the groups for your site.  Provides management tools for editing and deleting groups." />

    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/groups" searchColumn="name">
            <template #actions>
                <button class="uk-button uk-button-default">
                    <font-awesome-icon icon="Users" /> Create Group
                </button>
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">Groups</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">Description</UFSprunjeHeader>
                <UFSprunjeHeader>Actions</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <strong>
                        <RouterLink
                            :to="{
                                name: 'admin.group',
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
                            <li><a href="#">Edit Group</a></li>
                            <li><a href="#">Delete Group</a></li>
                        </ul>
                    </div>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
