import { defineWorkspace } from "vitest/config";

export default defineWorkspace([
    "./packages/theme-pink-cupcake/vite.config.ts",
    "./packages/sprinkle-core/vite.config.ts",
    "./packages/sprinkle-account/vite.config.ts",
    "./packages/sprinkle-admin/vite.config.ts",
    "./packages/skeleton/vite.config.ts",
]);
