<script setup>
import RoleCreateModal from '../../components/Pages/Admin/Role/RoleCreateModal.vue'
import RoleEditModal from '../../components/Pages/Admin/Role/RoleEditModal.vue'
import RoleDeleteModal from '../../components/Pages/Admin/Role/RoleDeleteModal.vue'
import RoleManagePermissionModal from '../../components/Pages/Admin/Role/RoleManagePermissionModal.vue'
</script>

<template>
    <UFHeaderPage
        title="Roles"
        caption="A listing of the roles for your site.  Provides management tools for editing and deleting roles." />

    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/roles" searchColumn="name">
            <template #actions="{ sprunjer }">
                <RoleCreateModal @saved="sprunjer.fetch()" class="uk-button uk-button-primary" />
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">Role</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">Description</UFSprunjeHeader>
                <UFSprunjeHeader>Actions</UFSprunjeHeader>
            </template>

            <template #body="{ item, sprunjer }">
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
                    <button class="uk-button uk-button-primary uk-text-nowrap" type="button">
                        Actions <span uk-drop-parent-icon></span>
                    </button>
                    <div
                        class="uk-padding-small"
                        uk-dropdown="pos: bottom-right; mode: click; offset: 2">
                        <ul class="uk-nav uk-dropdown-nav">
                            <li>
                                <RouterLink
                                    :to="{
                                        name: 'admin.role',
                                        params: { slug: item.slug }
                                    }">
                                    <font-awesome-icon icon="eye" fixed-width /> View
                                </RouterLink>
                            </li>
                            <li>
                                <RoleEditModal
                                    :role="item"
                                    @saved="sprunjer.fetch()"
                                    class="uk-drop-close" />
                            </li>
                            <li>
                                <RoleManagePermissionModal :role="item" class="uk-drop-close" />
                            </li>
                            <li>
                                <RoleDeleteModal
                                    :role="item"
                                    @deleted="sprunjer.fetch()"
                                    class="uk-drop-close" />
                            </li>
                        </ul>
                    </div>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
