<script setup>
import moment from 'moment'
</script>

<template>
    <UFHeaderPage title="Activities" caption="A listing of user activities." />

    <UFCardBox>
        <UFSprunjeTable dataUrl="/api/activities" :defaultSorts="{ occurred_at: 'desc' }">
            <template #header>
                <UFSprunjeHeader sort="occurred_at">Activity Time</UFSprunjeHeader>
                <UFSprunjeHeader sort="user">User</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">Description</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <div>{{ moment(item.occurred_at).format('dddd') }}</div>
                    <div>{{ moment(item.occurred_at).format('MMM Do, YYYY h:mm a') }}</div>
                </UFSprunjeColumn>
                <UFSprunjeColumn>
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
