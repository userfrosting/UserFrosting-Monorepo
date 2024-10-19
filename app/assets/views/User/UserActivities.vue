<script setup lang="ts">
import moment from 'moment'
import { defineProps } from 'vue'

const { user_name } = defineProps<{
    user_name: string
}>()
</script>

<template>
    <UFCardBox title="Activities">
        <UFSprunjeTable
            :dataUrl="'/api/users/u/' + user_name + '/activities'"
            :defaultSorts="{ occurred_at: 'desc' }">
            <template #header>
                <UFSprunjeHeader sort="occurred_at">Activity Time</UFSprunjeHeader>
                <UFSprunjeHeader sort="description">Description</UFSprunjeHeader>
            </template>

            <template #body="{ item }">
                <UFSprunjeColumn>
                    <div>{{ moment(item.occurred_at).format('dddd') }}</div>
                    <div>{{ moment(item.occurred_at).format('MMM Do, YYYY h:mm a') }}</div>
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
