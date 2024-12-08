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
                main: 'app/assets/index.ts',
                interfaces: 'app/assets/interfaces/index.ts',
                stores: 'app/assets/stores/index.ts',
                composables: 'app/assets/composables/index.ts'
            }
        },
        rollupOptions: {
            external: ['vue', 'pinia'],
            output: {
                exports: 'named',
                globals: {
                    vue: 'Vue',
                }
            }
        }
    },
    test: {
        coverage: {
            reportsDirectory: './_meta/_coverage',
            include: ['app/assets/**/*.*'],
            // exclude: ['app/assets/tests/**/*.*', 'app/assets/interfaces/routes.ts']
        },
        environment: 'happy-dom'
    }
})
