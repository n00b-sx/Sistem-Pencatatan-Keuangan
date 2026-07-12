/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/preline/dist/*.js',
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('preline/plugin'),
    ],
};
