<script setup lang="ts">
import GroupCreateModal from '../../components/Pages/Admin/Group/GroupCreateModal.vue'
import GroupEditModal from '../../components/Pages/Admin/Group/GroupEditModal.vue'
import GroupDeleteModal from '../../components/Pages/Admin/Group/GroupDeleteModal.vue'
</script>

<template>
    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/groups" searchColumn="name">
            <template #actions="{ sprunjer }">
                <GroupCreateModal @saved="sprunjer.fetch()" class="uk-button uk-button-primary" />
            </template>

            <template #header>
                <UFSprunjeHeader sort="name">{{ $t('GROUP.NAME') }}</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">{{ $t('DESCRIPTION') }}</UFSprunjeHeader>
                <UFSprunjeHeader sort="users_count" class="uk-width-small">{{
                    $t('USER', 2)
                }}</UFSprunjeHeader>
                <UFSprunjeHeader>{{ $t('ACTIONS') }}</UFSprunjeHeader>
            </template>

            <template #body="{ item, sprunjer }">
                <UFSprunjeColumn class="uk-width-1-6">
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
                <UFSprunjeColumn class="uk-text-center">
                    <span class="uk-badge">{{ item.users_count }}</span>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
                    <button class="uk-button uk-button-primary uk-text-nowrap" type="button">
                        {{ $t('ACTIONS') }} <span uk-drop-parent-icon></span>
                    </button>
                    <div
                        class="uk-padding-small"
                        uk-dropdown="pos: bottom-right; mode: click; offset: 2">
                        <ul class="uk-nav uk-dropdown-nav">
                            <li>
                                <RouterLink
                                    :to="{
                                        name: 'admin.group',
                                        params: { slug: item.slug }
                                    }">
                                    <font-awesome-icon icon="eye" fixed-width /> View
                                </RouterLink>
                            </li>
                            <li>
                                <GroupEditModal
                                    :group="item"
                                    @saved="sprunjer.fetch()"
                                    class="uk-drop-close" />
                            </li>
                            <li>
                                <GroupDeleteModal
                                    :group="item"
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
