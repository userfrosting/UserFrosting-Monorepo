<template>
    <UFCardBox :title="$t('ACTIVITY.LATEST')">
        <UFSprunjeTable
            dataUrl="/api/activities"
            :defaultSorts="{ occurred_at: 'desc' }"
            hidePagination
            hideFilters>
            <template #header>
                <UFSprunjeHeader>{{ $t('ACTIVITY.TIME') }}</UFSprunjeHeader>
                <UFSprunjeHeader>{{ $t('USER') }}</UFSprunjeHeader>
                <UFSprunjeHeader>{{ $t('DESCRIPTION') }}</UFSprunjeHeader>
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
                    <i>{{ $t('USER.DELETED') }}</i>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
                    <div>
                        <i>{{ item.description }}</i>
                    </div>
                    <div class="uk-text-meta">
                        {{ item.ip_address }}
                    </div>
                </UFSprunjeColumn>
            </template>
        </UFSprunjeTable>
    </UFCardBox>
</template>
