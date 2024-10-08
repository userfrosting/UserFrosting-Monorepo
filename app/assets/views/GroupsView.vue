<template>
    <UFHeaderPage
        title="Groups"
        caption="A listing of the groups for your site.  Provides management tools for editing and deleting groups." />

    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/groups">
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
                <UFSprunjeColumn></UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
