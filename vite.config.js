import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    server: {
        host: "192.168.1.10", //  LAN IP192.168.1.8
        port: 5173,
        strictPort: true,
        cors: true, // Optional: Allows other origins to connect (dev only)
        headers: {
            "Access-Control-Allow-Origin": "*", // Optional for dev
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
