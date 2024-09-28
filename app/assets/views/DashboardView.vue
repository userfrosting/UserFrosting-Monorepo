<script setup>
import { ref } from 'vue'
import axios from 'axios'

// TODO : Change to pinia (non-persisting) to avoid reactivity issues
// TODO : Use an interface for the data, maybe rework the API
const data = ref({
    "counter": {
        "users": 0,
        "roles": 0,
        "groups": 0
    },
    "info": {
        "version": {
            "framework": "",
            "php": ""
        },
        "database": {
            "connection": "",
            "name": "",
            "type": "",
            "version": ""
        },
        "environment": {},
        "path": {
            "project": ""
        }
    },
    "sprinkles": {},
    "users": []
})

axios.get('/api/dashboard')
    .then((response) => {
        data.value = response.data
    })
    .catch((err) => {
        console.error(err)
    })
</script>

<template>
    <h3>Dashboard</h3>

    <div class="uk-grid uk-child-width-1-3" uk-grid>
        <div>
            <RouterLink :to="{ name: 'admin.users'}">
                <UFInfoBox :value="data.counter.users" label="Users" faIcon="user" />
            </RouterLink>
        </div>
        <div>
            <RouterLink :to="{ name: 'admin.roles'} " class="uk-text-decoration-none">
                <UFInfoBox :value="data.counter.roles" label="Roles" faIcon="address-card" />
            </RouterLink>
        </div>
        <div>
            <RouterLink :to="{ name: 'admin.groups'} " class="uk-text-decoration-none">
                <UFInfoBox :value="data.counter.groups" label="Groups" faIcon="users" />
            </RouterLink>
        </div>
    </div>

    <!-- TODO : Add footer to the UFCard  -->
    <!-- TODO : Create user Card -->
    <div class="uk-grid uk-child-width-1-2" uk-grid>
        <div>
            <div class="uk-card uk-card-default uk-card-small">
                <div class="uk-card-header">
                    <div class="uk-grid uk-grid-small">
                        <div class="uk-width-auto">
                            <h4 data-test="title">Latest Users</h4>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <div class="uk-grid  uk-flex-center" uk-grid>
                        <div v-for="user in data.users" :key="user.id" class="uk-text-center">
                            <RouterLink :to="{ name: 'admin.user', params: { user_name: user.user_name } }" class="uk-text-decoration-none uk-link-text">
                                <img :src="user.avatar" alt="User Image" class="uk-border-circle">
                                <p class="uk-margin-remove">{{user.full_name}}</p>
                                <p class="uk-margin-remove uk-text-meta">{{ user.registered }}</p>
                            </RouterLink>
                        </div>
                    </div>
                </div>
                <div class="uk-card-footer uk-text-center">
                    <RouterLink :to="{ name: 'admin.users' }" class="uk-button uk-button-text">View All Users</RouterLink>
                </div>
            </div>
            <br />
            <UFCardBox title="System Information">
                <dl class="uk-description-list">
                    <dt>Frameword version</dt>
                    <dd><pre><code>{{data.info.version.framework}}</code></pre></dd>

                    <dt>PHP version</dt>
                    <dd><pre><code>{{data.info.version.php}}</code></pre></dd>

                    <dt>Webserver software</dt>
                    <dd><pre><code>{{data.info.environment.SERVER_SOFTWARE}}</code></pre></dd>

                    <dt>Database connection</dt>
                    <dd><pre><code>{{data.info.database.connection}}</code></pre></dd>

                    <dt>Database version</dt>
                    <dd><pre><code>{{data.info.database.type}} {{data.info.database.version}}</code></pre></dd>

                    <dt>Database name</dt>
                    <dd><pre><code>{{data.info.database.name}}</code></pre></dd>

                    <dt>Project directory</dt>
                    <dd><pre><code>{{data.info.path.project}}</code></pre></dd>

                    <dt>Site root url</dt>
                    <dd><pre><code><!-- {{site.uri.public}} --></code></pre></dd>

                    <dt>Loaded sprinkles</dt>
                    <dd>
                        <ul class="uk-list uk-list-disc uk-list-collapse">
                            <li v-for="sprinkle in data.sprinkles" :key="sprinkle.name">
                                {{sprinkle}}
                            </li>
                        </ul>
                    </dd>
                </dl>
            </UFCardBox>
        </div>
        <div>
            <UFCardBox title="Activities"></UFCardBox>
        </div>
    </div>
</template>