<script lang="ts" setup>
import { useTranslator } from '@userfrosting/sprinkle-core/stores'
const { $tdate } = useTranslator()
</script>

<template>
    <UFCardBox title="Latest Activities">
        <UFSprunjeTable
            dataUrl="/api/activities"
            :defaultSorts="{ occurred_at: 'desc' }"
            hidePagination
            hideFilters>
            <template #header>
                <UFSprunjeHeader>Activity Time</UFSprunjeHeader>
                <UFSprunjeHeader>User</UFSprunjeHeader>
                <UFSprunjeHeader>Description</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <div>{{ $tdate(item.occurred_at) }}</div>
                </UFSprunjeColumn>
                <UFSprunjeColumn v-if="item.user">
                    <strong>
                        <RouterLink
                            :to="{
                                name: 'admin.user',
                                params: { user_name: item.user.user_name }
                            }">
                            {{ item.user.full_name }} ({{ item.user.user_name }})
                        </RouterLink>
                    </strong>
                    <div class="uk-text-meta">{{ item.user.email }}</div>
                </UFSprunjeColumn>
                <UFSprunjeColumn v-else>
                    <i>Deleted User</i>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
                    <div>
                        {{ item.ip_address }}
                    </div>
                    <div>
                        <i>{{ item.description }}</i>
                    </div>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
