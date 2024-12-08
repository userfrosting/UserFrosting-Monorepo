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
                main: 'src/index.ts',
                composables: 'src/composables/index.ts',
                guards: 'src/guards/index.ts',
                interfaces: 'src/interfaces/index.ts',
                routes: 'src/routes/index.ts',
                stores: 'src/stores/index.ts',
                views: 'src/views/index.ts'
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
            include: ['src/**/*.*'],
            exclude: ['src/tests/**/*.*', 'src/interfaces/routes.ts']
        },
        environment: 'happy-dom',
        exclude: [
            ...configDefaults.exclude,
            './vendor/**/*.*',
        ],
    }
})
