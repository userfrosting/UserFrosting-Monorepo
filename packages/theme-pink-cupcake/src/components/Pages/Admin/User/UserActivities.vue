<script setup lang="ts">
const { user_name } = defineProps<{
    user_name: string
}>()
</script>

<template>
    <UFCardBox title="Activities">
        <UFSprunjeTable
            v-if="user_name !== ''"
            :dataUrl="'/api/users/u/' + user_name + '/activities'"
            :defaultSorts="{ occurred_at: 'desc' }">
            <template #header>
                <UFSprunjeHeader sort="occurred_at">Activity Time</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">Description</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <div>{{ $tdate(item.occurred_at) }}</div>
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
