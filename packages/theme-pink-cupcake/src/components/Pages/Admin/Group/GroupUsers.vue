<script setup lang="ts">
import { Severity } from '@userfrosting/sprinkle-core/interfaces'

const { slug } = defineProps<{
    slug: string
}>()
</script>

<template>
    <UFCardBox title="Group Users">
        <UFSprunjeTable
            :dataUrl="'/api/groups/g/' + slug + '/users'"
            searchColumn="name"
            hideFilters>
            <template #header>
                <UFSprunjeHeader sort="name">User</UFSprunjeHeader>
                <UFSprunjeHeader>Status</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <strong>
                        <RouterLink
                            :to="{
                                name: 'admin.user',
                                params: { user_name: item.user_name }
                            }">
                            {{ item.full_name }} ({{ item.user_name }})
                        </RouterLink>
                    </strong>
                    <div class="uk-text-meta">{{ item.email }}</div>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
                    <UFLabel :severity="Severity.Danger" v-if="item.flag_enabled == false">
                        Disabled
                    </UFLabel>
                    <UFLabel :severity="Severity.Warning" v-else-if="item.flag_verified == false">
                        Unactivated
                    </UFLabel>
                    <UFLabel :severity="Severity.Success" v-else>Active</UFLabel>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
