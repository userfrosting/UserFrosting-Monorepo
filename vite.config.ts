/// <reference types="vitest" />
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
                // plugin: 'app/assets/plugin.ts',
                // composables: 'app/assets/composables/index.ts',
                // types: 'app/assets/interfaces/index.ts',
                // guards: 'app/assets/guards/authGuard.ts',
                // stores: 'app/assets/stores/auth.ts'
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
            exclude: ['app/assets/tests/**/*.*', 'app/assets/interfaces/routes.ts']
        },
        environment: 'happy-dom'
    }
})
