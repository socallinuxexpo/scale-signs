import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

// https://vitejs.dev/config/
export default defineConfig({
	plugins: [react(), tailwindcss()],
	server: {
		// Proxy API requests to Go backend during development
		proxy: {
			'/schedule': 'http://localhost:2017',
			'/sponsors': 'http://localhost:2017',
		},
	},
	build: {
		// Output to a relative path
		outDir: '../pkg/display/dist',
		// Empty the output directory before building
		emptyOutDir: true,
		// Generate a manifest file for better integration with Go backend
		manifest: true,
		// Makes sure assets use relative paths for easier integration with Go
		assetsDir: 'assets',
	},
});
