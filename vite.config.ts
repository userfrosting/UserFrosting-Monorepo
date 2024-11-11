/// <reference types="vitest" />
import { configDefaults } from 'vitest/config'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import dts from 'vite-plugin-dts'

// https://vitejs.dev/config/
// https://stackoverflow.com/a/74397545/445757
export default defineConfig({
    plugins: [vue(), dts()],
    publicDir: false,
    build: {
        outDir: './dist',
        lib: {
            entry: {
                plugin: 'app/assets/plugin.ts',
                components: 'app/assets/components/index.ts',
                'composable/useDashboardApi': 'app/assets/composable/useDashboardApi.ts',
                'composable/useGroupApi': 'app/assets/composable/useGroupApi.ts',
                'composable/useGroupCreateApi': 'app/assets/composable/useGroupCreateApi.ts',
                'composable/useGroupEditApi': 'app/assets/composable/useGroupEditApi.ts',
                'composable/useGroupDeleteApi': 'app/assets/composable/useGroupDeleteApi.ts',
                'composable/usePermissionApi': 'app/assets/composable/usePermissionApi.ts',
                'composable/useRoleApi': 'app/assets/composable/useRoleApi.ts',
                'composable/useUserApi': 'app/assets/composable/useUserApi.ts',
                routes: 'app/assets/router/routes.ts'
            }
        },
        rollupOptions: {
            external: ['vue', 'vue-router', 'pinia'],
            output: {
                exports: 'named',
                globals: {
                    vue: 'Vue',
                    'vue-router': 'vueRouter'
                }
            }
        }
    },
    test: {
        coverage: {
            reportsDirectory: './_meta/_coverage',
            include: ['app/assets/**/*.*'],
            exclude: ['app/assets/tests/**/*.*']
        },
        environment: 'happy-dom',
        exclude: [
            ...configDefaults.exclude,
            './vendor/**/*.*',
        ],
    }
})
