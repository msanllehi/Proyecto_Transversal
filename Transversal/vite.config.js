import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js', 
                'resources/js/checkout.js', 
                'resources/js/darklight.js',
                'resources/js/loginregister.js',
                'resources/js/register-responsive.js',
                'resources/js/user-menu.js',
                'resources/js/order-confirmation.js',
                'resources/js/product-ratings.js',
                'resources/js/admin/product-category-loader.js',
                'resources/js/admin/product-manager.js',
                'resources/js/admin/category-manager.js',
                'resources/js/admin/subcategory-manager.js',
                'resources/js/admin/sales-chart.js',
                'resources/js/admin/order-details.js',
                'resources/js/comment-reminder.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
