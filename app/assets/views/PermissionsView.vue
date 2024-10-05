<template>
    <UFHeaderPage
        title="Permissions"
        caption="A listing of the permissions for your site.  Provides management tools for editing and deleting permissions." />

    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/permissions">
            <template #header>
                <UFSprunjeHeader>Permission</UFSprunjeHeader>
                <UFSprunjeHeader>Slug/Condition</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <strong>
                        <RouterLink
                            :to="{
                                name: 'admin.permission',
                                params: { id: item.id }
                            }">
                            {{ item.name }}
                        </RouterLink>
                    </strong>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
                    <div>
                        <code>{{ item.slug }}</code>
                    </div>
                    <div>
                        ↳ <code>{{ item.conditions }}</code>
                    </div>
                    <div>
                        <i>{{ item.description }}</i>
                    </div>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
