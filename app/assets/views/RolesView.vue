<template>
    <UFHeaderPage
        title="Roles"
        caption="A listing of the roles for your site.  Provides management tools for editing and deleting roles." />

    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/roles">
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
                <UFSprunjeColumn></UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
