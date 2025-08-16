import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'accent-green': '#10B981',
                'accent-green-hover': '#059669',
                'card-dark': '#1F2937',
                'secondary-dark': '#374151',
                'border-custom': '#4B5563',
                'text-primary': '#F9FAFB',
                'text-secondary': '#D1D5DB',
                'text-muted': '#9CA3AF',
            },
        },
    },

    plugins: [forms],
};
