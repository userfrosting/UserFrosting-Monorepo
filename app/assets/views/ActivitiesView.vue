<script setup>
import { ref } from 'vue'
import axios from 'axios'
import moment from 'moment'

// TODO : Change to pinia (non-persisting) to avoid reactivity issues
// TODO : Use an interface for the data, maybe rework the API
// TODO : Reenable typescript
const data = ref({})

axios
    .get('/api/activities?size=10&page=0&sorts%5Boccurred_at%5D=desc')
    .then((response) => {
        data.value = response.data
    })
    .catch((err) => {
        console.error(err)
    })
</script>

<template>
    <UFHeaderPage title="Activities" caption="A listing of user activities." />

    <UFCardBox>
        <table class="uk-table uk-table-striped">
            <thead>
                <tr>
                    <th>Activity Time</th>
                    <th>User</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in data.rows" :key="row.id">
                    <td>
                        <div>{{ moment(row.occurred_at).format('dddd') }}</div>
                        <div>{{ moment(row.occurred_at).format('MMM Do, YYYY h:mm a') }}</div>
                    </td>
                    <td>
                        <strong>
                            <RouterLink
                                :to="{
                                    name: 'admin.user',
                                    params: { user_name: row.user.user_name }
                                }">
                                {{ row.user.full_name }} ({{ row.user.user_name }})
                            </RouterLink>
                        </strong>
                        <div class="uk-text-meta">{{ row.user.email }}</div>
                    </td>
                    <td>
                        <div>
                            {{ row.ip_address }}
                        </div>
                        <div>
                            <i>{{ row.description }}</i>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </UFCardBox>
</template>
